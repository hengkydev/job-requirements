<?php
class Manage extends CI_Controller {

	public function __construct()
	{
		parent::__construct();		
	}

	public function index(){
		echo $this->blade->draw('dashboard.index');

	}
}
