<?php
class Api extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->user 	= $this->middleware->user();
		$this->webdata->userLoad();
	}

	public function Globalindex()
	{

		$watchlists = $this->user->watchlists->where("type","gi")->pluck("data")->toArray();

		$data 		= Requestdata::globalIndicies($watchlists);

		if(!$data->status){
			$this->restapi->error($data->message);
		}

		$this->restapi->response($data->results);
	}

	public function stocks(){
		$watchlists = $this->user->watchlists->where("type","stock")->pluck("data")->toArray();

		$data 		= Requestdata::stocks($watchlists);

		if(!$data->status){
			$this->restapi->error($data->message);
		}

		$this->restapi->response($data->results);
	}

	public function watchlists(){

		$watchlists = $this->user->watchlists;

		$data 		= Requestdata::watchlists($watchlists,true);

		if(!$data->status){
			$this->restapi->error($data->message);
		}

		$this->restapi->response($data->results);
		
	}

	public function earningscalendar()
	{

		$watchlists = $this->user->watchlists->where("type","ec")->pluck("data")->toArray();

		$_POST['country'][] 	= 5;
		$_POST['dateFrom']		= date("Y-m-d");
		$_POST['dateTo'] 		= date("Y-m-d",strtotime("+3 months"));
		$_POST['currentTab']	= 'custom';
		$_POST['limit_from']	= 0;
		$data 		= Requestdata::earningsCalendar($watchlists);

		if(!$data->status){
			$this->restapi->error($data->message);
		}

		$this->restapi->response($data->results);
	}

	public function currencies()
	{
		$data = Requestdata::currencies();
		
		if(!$data->status){
			$this->restapi->error($data->message);
		}

		$this->restapi->response($data->results);
	}

	public function commodities()
	{
		$data = Requestdata::commodities();
		
		if(!$data->status){
			$this->restapi->error($data->message);
		}

		$this->restapi->response($data->results);
	}

	public function economiccalendar()
	{
		$data = Requestdata::economicCalendar();
		if(!$data->status){
			$this->restapi->error($data->message);
		}

		$this->restapi->response($data->results);
	}
}