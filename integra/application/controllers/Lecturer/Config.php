<?php
class Config extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->lecturer 	= $this->middleware->lecturer();
		$this->webdata->basicLoad();
	}


	public function index()
	{
			$data 		= [
			"__MENU"			=> "config",
			"type"				=> "update",
			"url_action"		=> base_url("lecturer/config/submit"),
			'head_text'			=> 'Profil Pengajar',
			"body_text"			=> "Ubah profil saya",
			"table"				=> $this->lecturer
		];
		echo $this->blade->draw('lecturer.config.index',$data);
	}

	public function submit(){

		$rules = [
				    'required' 	=>	[
    					['name'],['identity_number'],['email'],['position'],
    				],
    				'numeric'		=> [
    					['identity_number']
    				],
    				'in'		=> [
    					['gender',['male','female']]
    				]
				 ];
		
		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}

		$table 					= $this->lecturer;
		if(!$table){
			$this->restapi->error("Maaf Pengajar tidak di temukan!");
		}

		$identity_number 		= $this->input->post("identity_number");
		$check 					= LecturerModel::where("identity_number",$this->input->post("identity_number"))
									->where("identity_number","!=",$table->identity_number)
									->first();
		if(isset($check->id)){
			$this->restapi->error("maaf no identitas '{$identity_number}' telah di gunakan!");
		}

		$email 					= $this->input->post("email");
		$check 					= LecturerModel::where("email",$this->input->post("email"))
									->where("email","!=",$table->email)
									->first();
		if(isset($check->id)){
			$this->restapi->error("maaf email '{$email}' telah di gunakan!");
		}

		if($this->input->post("password")){

			$rules = [
				    'required' 	=>	[
    					['password'],['password_confirmation']
    				],
    				'lengthMin'		=> [
    					['password',8],['password_confirmation',8]
    				],
    				'equals'	=> [
    					['password_confirmation','password']
    				]
				 ];
		
			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
			}
			$password 				= DefuseLib::encrypt($this->input->post("password"));
			$table->password 		= $password;	
		}
		

		$table->identity_number = $identity_number;
		$table->position 		= $this->input->post("position");
		$table->email 			= $email;
		$table->name 			= $this->input->post("name");
		$table->phone 			= $this->input->post("phone");
		$table->address 			= $this->input->post("address");
		$table->gender 			= $this->input->post("gender");

		if($this->validation->checkFiles("image")){

			$filename 				= 'LECTURER '.limit_string($this->input->post('name')).' ('.date('Ymdhis').')';
			$upload 				= $this->upfiles->allSizeImageUpload("lecturer","image",$filename);

			if(!$upload->status){
				$this->restapi->error($upload->result);
			}
		}


		if(!$table->save()){

			if($table->image){
				$this->upfiles->remove("lecturer",$table->image);	
			}

			$this->restapi->error("Maaf ada kesalahan silahkan coba nanti");
		}

		if(isset($upload->status)){
			if($table->image){
				$this->upfiles->remove("lecturer",$table->image);		
			}
			$table->image 			= $upload->result;
		}

		$table->save();

		$this->validation->setSuccess("Pengajar '{$table->name}' telah di perbarui");
		$this->restapi->response("/lecturer/config");

	}
}