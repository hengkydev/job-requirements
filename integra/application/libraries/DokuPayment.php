<?php 
// DOKU WORKFLOW
/*
	Copyright (c) 2016, AKSAMEDIA - JASA PEMBUATAN WEBSITE

	BASED ON DOKU DOCUMENTATION

	USE NATIVE FOR THIS LIBRARY

	1. MAKE AN PAYMENT FORM WITH FEW DATA FROM TRANSACTION // baca lengkap ndok doku
	2. FORM REDIRECTING ON PAGE PAYMENT DOKU CREDIT CARD // Insert DUMMY CREDIT CARD
	3. VALIDATING PAYMENT FROM DOKU DOKU BACKEND USE CURL TO ACCESS YOUR VERIFY URL WHEN U SET ON CONFIG ACCOUNT DOKU
		first rule 
		- identify // Make an Insert data result from doku u will be able have 4 data from doku POST
		- notify // validation beside your data with doku data using words and invoice id result as 'CONTINUE' for true and 'STOP: msg' for false
				 // make an update data who has been inserted from identify step 
		- result // this step will sending finish result 

	TRANSIDMERCHANT IS INVOICE NUMBER OR TRANSACTION ID
*/


class DokuPayment  {
	
	const sharedKey 			= "3rW5vC0iaTN5";		// DOKU SHARED KEY (MANDATORY)
	const mallId 				= "3346";		// DOKU MALL ID (MANDATORY)
	const payUrl 				= "http://staging.doku.com/Suite/Receive";
	const currency 				= '360'; 					// Default IDR

	public static function key(){
		return self::sharedKey;
	}

	public static function words($level,$data=null){
		//1 for payment
		//2 for notify
		//3 for redirect / result
		//4 for check

		switch ($level) {
			case '1':
				// AMOUNT, MALLID, TRANSIDMERCHANT
				return sha1($data['AMOUNT'].self::mallId.self::sharedKey.$data['TRANSIDMERCHANT']);
				break;
			case '2':
				// AMOUNT, MALLID, TRANSIDMERCHANT, RESULTMSG, VERIFYSTATUS

				return sha1($data['AMOUNT'].self::mallId.self::sharedKey.$data['TRANSIDMERCHANT'].$data['RESULTMSG'].$data['VERIFYSTATUS']);
				break;
			case '3':
				//  (AMOUNT, TRANSIDMERCHANT, STATUSCODE) 
				return sha1($data['AMOUNT'].self::sharedKey.$data['TRANSIDMERCHANT'].$data['STATUSCODE']);
				break;
			case '4':
				//  (MALLID, TRANSIDMERCHANT, CURRENCY)
				return sha1($data['AMOUNT'].self::sharedKey.$data['TRANSIDMERCHANT']);
				break;
			default:
				return false;
				break;
		}
	}

	// Echo Iki Nak View Gae Redirect Baca Dokumen DOku Untuk Parameter
	public static function paymentForm(array $data){
		/*
			NOTICE GIVE TRUE VALUE ON WORDS AND WORDS_RAW // auto config from here
			DATA EXAMPLE
			$data 		= array(
								'PAYMENTCHANNEL' 	=> 15,
								'MALLID' 			=> 123,
								'WORDS_RAW'			=> true,
								'WORDS'				=> true,
								dst
							);

		*/
		
		$nameRequired 	= [
								'PAYMENTCHANNEL','BASKET',
								'CHAINMERCHANT','AMOUNT','PURCHASEAMOUNT',
								'TRANSIDMERCHANT','REQUESTDATETIME','EMAIL',
								'NAME','ADDRESS','STATE','CITY',
								'PROVINCE','ZIPCODE','MOBILEPHONE'
							];
		//$static 	= ['MALLID','SHAREDKEY','CURRENCY','PURCHASECURRENCY','SESSIONID','WORDS','WORDS_RAW'];

		

		$form 		= '<form id="form-doku" method="post" action="'.self::payUrl.'">';

		$form 		.= '<input type="hidden" name="MALLID" value="'.self::mallId.'">';
		$form 		.= '<input type="hidden" name="SHAREDKEY" value="'.self::sharedKey.'">';		
		$form 		.= '<input type="hidden" name="CURRENCY" value="'.self::currency.'">';
		$form 		.= '<input type="hidden" name="PURCHASECURRENCY" value="'.self::currency.'">';
		$form 		.= '<input type="hidden" name="SESSIONID" value="'.session_id().'">';

		$words 		= self::words(1,$data);
		$form 		.= '<input type="hidden" name="WORDS" value="'.$words.'">';
		$form 		.= '<input type="hidden" name="WORDS_RAW" value="'.$words.'">';
		$form 		.= '<input type="hidden" name="COUNTRY" value="360">';


		foreach ($nameRequired as $key => $result) {
			if(!array_key_exists($result, $data)){
				$auth['auth'] 	= false;
				$auth['msg'] 	= "Opps! Value '".$result."' required";
				return json_decode(json_encode($auth));
			}
			$form .= '<input type="hidden" name="'.$result.'" value="'.$data[$result].'">';
		}


		$form 			.= '</form>';

		$form 			.= 	'<script>
								/*var timing = setTimeout(function(){
									$("#form-doku").submit();
								},2000)*/
						 	</script>';
		$auth['auth'] 	= true;
		$auth['msg'] 	= $form;
		return json_decode(json_encode($auth));
	}


	public static function checkStep($step){

		$check 			= self::rule();
		if(!$check->auth){
			return $check;
		}

		if(count($_POST)<=0){
			$data['auth'] 		= false;
			$data['msg'] 		= "STOP: ACCESS NOT VALID";
			return json_decode(json_encode($data));
		}

		switch ($step) {
			case 'identify':
				# The First Check is identify the rest is nothing
				break;

			case 'notify':
				$required 		= 	['AMOUNT','TRANSIDMERCHANT','RESULTMSG','VERIFYSTATUS','WORDS'];

				foreach ($required as $key => $result) {
					if(!array_key_exists($result, $_POST)){
						$auth['auth'] 		= false;
						$auth['msg'] 		= "STOP: ACCESS NOT VALID";
						return json_decode(json_encode($auth));
					}
				}

				if($_POST['WORDS']!=self::words(2,$_POST)){
					$data['auth'] 		= false;
					$data['msg'] 		= "STOP: REQUEST NOT VALID";
					return json_decode(json_encode($data));
				}

				break;

			case 'result':
				$required 		= 	['AMOUNT','TRANSIDMERCHANT','STATUSCODE','WORDS'];

				foreach ($required as $key => $result) {
					if(!array_key_exists($result, $_POST)){
						$auth['auth'] 		= false;
						$auth['msg'] 		= "STOP: ACCESS NOT VALID";
						return json_decode(json_encode($auth));
					}
				}
				
				if($_POST['WORDS']!=self::words(3,$_POST)){
					$data['auth'] 		= false;
					$data['msg'] 		= "STOP: REQUEST NOT VALID";
					return json_decode(json_encode($data));
				}

				break;
			
			default:
				$data['auth'] 		= false;
				$data['msg'] 		= "STOP: REQUEST NOT VALID";
				return json_decode(json_encode($data));
				break;
		}

		$data['auth'] 			= true;
		$data['msg']			= 'CONTINUE';
		return json_decode(json_encode($data));
	}


	private static function rule(){
		$required 		= 	['AMOUNT','TRANSIDMERCHANT','PAYMENTCHANNEL','SESSIONID'];
		$auth			= 	[];

		if(count($_POST)<=0){
			$auth['auth'] 		= false;
			$auth['msg'] 		= "STOP: ACCESS NOT VALID";
			return json_decode(json_encode($auth));
		}

		foreach ($required as $key => $result) {
			if(!array_key_exists($result, $_POST)){
				$auth['auth'] 		= false;
				$auth['msg'] 		= "STOP: ACCESS NOT VALID".$key;
				return json_decode(json_encode($auth));
			}
		}


		// WHITE LIST IP DOKU
		$ip 			= ip2long(@$_SERVER['REMOTE_ADDR']);
		$high_ip 		= ip2long('103.10.129.24');
		$low_ip 		= ip2long('103.10.129.0');


		if ($ip > $high_ip && $low_ip > $ip) {
		   	$auth['auth'] 		= false;
			$auth['msg'] 		= "STOP: IP NOT ALLOWED";
			return json_decode(json_encode($auth));
		}

		$auth['auth'] 			= true;
		$auth['msg']			= 'CONTINUE';
		return json_decode(json_encode($auth));
	}

}