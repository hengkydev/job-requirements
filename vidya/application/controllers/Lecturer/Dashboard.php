<?php
class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->lecturer 	= $this->middleware->lecturer();
		$this->webdata->basicLoad();
	}

	public function index()
	{
		$data['__MENU']			= "home";
		$data['head_text']		= 'Beranda';
		$data['body_text']		= "Sistem E-Learning";
		echo $this->blade->draw('lecturer.dashboard.index',$data);
	}
}