<?php
class Render extends CI_Controller {

	public function __construct()
	{
		parent::__construct();		
	}

	public function index(){

		$scrapper = new ScrapperData;

		print_r($scrapper->timeZone());

	}

	public function category(){

		$scrapper 	= new ScrapperData;

		CategoryModel::truncate();

		$data 			= ["economic_calendar","earnings_calendar"];

		foreach ($data as $key => $value) {
			$categoryData 	= $scrapper->category($value);

			foreach ($categoryData as $result) {
				
				$category 			= new CategoryModel;
				$category->name 	= $result->name;
				$category->value 	= $result->value;
				$category->type 	= $value;
				$category->save();
			}
		}

		exit('Category Rendered !');

	}

	public function country(){

		$scrapper 	= new ScrapperData;

		$data 		= $scrapper->country();

		CountryModel::truncate();

		foreach ($data as $result) {
			
			$model 			= new CountryModel;
			$model->name 	= $result->name;
			$model->value 	= $result->value;
			$model->save();
		}

		exit('Country Rendered !');

	}

	public function timezone(){

		$scrapper 	= new ScrapperData;

		$data 		= $scrapper->timeZone();

		TimezoneModel::truncate();

		foreach ($data as $result) {
			
			$model 			= new TimezoneModel;
			$model->name 	= $result->name;
			$model->value 	= $result->value;
			$model->save();
		}

		exit('Timezone Rendered !');

	}

	public function apikey(){

		echo 'key-'.date('Ymdhis').'-'.strtolower(getToken(32));
	}

	public function request(){
		 echo seo("Cote D'Ivoire");
	}
}
