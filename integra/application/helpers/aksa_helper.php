<?php


function crypto_rand_secure($min, $max)
{
    $range = $max - $min;
    if ($range < 1) return $min; // not so random...
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd >= $range);
    return $min + $rnd;
}

if(!function_exists("utf8ize")){
	function utf8ize($d) {
	    if (is_array($d)) {
	        foreach ($d as $k => $v) {
	            $d[$k] = utf8ize($v);
	        }
	    } else if (is_string ($d)) {
	        return utf8_encode($d);
	    }
	    return $d;
	}
}

if(! function_exists('isJson')){
	function isJson($string) {
	 json_decode($string);
	 return (json_last_error() == JSON_ERROR_NONE);
	}	
}


if(! function_exists('json_image_limitless')){

	function  json_image_limitless($data){

		$image_preview 		= "[";

		foreach ($data as $result) {
				$image 			= 'src="'.$result.'" class="file-preview-image"';
				$image_preview 	.= "'<img ".$image."/>' ,";
			}

		$image_preview 		.= "]";

		return $image_preview;
	}
}

if(! function_exists('diffDateString')){

	function diffDateString($date,$date2=null,$lang="EN"){
		$date1 		= new DateTime($date2);
		$date2 		= new DateTime($date);
		$diff 		= $date1->diff($date2);

		$string 	= '';

		if($diff->y>0){
			$string .= $diff->y.(($lang=="ID") ? ' Year , ' : ' Tahun , ') ;
		}

		if($diff->m>0){
			$string .= $diff->m.(($lang=="ID") ? ' Month , ' : ' Bulan , ');
		}

		if($diff->d>0){
			$string .= $diff->d.(($lang=="ID") ? ' Day , ' : ' Hari , ');
		}

		if($diff->h>0){
			$string .= $diff->h.(($lang=="ID") ? ' Hour , ' : ' Jam , ');
		}

		if($diff->i>0){
			$string .= $diff->i.(($lang=="ID") ? ' Minute , ' : ' Menit , ');
		}

		if($diff->s>0){
			$string .= $diff->s.(($lang=="ID") ? ' Second , ' : ' Detik , ');
		}

		return rtrim($string,", ");
	}
}


if(! function_exists('limitless_bg')){
	function limitless_bg($letter){
		$letter 	= strtolower($letter[0]);

		switch ($letter) {
			case 'a':
				return 'bg-primary';
				break;
			case 'b':
				return 'bg-success';
				break;
			case 'c':
				return 'bg-warning';
				break;
			case 'd':
				return 'bg-danger';
				break;
			case 'e':
				return 'bg-info';
				break;
			case 'f':
				return 'bg-pink';
				break;
			case 'g':
				return 'bg-purple';
				break;
			case 'h':
				return 'bg-violet';
				break;
			case 'i':
				return 'bg-indigo';
				break;
			case 'j':
				return 'bg-blue';
				break;
			case 'k':
				return 'bg-teal';
				break;
			case 'l':
				return 'bg-green';
				break;
			case 'm':
				return 'bg-orange';
				break;
			case 'n':
				return 'bg-brown';
				break;
			case 'o':
				return 'bg-grey';
				break;
			case 'p':
				return 'bg-slate';
				break;
			case 'q':
				return 'bg-primary-400';
				break;
			case 'r':
				return 'bg-success-400';
				break;
			case 's':
				return 'bg-warning-400';
				break;
			case 't':
				return 'bg-danger-400';
				break;
			case 'u':
				return 'bg-info-400';
				break;
			case 'v':
				return 'bg-pink-800';
				break;
			case 'w':
				return 'bg-blue-400';
				break;
			case 'x':
				return 'bg-brown-400';
				break;
			case 'y':
				return 'bg-slate-800';
				break;
			case 'z':
				return 'bg-violet-400';
				break;
			default:
				return 'bg-primary';
				break;
		}

	}
}

if(!function_exists('add_minutes')){

	function add_minutes($minute,$date=null){


		$minutes_to_add = $minute;

		$date 	= ($date==null) ? date('Y-m-d H:i:s') : $date;

		$time = new DateTime($date);
		$time->add(new DateInterval('PT' . $minutes_to_add . 'M'));

		return $stamp = $time->format('Y-m-d H:i:s');
	}
}

if(!function_exists('add_day')){

	function add_day($day){
		$date = strtotime(date('Y-m-d H:i:s'));
		$date = strtotime("+".$day." day", $date);
		return date('Y-m-d H:i:s', $date);
	}
}

function getToken($length)
{
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(0, $max)];
    }

    return $token;
}

if ( ! function_exists('toObject'))
{
	function toObject($var) {
	    return json_decode(json_encode($var));
	}
}

if (! function_exists('remove_symbols')){

	function remove_symbols($string){
		return preg_replace('/[^\p{L}\p{N}\s]/u', '', $string);
	}
}

if ( ! function_exists('read_more'))
{
	function read_more($string,$limit=100)
	{
		$string = trim(preg_replace('/\s+/', ' ', $string));
		$string = trim(preg_replace('/\t+/', '', $string));
		$string = str_replace('&nbsp;','',$string);
		$length = strlen(strip_tags($string));
		if ($length>$limit){
			return substr(strip_tags($string),0,$limit).' . . . ';
		}
		else {
			return strip_tags($string);
		}
	}
}

if ( ! function_exists('limit_string'))
{
	function limit_string($string=null,$limit=100)
	{
		if($string=="" || $string==null){
			return;
		}

		$string = trim(preg_replace('/\s+/', ' ', $string));
		$string = trim(preg_replace('/\t+/', '', $string));
		$string = str_replace('&nbsp;','',$string);
		$length = strlen(strip_tags($string));
		if ($length>$limit){
			return substr(strip_tags($string),0,$limit);
		}
		else {
			return strip_tags($string);
		}
	}
}

if( ! function_exists('is_mobile')){

	function is_mobile(){
		$useragent=$_SERVER['HTTP_USER_AGENT'];

		if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
			return true;
		}else{
			return false;
		}
	}
}

if ( ! function_exists('gRecaptcha'))
{

	function gRecaptcha($type=null)
	{

		if($type=="show"){
			$show = '<div class="g-recaptcha" data-sitekey="'.GOOGLE_RECAPTCHA_SITE.'"></div>';
			return $show;
		}
		$secret = GOOGLE_RECAPTCHA_SECRET;
	    $gRecaptcha = $_POST['g-recaptcha-response'];
	    $gRecaptcha = "https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$_POST['g-recaptcha-response'];
	    $response = file_get_contents($gRecaptcha);
	    $responseData = json_decode($response);

	    if(!isset($_POST['g-recaptcha-response'])){
	    	return false;
	    }


	    if($responseData->success){
	        return true;
	    }else{
	        return false;
	    }
	}
}

if ( ! function_exists('content_url')){

	function content_url($string=false){

		if($string){
			return getenv('CONTENT_URL').'/'.$string;
		}
		
		return getenv('CONTENT_URL');
	}
}

if ( ! function_exists('data_url')){

	function data_url($string=false){

		if($string){
			return getenv('DATA_URL').'/'.$string;
		}
		
		return getenv('DATA_URL');
	}
}

if ( ! function_exists('content_dir')){

	function content_dir($string=false){

		if($string){
			return __DIR__.getenv('CONTENT_DIR').$string;
		}
		
		return __DIR__.getenv('CONTENT_DIR');
	}
}



if (! function_exists('goResult')){

	function goResult($def,$msg){
    	$data['status'] 	= $def;
		$data['data'] 		= $msg;
		return toJson($data);
    }
}

if ( ! function_exists('youtube_preview'))
{
	
	function youtube_preview($url)
	{
		$bodytag = str_replace("https://www.youtube.com/watch?v=", "https://img.youtube.com/vi/", $url);
		return $bodytag.'/mqdefault.jpg';
	}
}

if ( ! function_exists('youtube_iframe'))
{
	function youtube_iframe($url)
	{
		$bodytag = str_replace("https://www.youtube.com/watch?v=", "https://www.youtube.com/embed/", $url);
		return $bodytag.'?rel=0&amp;controls=0&amp;showinfo=0';
	}
}



if ( ! function_exists('find_replace'))
{
	/**
	 * Site URL
	 *
	 * Create a local URL based on your basepath. Segments can be passed via the
	 * first parameter either as a string or an array.
	 *
	 * @param	string	$uri
	 * @param	string	$protocol
	 * @return	string
	 */
	function find_replace($string,$find)
	{
		$bodytag = str_replace($find, "<b><u>".$find."</u></b>", strtolower($string));
		return $bodytag;
	}
}

if ( ! function_exists('toJson'))
{
	function toJson($var) {
	    header('Content-Type: application/json');
	    return json_encode($var);
	}
}

/* if (!function_exists('http_response_code')) {
    function http_response_code($code = NULL) {

        if ($code !== NULL) {

            switch ($code) {
                case 100: $text = 'Continue'; break;
                case 101: $text = 'Switching Protocols'; break;
                case 200: $text = 'OK'; break;
                case 201: $text = 'Created'; break;
                case 202: $text = 'Accepted'; break;
                case 203: $text = 'Non-Authoritative Information'; break;
                case 204: $text = 'No Content'; break;
                case 205: $text = 'Reset Content'; break;
                case 206: $text = 'Partial Content'; break;
                case 300: $text = 'Multiple Choices'; break;
                case 301: $text = 'Moved Permanently'; break;
                case 302: $text = 'Moved Temporarily'; break;
                case 303: $text = 'See Other'; break;
                case 304: $text = 'Not Modified'; break;
                case 305: $text = 'Use Proxy'; break;
                case 400: $text = 'Bad Request'; break;
                case 401: $text = 'Unauthorized'; break;
                case 402: $text = 'Payment Required'; break;
                case 403: $text = 'Forbidden'; break;
                case 404: $text = 'Not Found'; break;
                case 405: $text = 'Method Not Allowed'; break;
                case 406: $text = 'Not Acceptable'; break;
                case 407: $text = 'Proxy Authentication Required'; break;
                case 408: $text = 'Request Time-out'; break;
                case 409: $text = 'Conflict'; break;
                case 410: $text = 'Gone'; break;
                case 411: $text = 'Length Required'; break;
                case 412: $text = 'Precondition Failed'; break;
                case 413: $text = 'Request Entity Too Large'; break;
                case 414: $text = 'Request-URI Too Large'; break;
                case 415: $text = 'Unsupported Media Type'; break;
                case 500: $text = 'Internal Server Error'; break;
                case 501: $text = 'Not Implemented'; break;
                case 502: $text = 'Bad Gateway'; break;
                case 503: $text = 'Service Unavailable'; break;
                case 504: $text = 'Gateway Time-out'; break;
                case 505: $text = 'HTTP Version not supported'; break;
                default:
                    exit('Unknown http status code "' . htmlentities($code) . '"');
                break;
            }

            $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');

            header($protocol . ' ' . $code . ' ' . $text);

            $GLOBALS['http_response_code'] = $code;

        } else {

            $code = (isset($GLOBALS['http_response_code']) ? $GLOBALS['http_response_code'] : 200);

        }

        return $code;

    }
}*/



if ( ! function_exists('goExplode'))
{
	function goExplode($string,$delimiter="-",$result=0) {
	    $var 	= explode($delimiter, $string);
	    if($result==0){
	    	return $var[0];
	    }

	    if(!isset($var[$result])){
	    	return;
	    }

	    return $var[$result];
	}
}



if ( ! function_exists('seo'))
{
	function seo($s) {
	    $c = array (' ');
	    $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+');
	    $s = str_replace($d, '', $s); // Hilangkan karakter yang telah disebutkan di array $d
	    $s = strtolower(str_replace($c, '-', $s)); // Ganti spasi dengan tanda - dan ubah hurufnya menjadi kecil semua
	    return $s;
		}
}

if ( ! function_exists('match'))
{
	function match($val,$val2,$return,$return_2=null){

		if($return_2==null){
			if ($val==$val2){
				return $return;
			}	
		}
		else {
			if ($val==$val2){
				return $return;
			}else{
				return $return_2;
			}		
		}
		
	}
}

if ( ! function_exists('daysLeft'))
{
	function daysLeft($date,$day){
		date_default_timezone_set('Asia/Jakarta');
		$tanggal = Date('Y-m-d');
		$now 	= new DateTime($tanggal);
		$date 	= new DateTime($date);
		$result = $now->diff($date);

		return (($day - $result->days)<=0) ? 0 : $day - $result->days ;
	}
}

if ( ! function_exists('dateLeft') ) {

	function dateLeft($date){

		if(!$date){
			return 0;
		}

		$tanggal 	= Date('Y-m-d');
		$date1 		= new DateTime($tanggal);
		$date2 		= new DateTime($date);
		if($date2<$date1){
			return 0;
		}
		$diff 		= $date1->diff($date2);
		return $diff->days;
	}
}

if ( ! function_exists('dayRangeTotal') ) {

	function dayRangeTotal($date,$date2){

		if(!$date || !$date2){
			return 0;
		}

		$date1 		= new DateTime($date);
		$date2 		= new DateTime($date2);
		if($date2<$date1){
			return 0;
		}
		$diff 		= $date1->diff($date2);
		return $diff->days;
	}
}



if ( ! function_exists('zero'))
{
	function zero($data,$url){
		if(count($data)<=0){
			redirect($url);
			exit;
		}
	}
}


if ( ! function_exists('remFile'))
{
	function remFile($path){
		if(file_exists($path)){
			if(unlink($path)){
				return true;	
			}
			return false;
		}

		return false;
	}
}



if (!function_exists('img_holder')){
	function img_holder($type=null){
		switch ($type) {
			case 'profile-lg':
			    return content_url('images/lg/placeholder/profile.png');
				break;
			case 'profile-md':
			    return content_url('images/md/placeholder/profile.png');
				break;
			case 'profile-sm':
			    return content_url('images/sm/placeholder/profile.png');
				break;
			case 'profile-xs':
			    return content_url('images/xs/placeholder/profile.png');
				break;

			case 'image-lg':
			    return content_url('images/lg/placeholder/image.png');
			break;
			case 'image-md':
			    return content_url('images/md/placeholder/image.png');
			break;
			case 'image-sm':
			    return content_url('images/sm/placeholder/image.png');
			break;
			case 'image-xs':
			    return content_url('images/xs/placeholder/image.png');
			break;

			case 'unknown-lg':
			    return content_url('images/lg/placeholder/unknown.png');
			break;
			case 'unknown-md':
			    return content_url('images/md/placeholder/unknown.png');
			break;
			case 'unknown-sm':
			    return content_url('images/sm/placeholder/unknown.png');
			break;
			case 'unknown-xs':
			    return content_url('images/xs/placeholder/unknown.png');
			break;


			case 'noimage-lg':
			    return content_url('images/lg/placeholder/empty.png');
			break;
			case 'noimage-md':
			    return content_url('images/md/placeholder/empty.png');
			break;
			case 'noimage-sm':
			    return content_url('images/sm/placeholder/empty.png');
			break;
			case 'noimage-xs':
			    return content_url('images/xs/placeholder/empty.png');
			break;
			default:
				return content_url('images/lg/placeholder/empty.png');
				# code...
				break;
		}
	}
}


if ( ! function_exists('toTime'))
{
	function toTime($date){
		$time=strtotime($date);
		return date("H:i A",$time);
	}
}

// ------------------------------------------------------------------------
if (!function_exists('tgl_indo')){
	function tgl_indo($tgl){
     	$tanggal = substr($tgl,8,2);
     	switch (substr($tgl,5,2)){
					case '01': 
						$bulan= "Januari";
						break;
					case '02':
						$bulan= "Februari";
						break;
					case '03':
						$bulan= "Maret";
						break;
					case '04':
						$bulan= "April";
						break;
					case '05':
						$bulan= "Mei";
						break;
					case '06':
						$bulan= "Juni";
						break;
					case '07':
						$bulan= "Juli";
						break;
					case '08':
						$bulan= "Agustus";
						break;
					case '09':
						$bulan= "September";
						break;
					case '10':
						$bulan= "Oktober";
						break;
					case '11':
						$bulan= "November";
						break;
					case '12':
						$bulan= "Desember";
						break;
				}

		$tahun = substr($tgl,0,4);
		return $tanggal.' '.$bulan.' '.$tahun;
     }
}

if (!function_exists('tgltobulan_indo')){
	function goObject($var){
		return json_decode(json_encode($var));
	}
}

if (!function_exists('tgltobulan_indo')){
	function tgltobulan_indo($tgl){
		if($tgl==null){
			return false;
		}
     	$tanggal = substr($tgl,8,2);
     	switch (substr($tgl,5,2)){
					case '01': 
						$bulan= "Januari";
						break;
					case '02':
						$bulan= "Februari";
						break;
					case '03':
						$bulan= "Maret";
						break;
					case '04':
						$bulan= "April";
						break;
					case '05':
						$bulan= "Mei";
						break;
					case '06':
						$bulan= "Juni";
						break;
					case '07':
						$bulan= "Juli";
						break;
					case '08':
						$bulan= "Agustus";
						break;
					case '09':
						$bulan= "September";
						break;
					case '10':
						$bulan= "Oktober";
						break;
					case '11':
						$bulan= "November";
						break;
					case '12':
						$bulan= "Desember";
						break;
				}

		$tahun = substr($tgl,0,4);
		return $bulan.' '.$tahun;
     }
}

if (!function_exists('bln_indo')){
	function bln_indo($bln){
     	switch ($bln){
			case '1': 
				$bulan= "Januari";
				break;
			case '2':
				$bulan= "Februari";
				break;
			case '3':
				$bulan= "Maret";
				break;
			case '4':
				$bulan= "April";
				break;
			case '5':
				$bulan= "Mei";
				break;
			case '6':
				$bulan= "Juni";
				break;
			case '7':
				$bulan= "Juli";
				break;
			case '8':
				$bulan= "Agustus";
				break;
			case '9':
				$bulan= "September";
				break;
			case '10':
				$bulan= "Oktober";
				break;
			case '11':
				$bulan= "November";
				break;
			case '12':
				$bulan= "Desember";
				break;
		}
		return $bulan;
     }
}

if (!function_exists('dateRange')){
	function dateRange($strDateFrom,$strDateTo)
	{
	    $aryRange=array();

	    $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
	    $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

	    if ($iDateTo>=$iDateFrom)
	    {
	        array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
	        while ($iDateFrom<$iDateTo)
	        {
	            $iDateFrom+=86400; // add 24 hours
	            array_push($aryRange,date('Y-m-d',$iDateFrom));
	        }
	    }
	    return $aryRange;
	}
}

if (!function_exists('matchArray')){
	function matchArray($array,$value,$rule=false,$response='hidden')
	{
		if($rule==false){
			if(!in_array($value, $array)){
				return $response;
			}
			return;
		}
		else {
			if(in_array($value, $array)){
				return $response;
			}
			return;
		}
	    
	}
}

if (!function_exists('superuserAccess')){

	function superuserAccess($value)
	{
		return App\Library\Validation::superuserRoles($value,false);
	}
}



if(!function_exists('string_between')){
	function string_between($string, $start, $end){
	    $string = ' ' . $string;
	    $ini = strpos($string, $start);
	    if ($ini == 0) return '';
	    $ini += strlen($start);
	    $len = strpos($string, $end, $ini) - $ini;
	    return substr($string, $ini, $len);
	}	
}


if(!function_exists('rate_string')){
	function rate_string($rate){

		if($rate>=5){
			return "Sangat Bagus !";
		}else if($rate>=4){
			return "Bagus";
		}
		else if($rate>=3){
			return "Lumayan";
		}
		else if($rate>=2){
			return "Jelek";
		}
		else if($rate>=1){
			return "Sangat Buruk";
		}
		else {
			return "Tidak disarankan";
		}
	}

}


if(!function_exists('rate_html')){

	function rate_html($rate)
	{		
		$attr_star 			= '<span class="active"><i class="fa fa-star"></i></span>';
		$attr_blank 		= '<span><i class="fa fa-star-o"></i></span>';
		$html 				= '';

		for ($count=0; $count < (5-$rate); $count++) { 
			$html .= $attr_blank;
		}


		for ($i=1; $i <= $rate ; $i++) { 
			$html .= $attr_star;
		}

		return $html;
	}	
}

if (!function_exists('courier_name')){
	function courier_name($code)
	{	
		$code 			= strtoupper($code);
		switch ($code) {
			case 'JNE':
				return '(JNE) Jalur Nugraha Ekakurir';
				break;
			case 'POS':
				return '(POS) POS Indonesia';
				break;
			case 'TIKI':
				return '(TIKI) Citra Van Titipan Kilat';
				break;
			case 'PCP':
				return '(PCP) Priority Cargo and Package';
				break;
			case 'ESL':
				return '(ESL) Eka Sari Lorena';
				break;
			case 'RPX':
				return '(RPX) RPX Holding';
				break;
			case 'PANDU':
				return '(PANDU) Pandu Logistics';
				break;
			case 'WAHANA':
				return '(WAHANA) Wahana Prestasi Logistik';
				break;
			case 'SICEPAT':
				return '(SICEPAT) SiCepat Express';
				break;
			case 'J&T':
				return '(J&T) J&T Express';
				break;
			case 'PAHALA':
				return '(PAHALA) Pahala Kencana Express';
				break;
			case 'CAHAYA':
				return '(CAHAYA) Cahaya Logistik';
				break;
			case 'SAP':
				return '(SAP) SAP Express';
				break;
			case 'JET':
				return '(JET) JET Express';
				break;
			case 'INDAH':
				return '(INDAH) Indah Logistic';
				break;
			case 'SLIS':
				return '(SLIS) Solusi Ekspres';
				break;
			case 'DSE':
				return '(DSE) 21 Express';
				break;
			default:
				return 'Uknown Courier';
				break;
		}
	}
}

if(!function_exists('string_newline')){
	function string_newline($text){

		$text 	= strip_tags($text,"<br /><br><br/>");
	    $breaks = array("<br />","<br>","<br/>");  
	    $text = str_ireplace($breaks, "\n", $text);  

	    return $text;
	}
}

if(! function_exists('imgContentRender')){

	function  imgContentRender($dir,$image,$type = "noimage"){

		$data['sm']		= img_holder("{$type}-sm");
		$data['xs']		= img_holder("{$type}-xs");
		$data['md']		= img_holder("{$type}-md");
		$data['lg']		= img_holder("{$type}-lg");
		
		if ($image && file_exists(content_dir("images/lg/{$dir}/{$image}"))) {
			$data['lg']	= content_url("images/lg/{$dir}/{$image}");
		}

		if ($image && file_exists(content_dir("images/md/{$dir}/{$image}"))) {
			$data['md']	= content_url("images/md/{$dir}/{$image}");
		}

		if ($image && file_exists(content_dir("images/sm/{$dir}/{$image}"))) {
			$data['sm']	= content_url("images/sm/{$dir}/{$image}");
		}

		if ($image && file_exists(content_dir("images/xs/{$dir}/{$image}"))) {
			$data['xs']	= content_url("images/xs/{$dir}/{$image}");
		}

		return toObject($data);
	}
}


if(! function_exists('giveDateIfNull')){

	function giveDateIfNull($date=false){
		if(!$date){
			return Date("Y-m-d");
		}

		return $date;
	}
}


if(! function_exists("labelHtml")){
	function labelHtml($class,$string){
		return "<span class='label {$class}' style='position:initial'>{$string}</span>";
	}
}


if(! function_exists('giveImageIfNull')){

	function giveImageIfNull($img=false,$type){
		if(!$img){
			return img_holder($type);
		}

		return $img;
	}
}

if(! function_exists('colorHawk1')){

	function colorHawk1($power){
		if($power>=20){
			return 'bg-green-600';
		}else if($power>=19){
			return 'bg-green';
		}else if($power>=18){
			return 'bg-warning';
		}else if($power>=17){
			return 'bg-warning-400';
		}else if($power>=16){
			return 'bg-danger-400';
		}else{
			return 'bg-danger-600';
		}
	}
}