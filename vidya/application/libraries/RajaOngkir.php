<?php 
// RAJAONGKIR
/*
	Copyright (c) 2016, AKSAMEDIA - JASA PEMBUATAN WEBSITE

	BASED ON RAJAONGKIR DOCUMENTATION
*/


class RajaOngkir  {

	const key 	= "5e610f0aa5f9d307a84c9c541e1d1701";
	const url 	= "http://pro.rajaongkir.com/api/";
	

	public static function getProvince(){
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "http://pro.rajaongkir.com/api/province",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
			  "key: ".self::key
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			$data['status'] 		= false;
			$data['results'] 		= "Error CURL : ".$err;
			return json_decode(json_encode($data));
		}

		$response = json_decode($response);


		if($response->rajaongkir->status->code!==200){
			$data['status'] 		= false;
			$data['results'] 		= $response->rajaongkir->status->description;
			return json_decode(json_encode($data));
		}

		if(count($response->rajaongkir->results)<=0){
			$data['status'] 		= false;
			$data['results'] 		= 'Tidak Ada Data';
			return json_decode(json_encode($data));	
		}

		foreach ($response->rajaongkir->results as $result) {
			$province[] 	= array('id' => $result->province_id, 'name' => $result->province);		
		}		

		$data['status'] 		= true;
		$data['results'] 		= $province;
		return json_decode(json_encode($data));
	}

	public static function findProvince($id){
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "http://pro.rajaongkir.com/api/province?id=".$id,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
			  "key: ".self::key
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			$data['status'] 		= false;
			$data['results'] 		= "Error CURL : ".$err;
			return json_decode(json_encode($data));
		}

		$response = json_decode($response);

		if($response->rajaongkir->status->code!==200){
			$data['status'] 		= false;
			$data['results'] 		= $response->rajaongkir->status->description;
			return json_decode(json_encode($data));
		}

		if(count($response->rajaongkir->results)<=0){
			$data['status'] 		= false;
			$data['results'] 		= 'Tidak Ada Data';
			return json_decode(json_encode($data));	
		}

		$data['status'] 		= true;
		$data['results'] 		= $response->rajaongkir->results;
		return json_decode(json_encode($data));
	}

	public static function getCity($province){

			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "http://pro.rajaongkir.com/api/api/city?id=&province=".$province,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			  CURLOPT_HTTPHEADER => array(
			     "key: ".self::key
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);


			if ($err) {
				$data['status'] 		= false;
				$data['results'] 		= "Error CURL : ".$err;
				return json_decode(json_encode($data));
			}
			$response = json_decode($response);

			if($response->rajaongkir->status->code!==200){
				$data['status'] 		= false;
				$data['results'] 		= $response->rajaongkir->status->description;
				return json_decode(json_encode($data));
			}

			if(count($response->rajaongkir->results)<=0){
				$data['status'] 		= false;
				$data['results'] 		= 'Tidak Ada Data';
				return json_decode(json_encode($data));	
			}

			foreach ($response->rajaongkir->results as $result) {
				$city[] 	= array('id' => $result->city_id, 'name' => $result->city_name,'type' => $result->type);		
			}			  

			$data['status'] 		= true;
			$data['results'] 		= $city;
			return json_decode(json_encode($data));
	}

	public static function findCity($id,$province){
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "http://pro.rajaongkir.com/api/city?id=".$id.'&province='.$province,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
			  "key: ".self::key
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			$data['status'] 		= false;
			$data['results'] 		= "Error CURL : ".$err;
			return json_decode(json_encode($data));
		}

		$response = json_decode($response);

		if($response->rajaongkir->status->code!==200){
			$data['status'] 		= false;
			$data['results'] 		= $response->rajaongkir->status->description;
			return json_decode(json_encode($data));
		}

		if(count($response->rajaongkir->results)<=0){
			$data['status'] 		= false;
			$data['results'] 		= 'Tidak Ada Data';
			return json_decode(json_encode($data));	
		}

		$data['status'] 		= true;
		$data['results'] 		= $response->rajaongkir->results;
		return json_decode(json_encode($data));
	}

	public static function getDistrict($city){
		
		$curl = curl_init();

		curl_setopt_array($curl, array(

		  CURLOPT_URL => "http://pro.rajaongkir.com/api/subdistrict?city=".$city,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array(
		    "key: ".self::key
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			$data['status'] 		= false;
			$data['results'] 		= "Error CURL : ".$err;
			return json_decode(json_encode($data));
		}

		$response = json_decode($response);


		if($response->rajaongkir->status->code!==200){
			$data['status'] 		= false;
			$data['results'] 		= $response->rajaongkir->status->description;
			return json_decode(json_encode($data));
		}

		if(count($response->rajaongkir->results)<=0){
			$data['status'] 		= false;
			$data['results'] 		= 'Tidak Ada Data';
			return json_decode(json_encode($data));	
		}


		foreach ($response->rajaongkir->results as $result) {
			$district[] = array('id' => $result->subdistrict_id, 'name' => $result->subdistrict_name);
		}

		$data['status'] 		= true;
		$data['results'] 		= $district;
		return json_decode(json_encode($data));
	}

	public static function findDistrict($id,$city,$province){
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "http://pro.rajaongkir.com/api/subdistrict?id=".$id.'&city='.$city.'&province='.$province,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
			  "key: ".self::key,
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			$data['status'] 		= false;
			$data['results'] 		= "Error CURL : ".$err;
			return json_decode(json_encode($data));
		}

		$response = json_decode($response);

		if($response->rajaongkir->status->code!==200){
			$data['status'] 		= false;
			$data['results'] 		= $response->rajaongkir->status->description;
			return json_decode(json_encode($data));
		}

		if(count($response->rajaongkir->results)<=0){
			$data['status'] 		= false;
			$data['results'] 		= 'Tidak Ada Data';
			return json_decode(json_encode($data));	
		}

		$data['status'] 		= true;
		$data['province_txt'] 	= $response->rajaongkir->results->province_id.'//'.$response->rajaongkir->results->province;
		
		$data['city_txt'] 		= $response->rajaongkir->results->city_id.'//'.
								  $response->rajaongkir->results->city.'//'.$response->rajaongkir->results->type;

		$data['district_txt'] 	= $response->rajaongkir->results->subdistrict_id.'//'.$response->rajaongkir->results->subdistrict_name;
		$data['results'] 		= $response->rajaongkir->results;
		return json_decode(json_encode($data));
	}

	public static function getCost(array $config){
			$required 	= ['destination','weight','courier','origin'];

			foreach ($required as $result) {
				if(!array_key_exists($result, $config)){
					$data['status'] 	= false;
					$data['results'] 	= "Opps! '".$result."' required";
					return json_decode(json_encode($data));
				}
			}

			// If Origin not set give default origin surabaya 
			if(!isset($config['origin'])){
				$config['origin'] 	= 444;
			}

			$config['weight'] 		= ceil($config['weight']/1000) * 1000;
			$config['courier']		= strtolower($config['courier']);

			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "http://pro.rajaongkir.com/api/cost",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => "origin=".$config['origin'].
			  						"&originType=city&destination=".$config['destination'].
			  						"&destinationType=subdistrict&weight=".$config['weight'].
			  						"&width=".@$config['width'].
			  						"&length=".@$config['length'].
			  						"&height=".@$config['height'].
			  						"&diameter=".@$config['diameter'].
			  						"&courier=".$config['courier'],
			  CURLOPT_HTTPHEADER => array(
			    "content-type: application/x-www-form-urlencoded",
			    "key: ".self::key
			  ),
			));


			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
				$data['status'] 		= false;
				$data['results'] 		= "Error CURL : ".$err;
				return json_decode(json_encode($data));
			}

			$response 		= json_decode($response);


			if($response->rajaongkir->status->code!==200){
				$data['status'] 		= false;
				$data['results'] 		= $response->rajaongkir->status->description;
				return json_decode(json_encode($data));
			}



			$costs 				= [];

			foreach ($response->rajaongkir->results[0]->costs as $result) {

				$costs[] 		= array(
										'name' 			=> $result->service, 
										'description'	=> $result->description,
										'cost' 			=> $result->cost[0]->value, 
										'estimation' 	=> $result->cost[0]->etd,
										'note' 			=> $result->cost[0]->note,
								  );

			}

			$data['status'] 		= true;
			$data['results'] 		= $costs;
			return json_decode(json_encode($data));
	}

	public static function getWaybill(array $config){
			$required 	= ['waybill','courier'];

			foreach ($required as $result) {
				if(!array_key_exists($result, $config)){
					$data['status'] 	= false;
					$data['results'] 	= "Opps! '".$result."' required";
					return json_decode(json_encode($data));
				}
			}

			$courier 	= strtolower($config['courier']);

			$available 	= ['jne','pos','tiki','wahana','jnt','rpx','sap','sicepat','pcp','jet','dse'];

			if(!in_array($courier, $available)){
				$data['status'] 	= false;
				$data['results'] 	= "Opps! '".$courier."' not available";
				return json_decode(json_encode($data));
			}

			$waybill 	= $config['waybill'];

			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "http://pro.rajaongkir.com/api/waybill",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => "waybill=".$waybill."&courier=".$courier,
			  CURLOPT_HTTPHEADER => array(
			    "content-type: application/x-www-form-urlencoded",
			    "key: ".self::key
			  ),
			));


			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
				$data['status'] 		= false;
				$data['results'] 		= "Error CURL : ".$err;
				return json_decode(json_encode($data));
			}

			$response 		= json_decode($response);

			if($response->rajaongkir->status->code!="200"){
				$data['status'] 		= false;
				$data['results'] 		= $response->rajaongkir->status->description;
				return json_decode(json_encode($data));
			}

			$data['status'] 		= true;
			$data['results'] 		= $response->rajaongkir->result;
			return json_decode(json_encode($data));
	}

	public static function result(array $config){

		$must 				= ['destination','courier','weight','service','origin'];

		foreach ($must as $result) {
			if(!array_key_exists($result, $config)){
				$data['status'] 	= false;
				$data['results'] 	= "Opps! '".$result."' required";
				return json_decode(json_encode($data));
			}
		}

		$config['weight'] 		= ceil($config['weight']/1000) * 1000;
		$config['courier']		= strtolower($config['courier']);

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://pro.rajaongkir.com/api/cost",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "origin=".$config['origin'].
		  						"&originType=city&destination=".$config['destination'].
		  						"&destinationType=subdistrict&weight=".$config['weight'].
		  						"&width=".@$config['width'].
		  						"&length=".@$config['length'].
		  						"&height=".@$config['height'].
		  						"&diameter=".@$config['diameter'].
		  						"&courier=".$config['courier'],
		  CURLOPT_HTTPHEADER => array(
		    "content-type: application/x-www-form-urlencoded",
		    "key: ".self::key
		  ),
		));


		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			$data['status'] 		= false;
			$data['results'] 		= "Error CURL : ".$err;
			return json_decode(json_encode($data));
		}

		$response 		= json_decode($response);

		if($response->rajaongkir->status->code!==200){
			$data['status'] 		= false;
			$data['results'] 		= $response->rajaongkir->status->description;
			return json_decode(json_encode($data));
		}

		$ongkir['weight'] 			= $response->rajaongkir->query->weight;

		$ongkir['origin']			= $response->rajaongkir->origin_details;
		$ongkir['origin_province']	= $ongkir['origin']->province_id.'//'.$ongkir['origin']->province;
		$ongkir['origin_city']		= $ongkir['origin']->city_id.'//'.$ongkir['origin']->city_name.'//'.$ongkir['origin']->type;

		$ongkir['destination']			= $response->rajaongkir->destination_details;
		$ongkir['destination_province']	= $ongkir['destination']->province_id.'//'.$ongkir['destination']->province;
		$ongkir['destination_city']		= $ongkir['destination']->city_id.'//'.$ongkir['destination']->city;
		$ongkir['destination_district']	= $ongkir['destination']->subdistrict_id.'//'.$ongkir['destination']->subdistrict_name;

		$ongkir['courier_name']			= $response->rajaongkir->results[0]->name;
		$ongkir['courier_code']			= $response->rajaongkir->results[0]->code;

		foreach ($response->rajaongkir->results[0]->costs as $result) {

			if($result->service==$config['service']){

				$data['status'] 		= true;
				$ongkir['service']		= array('name' => $result->service, 'price' => $result->cost[0]->value, 'day' => @$result->cost[0]->etd);
				$ongkir['service_txt']	= $ongkir['service']['name'].'//'.$ongkir['service']['price'].'//'.$ongkir['service']['day'];
				$data['results'] 		= $ongkir;

				return json_decode(json_encode($data));
			}
		}

		$data['status'] 		= false;
		$data['results'] 		= 'Pemilihan Ongkos Kirim Anda Tidak Benar';
		return json_decode(json_encode($data));

	}


}