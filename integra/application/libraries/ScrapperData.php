<?php 
use PHPHtmlParser\Dom;
use Sunra\PhpSimple\HtmlDomParser;
/*
	Copyright (c) 2016, AKSAMEDIA - JASA PEMBUATAN WEBSITE
	
	DATA SCRAPPER TO INVESTING.COM
*/


class ScrapperData  {

	private $url 		=[
							"https://www.investing.com/economic-calendar/",
							"https://www.investing.com/earnings-calendar/"
						  ];
	private $message 	= "";

	public function errorMessage(){
		return $this->message;
	}

	private function load($url){

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
		    "cookie: adBlockerNewUserDomains=1520367682; optimizelyEndUserId=oeu1520367655827r0.19649465523143883; optimizelySegments=%7B%224225444387%22%3A%22gc%22%2C%224226973206%22%3A%22search%22%2C%224232593061%22%3A%22false%22%2C%225010352657%22%3A%22none%22%7D; optimizelyBuckets=%7B%7D; _ga=GA1.2.129369607.1520367656; __qca=P0-2134206986-1520367657040; r_p_s=1; G_ENABLED_IDPS=google; PHPSESSID=dkmfa8pm70lb0mt77m44k6btt5; geoC=ID; StickySession=id.12761735475.557.www.investing.com; _gid=GA1.2.967627667.1521710460; editionPostpone=1521711197766; __gads=ID=95526a3ea4c8496f:T=1521711248:S=ALNI_MYDMxInwoSEuBaEZKza97tHDQ5_dQ; gtmFired=OK; billboardCounter_1=1; nyxDorf=NzNiNTRiYyE2YGh6NWdlbjBiNnNlYDMxYmc%3D",
		    "postman-token: 4330d8a5-e2a4-26f3-211a-26d3489ed181",
		    "referer: https://www.investing.com/economic-calendar/",
		    "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.186 Safari/537.36",
		    "x-requested-with: XMLHttpRequest"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  $this->message = $err;
		  echo $err;
		  die();
		  return false;
		} else {
		  return $response;
		}

	}

	private function dom($index){
		$html 	= $this->load($this->url[$index]);
		$dom 	= HtmlDomParser::str_get_html( $html );
		return $dom;
	}

	// COUNTRY DATA ..................................
	public function country(){
		$elems 	= $this->dom(0)->find("ul.countryOption",0);
		$country = [];

		foreach ($elems->find('li') as $child) {
			$country[]		= [
								'value'	=> $child->find('input',0)->value,
								'name'	=> $child->find('label',0)->plaintext
							  ];
		}

		return toObject($country);
	}

	// CATEGORY ECONOMIC 
	public function category($type){
		switch ($type) {
			case 'economic_calendar':
				return $this->categoryEconomicCalendar();
				break;
			case 'earnings_calendar':
				return $this->categoryEarningsCalendar();
				break;
			default:
				return false;
				break;
		}
	}

	public function categoryEconomicCalendar(){
		$elems 	= $this->dom(0)->find("ul.filterList",0);
		$data = [];

		foreach ($elems->find('li') as $child) {
			$data[]		= [
								'value'	=> $child->find('input',0)->value,
								'name'	=> $child->find('label',0)->plaintext
							  ];
		}

		return toObject($data);
	}

	public function categoryEarningsCalendar(){
		$elems 	= $this->dom(1)->find("ul.filterList",0);
		$data = [];

		foreach ($elems->find('li') as $child) {
			$data[]		= [
								'value'	=> $child->find('input',0)->value,
								'name'	=> $child->find('label',0)->plaintext
							  ];
		}

		return toObject($data);
	}

	// TIMEZONE .........................................
	public function timeZone(){
		$elems 	= $this->dom(0)->find("ul.js-scrollable-block",0);
		$data = [];

		foreach ($elems->find('li') as $child) {
			$data[]		= [
								'value'	=> substr($child->id,4),
								'name'	=> $child->plaintext
							  ];
		}

		return toObject($data);
	}

	// ATTRIBUTE DATA ..................................
	public function attribute(){

		$data 		= [
						'currentTab'	=> [
							'yesterday','today','tomorrow','nextWeek'
						],
						'timeFilter'	=> [
							'timeRemain','timeOnly'
						],
						'importance'	=> [
							1,2,3
						]
					  ];

		return toObject($data);

	}

}