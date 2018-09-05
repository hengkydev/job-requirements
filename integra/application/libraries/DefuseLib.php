<?php 

use \Defuse\Crypto\Crypto;
use \Defuse\Crypto\Encoding;
use \Defuse\Crypto\Key;

class DefuseLib  {
	const path 		= '../generate-key.txt';

	public static function key() {
		
		$key1 = Key::createNewRandomKey();
        $str  = $key1->saveToAsciiSafeString();
		return $str;
	}

	public static function loadKey(){

		$file = file_get_contents(self::path, FILE_USE_INCLUDE_PATH);

    	return Key::loadFromAsciiSafeString($file);
	}

	public static function encrypt($string){
		$string = (string) $string;
		$key 	= Self::loadKey();
		return Crypto::encrypt($string, $key);
	}

	public static function decrypt($string){
		$key 	= Self::loadKey();
		try {

			
			return Crypto::decrypt($string,$key);
			
		} catch (Exception $e) {
			
			return false;	
		}
	}

	public static function validation(array $data){

		if(!isset($data['hash']) || !isset($data['password'])){
			return false;
		}

		$password 		= $data['password'];
		$hash 			= $data['hash'];

		if($password===Self::decrypt($hash)){
			return true;
		}

		return false;
	}

}