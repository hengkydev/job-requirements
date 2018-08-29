<?php
class View extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->user 	= $this->middleware->user();
		$this->webdata->userLoad();
	}

	public function stocks()
	{
		$data['stocks'] 	= StockModel::asc("name")->get();
		$data['watchlists'] = $this->user->watchlists->pluck("unique")->toArray();
		echo $this->blade->draw("user.view.stock",$data);
	}

	public function Globalindex()
	{
		echo $this->blade->draw("user.globalindex.index");
	}

	public function earningcalendar()
	{

		$data['countries'] 	= CountryModel::asc("name")->get();
		$data['sector'] 	= CategoryModel::where("type","earnings_calendar")->asc("name")->get();
		$data['earnings']	= EarningModel::asc('name')->get();
		echo $this->blade->draw("user.view.earningcalendar",$data);
	}

	public function tradingidea(){
		$data['table'] 		= TradingIdeaModel::desc('power')->get();
		echo $this->blade->draw("user.view.tradingidea",$data);
	}

	public function currencies()
	{
		echo $this->blade->draw("user.view.currency");
	}

	public function commodities()
	{
		echo $this->blade->draw("user.view.commodities");
	}

	public function economiccalendar()
	{
		echo $this->blade->draw("user.view.economiccalendar");
	}
}