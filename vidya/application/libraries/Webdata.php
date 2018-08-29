<?php

class Webdata {

	function __construct() {
		$this->ci =& get_instance(); 
		$this->ci->load->library('blade');
	}

	public function load($type="public"){

		$this->errorForm();
		
		$this->ci->blade->share('__MENU','home');

		$csrf_name 	= $this->ci->security->get_csrf_token_name();
		$csrf_hash 	= $this->ci->security->get_csrf_hash();
		$html 		= '<div style="display:none !important;"><input type="hidden" name="'.$csrf_name.'" value="'.$csrf_hash.'"></div>';

		$this->ci->blade->share('csrf_name',$csrf_name);
		$this->ci->blade->share('csrf_hash',$csrf_hash);
		$this->ci->blade->share('csrf_input',$html);
		$this->ci->blade->share('ctrl',$this->ci);

	}

	public function basicLoad(){
		
		$this->errorForm();
		
		$this->ci->blade->share('__MENU','home');

		$csrf_name 	= $this->ci->security->get_csrf_token_name();
		$csrf_hash 	= $this->ci->security->get_csrf_hash();
		$html 		= '<div style="display:none !important;"><input type="hidden" name="'.$csrf_name.'" value="'.$csrf_hash.'"></div>';

		$information 	= InformationModel::first();
		$seo 			= SeoModel::first();

		$this->ci->blade->share('__INFO',$information);
		$this->ci->blade->share('__SEO',$seo);
		$this->ci->blade->share('csrf_name',$csrf_name);
		$this->ci->blade->share('csrf_hash',$csrf_hash);
		$this->ci->blade->share('csrf_input',$html);
		$this->ci->blade->share('ctrl',$this->ci);		
	}

	public function superuserLoad(){

		$this->errorForm();
		
		$this->ci->blade->share('__MENU','home');

		$csrf_name 	= $this->ci->security->get_csrf_token_name();
		$csrf_hash 	= $this->ci->security->get_csrf_hash();
		$html 		= '<div style="display:none !important;"><input type="hidden" name="'.$csrf_name.'" value="'.$csrf_hash.'"></div>';

		$information 	= InformationModel::first();
		$seo 			= SeoModel::first();

		$this->ci->blade->share('__INFO',$information);
		$this->ci->blade->share('__SEO',$seo);
		$this->ci->blade->share('csrf_name',$csrf_name);
		$this->ci->blade->share('csrf_hash',$csrf_hash);
		$this->ci->blade->share('csrf_input',$html);
		$this->ci->blade->share('ctrl',$this->ci);			
	}

	public function userLoad(){

		$this->errorForm();
		
		$this->ci->blade->share('__MENU','home');

		$csrf_name 	= $this->ci->security->get_csrf_token_name();
		$csrf_hash 	= $this->ci->security->get_csrf_hash();
		$html 		= '<div style="display:none !important;"><input type="hidden" name="'.$csrf_name.'" value="'.$csrf_hash.'"></div>';

		$information 	= InformationModel::first();
		$seo 			= SeoModel::first();

		$this->ci->blade->share('__INFO',$information);
		$this->ci->blade->share('__SEO',$seo);
		$this->ci->blade->share('csrf_name',$csrf_name);
		$this->ci->blade->share('csrf_hash',$csrf_hash);
		$this->ci->blade->share('csrf_input',$html);
		$this->ci->blade->share('ctrl',$this->ci);			
	}

	public function show_404($page='website.error.404',array $data=[]){
		$this->load();
		http_response_code();
		http_response_code(404);
		$data['__MENU'] 	= '404';
		echo $this->ci->blade->draw($page,$data);	
		exit();
	}

	private function errorForm(){
		$hasError 				= false;
		$hasSuccess 			= false;
		$errors 				= [];

		if($this->ci->session->userdata('hasSuccess')){
			$hasSuccess 		= $this->ci->session->userdata('hasSuccess');
		}


		if($this->ci->session->userdata('hasError')){
			$hasError 			= $this->ci->session->userdata('hasError');
		}

		if($this->ci->session->userdata('errors')){
			$errors 			= $this->ci->session->userdata('errors');
		}

		$this->ci->blade->share('hasError',$hasError);
		$this->ci->blade->share('hasSuccess',$hasSuccess);
		$this->ci->blade->share('errors',$errors);
	}
}