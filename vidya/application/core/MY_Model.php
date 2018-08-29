<?php


class MY_Model extends Illuminate\Database\Eloquent\Model {
	
	public $ci;
	
	function __construct()
	{	
		$this->ci =& get_instance();
	}

	public function scopeDesc($query,$column="id")
	{
		return $query->orderBy($column, 'desc');
	}

	public function scopeAsc($query,$column="id")
	{
		return $query->orderBy($column, 'asc');
	}

	public function scopePublish($query){
		return $query->where('status','publish');
	}

}