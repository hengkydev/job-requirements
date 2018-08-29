<?php

class TradingAlertModel extends MY_Model
{

	protected $table 	= "trading_alert";
	protected $appends 	= ['img_src','alert'];


	public function getImgsrcAttribute()
	{

		return imgContentRender("tradingalert",$this->image);
	}

	public function getAlertAttribute(){

		$remark 	= strtolower($this->remark);

		if(strpos($remark, strtolower("Hawk1 detected.")) !== false){
			return true;
		}

		return false;
	}

}
