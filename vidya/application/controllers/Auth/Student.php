<?php 

class Student extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		if($this->middleware->student(false)){
			if($this->input->is_ajax_request()){
				$url 			= $this->session->userdata('catched_location_student');
				$this->restapi->response($url);
			}
			redirect('student');
		}

		$this->webdata->basicLoad();
	}

	public function index(){	
		echo $this->blade->draw('auth.student.signin');
	}

	public function register(){	
		echo $this->blade->draw('auth.student.register');
	}

	public function authentication(){

		$this->validation->gRecaptcha();

		$rules = [
				    'required' 	=>	[
    					['username'],['password'],
    				]
				];
				
		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}

		$username 		= $this->input->post('username');
		$password 		= $this->input->post("password");

		$table		= StudentModel::where('username',$username)->first();

		if(!$table){
			$this->restapi->error("username '{$username}' tidak di temukan");
		}

		if($table->status=="blocked"){
			$this->restapi->error("username '{$username}' akun ini ter suspend");
		}


		$authHash		= [
			"password"	=> $password,
			"hash"		=> $table->password
		];

		if(!DefuseLib::validation($authHash)){

			if(DefuseLib::decrypt($table->password_old)===$password){
				$this->restapi->error("password ini telah di ganti pada '{$table->password_old_date}'");
			}

			$this->restapi->error("maaf password yang anda masukkan salah");
		}

		$table->ipaddress 		= $this->input->ip_address();
		$table->save();

		if(!$table->save()){
			$this->restapi->error("ada sesuatu kesalahan, silahkan ulangi kembali");
		}

		$newdata = array('auth_student'	=>  DefuseLib::encrypt($table->id));

		$this->session->set_userdata($newdata);

		$url 			= (!$this->session->userdata('catched_location_student')) ? '/user/dashboard' : $this->session->userdata('catched_location_student');
		$this->restapi->response($url);

	}

	public function doregister() {
		$rules = [
				    'required' 	=>	[
    					['name'],['identity_number'],['email'],['department'],
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
		$check 					= StudentModel::where("identity_number",$this->input->post("identity_number"))->first();
		if(isset($check->id)){
			$this->restapi->error("maaf no identitas '{$identity_number}' telah di gunakan!");
		}

		$email 					= $this->input->post("email");
		$check 					= StudentModel::where("email",$this->input->post("email"))->first();
		if(isset($check->id)){
			$this->restapi->error("maaf email '{$email}' telah di gunakan!");
		}

		$password 				= DefuseLib::encrypt($this->input->post("password"));

		$table 					= new StudentModel;
		$table->identity_number = $identity_number;
		$table->email 			= $email;
		$table->password 		= $password;
		$table->department 		= $this->input->post("department");
		$table->name 			= $this->input->post("name");
		$table->gender 			= $this->input->post("gender");
		$table->status 			='active';

		if($this->validation->checkFiles("image")){

			$filename 				= 'STUDENT '.limit_string($this->input->post('name')).' ('.date('Ymdhis').')';
			$upload 				= $this->upfiles->allSizeImageUpload("student","image",$filename);

			if(!$upload->status){
				$this->restapi->error($upload->result);
			}

			$table->image 			= $upload->result;
		}


		if(!$table->save()){

			if($table->image){
				$this->upfiles->remove("student",$table->image);	
			}

			$this->restapi->error("Maaf ada kesalahan silahkan coba nanti");
		}

		$newdata = array('auth_student'	=>  DefuseLib::encrypt($table->id));

		$this->session->set_userdata($newdata);

		$this->validation->setSuccess("Anda telah terdaftar menjadi mahasiswa di sistem e-learning");
		$this->restapi->response("/student/dashboard");
	}
}
