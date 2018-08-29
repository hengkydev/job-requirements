<?php

class SlidersModel extends MY_Model
{
    protected $table 	= "sliders";
	protected $appends 	= ['img_src'];


	public function getImgsrcAttribute()
	{
		return imgContentRender("sliders",$this->image);
	}

	public function scopeStatus($query,$status){
		return $query->where("status",$status);
	}

	public function scopePublish($query){
		return $query->where("status","publish");
	}
}
