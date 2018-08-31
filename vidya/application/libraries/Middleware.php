<?php

class Middleware {

	function __construct() {
		$this->ci =& get_instance(); 
		$this->ci->load->library('session');
		$this->ci->load->library('blade');
	}

	public function api_user($error=true){

		$result 	= toObject(apache_request_headers());

		if(!isset($result->Authorization)){
			$this->ci->restapi->error("Opps! Authorization Header Required");
		}

		if(goExplode($result->Authorization,' ',0)!=="User"){
			$this->ci->restapi->error("Invalid Authorization");	
		}

		$token 		= goExplode($result->Authorization,' ',1);

		if(!$token){
			$this->ci->restapi->error("Invalid Authorization");		
		}

		$jwt 		= toObject(JWT::decode($token));

		if(!isset($jwt->data)){
			$this->ci->restapi->error("Invalid Token Authorization");
		}

		$now 		= strtotime(date('Y-m-d h:i:s A T'));

		if($now>$jwt->exp){
			$this->ci->restapi->error("JWT Token Already Expired from ".date("Y-m-d h:i:s A T",$jwt->exp)." please try sign in again!");
		}

		$userToken 	= DefuseLib::decrypt($jwt->data->token);

		$username 	= goExplode($userToken,"//",0);
		$password 	= goExplode($userToken,"//",1);


		$user 		= UsersModel::active()->where("username",$username)->first();
		if(!$user){
			$this->ci->restapi->error("Opps! User Not Found");
		}

		if(DefuseLib::decrypt($user->password)!==$password){

			if(DefuseLib::decrypt($user->password_old)===$password){
				$this->ci->restapi->error("password ini telah di ganti pada '{$user->password_old_date}'");
			}

			$this->ci->restapi->error("maaf password yang anda masukkan salah");
		}


		return $user;
	}

	public function lecturer($redirect=true){
		$this->ci->load->library('session');

		if(!$this->ci->session->userdata('auth_lecturer')){
			if($redirect){
				$cur_url 	= (!isset($_SERVER['REQUEST_URI'])) ? '/lecturer/dashboard' : $_SERVER['REQUEST_URI'];
				$this->ci->session->set_userdata('catched_location_lecturer', $cur_url);
				redirect('auth/lecturer');	
			}
			return false;
		}

		$session 			= DefuseLib::decrypt($this->ci->session->userdata('auth_lecturer'));
		$table 				= LecturerModel::active()->find($session);
		if(!$table){
			$this->ci->session->unset_userdata('auth_lecturer');
			if($redirect){
				redirect('auth/lecturer');
				exit();

			}
			return false;
		}

		$this->ci->blade->share('__LECTURER',$table);
		return $table;
	}

	public function student($redirect=true){
		$this->ci->load->library('session');

		if(!$this->ci->session->userdata('auth_student')){
			if($redirect){
				$cur_url 	= (!isset($_SERVER['REQUEST_URI'])) ? '/student/dashboard' : $_SERVER['REQUEST_URI'];
				$this->ci->session->set_userdata('catched_location_student', $cur_url);
				redirect('auth/student');	
			}
			return false;
		}

		$session 			= DefuseLib::decrypt($this->ci->session->userdata('auth_student'));
		$table 				= StudentModel::active()->find($session);
		if(!$table){
			$this->ci->session->unset_userdata('auth_student');
			if($redirect){
				redirect('auth/student');
				exit();

			}
			return false;
		}

		$this->ci->blade->share('__STUDENT',$table);
		return $table;
	}

	public function superuser($redirect=true)
	{
		$this->ci->load->library('session');

		if(!$this->ci->session->userdata('auth_superuser')){
			if($redirect){
				$cur_url 	= (!isset($_SERVER['REQUEST_URI'])) ? '/superuser/dashboard' : $_SERVER['REQUEST_URI'];
				$this->ci->session->set_userdata('catched_location_superuser', $cur_url);
				redirect('auth/superuser');	
			}
			return false;
		}

		$session 			= DefuseLib::decrypt($this->ci->session->userdata('auth_superuser'));
		$superuser 			= SuperuserModel::active()->find($session);
		if(!$superuser){
			$this->ci->session->unset_userdata('auth_superuser');
			if($redirect){
				redirect('auth/superuser');
				exit();

			}
			return false;
		}

		$this->ci->blade->share('__SUPERUSER',$superuser);
		return $superuser;
		
	}
	
}