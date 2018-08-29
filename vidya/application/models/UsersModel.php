<?php

class UsersModel extends MY_Model
{

    protected $table 	= "users";
	protected $appends 	= ['img_src'];
	
	protected $hidden 	= [
		"password"
	];

	public function watchlists()
	{
		return $this->hasMany("WatchlistModel", 'user_id', 'id');
	}

	public function getImgsrcAttribute()
	{

		return imgContentRender("users",$this->image,"profile");
	}

	public function scopeStatus($query,$status){
		return $query->where("status",$status);
	}

	public function scopeActive($query){
		return $query->where("status",'=','active');
	}
}
