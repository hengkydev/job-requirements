<?php

class PageModel extends MY_Model
{
    protected $table 	= "page";
	protected $appends 	= ['img_src'];


	public function getImgsrcAttribute()
	{
		return imgContentRender("page",$this->image);
	}

	public function scopeType($query,$status){
		return $query->where("type",$status);
	}

	public function scopeStatus($query,$status){
		return $query->where("status",$status);
	}

	public function scopePublish($query){
		return $query->where("status","publish");
	}
}
