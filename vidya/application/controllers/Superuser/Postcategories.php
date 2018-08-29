<?php
class Postcategories extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->superuser 	= $this->middleware->superuser();
		$this->webdata->superuserLoad();
	}

	public function index()
	{
		$data['__MENU']				= "postcategories";
		$data['head_text']			= 'Post Kategori';
		$data['body_text']			= "Daftar Post Kategori";
		$data['table'] 	= PostCategoriesModel::desc()->get();
		echo $this->blade->draw('superuser.postcategories.index',$data);
	}

	public function create(){

		$data 		= [
			"__MENU"			=> "postcategories_create",
			"type"				=> "create",
			"url_action"		=> base_url("superuser/postcategories/created"),
			'head_text'			=> 'Buat kategori',
			"body_text"			=> "Membuat Post Kategori Baru"
		];

		echo $this->blade->draw('superuser.postcategories.content',$data);
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

		$table 				= new PostCategoriesModel;
		$table->name 		= $this->input->post("name");
		$table->description = $this->input->post("description");

		if(!$table->save()){

			$this->restapi->error("Maaf ada kesalahan silahkan coba nanti");
		}

		$this->validation->setSuccess("Post Kategori baru telah ditambahkan");
		$this->restapi->response("/superuser/postcategories");

	}

	public function update($id=null){

		if(!$id){
			show_404();
		}

		$table 		= PostCategoriesModel::find($id);
		if(!$table){
			show_404();
		}


		$data 		= [
			"__MENU"			=> "postcategories_update",
			"type"				=> "update",
			"url_action"		=> base_url("superuser/postcategories/updated"),
			'head_text'			=> 'Ubah kategori',
			"body_text"			=> "Mengubah Kategori {$table->name}",
			"table"				=> $table,
		];

		echo $this->blade->draw('superuser.postcategories.content',$data);
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

		$table 				= PostCategoriesModel::find($this->input->post('id'));
		if(!$table){
			$this->restapi->error("Post Kategori not found!");
		}

		$table->name 		= $this->input->post("name");
		$table->description = $this->input->post("description");

		if(!$table->save()){

			$this->restapi->error("Maaf ada kesalahan silahkan coba nanti");
		}

		$this->validation->setSuccess("Post Kategori '{$table->name}' telah di perbarui");
		$this->restapi->response("/superuser/postcategories");

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
		$table 		= PostCategoriesModel::whereIn('id',$this->input->post('data'))->get();

		if(count($table)<=0){
			$this->validation->setError("Tidak ada data yang di pilih!");
			redirect('superuser/postcategories');
		}

		switch ($action) {
			case 'delete':
				PostCategoriesModel::whereIn('id',$this->input->post('data'))->delete();
				$this->validation->setSuccess("Data telah terhapus");
				break;
			default:
				show_404();
				break;
		}

		redirect('superuser/postcategories');
		return;
	}

	public function remove($id=null){
		if(!$id){
			show_404();
		}

		$table 		= PostCategoriesModel::find($id);
		if(!$table){
			show_404();
		}

		$table->delete();
		$this->validation->setSuccess("Post Kategori '{$table->name}' telah di hapus");
		redirect("superuser/postcategories");
	}
}