<?php
class Signin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();		
	}

	public function index(){
		echo $this->blade->draw('template.login');

	}
}
