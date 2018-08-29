<?php
class Seo extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->superuser 	= $this->middleware->superuser();
		$this->webdata->superuserLoad();
	}

	public function index()
	{
		$data['__MENU']				= "seo";
		$data['head_text']			= 'SEO';
		$data['body_text']			= "Konfigurasi SEO";
		$data['table'] 				= SeoModel::first();
		$data["url_action"]			= base_url("superuser/seo/apply");
		echo $this->blade->draw('superuser.seo.content',$data);
	}

	public function apply(){

		$rules = [
				    'required' 	=>	[
    					['title'],['author'],['description'],
    					['keywords']
    				]
				 ];
		
		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}

		$table 				= SeoModel::first();
		$table->title 		= $this->input->post("title");
		$table->author 		= $this->input->post("author");
		$table->keywords 	= $this->input->post("keywords");
		$table->description = $this->input->post("description");

		$table->google_tracking_id 	= $this->input->post("google_tracking_id");
		$table->fb_pixel 			= $this->input->post("fb_pixel");

		if(!$table->save()){
			$this->restapi->error("Maaf ada kesalahan silahkan coba nanti");
		}

		$this->validation->setSuccess("Konfigurasi SEO telah di perbarui");
		$this->restapi->response("/superuser/seo");

	}
}