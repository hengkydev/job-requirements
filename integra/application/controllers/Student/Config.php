<?php
class Config extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->student 	= $this->middleware->student();
		$this->webdata->basicLoad();
	}


	public function index()
	{
			$data 		= [
			"__MENU"			=> "config",
			"type"				=> "update",
			"url_action"		=> base_url("student/config/submit"),
			'head_text'			=> 'Profil Mahasiswa',
			"body_text"			=> "Ubah profil saya",
			"table"				=> $this->student
		];
		echo $this->blade->draw('student.config.index',$data);
	}

	public function submit(){

		$rules = [
				    'required' 	=>	[
    					['name'],['identity_number'],['email'],['department'],
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

		$table 					= $this->student;
		if(!$table){
			$this->restapi->error("Maaf Mahasiswa tidak di temukan!");
		}

		$identity_number 		= $this->input->post("identity_number");
		$check 					= StudentModel::where("identity_number",$this->input->post("identity_number"))
									->where("identity_number","!=",$table->identity_number)
									->first();
		if(isset($check->id)){
			$this->restapi->error("maaf no identitas '{$identity_number}' telah di gunakan!");
		}

		$email 					= $this->input->post("email");
		$check 					= StudentModel::where("email",$this->input->post("email"))
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
		$table->department 		= $this->input->post("department");
		$table->email 			= $email;
		$table->name 			= $this->input->post("name");
		$table->gender 			= $this->input->post("gender");

		if($this->validation->checkFiles("image")){

			$filename 				= 'STUDENT '.limit_string($this->input->post('name')).' ('.date('Ymdhis').')';
			$upload 				= $this->upfiles->allSizeImageUpload("student","image",$filename);

			if(!$upload->status){
				$this->restapi->error($upload->result);
			}
		}


		if(!$table->save()){

			if($table->image){
				$this->upfiles->remove("student",$table->image);	
			}

			$this->restapi->error("Maaf ada kesalahan silahkan coba nanti");
		}

		if(isset($upload->status)){
			if($table->image){
				$this->upfiles->remove("student",$table->image);		
			}
			$table->image 			= $upload->result;
		}

		$table->save();

		$this->validation->setSuccess("Mahasiswa '{$table->name}' telah di perbarui");
		$this->restapi->response("/student/config");

	}
}