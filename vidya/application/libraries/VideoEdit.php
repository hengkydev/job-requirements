<?php 

class VideoEdit  {

	public static function snapshot(array $config){

		if(!isset($config['file']) || !isset($config['output'])){
			return false;
		}

		$ffmpeg = FFMpeg\FFMpeg::create([
			'ffmpeg.binaries'  => 'C:/ffmpeg/bin/ffmpeg.exe', 
            'ffprobe.binaries' => 'C:/ffmpeg/bin/ffprobe.exe', 
            'timeout'          => 3600, 
            'ffmpeg.threads'   => 12,   
		]);

		$video = $ffmpeg->open($config['file']);
		$frame = $video->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(42));
		return $frame->save($config['output']);
	}
}