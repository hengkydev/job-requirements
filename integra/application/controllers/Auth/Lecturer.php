<?php 

class Lecturer extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		if($this->middleware->lecturer(false)){
			if($this->input->is_ajax_request()){
				$url 			= $this->session->userdata('catched_location_lecturer');
				$this->restapi->response($url);
			}
			redirect('lecturer');
		}

		$this->webdata->basicLoad();
	}

	public function index(){	
		echo $this->blade->draw('auth.lecturer.signin');
	}

	public function authentication(){

		$this->validation->gRecaptcha();

		$rules = [
				    'required' 	=>	[
    					['identity_number'],['password'],
    				]
				];
				
		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}

		$identity_number 		= $this->input->post('identity_number');
		$password 				= $this->input->post("password");

		$table					= LecturerModel::where('identity_number',$identity_number)->first();

		if(!$table){
			$this->restapi->error("No Identitas '{$identity_number}' tidak di temukan");
		}

		if($table->status=="blocked"){
			$this->restapi->error("No Identitas '{$identity_number}' akun ini di blokir");
		}


		$authHash		= [
			"password"	=> $password,
			"hash"		=> $table->password
		];

		if(!DefuseLib::validation($authHash)){

			$this->restapi->error("maaf password yang anda masukkan salah");
		}

		$table->save();

		if(!$table->save()){
			$this->restapi->error("ada sesuatu kesalahan, silahkan ulangi kembali");
		}

		$newdata = array('auth_lecturer'	=>  DefuseLib::encrypt($table->id));

		$this->session->set_userdata($newdata);

		$url 			= (!$this->session->userdata('catched_location_lecturer')) ? '/lecturer/dashboard' : $this->session->userdata('catched_location_lecturer');
		$this->restapi->response($url);

	}
}
