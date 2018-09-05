<?php
class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->student 	= $this->middleware->student();
		$this->webdata->basicLoad();
	}

	public function index()
	{
		$data['__MENU']			= "home";
		$data['head_text']		= 'Beranda';
		$data['body_text']		= "Sistem E-Learning";
		echo $this->blade->draw('student.dashboard.index',$data);
	}
}