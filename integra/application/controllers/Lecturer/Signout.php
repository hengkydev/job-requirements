<?php
class Signout extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->lecturer 	= $this->middleware->lecturer();
		$this->webdata->basicLoad();
	}

	public function index()
	{
		$this->session->unset_userdata('auth_lecturer');
		redirect('auth/lecturer');
	}
}