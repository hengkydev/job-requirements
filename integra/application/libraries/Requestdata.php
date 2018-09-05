<?php
/*
	Copyright (c) 2016, AKSAMEDIA - JASA PEMBUATAN WEBSITE
	
	DATA SCRAPPER TO INVESTING.COM
*/
use PHPHtmlParser\Dom;
use Sunra\PhpSimple\HtmlDomParser;
use \Curl\Curl;


class Requestdata  {

	private $url 		= "https://www.investing.com/economic-calendar/";
	private $message 	= "koko";


	public function errorMessage(){
		return $this->message;
	}

	private function request($url){
		$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_URL => $url,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => http_build_query($_POST),
			  CURLOPT_HTTPHEADER => array(
			    "accept: */*",
			    "accept-encoding: gzip, deflate, br",
			    "accept-language: en-GB,en;q=0.9,en-US;q=0.8,ms;q=0.7,id;q=0.6",
			    "cache-control: no-cache",
			    "connection: keep-alive",
			    "content-type: application/x-www-form-urlencoded",
			    "origin: https://www.investing.com",
			    "referer: https://www.investing.com/economic-calendar/",
			    "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36",
			    "x-requested-with: XMLHttpRequest"
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			return toObject(["response"=>$response,"error"=>$err]);
	}

	private function requestGet($url){

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array(
		    "accept: */*",
		    "accept-encoding: gzip, deflate, br",
		    "accept-language: en-GB,en;q=0.9,en-US;q=0.8,ms;q=0.7,id;q=0.6",
		    "cache-control: no-cache",
		    "connection: keep-alive",
		    "referer: https://www.investing.com/indices/major-indices",
		    "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36",
		    "x-requested-with: XMLHttpRequest"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		return toObject(["response"=>$response,"error"=>$err]);
	}

	public static function commodities(){
			$url = "https://www.investing.com/commodities/real-time-futures";
			
			$request 				= (new self)->requestGet($url);

			if ($request->error) {

				$data['status']		= false;
				$data['message'] 	= "cURL Error #:" . $request->error;

			}else{

				$response 			= $request->response;
				$elems 				= (new self)->dom($response)->find("table[id=cross_rate_1]",0)->find("tr");
				$newdata 			= [];



				

				foreach ($elems as $key => $child) {
					if(count($child->find('td'))>=1){
						$name 				= strtolower($child->find("td",0)->find("span",0)->class);
						if(strpos($name, 'gold') !== false){
							$name 		= "Gold";
						}else if(strpos($name,"silver") !== false) {
							$name 		= "Silver";
						}else{
							$name 		= $child->find("td",0)->find("span",0)->title;
						}

						$chg_status 	= strtolower($child->find("td",6)->class);

						if(strpos($chg_status, 'greenfont') !== false){
							$chg_status 	= "up";
						}else if(strpos($chg_status, 'redfont') !== false){
							$chg_status 	= "down";
						}else{
							$chg_status 	= "normal";
						}

						$chg_status_percent 	= strtolower($child->find("td",7)->class);

						if(strpos($chg_status_percent, 'greenfont') !== false){
							$chg_status_percent 	= "up";
						}else if(strpos($chg_status, 'redfont') !== false){
							$chg_status_percent 	= "down";
						}else{
							$chg_status_percent 	= "normal";
						}

						$time_status 	= strtolower($child->find("td",9)->find("span",0)->class);

						if(strpos($time_status, 'greenclockicon') !== false){
							$time_status	= "good";
						}else{
							$time_status	= "bad";
						}

						$array 	= [
									"flag"	=>	[
										"img"	=> imgContentRender("country",seo(strtolower($name)).".png"),
										"name"	=> $name,
									],
									"commodity"		=> $child->find("td",1)->find("a",0)->plaintext,
									"month"			=> $child->find('td',2)->plaintext,
									"last"			=> $child->find('td',3)->plaintext,
									"high"			=> $child->find('td',4)->plaintext,
									"low"			=> $child->find('td',5)->plaintext,
									"chg_status"	=> $chg_status,
									"chg"			=> $child->find('td',6)->plaintext,
									"chg_percent_status"	=> $chg_status_percent,
									"chg_percent"	=> $child->find('td',7)->plaintext,
									"time"			=> $child->find('td',8)->plaintext,
									"time_status"	=> $time_status,
								  ];	

						$newdata[] 	= $array;
					}

				}

				$data['status'] 	= true;
				$data['results'] 	= $newdata;
			}

			return toObject($data);
	}

	public static function currencies(){
			$url = "https://www.investing.com/currencies/";
			
			$request 				= (new self)->requestGet($url);

			if ($request->error) {
				$data['status']		= false;
				$data['message'] 	= "cURL Error #:" . $request->error;
			}else{

				$response 			= $request->response;

				$elems 				= (new self)->dom($response)->find("table[id=cr1]",0)->find("tr");

				$newdata 			= [];

				foreach ($elems as $key => $child) {
					if(count($child->find('td'))>=1){

						$condition 	= strtolower($child->find("td",0)->find("span",0)->class);

						if(strpos($condition, 'greenarrowicon') !== false){
							$condition 	= "good";
						}else if(strpos($condition,"redarrowicon") !== false) {
							$condition 	= "bad";
						}else{
							$condition 	= "normal";
						}

						$chg_status 	= strtolower($child->find("td",6)->class);

						if(strpos($chg_status, 'greenfont') !== false){
							$chg_status 	= "up";
						}else if(strpos($chg_status, 'redfont') !== false){
							$chg_status 	= "down";
						}else{
							$chg_status 	= "normal";
						}

						$chg_status_percent 	= strtolower($child->find("td",7)->class);

						if(strpos($chg_status_percent, 'greenfont') !== false){
							$chg_status_percent 	= "up";
						}else if(strpos($chg_status, 'redfont') !== false){
							$chg_status_percent 	= "down";
						}else{
							$chg_status_percent 	= "normal";
						}

						$array 	= [
									"pair"			=> [
										"condition"	=> $condition,
										"name"		=> $child->find("td",1)->find("a",0)->plaintext,
									],
									"last"			=> $child->find('td',2)->plaintext,
									"open"			=> $child->find('td',3)->plaintext,
									"high"			=> $child->find('td',4)->plaintext,
									"low"			=> $child->find('td',5)->plaintext,
									"chg_status"	=> $chg_status,
									"chg"			=> $child->find('td',6)->plaintext,
									"chg_percent_status"	=> $chg_status_percent,
									"chg_percent"	=> $child->find('td',7)->plaintext,
									"time"			=> $child->find('td',8)->plaintext,
								  ];	

						$newdata[] 	= $array;
					}

				}

				$data['status'] 	= true;
				$data['results'] 	= $newdata;
			}

			return toObject($data);
	}

	public static function watchlists($watchlists=[]){
		$url = "https://www.investing.com/equities/StocksFilter?noconstruct=1&smlID=800&sid=&tabletype=price&index_id=all";// URL ORI
		//$url = "https://www.investing.com/equities/StocksFilter?noconstruct=1&smlID=800&sid=&tabletype=price&index_id=20";

		$request 				= (new self)->requestGet($url);

		if ($request->error) {
			$data['status']		= false;
			$data['message'] 	= "cURL Error #:" . $request->error;
		}else{
			
			$response 			= $request->response;

			

			$elems 				= (new self)->dom($response)->find("table[id=cross_rate_markets_stocks_1]",0)->find("tr");
			$newdata 			= [];

			$_POST['country'][] 	= 5;
			$_POST['dateFrom']		= date("Y-m-d");
			$_POST['dateTo'] 		= date("Y-m-d",strtotime("+3 months"));
			$_POST['currentTab']	= 'custom';
			$_POST['limit_from']	= 0;

			$earning 			= Self::earningsCalendar();

			if(!$earning->status){
				$data['status']		= false;
				$data['message'] 	= "cURL Error #:" . $earning->message;
				return $data;
			}

			foreach ($elems as $key => $child) {
				if($key==0){
					continue;
				}

				$time_status 	= strtolower($child->find("td",9)->find("span",0)->class);

				if(strpos($time_status, 'greenclockicon') !== false){
					$time_status	= "good";
				}else{
					$time_status	= "bad";
				}

				$id 	= strtolower($child->find('td',1)->find('span',0)->{'data-id'});
				$unique = preg_replace('/[^\p{L}\p{N}\s]/u', '', htmlspecialchars_decode($child->find('td',1)->find('a',0)->plaintext));
				$unique = strtolower(str_replace(' ', '', $unique));

				$mewc = $watchlists->where("data",$id)->first();

				$symbol_name=htmlspecialchars_decode($child->find('td',1)->find('a',0)->title);

				$symbol 	= SymbolsModel::where("name","like","%".$symbol_name."%")->first();

				$array 	= [
							"id"			=> $id,
							"symbol" 		=> @$symbol->symbol,
							"unique"		=> $unique,
							"name"			=> $child->find('td',1)->find('a',0)->title,
							"sort_name"		=> $child->find('td',1)->find('a',0)->plaintext,
							"img"			=> imgContentRender("country",seo(strtolower($child->find('td',0)->find('span',0)->title)).".png"),
							"watchlist"		=> ($mewc) ? true : false,
							"last"			=> $child->find('td',2)->plaintext,
							"high"			=> $child->find('td',3)->plaintext,
							"low"			=> $child->find('td',4)->plaintext,
							"chg"			=> $child->find('td',5)->plaintext,
							"chg_percent"	=> $child->find('td',6)->plaintext,
							"vol"			=> $child->find('td',7)->plaintext,
							"time"			=> $child->find('td',8)->plaintext,
							"time_status"	=> $time_status,
							"earning" 		=> [],
						  ];	

				if($mewc){
					$array['earning']			= @$earning->results->data->{$unique};

					if($array['earning']){
						$notif 					= date('Y-m-d', strtotime($array['earning']->date. ' - '.$mewc->notif_day.' days'));

						$array['earning']->notif = [
							"active"		=> (date("Y-m-d")>=$notif),
							"date_earning"	=> $array['earning']->date,
							"date_notif" 	=> $notif,
							"day_left"		=> dateLeft($array['earning']->date),
							"day_left_notif"=> dateLeft($notif),
							"day"			=> $mewc->notif_day,
						];
					}

					$newdata[] 	= $array;
				}

			}
			

			$data['status'] 	= true;
			$data['results'] 	= $newdata;

		}

		return toObject($data);
	}

	public static function dumpEarning(){

		$_POST['country'][] 	= 5;
		$_POST['dateFrom']		= date("Y-m-d");
		$_POST['dateTo'] 		= date("Y-m-d",strtotime("+3 months"));
		$_POST['currentTab']	= 'custom';
		$_POST['limit_from']	= 0;
		$request 				= (new self)->request("https://www.investing.com/earnings-calendar/Service/getCalendarFilteredData");

		if ($request->error) {
			$data['status']		= false;
			$data['message'] 	= "cURL Error #:" . $request->error;
		}else{

				$response 			= json_decode($request->response);

			$elems 				= (new self)->dom($response->data)->find("tr");

			EarningModel::truncate();

			foreach ($elems as $key => $child) {
				if(count($child->find('td'))<=1){
					$time = strtotime($child->find('td',0)->plaintext);
					$newformat = date('Y-m-d',$time);
					$earning_date 						= $newformat;
				}else{

					$forecast1 				= str_replace("&nbsp;","",str_replace("/","", @$child->find('td',3)->plaintext));
					$forecast2 				= str_replace("&nbsp;","",str_replace("/","", @$child->find('td',5)->plaintext));

					$eps_status 				= strtolower($child->find('td',2)->class);

					if (strpos($eps_status, 'greenfont') !== false) {
					    $eps_status 			= "plus";
					}else if (strpos($eps_status, 'redfont') !== false){
						$eps_status 			= "minus";
					}else{
						$eps_status 			= "normal";
					}

					$revenue_status 				= strtolower($child->find('td',4)->class);

					if (strpos($revenue_status, 'greenfont') !== false) {
					    $revenue_status 			= "plus";
					}else if (strpos($eps_status, 'redfont') !== false){
						$revenue_status 			= "minus";
					}else{
						$revenue_status 			= "normal";
					}

					$unique = preg_replace('/[^\p{L}\p{N}\s]/u', '', htmlspecialchars_decode($child->find('td',1)->find('span',0)->plaintext));
					$unique = strtolower(str_replace(' ', '', $unique));

					$earning 					= new EarningModel;
					$earning->unique 			= $unique;
					$earning->country  			= $child->find('td',0)->find('span',0)->title;
					$earning->name 				= $child->find('td',1)->find('span',0)->plaintext;
					$earning->symbol 			= $child->find('td',1)->find('a',0)->plaintext;
					$earning->eps_status		= $eps_status;
					$earning->eps				= $child->find('td',2)->plaintext;
					$earning->eps_forecast		= $forecast1;
					$earning->revenue_status	= $eps_status;
					$earning->revenue			= $child->find('td',4)->plaintext;
					$earning->revenue_forecast	= $forecast2;
					$earning->market_cap		= $child->find('td',6)->plaintext;
					$earning->time				= strtolower($child->find("td",7)->find("span",0)->{"data-tooltip"});
					$earning->date 				= $earning_date;
					$earning->save();
				}
			}
		}

		$data['status'] 	= true;
		$data['results'] 	= "saved";

		return toObject($data);
	}	

	public static function dumpStocks(){
		$url = "https://www.investing.com/equities/StocksFilter?noconstruct=1&smlID=800&sid=&tabletype=price&index_id=all";// URL ORI

		$request 				= (new self)->requestGet($url);

		if ($request->error) {
			$data['status']		= false;
			$data['message'] 	= "cURL Error #:" . $request->error;
		}else{
			
			$response 			= $request->response;

			

			$elems 				= (new self)->dom($response)->find("table[id=cross_rate_markets_stocks_1]",0)->find("tr");
			$newdata 			= [];

			StockModel::truncate();

			foreach ($elems as $key => $child) {
				if($key==0){
					continue;
				}

				$time_status 	= strtolower($child->find("td",9)->find("span",0)->class);

				if(strpos($time_status, 'greenclockicon') !== false){
					$time_status	= "good";
				}else{
					$time_status	= "bad";
				}

				$id 	= strtolower($child->find('td',1)->find('span',0)->{'data-id'});

				$unique = preg_replace('/[^\p{L}\p{N}\s]/u', '', htmlspecialchars_decode($child->find('td',1)->find('a',0)->plaintext));
				$unique = strtolower(str_replace(' ', '', $unique));

				$stock 	= StockModel::where("unique",$unique)->first();
				if(!$stock){
					$symbol_name 		=htmlspecialchars_decode($child->find('td',1)->find('a',0)->title);
					$symbol 			= SymbolsModel::where("name","like","%".$symbol_name."%")->first();

					$stock 				= new StockModel;
					$stock->symbol 		= @$symbol->symbol;
					$stock->unique 		= $unique;
					$stock->name 		= $child->find('td',1)->find('a',0)->title;
					$stock->sort_name 	= $child->find('td',1)->find('a',0)->plaintext;
					$stock->country 	= $child->find('td',0)->find('span',0)->title;
					$stock->last		= $child->find('td',2)->plaintext;
					$stock->high		= $child->find('td',3)->plaintext;
					$stock->low			= $child->find('td',4)->plaintext;
					$stock->chg			= $child->find('td',5)->plaintext;
					$stock->chg_percent	= $child->find('td',6)->plaintext;
					$stock->vol			= $child->find('td',7)->plaintext;
					$stock->time		= $child->find('td',8)->plaintext;
					$stock->time_status	= $time_status;
					$stock->save();
				}

			}

			$data['status'] 	= true;
			$data['results'] 	= "Saved";

		}

		return toObject($data);
	}

	public static function stocks($watchlists=[],$filter=false){
		$url = "https://www.investing.com/equities/StocksFilter?noconstruct=1&smlID=800&sid=&tabletype=price&index_id=all";// URL ORI
		//$url = "https://www.investing.com/equities/StocksFilter?noconstruct=1&smlID=800&sid=&tabletype=price&index_id=20";

		$request 				= (new self)->requestGet($url);

		if ($request->error) {
			$data['status']		= false;
			$data['message'] 	= "cURL Error #:" . $request->error;
		}else{
			
			$response 			= $request->response;

			

			$elems 				= (new self)->dom($response)->find("table[id=cross_rate_markets_stocks_1]",0)->find("tr");
			$newdata 			= [];

			foreach ($elems as $key => $child) {
				if($key==0){
					continue;
				}

				$time_status 	= strtolower($child->find("td",9)->find("span",0)->class);

				if(strpos($time_status, 'greenclockicon') !== false){
					$time_status	= "good";
				}else{
					$time_status	= "bad";
				}

				$id 	= strtolower($child->find('td',1)->find('span',0)->{'data-id'});

				$unique = preg_replace('/[^\p{L}\p{N}\s]/u', '', htmlspecialchars_decode($child->find('td',1)->find('a',0)->plaintext));
				$unique = strtolower(str_replace(' ', '', $unique));
				$array 	= [
							"id"			=> $id,
							"unique"		=> $unique,
							"name"			=> $child->find('td',1)->find('a',0)->title,
							"sort_name"		=> $child->find('td',1)->find('a',0)->plaintext,
							"img"			=> imgContentRender("country",seo(strtolower($child->find('td',0)->find('span',0)->title)).".png"),
							"watchlist"		=> in_array($id, $watchlists),
							"last"			=> $child->find('td',2)->plaintext,
							"high"			=> $child->find('td',3)->plaintext,
							"low"			=> $child->find('td',4)->plaintext,
							"chg"			=> $child->find('td',5)->plaintext,
							"chg_percent"	=> $child->find('td',6)->plaintext,
							"vol"			=> $child->find('td',7)->plaintext,
							"time"			=> $child->find('td',8)->plaintext,
							"time_status"	=> $time_status,
						  ];	

				if($filter){
					if(in_array($id, $watchlists)){
						$newdata[] 	= $array;		
					}

				}else{
					$newdata[] 	= $array;	
				}

			}

			$data['status'] 	= true;
			$data['results'] 	= $newdata;

		}

		return toObject($data);
	}

	public static function majorWorldIndicies(){
			$url = "https://www.investing.com/indices/Service/Price?pairid%5BmmID%5D=103&pairid%5BquoteType%5D=indice&pairid%5BsmlID%5D=74&sid=e5acbcf749e83ca3c819462297786b79&filterParams=&smlID=74";
			
			$request 				= (new self)->requestGet($url);

			if ($request->error) {
				$data['status']		= false;
				$data['message'] 	= "cURL Error #:" . $request->error;
			}else{

				$response 			= $request->response;

				$elems 				= (new self)->dom($response)->find("tr");

				$newdata 			= [];

				foreach ($elems as $key => $child) {
					if(count($child->find('td'))>=1){

						$array 	= [
									"index"		=>[
										"img"		=>  imgContentRender("country",seo(strtolower($child->find('td',0)->find('span',0)->title)).".png"),
										"country"	=> $child->find('td',0)->find('span',0)->title,
										"name"		=> $child->find('td',1)->find('a',0)->plaintext,
									],
									"last"			=> $child->find('td',2)->plaintext,
									"high"			=> $child->find('td',3)->plaintext,
									"low"			=> $child->find('td',4)->plaintext,
									"chg"			=> $child->find('td',5)->plaintext,
									"chg_percent"	=> $child->find('td',6)->plaintext,
									"time"			=> $child->find('td',7)->plaintext,
								  ];	

						$newdata[] 	= $array;
					}

				}

				$data['status'] 	= true;
				$data['results'] 	= $newdata;
			}

			return toObject($data);
	}

	public static function globalIndicies($watchlists=[],$filter=false){
			$url = "https://www.investing.com/indices/Service/Price?pairid%5BmmID%5D=103&pairid%5BquoteType%5D=indice&pairid%5BsmlID%5D=74&sid=e5acbcf749e83ca3c819462297786b79&filterParams=&smlID=74";
			
			$request 				= (new self)->requestGet($url);

			if ($request->error) {
				$data['status']		= false;
				$data['message'] 	= "cURL Error #:" . $request->error;
			}else{

				$response 			= $request->response;

				$elems 				= (new self)->dom($response)->find("tr");

				$newdata 			= [];

				foreach ($elems as $key => $child) {
					if(count($child->find('td'))>=1){

						$array 	= [
									"id"		=> $child->find('td',1)->find('span',0)->{'data-id'},
									"watchlist"	=> in_array($child->find('td',1)->find('span',0)->{'data-id'}, $watchlists),
									"index"		=>[
										"img"		=>  imgContentRender("country",seo(strtolower($child->find('td',0)->find('span',0)->title)).".png"),
										"country"	=> $child->find('td',0)->find('span',0)->title,
										"name"		=> $child->find('td',1)->find('a',0)->plaintext,
									],
									"last"			=> $child->find('td',2)->plaintext,
									"high"			=> $child->find('td',3)->plaintext,
									"low"			=> $child->find('td',4)->plaintext,
									"chg"			=> $child->find('td',5)->plaintext,
									"chg_percent"	=> $child->find('td',6)->plaintext,
									"time"			=> $child->find('td',7)->plaintext,
								  ];	

						if($filter){
							if(in_array($child->find('td',1)->find('span',0)->{'data-id'}, $watchlists)){
								$newdata[] 	= $array;		
							}

						}else{
							$newdata[] 	= $array;	
						}
						
					}

				}

				$data['status'] 	= true;
				$data['results'] 	= $newdata;
			}

			return toObject($data);
	}

	public static function economicCalendar(){
			
			$request 				= (new self)->request("https://www.investing.com/economic-calendar/Service/getCalendarFilteredData");

			if ($request->error) {
				$data['status']		= false;
				$data['message'] 	= "cURL Error #:" . $request->error;
			}else{

				$response 			= json_decode($request->response);

				$elems 				= (new self)->dom($response->data)->find("tr");

				$elem_data['header'] 	= null;
				$elem_data['data'] 		= [];

				foreach ($elems as $key => $child) {
					if(count($child->find('td'))<=1){
						$elem_data['data'][] 	= ["header"=>$child->find('td',0)->plaintext];
					}else{

						$actual_status 	= strtolower(@$child->find("td",4)->class);

						if(strpos($actual_status, 'greenfont') !== false){
							$actual_status 	= "up";
						}else if(strpos($actual_status, 'redfont') !== false){
							$actual_status 	= "down";
						}else{
							$actual_status 	= "normal";
						}


						$previous_status 	= strtolower(@$child->find("td",6)->class);

						if(strpos($previous_status, 'greenfont') !== false){
							$previous_status 	= "up";
						}else if(strpos($actual_status, 'redfont') !== false){
							$previous_status 	= "down";
						}else{
							$previous_status 	= "normal";
						}

						$elem_data['data'][] 	= [
												"time"			=> $child->find('td',0)->plaintext,
												"currency"		=> [
													"img"		=>  imgContentRender("country",seo(strtolower($child->find('td',1)->find('span',0)->title)).".png"),
													"img_name"	=> seo(strtolower($child->find('td',1)->find('span',0)->title)).".png",
													"country"	=> $child->find('td',1)->find('span',0)->title,
													"code"		=> str_replace("&nbsp;","",$child->find('td',1)->plaintext),
												],
												"imp"			=> count($child->find("td",2)->find("i[class=grayFullBullishIcon]")),
												"event"			=> (!isset($child->find("td",3)->find("a",0)->plaintext) ? '' : $child->find("td",3)->find("a",0)->plaintext),
												"actual_status"	=> $actual_status,
												"actual"		=> (!isset($child->find("td",4)->plaintext) ? '' : $child->find("td",4)->plaintext),
												"forecast"		=> str_replace("&nbsp;","",@$child->find("td",5)->plaintext),
												"previous_status"	=> $previous_status,
												"previous"		=> (!isset($child->find("td",6)->plaintext) ? '' : $child->find("td",6)->plaintext),
											  ];	
					}

				}

				$response->header 	= $elem_data['header'];
				$response->data 	= $elem_data['data'];

				$data['status'] 	= true;
				$data['results'] 	= $response;
			}

			return toObject($data);
	}

	public static function earningsCalendar($watchlists=[],$filter=false){
			
		$request 				= (new self)->request("https://www.investing.com/earnings-calendar/Service/getCalendarFilteredData");

		if ($request->error) {
			$data['status']		= false;
			$data['message'] 	= "cURL Error #:" . $request->error;
		}else{

			$response 			= json_decode($request->response);

			$elems 				= (new self)->dom($response->data)->find("tr");

			$elem_data['header'] 	= null;
			$elem_data['data'] 		= [];

			foreach ($elems as $key => $child) {
				if(count($child->find('td'))<=1){
					$elem_data['data']["break_".$key] 	= ["header"=>$child->find('td',0)->plaintext];
					$time = strtotime($child->find('td',0)->plaintext);
					$newformat = date('Y-m-d',$time);
					$earning_date 						= $newformat;
				}else{

					$forecast1 				= str_replace("&nbsp;","",str_replace("/","", @$child->find('td',3)->plaintext));
					$forecast2 				= str_replace("&nbsp;","",str_replace("/","", @$child->find('td',5)->plaintext));

					$eps_status 				= strtolower($child->find('td',2)->class);

					if (strpos($eps_status, 'greenfont') !== false) {
					    $eps_status 			= "plus";
					}else if (strpos($eps_status, 'redfont') !== false){
						$eps_status 			= "minus";
					}else{
						$eps_status 			= "normal";
					}

					$revenue_status 				= strtolower($child->find('td',4)->class);

					if (strpos($revenue_status, 'greenfont') !== false) {
					    $revenue_status 			= "plus";
					}else if (strpos($eps_status, 'redfont') !== false){
						$revenue_status 			= "minus";
					}else{
						$revenue_status 			= "normal";
					}

					$unique = preg_replace('/[^\p{L}\p{N}\s]/u', '', htmlspecialchars_decode($child->find('td',1)->find('span',0)->plaintext));
					$unique = strtolower(str_replace(' ', '', $unique));

					$array		= [
									"id" 			=> $child->find('td',1)->find('a',0)->plaintext,
									"watchlist"		=> in_array($child->find('td',1)->find('a',0)->plaintext, $watchlists),
									"unique"		=> $unique,
									"date"			=> $earning_date,
									"country"		=> [
										"img"		=> imgContentRender("country",seo(strtolower($child->find('td',0)->find('span',0)->title)).".png"),
										"name"		=> $child->find('td',0)->find('span',0)->title,
									],
									"company"		=> [
										"name"		=> $child->find('td',1)->find('span',0)->plaintext,
										"code"		=> $child->find('td',1)->find('a',0)->plaintext,
									],
									"eps_status"		=> $eps_status,
									"eps"				=> $child->find('td',2)->plaintext,
									"eps_forecast"		=> $forecast1,
									"revenue_status"	=> $eps_status,
									"revenue"			=> $child->find('td',4)->plaintext,
									"revenue_forecast"	=> $forecast2,
									"market_cap"		=> $child->find('td',6)->plaintext,
									"time"				=> strtolower($child->find("td",7)->find("span",0)->{"data-tooltip"})
								  ];	

					if($filter){
						if(in_array($child->find('td',1)->find('a',0)->plaintext, $watchlists)){
							
							$elem_data['data'][$unique] 	= $array;		
						}

					}else{
						$elem_data['data'][$unique] 	= $array;	
					}
				}

			}

			$response->header 	= $elem_data['header'];
			$response->data 	= $elem_data['data'];

			$data['status'] 	= true;
			$data['results'] 	= $response;
		}

		return toObject($data);
	}

	private function dom($html){
		$dom 	= HtmlDomParser::str_get_html( $html );
		return $dom;
	}

	// COUNTRY DATA ..................................
	public function country(){
		$elems 	= $this->dom()->find("ul.countryOption",0);
		$country = [];

		foreach ($elems->find('li') as $child) {
			$country[]		= [
								'value'	=> $child->find('input',0)->value,
								'name'	=> $child->find('label',0)->plaintext
							  ];
		}

		return toObject($country);
	}

	
}