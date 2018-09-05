<?php

class StudentModel extends MY_Model
{

    protected $table 	= "student";
	protected $appends 	= ['img_src'];
	
	protected $hidden 	= [
		"password"
	];

	public function getImgsrcAttribute()
	{

		return imgContentRender("student",$this->image,"profile");
	}

	public function scopeStatus($query,$status){
		return $query->where("status",$status);
	}

	public function scopeActive($query){
		return $query->where("status",'=','active');
	}
}
