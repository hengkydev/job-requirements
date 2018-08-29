<?php
class Signout extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->user 	= $this->middleware->user();
		$this->webdata->userLoad();
	}

	public function index()
	{
		$this->session->unset_userdata('auth_user');
		redirect('user');
	}
}