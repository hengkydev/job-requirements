<?php
class Amibroker extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->restapi->validateKey();
	}

	public function index(){
		$this->restapi->response($this->user->toArray());
	}

	public function run(){
		if($this->input->post("filename")){
			$filename 	= strtoupper($this->input->post("filename"));
			exec('Wscript.exe "C:/xampp/htdocs/amjis/'.$filename.'.js"');
			$this->restapi->response(content_url("amibroker/{$filename}.gif"));

		}else{

			$rules = [
					    'required' 	=> [
					    	['name'],
					        ['type'],
					        ['value']
					    ]
					 ];

			$validate 	= $this->validation->check($rules,'post');

			if(!$validate->correct){
				$this->restapi->error($validate->data);
			}

			$value 	= $this->input->post("value");
			$type 	= strtoupper($this->input->post("type"));
			$name 	= strtoupper($this->input->post("name"));

			if(!in_array($value,['1','15'])){
				$this->restapi->error("Invalid value must be [1,15]");
			}

			if(!in_array($type,['H','D','M','W'])){
				$this->restapi->error("Invalid type must be [H,D,M,W] represent hours,day,minutes,week");
			}

			$amibroker 	= AmibrokerModel::where("symbol",$name)->first();
			if(!$amibroker){
				$this->restapi->error("Name not found on amibroker list");
			}
			$filename 	= $amibroker->symbol.$type.$value;
			exec('Wscript.exe "C:/xampp/htdocs/amjis/'.$filename.'.js"');
			$this->restapi->response(content_url("amibroker/{$filename}.gif"));


		}
	}
	
	public function lists(){
		$table = AmibrokerModel::get()->toArray();
		$this->restapi->response($table);
	}

	public function listsfile(){
		$files = scandir("C:/xampp/htdocs/amjis/");
		$this->restapi->response($files);
	}
}