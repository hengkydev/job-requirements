<?php
use Nasution\ZenzivaSms\Client as Sms;

class Zenzivasms {

	function __construct() {
		$this->ci =& get_instance(); 
	}

	private function auth(){

		$userKey 		= getEnv('ZENZIVA_USERKEY');
		$passKey 		= getEnv('ZENZIVA_PASSKEY');

		$sms = new Sms($userKey, $passKey);

		return $sms;
	}

	public function send($phone,$text){

		return $this->auth()->to($phone)
		    ->text($text)
		    ->send();

	}
}