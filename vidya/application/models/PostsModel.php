<?php

class PostsModel extends MY_Model
{
    protected $table 	= "posts";
	protected $appends 	= ['img_src'];

	public function category()
	{
		return $this->hasOne('PostCategoriesModel', 'id', 'category_id');
	}

	public function author_detail()
	{
		return $this->hasOne('SuperuserModel', 'id', 'author_id');
	}

	public function tags()
	{
		return $this->hasMany('PostTagsUseModel', 'post_id', 'id');
	}

	public function getImgsrcAttribute()
	{
		return imgContentRender("posts",$this->image);
	}

	public function scopeStatus($query,$status){
		return $query->where("status",$status);
	}

	public function scopePublish($query){
		return $query->where("status","publish");
	}
}
