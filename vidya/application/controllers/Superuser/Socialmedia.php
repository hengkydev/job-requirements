<?php
class Socialmedia extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->superuser 	= $this->middleware->superuser();
		$this->webdata->superuserLoad();
	}

	public function index()
	{
		$data['__MENU']				= "socialmedia";
		$data['head_text']			= 'Social Media';
		$data['body_text']			= "Daftar Social Media";
		$data['table'] 				= SocialMediaModel::desc()->get();
		echo $this->blade->draw('superuser.socialmedia.index',$data);
	}

	public function create(){

		$data 		= [
			"__MENU"			=> "socialmedia_create",
			"type"				=> "create",
			"url_action"		=> base_url("superuser/socialmedia/created"),
			'head_text'			=> 'Buat Social Media',
			"body_text"			=> "Membuat Social Media Baru",
			"data_type"			=> ['facebook','gplus','instagram','youtube','twitter','pinterest','flickr','tumblr','linkedn','reddit','vine']
		];

		echo $this->blade->draw('superuser.socialmedia.content',$data);
	}

	public function created(){

		$rules = [
				    'required' 	=>	[
    					['name'],['url'],['type']
    				],
    				'in'		=> [
    					['type',  ['facebook','gplus','instagram','youtube','twitter','pinterest','flickr','tumblr','linkedn','reddit','vine'] ]
    				]
				 ];
		
		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}

		$table 				= new SocialMediaModel;
		$table->name 		= $this->input->post("name");
		$table->url 		= $this->input->post("url");
		$table->type 		= $this->input->post("type");

		if(!$table->save()){

			$this->restapi->error("Maaf ada kesalahan silahkan coba nanti");
		}

		$this->validation->setSuccess("Social Media baru telah ditambahkan");
		$this->restapi->response("/superuser/socialmedia");

	}

	public function update($id=null){

		if(!$id){
			show_404();
		}

		$table 		= SocialMediaModel::find($id);
		if(!$table){
			show_404();
		}


		$data 		= [
			"__MENU"			=> "socialmedia_update",
			"type"				=> "update",
			"url_action"		=> base_url("superuser/socialmedia/updated"),
			'head_text'			=> 'Ubah Social Media',
			"body_text"			=> "Mengubah Kategori {$table->name}",
			"data_type"			=> ['facebook','gplus','instagram','youtube','twitter','pinterest','flickr','tumblr','linkedn','reddit','vine'],
			"table"				=> $table,
		];

		echo $this->blade->draw('superuser.socialmedia.content',$data);
	}

	public function updated(){

		$rules = [
				    'required' 	=>	[
    					['id'],['name'],['url'],['type']
    				],
    				'in'		=> [
    					['type',  ['facebook','gplus','instagram','youtube','twitter','pinterest','flickr','tumblr','linkedn','reddit','vine'] ]
    				]
				 ];
		
		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}

		$table 				= SocialMediaModel::find($this->input->post('id'));
		if(!$table){
			$this->restapi->error("Social Media not found!");
		}

		$table->name 		= $this->input->post("name");
		$table->url 		= $this->input->post("url");
		$table->type 		= $this->input->post("type");

		if(!$table->save()){

			$this->restapi->error("Maaf ada kesalahan silahkan coba nanti");
		}

		$this->validation->setSuccess("Social Media '{$table->name}' telah di perbarui");
		$this->restapi->response("/superuser/socialmedia");

	}

	public function bulkaction(){

		$rules = [
				    'required' 	=> [
				        ['action'],['data']
				    ]
				  ];

		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}

		$action 		= $this->input->post('action');
		$selectedData 	= $this->input->post('data');
		$table 			= SocialMediaModel::whereIn('id',$selectedData)->get();

		if(!$table){
			$this->restapi->error("no data selected");
		}

		switch ($action) {
			case 'publish':

				SocialMediaModel::whereIn('id',$selectedData)->update(['status'=>0]);
				$this->validation->setSuccess("Changed to publish");	
				$this->restapi->success("Changed to publish");

				break;
			case 'draft':

				SocialMediaModel::whereIn('id',$selectedData)->update(['status'=>1]);
				$this->validation->setSuccess("Changed to draft");	
				$this->restapi->success("Changed to draft");

				break;
			case 'delete':
				$table 	= SocialMediaModel::whereIn('id',$selectedData)->get();
				foreach ($table as $result) {
					if($result->image!=""){
						$this->upfiles->remove("socialmedia",$result->image);	
					}
				}

				SocialMediaModel::whereIn('id',$selectedData)->delete();
				$this->validation->setSuccess('data deleted');	
				$this->restapi->success("data deleted");

				break;
			default:
				show_404();
				break;
		}

	}

	public function remove($id=null){
		if(!$id){
			show_404();
		}

		$table 		= SocialMediaModel::find($id);
		if(!$table){
			show_404();
		}

		$table->delete();
		$this->validation->setSuccess("Social Media '{$table->name}' telah di hapus");
		redirect("superuser/socialmedia");
	}
}