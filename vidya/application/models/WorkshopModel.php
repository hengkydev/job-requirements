<?php

class WorkshopModel extends MY_Model
{

	protected $table 	= "workshop";
	protected $appends 	= ['img_src'];

	public function getImgsrcAttribute()
	{
		return imgContentRender("workshop",$this->image);
	}

}
