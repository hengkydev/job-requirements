<?php
class Signout extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->student 	= $this->middleware->student();
		$this->webdata->basicLoad();
	}

	public function index()
	{
		$this->session->unset_userdata('auth_student');
		redirect('auth/student');
	}
}