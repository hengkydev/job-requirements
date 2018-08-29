<?php
class Configuration extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->superuser 	= $this->middleware->superuser();
		$this->webdata->superuserLoad();
	}

	public function index()
	{
		$data['__MENU']				= "config";
		$data['head_text']			= 'Konfigurasi';
		$data['body_text']			= "Konfigurasi Website";
		$data['table'] 				= InformationModel::first();
		$data["url_action"]			= base_url("superuser/configuration/apply");
		echo $this->blade->draw('superuser.configuration.content',$data);
	}

	public function apply(){

		$rules = [
				    'required' 	=>	[
    					['name'],['company_name'],['phone'],
    					['address'],['website_status']
    				],
    				'in'		=> [
    					['website_status',['maintenance','open']]
    				]
				 ];
		
		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}

		$table 						= InformationModel::first();

		$table->name 				= $this->input->post("name");
		$table->company_name 		= $this->input->post("company_name");
		$table->phone 				= $this->input->post("phone");
		$table->phone_2 			= $this->input->post("phone_2");
		$table->whatsapp 			= $this->input->post("whatsapp");
		$table->bbm 				= $this->input->post("bbm");
		$table->address 			= $this->input->post("address");
		$table->zipcode 			= $this->input->post("zipcode");
		$table->gmap 				= $this->input->post("gmap");
		$table->gmap_query 			= $this->input->post("gmap_query");
		$table->website_status 		= $this->input->post("website_status");

		/**
	
		Logo Uploading code ... (>_<)
		*/
		// Main Logo
		if($this->validation->checkFiles("logo")){

			$filename 				= 'LOGO '.limit_string($table->name).' ('.date('Ymdhis').')';
			$upload_logo 			= $this->upfiles->allSizeImageUpload("logo","logo",$filename);

			if(!$upload_logo->status){
				$this->restapi->error($upload_logo->result);
			}
		}

		// White Logo
		if($this->validation->checkFiles("logo_white")){

			$filename 				= 'LOGO_WHITE '.limit_string($table->name).' ('.date('Ymdhis').')';
			$upload_logo_white 		= $this->upfiles->allSizeImageUpload("logo","logo_white",$filename);

			if(!$upload_logo_white->status){
				$this->restapi->error($upload_logo_white->result);
			}
		}

		// Dark Logo
		if($this->validation->checkFiles("logo_dark")){

			$filename 				= 'LOGO_DARK '.limit_string($table->name).' ('.date('Ymdhis').')';
			$upload_logo_dark 		= $this->upfiles->allSizeImageUpload("logo","logo_dark",$filename);

			if(!$upload_logo_dark->status){
				$this->restapi->error($upload_logo_dark->result);
			}
		}

		/**
	
		Icon Uploading code ... (>_<)
		*/
		// Main Icon
		if($this->validation->checkFiles("icon")){

			$filename 				= 'ICON '.limit_string($table->name).' ('.date('Ymdhis').')';
			$upload_icon 			= $this->upfiles->allSizeImageUpload("icon","icon",$filename);

			if(!$upload_icon->status){
				$this->restapi->error($upload_icon->result);
			}
		}

		// White Icon
		if($this->validation->checkFiles("icon_white")){

			$filename 				= 'ICON_WHITE '.limit_string($table->name).' ('.date('Ymdhis').')';
			$upload_icon_white 		= $this->upfiles->allSizeImageUpload("icon","icon_white",$filename);

			if(!$upload_icon_white->status){
				$this->restapi->error($upload_icon_white->result);
			}
		}

		// Dark Icon
		if($this->validation->checkFiles("icon_dark")){

			$filename 				= 'ICON_DARK '.limit_string($table->name).' ('.date('Ymdhis').')';
			$upload_icon_dark 		= $this->upfiles->allSizeImageUpload("icon","icon_dark",$filename);

			if(!$upload_icon_dark->status){
				$this->restapi->error($upload_icon_dark->result);
			}
		}

		if(!$table->save()){
			$this->restapi->error("Maaf ada kesalahan silahkan coba nanti");
		}


		/** LOGO removing old one if uploadnew one */
		if(isset($upload_logo->status)){
			if($table->logo){
				$this->upfiles->remove("logo",$table->logo);	
			}
			$table->logo 			= $upload_logo->result;
		}

		if(isset($upload_logo_white->status)){
			if($table->logo_white){
				$this->upfiles->remove("logo",$table->logo_white);	
			}
			$table->logo_white 		= $upload_logo_white->result;
		}

		if(isset($upload_logo_dark->status)){
			if($table->logo_dark){
				$this->upfiles->remove("logo",$table->logo_dark);	
			}
			$table->logo_dark 		= $upload_logo_dark->result;
		}

		/** ICON removing old one if uploadnew one */
		if(isset($upload_icon->status)){
			if($table->icon){
				$this->upfiles->remove("icon",$table->icon);	
			}
			$table->icon 			= $upload_icon->result;
		}

		if(isset($upload_icon_white->status)){
			if($table->icon_white){
				$this->upfiles->remove("icon",$table->icon_white);	
			}
			$table->icon_white 		= $upload_icon_white->result;
		}

		if(isset($upload_icon_dark->status)){
			if($table->icon_dark){
				$this->upfiles->remove("icon",$table->icon_dark);	
			}
			$table->icon_dark 		= $upload_icon_dark->result;
		}

		$table->save();

		$this->validation->setSuccess("Konfigurasi Website telah di perbarui");
		$this->restapi->response("/superuser/configuration");

	}
}