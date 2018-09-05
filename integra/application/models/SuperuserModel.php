<?php

class SuperuserModel extends MY_Model
{

    protected $table 	= "superusers";
    protected $guard 	= 'superusers';
	protected $appends 	= ['img_src'];
	
	protected $hidden 	= [
		"password"
	];

	public function roles()
	{
		return $this->hasMany("SuperuserRolesGiveModel", 'superuser_id', 'id');
	}

	public function posts()
	{
		return $this->hasMany('PostsModel', 'author_id', 'id');
	}

	public function getImgsrcAttribute()
	{

		return imgContentRender("superusers",$this->image,"profile");
	}

	public function scopeStatus($query,$status){
		return $query->where("status",$status);
	}

	public function scopeActive($query){
		return $query->where("status",'=','active');
	}
}
