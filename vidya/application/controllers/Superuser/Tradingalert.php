<?php
class Tradingalert extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->superuser 	= $this->middleware->superuser();
		$this->webdata->superuserLoad();
	}

	public function index()
	{

		$data['__MENU']			= "tradingalert";
		$data['head_text']		= "Trading Alert";
		$data['body_text']		= "Daftar Trading Alert";
		$data['table'] 			= TradingAlertModel::desc("power")->get();
		echo $this->blade->draw('superuser.tradingalert.index',$data);
	}


	public function create(){

		$data 		= [
			"__MENU"			=> "tradingalert_create",
			"type"				=> "create",
			"url_action"		=> base_url("superuser/tradingalert/created"),
			'head_text'			=> 'Buat Trading Alert',
			"body_text"			=> "Membuat Trading Alert Baru"
		];

		echo $this->blade->draw('superuser.tradingalert.content',$data);
	}

	public function update($id=null){

		if(!$id){
			show_404();
		}

		$table 		= TradingAlertModel::find($id);

		if(!$table){
			show_404();
		}

		$data 		= [
			"__MENU"			=> "tradingalert_update",
			"type"				=> "update",
			"url_action"		=> base_url("superuser/tradingalert/updated"),
			'head_text'			=> 'Ubah Trading Alert',
			"body_text"			=> "Mengubah Trading Alert {$table->symbol}",
			"table"				=> $table,
		];

		echo $this->blade->draw('superuser.tradingalert.content',$data);
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

		$table 					= new TradingAlertModel;
		$table->symbol 			= $this->input->post("symbol");
		$table->power 			= $power;
		$table->remark 			= $this->input->post("remark");
		$table->datetime 		= $this->input->post("datetime");

		if($this->validation->checkFiles("image")){

			$filename 				= 'TALERT '.limit_string($table->symbol).' ('.date('Ymdhis').')';
			$upload 				= $this->upfiles->allSizeImageUpload("tradingalert","image",$filename);

			if(!$upload->status){
				$this->restapi->error($upload->result);
			}

			$table->image 			= $upload->result;
		}


		if(!$table->save()){

			if($table->image){
				$this->upfiles->remove("tradingalert",$table->image);	
			}

			$this->restapi->error("Maaf ada kesalahan silahkan coba nanti");
		}

		$this->validation->setSuccess("Trading Alert baru telah ditambahkan");
		$this->restapi->response([
			"socket_response"	=> $table->toArray(),
			"results"			=> base_url("/superuser/tradingalert")
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

		$table 					= TradingAlertModel::find($this->input->post("id"));
		if(!$table){
			$this->restapi->error("Trading Alert tidak ditemukan !");
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

		if($this->validation->checkFiles("image")){

			$filename 				= 'TALERT '.limit_string($table->symbol).' ('.date('Ymdhis').')';
			$upload 				= $this->upfiles->allSizeImageUpload("tradingalert","image",$filename);

			if(!$upload->status){
				$this->restapi->error($upload->result);
			}
		}


		if(!$table->save()){

			if($table->image){
				$this->upfiles->remove("tradingalert",$table->image);	
			}

			$this->restapi->error("Maaf ada kesalahan silahkan coba nanti");
		}

		if($table->image && isset($upload->status)){
			$this->upfiles->remove("tradingalert",$table->image);	
			$table->image 			= $upload->result;
		}

		$table->save();

		$this->validation->setSuccess("Trading Alert '{$table->symbol}' telah di perbarui");
		$this->restapi->response([
			"socket_response"	=> $table->toArray(),
			"results"			=> base_url("/superuser/tradingalert")
		]);

	}

	public function bulkaction(){
		$rules = [
					'required' 	=> [
				        ['action'],['data']
				    ]
				  ];

		$validate 	= $this->validation->check($rules,'tradingalert');

		if(!$validate->correct){
			$this->validation->setError($validate->data);
		}

		$action 	= $this->input->post('action');
		$table 		= TradingAlertModel::whereIn('id',$this->input->post('data'))->get();

		if(count($table)<=0){
			$this->validation->setError("Tidak ada data yang di pilih!");
			redirect('superuser/tradingalert');
		}

		switch ($action) {
			case 'delete':
				$table 	= TradingAlertModel::whereIn('id',$this->input->post('data'))->get();
				foreach ($table as $result) {
					if($result->image){
						$this->upfiles->remove("tradingalert",$result->image);	
					}
				}

				TradingAlertModel::whereIn('id',$this->input->post('data'))->delete();
				$this->validation->setSuccess("Data telah terhapus");
				break;
			default:
				show_404();
				break;
		}

		redirect('superuser/tradingalert');
		return;
	}

	public function remove($id=null){
		if(!$id){
			show_404();
		}

		$table 		= TradingAlertModel::find($id);
		if(!$table){
			show_404();
		}

		if($table->image){
			$this->upfiles->remove("tradingalert",$table->image);	
		}


		$table->delete();
		$this->validation->setSuccess("Trading Alert '{$table->symbol}' telah di hapus");
		redirect("superuser/tradingalert");
	}
}