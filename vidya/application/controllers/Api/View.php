<?php
class View extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->restapi->validateKey();
		$this->user 	= $this->middleware->api_user();
	}

	public function commodities(){
		$data = Requestdata::commodities();
		
		if(!$data->status){
			$this->restapi->error($data->message);
		}

		$this->restapi->response($data->results);
	}

	public function currencies(){
		$data = Requestdata::currencies();
		
		if(!$data->status){
			$this->restapi->error($data->message);
		}

		$this->restapi->response($data->results);
	}

	public function earningscalendar(){

		$watchlists = $this->user->watchlists->where("type","ec")->pluck("data")->toArray();

		$data 		= Requestdata::earningsCalendar($watchlists);

		if(!$data->status){
			$this->restapi->error($data->message);
		}

		$this->restapi->response($data->results);
		
	}

	public function economiccalendar(){
		$data = Requestdata::economicCalendar();
		if(!$data->status){
			$this->restapi->error($data->message);
		}

		$this->restapi->response($data->results);
	}

	public function stocks(){

		$name 		= $this->input->post("name");
		$table 		= StockModel::with('watchlist')
						->where("name","like","%{$name}%")
						->orWhere("symbol","like","%{$name}%");

		$ava_order 	= ['desc','asc'];
		$order 		= $this->input->post("order");

		if(in_array($order, $ava_order)){
			$table->orderBy('id',$order);
		}

		$page 		= ($this->input->post("page")) ? $this->input->post("page") : 0;
		$take 		= ($this->input->post("take")) ? $this->input->post("take") : 20;
		
		$table		= $table->take($take)->skip($page*$take)->get()->toArray();

		$this->restapi->response($table);
	}

	public function globalindex(){

		$watchlists = $this->user->watchlists->where("type","gi")->pluck("data")->toArray();

		$data 		= Requestdata::globalIndicies($watchlists);

		if(!$data->status){
			$this->restapi->error($data->message);
		}

		$this->restapi->response($data->results);
	}

	public function video(){
		$name 	= $this->input->post("name");
		$table 	= VideoModel::where("name","like","%{$name}%");

		$ava_order 	= ['desc','asc'];
		$order 		= $this->input->post("order");

		if(in_array($order, $ava_order)){
			$table->orderBy('id',$order);
		}
		$table = $table->get()->toArray();
		$this->restapi->response($table);
	}

	public function tradingidea(){
		$name 	= $this->input->post("name");
		$table 	= TradingIdeaModel::where("symbol","like","%{$name}%")
					->orWhere("remark","like","%{$name}%");

		$ava_order 	= ['desc','asc'];
		$order 		= $this->input->post("order");

		$order 		= (in_array($order, $ava_order)) ? $order : "desc";

		$ava_by 	= ["power","symbol"];
		$by 		= $this->input->post("by");
		$by 		= (in_array($by, $ava_by)) ? $by : "power";

		$table		 = $table->orderBy($by,$order)->get()->toArray();
		$this->restapi->response($table);
	}

	public function news(){

		$name 	= $this->input->post("title");
		$table 	= PostsModel::with('category','havetags.tag')->where("title","like","%{$name}%");


		$ava_status = ['member','public'];
		$status 	= $this->input->post("access");
		if(in_array($status, $ava_status)){
			$table->where("access",$status);
		}

	
		$table = $table->get()->toArray();
		$this->restapi->response($table);
	}

	public function workshop(){


		$name 	= $this->input->post("name");
		$table 	= WorkshopModel::where("name","like","%{$name}%");

		$start 	= $this->input->post("start");
		$end 	= $this->input->post("end");

		if($start && $end){
			$table 	= $table->where("start",">=",$start)->where("end","<=",$end);
		}

		$ava_status = ['publish','draft'];
		$status 	= $this->input->post("status");
		if(in_array($status, $ava_status)){
			$table->where("status",$status);
		}

		$ava_order 	= ['desc','asc'];
		$order 		= $this->input->post("order");

		if(in_array($order, $ava_order)){
			$table->orderBy('id',$order);
		}
		$table = $table->get()->toArray();
		$this->restapi->response($table);
	}
}
