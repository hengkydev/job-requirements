<?php

class LecturerModel extends MY_Model
{

    protected $table 	= "lecturer";
	protected $appends 	= ['img_src'];

	public function getImgsrcAttribute()
	{

		return imgContentRender("lecturer",$this->image,"profile");
	}

	public function scopeStatus($query,$status){
		return $query->where("status",$status);
	}

	public function scopeActive($query){
		return $query->where("status",'=','active');
	}
}
