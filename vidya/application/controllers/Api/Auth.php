<?php
class Auth extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->restapi->validateKey();
	}

	public function user(){

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

		$issuedAt   = time();
		$notBefore  = $issuedAt + 10;  //Adding 10 seconds
		$expire     = $notBefore + 604800; // Adding 60 seconds
		$serverName = base_url(); /// set your domain name 
		
		$data = [
		    'iat'  => $issuedAt,         // Issued at: time when the token was generated
		    'jti'  => $user->token, 
		    'iss'  => $serverName,       // Issuer
		    'nbf'  => $notBefore,        // Not before
		    'exp'  => $expire,           // Expire
		    'data' => [                  // Data related to the logged user you can set your required data
						'token'   	=> DefuseLib::encrypt($user->username.'//'.$this->input->post("password")), 	 // id from the users table
		              ]
		];

		$token = JWT::encode($data);
		$response['user']		= $user->toArray();
		$response['token']		= $token;
		$this->restapi->response($response);
	}

}
