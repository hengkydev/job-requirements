<?php
class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->user 	= $this->middleware->user();
		$this->webdata->userLoad();
	}

	public function index()
	{
		echo $this->blade->draw("user.dashboard.index");
	}
}