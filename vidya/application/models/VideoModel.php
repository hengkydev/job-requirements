<?php

class VideoModel extends MY_Model
{

	protected $table 	= "video";
	protected $appends 	= ['img_src','video_dir'];

	public function getImgsrcAttribute()
	{
		if($this->type=="youtube"){
			$preview 	= youtube_preview($this->value);

			return toObject([
				"lg"	=> $preview,
				"md"	=> $preview,
				"sm"	=> $preview,
				"xs"	=> $preview,
			]);

		}else{
			return imgContentRender("video",$this->image);	
		}
		
	}


	public function getVideodirAttribute()
	{
		if($this->type=="youtube"){

			return youtube_iframe($this->value);

		}else{
			if(file_exists(content_dir("video/{$this->value}"))){
				return content_url("video/{$this->value}");
			}else{
				return null;
			}
			
		}
		
	}

	public function scopeType($query,$type){
		return $query->where("type",$type);
	}

	public function scopeStatus($query,$status){
		return $query->where("status",$status);
	}

	public function scopePublish($query){
		return $query->where("status","publish");
	}

}
