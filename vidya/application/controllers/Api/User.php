<?php
class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->restapi->validateKey();
		$this->user 	= $this->middleware->api_user();
	}

	public function index(){
		$this->restapi->response($this->user->toArray());
	}

	public function updateprofile(){

		$rules = [
				    'required' 	=>	[
    					['name'],['phone'],['email']
    				],
    				'email'	=> [
    					['email']
    				]
				];
				
		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}


		$email 					= $this->input->post("email");
		$check 					= UsersModel::where("email",$this->input->post("email"))
									->where("id","!=",$this->user->id)->first();
		if(isset($check->id)){
			$this->restapi->error("maaf '{$email}' telah di gunakan!");	
		}

		$table 					= $this->user;
		$table->email 			= $email;
		$table->name 			= $this->input->post("name");
		$table->phone 			= $this->input->post("phone");

		if($this->validation->checkFiles("image")){

			$filename 				= 'USER '.limit_string($this->input->post('name')).' ('.date('Ymdhis').')';
			$upload 				= $this->upfiles->allSizeImageUpload("users","image",$filename);

			if(!$upload->status){
				$this->restapi->error($upload->result);
			}

			$table->image 			= $upload->result;
		}

		if(!$table->save()){

			if($table->image){
				$this->upfiles->remove("users",$table->image);	
			}

			$this->restapi->error("Maaf ada kesalahan silahkan coba nanti");
		}

		$this->restapi->response($table->toArray());

	}

	public function changepassword(){

		$password_old 			= DefuseLib::decrypt($this->user->password);

		$rules = [
				    'required' 	=>	[
    					['password'],['password_confirmation'],
    					['password_old']
    				],
    				'equals'	=> [
    					['password_confirmation','password']
    				],
    				'lengthMin'	=> [
    					['password',8],['password_confirmation',8]
    				]
				];
				
		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}

		if($this->input->post("password_old")!==$password_old){
			$this->restapi->error("password lama anda tidak sesuai!");
		}

		$user 						= $this->user;
		$user->password_old_date 	= date("Y-m-d h:i:s");
		$user->password_old 		= $user->password;
		$user->password 			= DefuseLib::encrypt($this->input->post("password"));

		if(!$user->save()){
			$this->restapi->error("Password tidak berhasil di ubah , coba lagi nanti!");
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
		$response['jwt']		= [
			"token"				=> $token,
			"description" 		=> "This is new generate JWT Token based on Auth user, cause changing the password will change the token either"
		];
		$this->restapi->response($response);

	}

}
