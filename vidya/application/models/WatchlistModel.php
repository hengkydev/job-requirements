<?php

class WatchlistModel extends MY_Model
{

    protected $table 	= "watchlist";
    protected $appends 	= ['notif'];
    protected $hidden 	= ['stock'];

	public function user()
	{
		return $this->hasOne("UsersModel", 'id', 'user_id');
	}

	public function getNotifAttribute()
	{
		if(!isset($this->stock->earning->id)){
			return null;
		}

		$notif 					= date('Y-m-d', strtotime($this->stock->earning->date. ' - '.$this->notif_day.' days'));
		$active 				= (date("Y-m-d")>=$notif);

		$response 	= [
			"active"		=> $active,
			"date_earning"	=> $this->stock->earning->date,
			"date_notif" 	=> $notif,
			"day_left"		=> dateLeft($this->stock->earning->date),
			"day_left_notif"=> dateLeft($notif),
			"day"			=> $this->notif_day,
		];

		if($active && dateLeft($notif) > 0){
			return toObject($response);
		}else{
			return null;
		}
	}

	public function stock()
	{
		return $this->hasOne('StockModel', 'unique', 'unique');
	}

}
