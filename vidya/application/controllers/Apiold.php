<?php

class Api extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->restapi->validateKey();
	}

	public function index(){
		$this->restapi->response('OK, API KEY VALID');
	}


}