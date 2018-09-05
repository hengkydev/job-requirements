<?php

class MateriCommentsModel extends MY_Model
{
    protected $table 	= "materi_comments";
	protected $appends 	= ['img_src'];


	public function lecturer()
	{
		return $this->hasOne('LecturerModel', 'id', 'lecturer_id');
	}

	public function student()
	{
		return $this->hasOne('StudentModel', 'id', 'student_id');
	}

	public function materi()
	{
		return $this->hasOne('MateriModel', 'id', 'student_id');
	}

}
