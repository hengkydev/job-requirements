<?php
class Data extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//$this->restapi->validateKey();
	}

	public function index(){
		$this->restapi->response($this->user->toArray());
	}

	public function all(){

		$rules = [
				    'required' 	=> [
				        ['type']
				    ]
				 ];

		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}

		$type = strtolower($this->input->post('type'));

		switch ($type) {
			case 'economic_calendar':
				
				$response['country']  	= CountryModel::get()->toArray();
				$response['timezone'] 	= TimezoneModel::get()->toArray();
				$response['category']	= CategoryModel::type('economic_calendar')->get()->toArray();

				$scrapper 				= new ScrapperData;
				$response['attribute']	= $scrapper->attribute();
				
				break;
			case 'earnings_calendar':
				$response['country']  	= CountryModel::get()->toArray();
				$response['category']	= CategoryModel::type('earnings_calendar')->get()->toArray();
				$scrapper 				= new ScrapperData;
				$response['attribute']	= $scrapper->attribute();
				unset($response['attribute']->timeFilter);
				break;
			default:
				$this->restapi->error("Invalid type of all data");
				break;
		}

		$this->restapi->response($response);
	}

	public function newscategory(){
		$table = PostCategoriesModel::asc('name')->get()->toArray();
		$this->restapi->response($table);
	}

	public function newstags(){
		$table = PostTagsModel::asc('name')->get()->toArray();
		$this->restapi->response($table);
	}

// ########################################################### || COUNTRY DATA
	public function country(){

		$model 	= CountryModel::get();
		$this->restapi->response($model->toArray());

	}

// ########################################################### || TIMEZONE DATA
	public function timezone(){

		$model 	= TimezoneModel::get();
		$this->restapi->response($model->toArray());

	}

// ########################################################### || ATTRIBUTE DATA
	public function attribute(){
		$data 	= new ScrapperData;
		$this->restapi->response($data->attribute());

	}


// ########################################################### || CATEGORY DATA 
	public function category(){

		$rules = [
				    'required' 	=> [
				        ['type']
				    ]
				 ];

		$validate 	= $this->validation->check($rules,'post');

		if(!$validate->correct){
			$this->restapi->error($validate->data);
		}


		$type 		= strtolower($this->input->post('type'));
		$available 	= ['economic_calendar','earnings_calendar'];

		if(!in_array($type, $available))
			$this->restapi->error("Invalid type available ".json_encode($available));

		$model 	= CategoryModel::type($type)->get();

		$this->restapi->response($model->toArray());

	}
// ########################################################### || CATEGORY DATA 
	public function dump(){
		$earning 	= Requestdata::dumpEarning();
		$stock 		= Requestdata::dumpStocks();
		
		$data['earning'] 	= $earning;
		$data['stock'] 		= $stock;

		$this->restapi->response($data);
	}
}
