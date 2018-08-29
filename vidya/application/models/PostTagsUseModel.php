<?php

class PostTagsUseModel extends MY_Model
{
    protected $table 	= "post_tags_use";

	public function tag()
	{
		return $this->hasOne('PostTagsModel', 'id', 'tag_id');
	}

	public function post()
	{
		return $this->hasOne('PostsModel', 'id', 'post_id');
	}

	public function havetags()
	{
		return $this->hasMany('PostTagsUseModel', 'post_id', 'id');
	}

}
