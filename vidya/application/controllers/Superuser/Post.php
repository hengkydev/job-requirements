<?php
class Post extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->superuser 	= $this->middleware->superuser();
		$this->webdata->superuserLoad();
	}

	public function index()
	{
		$data['__MENU']			= "post";
		$data['head_text']		= 'Artikel';
		$data['body_text']		= "Daftar Artikel";
		$data['table'] 			= PostsModel::desc()->get();
		echo $this->blade->draw('superuser.post.index',$data);
	}

	public function create(){

		$data 		= [
			"__MENU"			=> "post_create",
			"type"				=> "create",
			"url_action"		=> base_url("superuser/post/created"),
			'head_text'			=> 'Buat Artikel',
			"body_text"			=> "Membuat Artikel Baru",
			"post_tags"			=> [],
			"category"			=> PostCategoriesModel::asc("name")->get(),
			"tags"				=> PostTagsModel::asc("name")->get(),
		];


		echo $this->blade->draw('superuser.post.content',$data);
	}

	public function update($id=null){

		if(!$id){
			show_404();
		}

		$table 		= PostsModel::find($id);

		if(!$table){
			show_404();
		}

		$data 		= [
			"__MENU"			=> "post_update",
			"type"				=> "update",
			"url_action"		=> base_url("superuser/post/updated"),
			'head_text'			=> 'Ubah Artikel',
			"body_text"			=> "Mengubah Artikel {$table->title}",
			"table"				=> $table,
			"category"			=> PostCategoriesModel::asc("name")->get(),
			"tags"				=> PostTagsModel::asc("name")->get(),
		];

		echo $this->blade->draw('superuser.post.content',$data);
	}

	public function created(){

		$rules = [
				    'required' 	=>	[
    					['title'],['category']
    				]
				 ];
		
		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}

		$category 				= PostCategoriesModel::find($this->input->post("category"));
		if(!$category){
			$this->restapi->error("Maaf kategori tidak di temukan!");
		}



		if($this->input->post("tags")){
			$tags 				= PostTagsModel::whereIn("id",$this->input->post("tags"))->get();
			if(!$tags){
				$this->restapi->error("Maaf Tag tidak di temukan");
			}
		}

		if(!$this->validation->checkFiles("image")){
			$this->restapi->error("Article Image required");
		}

		$table 					= new PostsModel;
		$table->category_id		= $category->id;
		$table->author_id		= $this->superuser->id;
		$table->author 			= $this->superuser->name;

		$table->title 			= $this->input->post("title");
		$table->slug 			= seo($table->title);
		$table->description 	= $this->security->xss_clean($this->input->post("description"));
		$table->status 			= ($this->input->post("status")) ? "publish" : "draft";

		$filename 				= 'POSTS '.limit_string($this->input->post('title')).' ('.date('Ymdhis').')';
		$upload 				= $this->upfiles->allSizeImageUpload("posts","image",$filename);

		if(!$upload->status){
			$this->restapi->error($upload->result);
		}

		$table->image 			= $upload->result;

		if(!$table->save()){

			if($table->image){
				$this->upfiles->remove("posts",$table->image);	
			}

			$this->restapi->error("Maaf ada kesalahan silahkan coba nanti");
		}

		if(isset($tags)){
			foreach ($tags as $result) {
				$tags 				= new PostTagsUseModel;
				$tags->tag_id 		= $result->id;
				$tags->post_id 		= $table->id;
				$tags->save();
			}
		}

		$this->validation->setSuccess("Artikel baru telah ditambahkan");
		$this->restapi->response("/superuser/post");

	}

	public function updated(){

		$rules = [
				    'required' 	=>	[
    					['id'],['title'],['category']
    				]
				 ];
		
		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}

		$table 					= PostsModel::find($this->input->post("id"));
		if(!$table){
			$this->restapi->error("Artikel tidak ditemukan !");
		}

		$category 				= PostCategoriesModel::find($this->input->post("category"));
		if(!$category){
			$this->restapi->error("Maaf kategori tidak di temukan!");
		}

		if($this->input->post("tags")){
			$tags 				= PostTagsModel::whereIn("id",$this->input->post("tags"))->get();
			if(!$tags){
				$this->restapi->error("Maaf Tag tidak di temukan");
			}
		}

		$table->category_id		= $category->id;
		$table->author_id		= $this->superuser->id;
		$table->author 			= $this->superuser->name;

		$table->title 			= $this->input->post("title");
		$table->slug 			= seo($table->title);
		$table->description 	= $this->security->xss_clean($this->input->post("description"));
		$table->status 			= ($this->input->post("status")) ? "publish" : "draft";

		if($this->validation->checkFiles("image")){

			$filename 				= 'POSTS '.limit_string($this->input->post('title')).' ('.date('Ymdhis').')';
			$upload 				= $this->upfiles->allSizeImageUpload("posts","image",$filename);

			if(!$upload->status){
				$this->restapi->error($upload->result);
			}
		}


		if(!$table->save()){

			if($table->image){
				$this->upfiles->remove("posts",$table->image);	
			}

			$this->restapi->error("Maaf ada kesalahan silahkan coba nanti");
		}


		if($table->image && isset($upload->status)){
			$this->upfiles->remove("posts",$table->image);	
			$table->image 			= $upload->result;
		}

		$table->save();

		PostTagsUseModel::where("post_id",$table->id)->delete();

		if(isset($tags)){
			foreach ($tags as $result) {
				$tags 				= new PostTagsUseModel;
				$tags->tag_id 		= $result->id;
				$tags->post_id 		= $table->id;
				$tags->save();
			}
		}

		$this->validation->setSuccess("Artikel '{$table->title}' telah di perbarui");
		$this->restapi->response("/superuser/post");

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
		$table 		= PostsModel::whereIn('id',$this->input->post('data'))->get();

		if(count($table)<=0){
			$this->validation->setError("Tidak ada data yang di pilih!");
			redirect('superuser/post');
		}

		switch ($action) {
			case 'publish':
				PostsModel::whereIn('id',$this->input->post('data'))->update(['status'=>'publish']);
				$this->validation->setSuccess("Data menjadi 'publish'");
				break;
			case 'draft':
				PostsModel::whereIn('id',$this->input->post('data'))->update(['status'=>'draft']);
				$this->validation->setSuccess("Data Menjadi 'Draft'");
				break;
			case 'delete':
				$table 	= PostsModel::whereIn('id',$this->input->post('data'))->get();
				foreach ($table as $result) {
					if($result->image){
						$this->upfiles->remove("posts",$result->image);	
					}
				}

				PostsModel::whereIn('id',$this->input->post('data'))->delete();
				$this->validation->setSuccess("Data telah terhapus");
				break;
			default:
				show_404();
				break;
		}

		redirect('superuser/post');
		return;
	}

	public function remove($id=null){
		if(!$id){
			show_404();
		}

		$table 		= PostsModel::find($id);
		if(!$table){
			show_404();
		}

		if($table->image){
			$this->upfiles->remove("posts",$table->image);	
		}

		$table->delete();
		$this->validation->setSuccess("Artikel '{$table->title}' telah di hapus");
		redirect("superuser/post");
	}
}