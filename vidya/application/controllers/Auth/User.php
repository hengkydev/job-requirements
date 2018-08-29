<?php 

class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		if($this->middleware->user(false)){
			if($this->input->is_ajax_request()){
				$url 			= $this->session->userdata('catched_location_user');
				$this->restapi->response($url);
			}
			redirect('user');
		}

		$this->webdata->basicLoad();
	}

	public function index(){	
		echo $this->blade->draw('auth.user.signin');
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

		$user		= UsersModel::where('username',$username)->first();

		if(!$user){
			$this->restapi->error("username '{$username}' tidak di temukan");
		}

		if($user->status=="blocked"){
			$this->restapi->error("username '{$username}' akun ini ter suspend");
		}


		$authHash		= [
			"password"	=> $password,
			"hash"		=> $user->password
		];

		if(!DefuseLib::validation($authHash)){

			if(DefuseLib::decrypt($user->password_old)===$password){
				$this->restapi->error("password ini telah di ganti pada '{$user->password_old_date}'");
			}

			$this->restapi->error("maaf password yang anda masukkan salah");
		}

		$user->ipaddress 		= $this->input->ip_address();
		$user->save();

		if(!$user->save()){
			$this->restapi->error("ada sesuatu kesalahan, silahkan ulangi kembali");
		}

		$newdata = array('auth_user'	=>  DefuseLib::encrypt($user->id));

		$this->session->set_userdata($newdata);

		$url 			= (!$this->session->userdata('catched_location_user')) ? '/user/dashboard' : $this->session->userdata('catched_location_user');
		$this->restapi->response($url);

	}
}
