<?php
class Datacollege extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function usernamevalid(){
		$rules = [
			    'required' 	=>	[
					['value'],
				],
			];
		
		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}

		$user 	= UsersModel::where("username",strtolower($this->input->post('value')));

		if($this->input->post("exception")){
			$user 	= $user->where("id","!=",$this->input->post("exception"));
		}
		$user 	= $user->first();
		if($user){
			$this->restapi->error("Maaf username '{$user->username}' telah di gunakan");
		}

		$this->restapi->response("Oke, username ini dapat anda gunakan");
	}

	public function emailvalid(){
		$rules = [
			    'required' 	=>	[
					['value'],
				],
				'email'		=> [
					['value']
				]
			];
		
		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}

		$user 	= UsersModel::where("email",$this->input->post('value'));

		if($this->input->post("exception")){
			$user 	= $user->where("id","!=",$this->input->post("exception"));
		}
		$user 	= $user->first();
		if($user){
			$this->restapi->error("Maaf email '{$user->email}' telah di gunakan");
		}

		$this->restapi->response("Oke, Email ini dapat anda gunakan");
	}
}
