<?php

class MateriAttachmentsModel extends MY_Model
{
    protected $table 	= "materi_attachments";
	protected $appends 	= ['img_src'];

	public function materi()
	{
		return $this->hasOne('MateriModel', 'id', 'materi_id');
	}

}
