<?php 
use \Curl\Curl;
/*
	Copyright (c) 2016, AKSAMEDIA - JASA PEMBUATAN WEBSITE

	BASED ON GOOGLE API DOCUMENTATION (OAUTH)
	BASED ON FACEBOOK API DOCUMENTATION (OAUTH)
*/


class AksaAuthentication  {
	
	public static function googleAuth(array $config){

		$required 	= ['client_id','token_id'];

		foreach ($required as $result) {
			if(!array_key_exists($result, $config)){
				$data['auth'] 	= false;
				$data['msg'] 	= "Opps! '".$result."' required";
				return json_decode(json_encode($data));
			}
		}

		$CLIENT_ID 		= $config['client_id'];
		$token 			= $config['token_id'];

		$client 		= new Google_Client(['client_id' => $CLIENT_ID]);


		$payload 		= $client->verifyIdToken($token);

		if(!$payload){
			$data['auth'] 	= false;
			$data['msg'] 	= "Invalid Token";
			return json_decode(json_encode($data));
		}

		$payload 		= json_decode(json_encode($payload));

		if($payload->aud !== $CLIENT_ID){
			$data['auth'] 	= false;
			$data['msg'] 	= "Invalid Client ID";
			return json_decode(json_encode($data));
		}

		

		$data['auth'] 		= true;
		$data['msg'] 		= $payload;
		return json_decode(json_encode($data));
	}


	public static function facebookAuth(array $config){

		$required 	= ['app_id','app_secret','token'];

		foreach ($required as $result) {
			if(!array_key_exists($result, $config)){
				$data['auth'] 	= false;
				$data['msg'] 	= "Opps! '".$result."' required";
				return json_decode(json_encode($data));
			}
		}

		$fb = new \Facebook\Facebook([
		  'app_id' => $config['app_id'],
		  'app_secret' => $config['app_secret'],
		  'default_graph_version' => 'v2.8',
		  //'default_access_token' => '{access-token}', // optional
		]);

		try {
		  // Get the \Facebook\GraphNodes\GraphUser object for the current user.
		  // If you provided a 'default_access_token', the '{access-token}' is optional.
		  $response = $fb->get('/me?fields=id,name,email,first_name,last_name,link,gender,locale,timezone,verified', $config['token']);
		} catch(\Facebook\Exceptions\FacebookResponseException $e) {

		  $data['auth'] = false;
		  $data['msg'] 	= 'Graph returned an error: ' . $e->getMessage();
		  return json_decode(json_encode($data));

		} catch(\Facebook\Exceptions\FacebookSDKException $e) {

		  $data['auth'] = false;
		  $data['msg'] 	= 'Facebook SDK returned an error: ' . $e->getMessage();
		  return json_decode(json_encode($data));
		}

		$me = $response->getGraphUser();

		if($me->getEmail()=="" || $me->getEmail()==null){
		  $data['auth'] = false;
		  $data['msg'] 	= 'Your email facebook not verified';
		  return json_decode(json_encode($data));
		}

		$profile['id'] 			= $me->getId();
		$profile['name'] 		= $me->getName();
		$profile['email'] 		= $me->getEmail();
		$profile['first_name'] 	= $me->getFirstName();
		$profile['last_name'] 	= $me->getLastName();
		$profile['link'] 		= $me->getLink();
		$profile['gender'] 		= $me->getGender();
		$profile['locale'] 		= $me['locale'];
		$profile['timezone'] 	= $me['timezone'];
		$profile['verified'] 	= $me['verified'];

		$data['auth'] 			= true;
		$data['msg'] 			= $profile;
		return json_decode(json_encode($data));
	}


}