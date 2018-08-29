<?php
class Watchlist extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->user 	= $this->middleware->user();
		$this->webdata->userLoad();
	}

	public function index()
	{
		$data['watchlists'] 	= $this->user->watchlists;
		echo $this->blade->draw("user.watchlist.index",$data);
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

		$this->restapi->response("Data ini di tambahkan ke watchlist anda");

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