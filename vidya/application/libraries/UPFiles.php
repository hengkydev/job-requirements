<?php
use Gregwar\Image\Image;

class UPFiles {

	function __construct() {
		$this->ci =& get_instance(); 
		$this->ci->load->library('session');
	}

	public function submit(array $option)
	{

		$filename 					= (isset($option['filename'])) ? $option['filename'] : $_FILES[0];
		$name 						= (isset($option['name'])) ? $option['name'] : getToken(8);
		$path 						= (isset($option['path'])) ? $option['path'] : "/";
		$ext 						= (isset($option['ext'])) ? $option['ext'] : 'jpg|png|jpeg';
		$max 						= (isset($option['max'])) ? $option['max'] : 3000;

		$config['upload_path']      = content_dir($path);
        $config['allowed_types']    = $ext;
        $config['max_size']         = $max;
        $config['file_name'] 		= $name;
        
        $this->ci->load->library('upload', $config);

        $this->ci->upload->initialize($config);

        if ( ! $this->ci->upload->do_upload($filename))
        {		
        		$data['status'] 	= false;
                $data['result'] 	= $this->ci->upload->display_errors();
                return json_decode(json_encode($data));
        }
        else
        {
        		$data['status'] 	= true;
        		$data['result']		= $this->ci->upload->data("file_name");
        		return json_decode(json_encode($data));
        }

	}

	public function doit(array $option)
	{

		$filename 					= $option['filename'];
		$name 						= $option['name'];
		$path 						= $option['path'];
		$size_md 					= @$option['size_md'];
		$size_sm 					= @$option['size_sm'];
		$size_xs 					= @$option['size_xs'];

		$upload 	= $this->uploadImage(content_dir('images/lg/'.$path.'/'),$name,$filename);

		if(!$upload->status){
			return $upload;
		}

		$response['status']				= true;
		$response['result']['lg']		= 'success';
		$response['result']['md']		= 'success';
		$response['result']['sm']		= 'success';
		$response['result']['xs']		= 'success';

		$file 					= $upload->result->file_name;

		$config['origin']		= content_dir('images/lg/'.$path.'/'.$file);
		$config['filename']		= $file;
		// Resize MEDIUM

		if($size_md){

			$config['size']			= $size_md;
			$config['path'] 		= content_dir('images/md/'.$path.'/');
			$md 				= $this->resize($config);

			if(!$md->status){
				$response['result']['md']		= $md->result;
			}	

		}

		if($size_sm){

			$config['size']			= $size_sm;
			$config['path'] 		= content_dir('images/sm/'.$path.'/');
			$sm 					= $this->resize($config);

			if(!$sm->status){
				$response['result']['sm']		= $sm->result;
			}	

		}

		if($size_xs){

			$config['size']			= $size_xs;
			$config['path'] 		= content_dir('images/xs/'.$path.'/');
			$xs 					= $this->resize($config);

			if(!$xs->status){
				$response['result']['xs']		= $xs->result;
			}	

		}
		

		return json_decode(json_encode($response));
	}


	public function avatarCrop(array $option){

		$width 			= $option['width'];
		$height 		= $option['height'];
		$xPos 			= $option['xPos'];
		$yPos 			= $option['yPos'];
		
		$origin 		= $option['origin'];
		$filename 		= $option['file_name'];

		if(!file_exists($origin)){
			$data['status'] 	= false;
            $data['result'] 	= 'file not exists';
            return json_decode(json_encode($data));
		}


		$crop 			= Image::open($origin)
							->crop($xPos, $yPos,$width, $height)
							->fillBackground('0xffffff');							

		if(!$crop->save(content_dir('images/lg/users/'.$filename))){
			$data['status'] 	= false;
            $data['result'] 	= 'failed crop';
            return json_decode(json_encode($data));
		}


		$response['status']					= true;
		$response['result']['lg']		= 'success';
		$response['result']['md']		= 'success';
		$response['result']['sm']		= 'success';
		$response['result']['xs']			= 'success';

		$option['origin']					= content_dir('images/lg/users/'.$filename);
		$option['filename']					= $filename;


		// RESIZE TO MEDIUM
		$option['size']						= 350;
		$option['path']						= content_dir('images/md/users/');
		$resize 							= $this->resize($option);

		if(!$resize->status){
			$response['result']['md']	= $resize->result;
		}

		// RESIZE TO SMALL
		$option['size']						= 200;
		$option['path']						= content_dir('images/sm/users/');
		$resize 							= $this->resize($option);

		if(!$resize->status){
			$response['result']['sm']	= $resize->result;
		}


		// RESIZE TO SMALL
		$option['size']						= 80;
		$option['path']						= content_dir('images/xs/users/');
		$resize 							= $this->resize($option);

		if(!$resize->status){
			$response['result']['xs']		= $resize->result;
		}

		return json_decode(json_encode($response));

	}

	public function uploadImage($dir,$name ='userfile',$filename=false){
		$config['upload_path']      = $dir;
        $config['allowed_types']    = 'jpg|png|jpeg|gif';
        $config['max_size']         = 2000;

        if($filename){
        	$config['file_name'] 	= $filename;
        }else {
        	$config['encrypt_name'] 	= TRUE;
        }
        
        $this->ci->load->library('upload', $config);

        $this->ci->upload->initialize($config);

        if ( ! $this->ci->upload->do_upload($name))
        {		
        		$data['status'] 	= false;
                $data['result'] 	= $this->ci->upload->display_errors();
                return json_decode(json_encode($data));
        }
        else
        {
        		$data['status'] 	= true;
        		$data['result']		= $this->ci->upload->data();
        		return json_decode(json_encode($data));
        }
	}

	public function remove($dir,$file,array $size=['lg','md','sm','xs']){
		
		foreach ($size as $key => $value) {
			remFile(content_dir("images/{$value}/{$dir}/{$file}"));	
		}

		return true;
	}

	public function removeSingle($dir,$file){
		remFile(content_dir("{$dir}/{$file}"));
		return true;
	}



	public function allSizeImageUpload($dir,$file,$filename,array $size=[500,250,100]){
		$upload 				= $this->uploadImage(content_dir("images/lg/{$dir}"),$file,$filename);

		if(!$upload->status){
			return $upload;
		}

		$filename 				= $upload->result->file_name;

		$option['origin']		= content_dir("images/lg/{$dir}/{$filename}");
		$option['filename']		= $filename;

		$ava_size 				= ['md','sm','xs'];
		$previousValue 			= [];

		foreach ($ava_size as $key => $value) {

			$option['size']			= $size[$key];
			$option['path']			= content_dir("images/{$value}/{$dir}/");
			$render 				= $this->resize($option);

			if(!$render->status){
				if($previousValue){
					foreach ($previousValue as $prev) {
						remFile(content_dir("images/{$prev}/{$dir}/{$filename}"));	
					}
				}
				return $render;
			}

			$previousValue[] 		= $value;				
		}

		$data['status'] 		= true;
		$data['result'] 		= $filename;

		return toObject($data);
	}

	public function allSizeImage($filename,$dir,array $size=[500,250,100]){

		$option['origin']		= content_dir("images/lg/{$dir}/{$filename}");
		$option['filename']		= $filename;

		$ava_size 				= ['md','sm','xs'];
		$previousValue 			= [];

		foreach ($ava_size as $key => $value) {

			$option['size']			= $size[$key];
			$option['path']			= content_dir("images/{$value}/{$dir}/");
			$render 				= $this->resize($option);

			if(!$render->status){
				if($previousValue){
					foreach ($previousValue as $prev) {
						remFile(content_dir("images/{$prev}/{$dir}/{$filename}"));	
					}
				}
				return $render;
			}

			$previousValue[] 		= $value;				
		}

		$data['status'] 		= true;
		$data['result'] 		= $filename;

		return toObject($data);
	}


	public function upload(array $config){

		$path 				= (!isset($config['path'])) ? content_dir() : $config['path'];
		$name 				= (!isset($config['name'])) ? 'files' : $config['name'];
		$max_size 			= (!isset($config['max_size'])) ? 5000 : $config['max_size'];
		$allowed 			= (!isset($config['allowed'])) ? 'jpg|gif|png|jpeg' : $config['allowed'];

		$data['status'] 		= false;
		$data['message'] 		= "File {$name} did not uploaded";
		$data['result'] 		= null;
		
		 $config_upload = array(
            'upload_path'   => $path,
            'allowed_types' => $allowed,
            'max_size'		=> $max_size,
            'overwrite'     => false,
        );

        if(isset($config['file_name'])){
        	$config_upload['file_name'] 	= $config['file_name'];
        }else {
        	$config_upload['encrypt_name'] 	= TRUE;
        }

 		$this->ci->load->library('upload', $config_upload);
        $this->ci->upload->initialize($config_upload);

        if ($this->ci->upload->do_upload($name)) {

        	$data 				= [
    			"status"		=> true,
    			"result" 		=> $this->ci->upload->data()
    		];
        } else {
        	$data 				= [
    			"status"		=> false,
    			"result" 		=> $this->ci->upload->display_errors()
    		];
        }

        return toObject($data);

	}

	public function multiple(array $config){

		$path 				= (!isset($config['path'])) ? content_dir() : $config['path'];
		$name 				= (!isset($config['name'])) ? 'files' : $config['name'];
		$max_size 			= (!isset($config['max_size'])) ? 5000 : $config['max_size'];
		$allowed 			= (!isset($config['allowed'])) ? 'jpg|gif|png|jpeg' : $config['allowed'];

		$data['status'] 		= false;
		$data['message'] 		= "File {$name} did not uploaded";
		$data['result'] 		= null;
		
		 $config_upload = array(
            'upload_path'   => $path,
            'allowed_types' => $allowed,
            'max_size'		=> $max_size,
            'overwrite'     => false,
        );

		

        $fail 	= 0;
        $count 	= count($_FILES[$name]['name']);

        foreach ($_FILES[$name]['name'] as $key => $value) {
            $_FILES['system_file']['name']		= $_FILES[$name]['name'][$key];
            $_FILES['system_file']['type']		= $_FILES[$name]['type'][$key];
            $_FILES['system_file']['tmp_name']	= $_FILES[$name]['tmp_name'][$key];
            $_FILES['system_file']['error']		= $_FILES[$name]['error'][$key];
            $_FILES['system_file']['size']		= $_FILES[$name]['size'][$key];

            if(isset($config['file_name'][$key])){
	        	$config_upload['file_name'] 	= 'ATTACHMENT__'.$config['file_name'][$key].'__['.getToken(5).']__('.date('Ymdhis').')';
	        }else {
	        	$config_upload['encrypt_name'] 	= TRUE;
	        }

	        $this->ci->load->library('upload', $config_upload);
            $this->ci->upload->initialize($config_upload);

            if ($this->ci->upload->do_upload('system_file')) {

        		$data['result'][] 	= [
        			"status"		=> true,
        			"result" 		=> $this->ci->upload->data()
        		];
            } else {
            	$fail++;
            	$data['result'][] 	= [
        			"status"		=> false,
        			"result" 		=> $this->ci->upload->display_errors()
        		];
            }
        }

        if($fail>0){
        	$message 		= "Some File didnt uploaded !";
        }else if($fail>=$count){
        	$message 		= "All File didnt uploaded !";
        }else{
        	$message 		= "All File Uploaded !";
        }

        if($fail<$count){
        	$data['status']	= true;
        }else{
        	$data['status']	= false;
        }
        $data['message'] 	= $message;
        return toObject($data);

	}

	public function multipleFile(array $config){

		$path 				= (!isset($config['path'])) ? content_dir() : $config['path'];
		$name 				= (!isset($config['name'])) ? 'files' : $config['name'];
		$max_size 			= (!isset($config['max_size'])) ? 5000 : $config['max_size'];
		$allowed 			= (!isset($config['allowed'])) ? 'jpg|gif|png|jpeg' : $config['max_size'];

		
		 $config = array(
            'upload_path'   => $path,
            'allowed_types' => $allowed,
            'max_size'		=> $max_size,
            'overwrite'     => false,
        );

		 if(!isset($config['file_name'])){
        	$config['file_name'] 	= $config['file_name'];
        }else {
        	$config['encrypt_name'] 	= TRUE;
        }

        $this->load->library('upload', $config);

         foreach ($files[$name] as $key => $image) {
            $_FILES['system_file[]']['name']		= $files['name'][$key];
            $_FILES['system_file[]']['type']		= $files['type'][$key];
            $_FILES['system_file[]']['tmp_name']	= $files['tmp_name'][$key];
            $_FILES['system_file[]']['error']		= $files['error'][$key];
            $_FILES['system_file[]']['size']		= $files['size'][$key];

            $this->upload->initialize($config);

            if ($this->upload->do_upload('system_file[]')) {
            	$data['auth']		= true;
            	array_push($data['msg'],$this->upload->data());
            } else {
            	$data['auth']		= ($data['auth']==true) ? true : false;
            	array_push($data['msg'],$this->upload->display_errors());
            }
        }

	}

	public function resize(array $config){

		$origin 				= $config['origin'];
		$size 					= $config['size'];
		$path 					= $config['path'];
		$filename 				= $config['filename'];


		if(!file_exists($path)){
			$data['status'] 	= false;
            $data['result'] 	= 'path not exists';
            return json_decode(json_encode($data));
		}


		if(!file_exists($origin)){
			$data['status'] 	= false;
            $data['result'] 	= 'file not exists';
            return json_decode(json_encode($data));
		}


		list($width, $height, $type, $attr) = getimagesize($origin);

		if($width>$size){
			$height 		= ($height / $width) * $size;
			$width 			= $size;	
		}
		
		$resize 		= Image::open($origin)
						->forceResize($width, $height);

		if(!$resize->save($path.$filename)){
			$data['status'] 	= false;
            $data['result'] 	= 'failed resize';
            return json_decode(json_encode($data));
		}

		$data['status'] 	= true;
        $data['result'] 	= 'resize success';
        return json_decode(json_encode($data));
	}
}