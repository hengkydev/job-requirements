<?php
class Tradingidea extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->superuser 	= $this->middleware->superuser();
		$this->webdata->superuserLoad();
	}

	public function index()
	{
		$data['__MENU']			= "tradingidea";
		$data['head_text']		= "Trading Idea";
		$data['body_text']		= "Daftar Trading Idea";
		$data['table'] 			= TradingIdeaModel::desc("power")->get();
		echo $this->blade->draw('superuser.tradingidea.index',$data);
	}


	public function create(){

		$data 		= [
			"__MENU"			=> "tradingidea_create",
			"type"				=> "create",
			"url_action"		=> base_url("superuser/tradingidea/created"),
			'head_text'			=> 'Buat Trading Idea',
			"body_text"			=> "Membuat Trading Idea Baru"
		];

		echo $this->blade->draw('superuser.tradingidea.content',$data);
	}

	public function update($id=null){

		if(!$id){
			show_404();
		}

		$table 		= TradingIdeaModel::find($id);

		if(!$table){
			show_404();
		}

		$data 		= [
			"__MENU"			=> "tradingidea_update",
			"type"				=> "update",
			"url_action"		=> base_url("superuser/tradingidea/updated"),
			'head_text'			=> 'Ubah Trading Idea',
			"body_text"			=> "Mengubah Trading Idea {$table->symbol}",
			"table"				=> $table,
		];

		echo $this->blade->draw('superuser.tradingidea.content',$data);
	}

	public function created(){

		$rules = [
				    'required' 	=>	[
    					['symbol'],['power'],['remark'],['datetime']
    				]
				 ];
		
		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}

		$power 					= $this->input->post("power");

		if($power>20){
			$power 				= 20;
		}else if($power<16){
			$power 				= 16;
		}

		$table 					= new TradingIdeaModel;
		$table->symbol 			= $this->input->post("symbol");
		$table->power 			= $power;
		$table->remark 			= $this->input->post("remark");
		$table->datetime 		= $this->input->post("datetime");

		if(!$table->save()){
			$this->restapi->error("Maaf ada kesalahan silahkan coba nanti");
		}

		$this->validation->setSuccess("Trading Idea baru telah ditambahkan");
		$this->restapi->response([
			"socket_response"	=> $table->toArray(),
			"results"			=> base_url("/superuser/tradingidea")
		]);

	}

	public function updated(){

		$rules = [
				    'required' 	=>	[
    					['id'],['symbol'],['power'],['remark'],['datetime']
    				]
				 ];
		
		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}

		$table 					= TradingIdeaModel::find($this->input->post("id"));
		if(!$table){
			$this->restapi->error("Trading Idea tidak ditemukan !");
		}

		$power 					= $this->input->post("power");

		if($power>20){
			$power 				= 20;
		}else if($power<16){
			$power 				= 16;
		}

		$table->symbol 			= $this->input->post("symbol");
		$table->power 			= $power;
		$table->remark 			= $this->input->post("remark");
		$table->datetime 		= $this->input->post("datetime");

		if(!$table->save()){
			$this->restapi->error("Maaf ada kesalahan silahkan coba nanti");
		}

		$this->validation->setSuccess("Trading Idea '{$table->symbol}' telah di perbarui");
		$this->restapi->response([
			"socket_response"	=> $table->toArray(),
			"results"			=> base_url("/superuser/tradingidea")
		]);

	}

	public function bulkaction(){
		$rules = [
					'required' 	=> [
				        ['action'],['data']
				    ]
				  ];

		$validate 	= $this->validation->check($rules,'tradingidea');

		if(!$validate->correct){
			$this->validation->setError($validate->data);
		}

		$action 	= $this->input->post('action');
		$table 		= TradingIdeaModel::whereIn('id',$this->input->post('data'))->get();

		if(count($table)<=0){
			$this->validation->setError("Tidak ada data yang di pilih!");
			redirect('superuser/tradingidea');
		}

		switch ($action) {
			case 'delete':
				TradingIdeaModel::whereIn('id',$this->input->post('data'))->delete();
				$this->validation->setSuccess("Data telah terhapus");
				break;
			default:
				show_404();
				break;
		}

		redirect('superuser/tradingidea');
		return;
	}

	public function remove($id=null){
		if(!$id){
			show_404();
		}

		$table 		= TradingIdeaModel::find($id);
		if(!$table){
			show_404();
		}

		$table->delete();
		$this->validation->setSuccess("Trading Idea '{$table->symbol}' telah di hapus");
		redirect("superuser/tradingidea");
	}
}