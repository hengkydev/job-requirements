<?php 
use Valitron\Validator as V;

class Validation  {

	function __construct() {
		$this->ci =& get_instance(); 
		$this->ci->load->library('session');
		$this->ci->load->helper('file');
	}

	public function method($method){
		$method 	= strtoupper($method);

		$request 	= $_SERVER['REQUEST_METHOD'];

		if($request!=$method){

			if($this->ci->input->is_ajax_request()){
				$this->restapi->error('Invalid Method');
			}

			$this->webdata->show_404();
		}

	}

	public function checkFiles($name){
		if($_FILES[$name]['size'] == 0 && $_FILES[$name]['name'] == false){
			return false;
		}

		return true;
	}

	public function check($rules,$type){

		if($type=="post"){
			$v = new Valitron\Validator($_POST);
			if(!$this->ci->input->is_ajax_request()){
				$this->ci->session->set_flashdata('form_value',$_POST);	
			}
			
		}
		else {
			$v = new Valitron\Validator($_GET);		
			if(!$this->ci->input->is_ajax_request()){
				$this->ci->session->set_flashdata('form_value',$_GET);
			}
		}

		$response['correct'] 		= true;
		$response['data'] 			= [];



		$v->rules($rules);

		if(!$v->validate()){

			$response['correct']	= false;

			foreach ($v->errors() as $key => $value) {
				$response['data'] = @$value[0];
				break;
			}

			foreach ($v->errors() as $key => $value) {
				$response['all'][$key] 	= @$value[0];
			}

			//$response['all'] 		= $v->errors();

			if(!$this->ci->input->is_ajax_request()){
				$this->ci->session->set_flashdata('hasError',true);
				$this->ci->session->set_flashdata('errors',$response['all']);
			}

			return goObject($response);
		}

		if(!$this->ci->input->is_ajax_request()){
			$this->ci->session->set_flashdata('hasError',false);
			$this->ci->session->set_flashdata('errors',null);
		}

		return goObject($response);
	}


	public function ajaxRequest($throw="index"){

		if(!$this->ci->input->is_ajax_request() && $this->ci->input->server('REQUEST_METHOD') != 'POST'){
			switch ($throw) {
				case 'root':
					$this->ci->rootdata->show_404();
					break;
				case 'vendor':
					$this->ci->vendordata->show_404();
					break;
				default:
					$this->ci->webdata->show_404();
					break;
			}
		}
	}

	public function findRoutes($string){

		$string 	= strtolower($string);
		$controllers = array();

	    $files = get_dir_file_info(APPPATH.'controllers', FALSE);
	    foreach ( array_keys($files) as $file ) {
	        if ( $file != 'index.html' )
	            $controllers[] = strtolower(str_replace('.php', '', $file));
	    }

	    foreach (array_keys($this->ci->router->routes) as $result) {
	    	$controllers[] 		= strtolower($result);
	    }
	    
	    if(in_array($string, $controllers)){
	    	return true;
	    }

	    foreach ($controllers as $result) {
	    	if (strpos($result, $string) !== false) {
			    return true;
			}
	    }

	    return false;
	}

	public function setError($msg="There's something error"){

		$this->ci->session->set_flashdata('hasError',$msg);
		$this->ci->session->set_flashdata('errors',$msg);

	}

	public function setSuccess($msg=false){
		$this->ci->session->set_flashdata('hasSuccess',$msg);
	}

	public function showError($name){
		$errors 				= $this->ci->session->userdata('errors');

		if(!$errors){
			return;
		}
		return @$errors[$name];
	}

	public function value($name){ 
		$value 					= $this->ci->session->userdata('form_value');

		if(!$value){
			return;
		}

		return @$value[$name];
	}

	public function suspendRoot(){

		if(!$this->ci->session->userdata('suspend_root')){
			return false;
		}

		$suspend 	= toObject($this->ci->session->userdata('suspend_root'));

		if($suspend->status){

			$now 	= new DateTime();
			$date 	= new DateTime($suspend->time);

			if($now > $date ) {

			    $data 	= [
							'suspend_root'	=> [
										'status'	=> false ,
										'chance' 	=> 3,
								 ]
							 ];
				$this->ci->session->set_userdata($data);
				return false;

			}else{
				
				return true;
			}
		}else{

			return false;
		}
	}

	public function setSuspendRoot(){

		if($this->ci->session->userdata('suspend_root')){

			$suspend 		= toObject($this->ci->session->userdata('suspend_root'));

			if($suspend->chance<=0)	{

				$data 	= [
							'suspend_root'	=> [
									'status'	=> true ,
									'chance' 	=> 0,
									'time'		=> add_minutes(1)
							 ]
						 ];
						 
				$this->ci->session->set_userdata($data);

			}else{
				$data 	= [
							'suspend_root'	=> [
										'status'	=> false ,
										'chance' 	=> ($suspend->chance - 1)
								 ]
							 ];
				$this->ci->session->set_userdata($data);
			}

		}else{
			$data 	= [
						'suspend_root'	=> [
									'status'	=> false ,
									'chance' 	=> 3,
							 ]
						 ];
			$this->ci->session->set_userdata($data);
		}

		return toObject($this->ci->session->userdata('suspend_root'));
	}


	public function gRecaptcha()
	{	
		if(!G_RECAPTCHA){
			return true;
		}

		if(!isset($_POST['g-recaptcha-response'])){
			$this->ci->restapi->error("Kesalahan pada Recaptcha");
		}

		$recaptcha = new \ReCaptcha\ReCaptcha(G_RECAPTCHA_SECRET_KEY);
		$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
		if ($resp->isSuccess()) {
			 return true;
		} else {
		    $this->ci->restapi->error( $resp->getErrorCodes());
		}

	}


}