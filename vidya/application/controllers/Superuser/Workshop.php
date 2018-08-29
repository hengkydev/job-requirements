<?php
class Workshop extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->superuser 	= $this->middleware->superuser();
		$this->webdata->superuserLoad();
	}

	public function index()
	{
		$data 		= [
			"__MENU"			=> "workshop",
			"head_text"			=> "Workshop",
			"body_text"			=> "Daftar Workshop Anda",
			"table"				=> WorkshopModel::desc()->get()
		];
		
		echo $this->blade->draw('superuser.workshop.index',$data);
	}

	public function create(){

			$data 		= [
			"__MENU"			=> "workshop_create",
			"type"				=> "create",
			"url_action"		=> base_url("superuser/workshop/created"),
			'head_text'			=> 'Worksop',
			"body_text"			=> "Buat Workshop baru"
		];

		echo $this->blade->draw('superuser.workshop.content',$data);
	}

	public function created(){

		$rules = [
				    'required' 	=>	[
    					['name'],['location'],['start'],['end']
    				],
    				'date'		=> [
    					['start'],['end']
    				]
				 ];
		
		$validate 	= $this->validation->check($rules,'workshop');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}

		$table 				= new WorkshopModel;
		$table->name 		= $this->input->post("name");
		$table->description = $this->input->post("description");
		$table->location 	= $this->input->post('location');
		$table->google_map 	= $this->input->post('google_map');
		$table->start 		= $this->input->post("start");
		$table->end 		= $this->input->post("end");
		$table->status 		= ($this->input->post('status')) ? 'publish' : 'draft';

		if($this->validation->checkFiles("image")){
			$filename 				= 'WORKSHOP '.limit_string($this->input->post('name')).' ('.date('Ymdhis').')';
			$upload 				= $this->upfiles->allSizeImageUpload("workshop","image",$filename);

			if(!$upload->status){
				$this->restapi->error($upload->result);
			}

			$table->image 			= $upload->result;
		}

		if(!$table->save()){

			if($table->value){
				$this->upfiles->remove("workshop",$table->image);	
			}

			$this->restapi->error("Maaf ada kesalahan silahkan coba nanti");
		}

		$this->validation->setSuccess("Workshop baru telah ditambahkan");
		$this->restapi->response("/superuser/workshop");

	}

	public function update($id=null){

		if(!$id){
			show_404();
		}

		$workshop 		= WorkshopModel::find($id);
		if(!$workshop){
			show_404();
		}

		$data 		= [
			"__MENU"			=> "workshop_update",
			"type"				=> "update",
			"url_action"		=> base_url("superuser/workshop/updated"),
			"text_content"		=> "Ubah Workshop - {$workshop->name}",
			"workshop"				=> $workshop,
		];

		echo $this->blade->draw('superuser.workshop.content',$data);
	}

	public function updated(){

		$rules = [
				    'required' 	=>	[
    					['id'],['name'],['location'],['start'],['end']
    				],
    				'date'		=> [
    					['start'],['end']
    				]
				 ];
		
		$validate 	= $this->validation->check($rules,'workshop');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}

		$table 				= WorkshopModel::find($this->input->post('id'));
		if(!$table){
			$this->restapi->error("Workshop not found!");
		}
		
		$table->name 		= $this->input->post("name");
		$table->description = $this->input->post("description");
		$table->location 	= $this->input->post('location');
		$table->google_map 	= $this->input->post('google_map');
		$table->start 		= $this->input->post("start");
		$table->end 		= $this->input->post("end");
		$table->status 		= ($this->input->post('status')) ? 'publish' : 'draft';

		if($this->validation->checkFiles("image")){
			$filename 				= 'WORKSHOP '.limit_string($this->input->post('name')).' ('.date('Ymdhis').')';
			$upload 				= $this->upfiles->allSizeImageUpload("workshop","image",$filename);

			if(!$upload->status){
				$this->restapi->error($upload->result);
			}

			if($table->image){
				$this->upfiles->remove("workshop",$table->image);	
			}

			$table->image 			= $upload->result;
		}

		if(!$table->save()){

			if($table->value){
				$this->upfiles->remove("workshop",$table->image);	
			}

			$this->restapi->error("Maaf ada kesalahan silahkan coba nanti");
		}

		$this->validation->setSuccess("Workshop '{$table->name}' telah di perbarui");
		$this->restapi->response("/superuser/workshop");
		
	}
}