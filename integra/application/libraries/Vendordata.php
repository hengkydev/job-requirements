<?php

class Vendordata {

	function __construct() {
		$this->ci =& get_instance(); 
		$this->ci->load->library('blade');
	}

	public function load(){
		$__CONFIG		= ConfigModel::first();
		$__VENDOR 		= $this->ci->middleware->vendor();		

		$__N_TRANS 		= TransactionDetailModel::status('approve')->mine($__VENDOR->id)->new()->get();
		$__N_TOTAL 		= count($__N_TRANS);

		$this->errorForm();		
		$this->ci->blade->share('__MENU','home');
		$this->ci->blade->share('__CONFIG',$__CONFIG);
		$this->ci->blade->share('__VENDOR',$__VENDOR);
		$this->ci->blade->share('__N_TOTAL',$__N_TOTAL);
		$this->ci->blade->share('__N_TRANS',$__N_TRANS);

		$csrf_name 	= $this->ci->security->get_csrf_token_name();
		$csrf_hash 	= $this->ci->security->get_csrf_hash();
		$html 		= '<div style="display:none !important;"><input type="hidden" name="'.$csrf_name.'" value="'.$csrf_hash.'"></div>';

		$this->ci->blade->share('csrf_name',$csrf_name);
		$this->ci->blade->share('csrf_hash',$csrf_hash);
		$this->ci->blade->share('csrf_input',$html);

	}

	public function show_404($page='vendor.error.404',array $data=[]){
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