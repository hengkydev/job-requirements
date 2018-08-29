<?php

class SeoModel extends MY_Model
{
    protected $table 	= "seo";
	protected $appends 	= ['img_src'];


	public function getImgsrcAttribute()
	{
		return imgContentRender('seo',$this->image);
	}

}
