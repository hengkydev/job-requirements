<?php
class Lecturer extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->superuser 	= $this->middleware->superuser();
		$this->webdata->superuserLoad();
	}


	public function index()
	{
		$data['__MENU']			= "lecturer";
		$data['head_text']		= 'Pengajar';
		$data['body_text']		= "Daftar Pengajar";
		$data['table'] 			= LecturerModel::desc()->get();
		echo $this->blade->draw('superuser.lecturer.index',$data);
	}

	public function create(){

		$data 		= [
			"__MENU"			=> "lecturer_create",
			"type"				=> "create",
			"url_action"		=> base_url("superuser/lecturer/created"),
			'head_text'			=> 'Buat Pengajar',
			"body_text"			=> "Membuat Pengajar Baru"
		];

		echo $this->blade->draw('superuser.lecturer.content',$data);
	}

	public function update($id=null){

		if(!$id){
			show_404();
		}

		$table 		= LecturerModel::find($id);

		if(!$table){
			show_404();
		}

		$data 		= [
			"__MENU"			=> "lecturer_update",
			"type"				=> "update",
			"url_action"		=> base_url("superuser/lecturer/updated"),
			'head_text'			=> 'Ubah Pengajar',
			"body_text"			=> "Mengubah Pengajar {$table->nama}",
			"table"				=> $table
		];

		echo $this->blade->draw('superuser.lecturer.content',$data);
	}

	public function created(){

		$rules = [
				    'required' 	=>	[
    					['name'],['identity_number'],['email'],['position'],
    					['password'],['password_confirmation']
    				],
    				'numeric'	=> [
    					['identity_number']
    				],
    				'lengthMin'		=> [
    					['password',8],['password_confirmation',8]
    				],
    				'equals'	=> [
    					['password_confirmation','password']
    				],
    				'in'		=> [
    					['gender',['male','female']]
    				]
				 ];
		
		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}

		$identity_number 		= $this->input->post("identity_number");
		$check 					= LecturerModel::where("identity_number",$this->input->post("identity_number"))->first();
		if(isset($check->id)){
			$this->restapi->error("maaf no identitas '{$identity_number}' telah di gunakan!");
		}

		$email 					= $this->input->post("email");
		$check 					= LecturerModel::where("email",$this->input->post("email"))->first();
		if(isset($check->id)){
			$this->restapi->error("maaf email '{$email}' telah di gunakan!");
		}

		$password 				= DefuseLib::encrypt($this->input->post("password"));

		$table 					= new LecturerModel;
		$table->identity_number 		= $identity_number;
		$table->email 			= $email;
		$table->password 		= $password;
		$table->position 		= $this->input->post("position");
		$table->name 			= $this->input->post("name");
		$table->gender 			= $this->input->post("gender");
		$table->phone 			= $this->input->post("phone");
		$table->address 		= $this->input->post("address");
		$table->status 			= ($this->input->post("status")) ? "active" : "blocked";

		if($this->validation->checkFiles("image")){

			$filename 				= 'LECTURER '.limit_string($this->input->post('name')).' ('.date('Ymdhis').')';
			$upload 				= $this->upfiles->allSizeImageUpload("lecturer","image",$filename);

			if(!$upload->status){
				$this->restapi->error($upload->result);
			}

			$table->image 			= $upload->result;
		}


		if(!$table->save()){

			if($table->image){
				$this->upfiles->remove("lecturer",$table->image);	
			}

			$this->restapi->error("Maaf ada kesalahan silahkan coba nanti");
		}

		$this->validation->setSuccess("Pengajar baru telah ditambahkan");
		$this->restapi->response("/superuser/lecturer");

	}

	public function updated(){

		$rules = [
				    'required' 	=>	[
    					['id'],['name'],['identity_number'],['email'],['position'],
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

		$table 					= LecturerModel::find($this->input->post("id"));
		if(!$table){
			$this->restapi->error("Maaf pengguna tidak di temukan!");
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
		$table->gender 			= $this->input->post("gender");
		$table->address 		= $this->input->post("address");
		$table->status 			= ($this->input->post("status")) ? "active" : "blocked";

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
		$this->restapi->response("/superuser/lecturer");

	}


	public function bulkaction(){
		$rules = [
					'required' 	=> [
				        ['action'],['data']
				    ]
				  ];

		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->validation->setError($validate->data);
		}

		$action 	= $this->input->post('action');
		$table 		= LecturerModel::whereIn('id',$this->input->post('data'))->get();

		if(count($table)<=0){
			$this->validation->setError("Tidak ada data yang di pilih!");
			redirect('superuser/post');
		}

		switch ($action) {
			case 'active':
				LecturerModel::whereIn('id',$this->input->post('data'))->update(['status'=>'active']);
				$this->validation->setSuccess("Data di 'Aktifkan'");
				break;
			case 'suspend':
				LecturerModel::whereIn('id',$this->input->post('data'))->update(['status'=>'blocked']);
				$this->validation->setSuccess("Data di 'Blokir'");
				break;
			case 'delete':
				$table 	= LecturerModel::whereIn('id',$this->input->post('data'))->get();
				foreach ($table as $result) {
					if($result->image){
						$this->upfiles->remove("lecturer",$result->image);	
					}
				}

				LecturerModel::whereIn('id',$this->input->post('data'))->delete();
				$this->validation->setSuccess("Data telah terhapus");
				break;
			default:
				show_404();
				break;
		}

		redirect('superuser/lecturer');
		return;
	}

	public function remove($id=null){
		if(!$id){
			show_404();
		}

		$table 		= LecturerModel::find($id);
		if(!$table){
			show_404();
		}

		if($table->image){
			$this->upfiles->remove("lecturer",$table->image);	
		}

		$table->delete();
		$this->validation->setSuccess("Pengajar '{$table->name}' telah di hapus");
		redirect("superuser/lecturer");
	}

}