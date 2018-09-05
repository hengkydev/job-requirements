<?php

class MateriModel extends MY_Model
{
    protected $table 	= "materi";
	protected $appends 	= ['img_src'];

	public function attachments()
	{
		return $this->hasMany('MateriAttachmentsModel', 'materi_id', 'id');
	}

	public function lecturer()
	{
		return $this->hasOne('LecturerModel', 'id', 'lecturer_id');
	}

	public function comments()
	{
		return $this->hasMany('MateriCommentsModel', 'materi_id', 'id');
	}

	public function getImgsrcAttribute()
	{
		return imgContentRender("materi",$this->image);
	}

	public function scopeStatus($query,$status){
		return $query->where("status",$status);
	}

	public function scopePublish($query){
		return $query->where("status","publish");
	}
}
