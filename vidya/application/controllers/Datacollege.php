<?php
class Datacollege extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function lectureridentityvalid(){
		$rules = [
			    'required' 	=>	[
					['value'],
				],
			];
		
		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}

		$table 	= LecturerModel::where("identity_number",strtolower($this->input->post('value')));

		if($this->input->post("exception")){
			$table 	= $table->where("id","!=",$this->input->post("exception"));
		}
		$table 	= $table->first();

		if($table){
			$this->restapi->error("Maaf No Identitas '{$table->identity_number}' telah di gunakan");
		}

		$this->restapi->response("Oke, no Identitas ini belum di pakai");
	}

	public function lectureremailvalid(){
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

		$table 	= LecturerModel::where("email",$this->input->post('value'));

		if($this->input->post("exception")){
			$table 	= $user->where("id","!=",$this->input->post("exception"));
		}
		$table 	= $table->first();
		if($table){
			$this->restapi->error("Maaf email '{$table->email}' telah di gunakan");
		}

		$this->restapi->response("Oke, Email ini dapat anda gunakan");
	}

	public function studentidentityvalid(){
		$rules = [
			    'required' 	=>	[
					['value'],
				],
			];
		
		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}

		$table 	= StudentModel::where("identity_number",strtolower($this->input->post('value')));

		if($this->input->post("exception")){
			$table 	= $table->where("id","!=",$this->input->post("exception"));
		}
		$table 	= $table->first();

		if($table){
			$this->restapi->error("Maaf No Identitas '{$table->identity_number}' telah di gunakan");
		}

		$this->restapi->response("Oke, no Identitas ini belum di pakai");
	}

	public function studentemailvalid(){
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

		$table 	= StudentModel::where("email",$this->input->post('value'));

		if($this->input->post("exception")){
			$table 	= $user->where("id","!=",$this->input->post("exception"));
		}
		$table 	= $table->first();
		if($table){
			$this->restapi->error("Maaf email '{$table->email}' telah di gunakan");
		}

		$this->restapi->response("Oke, Email ini dapat anda gunakan");
	}
}
