<?php
class Watchlists extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->restapi->validateKey();
		$this->user 	= $this->middleware->api_user();
	}

	public function index(){

		$watchlists = WatchlistModel::where('user_id',$this->user->id)->get()->pluck("unique");

		$table 		= StockModel::with('watchlist')
						->where("name","like","%{$name}%")
						->orWhere("symbol","like","%{$name}%")
						->whereIn("unique",$watchlists);

		$ava_order 	= ['desc','asc'];
		$order 		= $this->input->post("order");

		if(in_array($status, $ava_order)){
			$table->orderBy('id',$ava_order);
		}

		$page 		= ($this->input->post("page")) ? $this->input->post("page") : 0;
		$take 		= ($this->input->post("take")) ? $this->input->post("take") : 20;
		
		$table		= $table->take($take)->skip($page*$take)->get()->toArray();

		$this->restapi->response($table);
	}

	public function add()
	{
		$rules = [
				    'required' 	=> [
				    	['id']
				    ]
				 ];

		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}

		$stock 		= StockModel::find($this->input->post('id'));
		if(!$stock){
			$this->restapi->error("Stock not found!");
		}

		$watchlist = WatchlistModel::where([
						"user_id"		=> $this->user->id,
						"unique"		=> $stock->unique,
						"notif_day"		=> 3,
					])->first();

		if(isset($watchlist->id)){
			$this->restapi->error("Data ini telah masuk ke dalam Watchlist Anda");
		}

		$watchlist 				= new WatchlistModel;
		$watchlist->user_id 	= $this->user->id;
		$watchlist->unique 		= $stock->unique;
		if(!$watchlist->save()){
			$this->restapi->error("Silahkan ulangi kembali nanti");
		}

		$this->restapi->response($watchlist);

	}

	public function remove()
	{
		$rules = [
				    'required' 	=> [
				    	['id']
				    ]
				 ];

		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}

		$stock 		= StockModel::find($this->input->post('id'));
		if(!$stock){
			$this->restapi->error("Stock not found!");
		}


		WatchlistModel::where([
						"user_id"	=> $this->user->id,
						"unique"		=> $stock->unique,
					])->delete();

		$this->restapi->response("Data ini di hapus dari watchlist anda");

	}

}
