<?php 

class Superuser extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		if($this->middleware->superuser(false)){
			if($this->input->is_ajax_request()){
				$url 			= $this->session->userdata('catched_location_superuser');
				$this->restapi->response($url);
			}
			redirect('superuser');
		}

		$this->webdata->basicLoad();
	}

	public function index(){	
		echo $this->blade->draw('auth.superuser.signin');
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

		$superuser		= SuperuserModel::where('username',$username)->first();

		if(!$superuser){
			$this->restapi->error("username '{$username}' tidak di temukan");
		}

		if($superuser->status=="blocked"){
			$this->restapi->error("username '{$username}' akun ini ter suspend");
		}

		$authHash		= [
			"password"	=> $password,
			"hash"		=> $superuser->password
		];

		if(!DefuseLib::validation($authHash)){

			if(DefuseLib::decrypt($superuser->password_old)===$password){
				$this->restapi->error("password ini telah di ganti pada '{$superuser->password_old_date}'");
			}

			$this->restapi->error("maaf password yang anda masukkan salah");
		}


		$superuser->ipaddress 		= $this->input->ip_address();
		$superuser->save();

		if(!$superuser->save()){
			$this->restapi->error("ada sesuatu kesalahan, silahkan ulangi kembali");
		}

		$newdata = array('auth_superuser'	=>  DefuseLib::encrypt($superuser->id));

		$this->session->set_userdata($newdata);

		$url 			= (!$this->session->userdata('catched_location_superuser')) ? '/superuser/dashboard' : $this->session->userdata('catched_location_superuser');
		$this->restapi->response($url);

	}
}
