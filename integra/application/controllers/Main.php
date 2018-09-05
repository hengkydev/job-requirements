<?php
class Main extends CI_Controller {

	public function __construct()
	{
		parent::__construct();		
	}

	public function passwd(){
		echo DefuseLib::encrypt('adminaksamedia');
	}

	public function index(){
		echo "asdasd";
	}

	public function comingsoon(){
		echo $this->blade->draw('website.comingsoon');
	}

	public function news(){
		echo $this->blade->draw('website.news.index');
	}

	public function splash(){
		echo $this->blade->draw('website.splash.index');	
	}

	public function earnings_calendar(){
		echo $this->blade->draw('website.earnings_calendar.index');
	}

	public function hitmap(){
		$color 				= [
								'text-primary','text-danger','text-warning',
								'text-success',
							  ];
		echo $this->blade->draw('website.hitmap.index');
	}

	public function signin(){
		echo $this->blade->draw('website.authentication.signin');
	}
}
