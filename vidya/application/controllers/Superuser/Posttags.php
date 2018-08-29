<?php
class Posttags extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->superuser 	= $this->middleware->superuser();
		$this->webdata->superuserLoad();
	}

	public function index()
	{
		$data['__MENU']				= "posttags";
		$data['head_text']			= 'Post Tag';
		$data['body_text']			= "Daftar Post Tag";
		$data['table'] 				= PostTagsModel::desc()->get();
		echo $this->blade->draw('superuser.posttags.index',$data);
	}

	public function create(){

		$data 		= [
			"__MENU"			=> "posttags_create",
			"type"				=> "create",
			"url_action"		=> base_url("superuser/posttags/created"),
			'head_text'			=> 'Buat kategori',
			"body_text"			=> "Membuat Post Tag Baru"
		];

		echo $this->blade->draw('superuser.posttags.content',$data);
	}

	public function created(){

		$rules = [
				    'required' 	=>	[
    					['name']
    				]
				 ];
		
		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}

		$table 				= new PostTagsModel;
		$table->name 		= $this->input->post("name");
		$table->description = $this->input->post("description");

		if(!$table->save()){

			$this->restapi->error("Maaf ada kesalahan silahkan coba nanti");
		}

		$this->validation->setSuccess("Post Tag baru telah ditambahkan");
		$this->restapi->response("/superuser/posttags");

	}

	public function update($id=null){

		if(!$id){
			show_404();
		}

		$table 		= PostTagsModel::find($id);
		if(!$table){
			show_404();
		}


		$data 		= [
			"__MENU"			=> "posttags_update",
			"type"				=> "update",
			"url_action"		=> base_url("superuser/posttags/updated"),
			'head_text'			=> 'Ubah kategori',
			"body_text"			=> "Mengubah Kategori {$table->name}",
			"table"				=> $table,
		];

		echo $this->blade->draw('superuser.posttags.content',$data);
	}

	public function updated(){

		$rules = [
				    'required' 	=>	[
    					['id'],['name']
    				]
				 ];
		
		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}

		$table 				= PostTagsModel::find($this->input->post('id'));
		if(!$table){
			$this->restapi->error("Post Tag not found!");
		}

		$table->name 		= $this->input->post("name");
		$table->description = $this->input->post("description");

		if(!$table->save()){

			$this->restapi->error("Maaf ada kesalahan silahkan coba nanti");
		}

		$this->validation->setSuccess("Post Tag '{$table->name}' telah di perbarui");
		$this->restapi->response("/superuser/posttags");

	}

	public function bulkaction(){
		$rules = [
					'required' 	=> [
				        ['action'],['data']
				    ]
				  ];

		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->validation->setError($validate->data);
		}

		$action 	= $this->input->post('action');
		$table 		= PostTagsModel::whereIn('id',$this->input->post('data'))->get();

		if(count($table)<=0){
			$this->validation->setError("Tidak ada data yang di pilih!");
			redirect('superuser/posttags');
		}

		switch ($action) {
			case 'delete':
				PostTagsModel::whereIn('id',$this->input->post('data'))->delete();
				$this->validation->setSuccess("Data telah terhapus");
				break;
			default:
				show_404();
				break;
		}

		redirect('superuser/posttags');
		return;
	}

	public function remove($id=null){
		if(!$id){
			show_404();
		}

		$table 		= PostTagsModel::find($id);
		if(!$table){
			show_404();
		}

		$table->delete();
		$this->validation->setSuccess("Post Tag '{$table->name}' telah di hapus");
		redirect("superuser/posttags");
	}
}