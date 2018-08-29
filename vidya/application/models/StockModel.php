<?php

class StockModel extends MY_Model
{

	protected $table 	= "stock";
	protected $appends 	= ['img_src'];


	public function getImgsrcAttribute()
	{
		return imgContentRender("country",strtolower(seo($this->country)).'.png');
	}

	public function earning()
	{
		return $this->hasOne('EarningModel', 'unique', 'unique');
	}

	public function watchlist()
	{
		return $this->hasOne('WatchlistModel', 'unique', 'unique');
	}

}
