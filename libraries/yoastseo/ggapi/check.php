<?php 

// ini_set('display_errors','1');
// ini_set('display_startup_errors','1');
// error_reporting (E_ALL);

include_once __DIR__ . '/vendor/autoload.php';
$GCSE_API_KEY = "AIzaSyDbbMMydJ0-ybOr6zFze37VoAJeAjohiLs";
$GCSE_SEARCH_ENGINE_ID = "015866630168840540940:dbg6nifcpvb";
$client = new Google_Client();
$client->setApplicationName("My Project");
$client->setDeveloperKey($GCSE_API_KEY);
$service = new Google_Service_Customsearch($client);
$optParams = array("cx"=>$GCSE_SEARCH_ENGINE_ID); 

$c_content = @$_POST['c_content'];
$c_content = html_entity_decode($c_content);
$c_content = htmlspecialchars_decode($c_content);
$c_content = str_replace("&nbsp;", ' ', $c_content);
$new_content = $c_content;
$content = preg_split('/\. |\?|!|p>|li>|div>|h1>|h2>|h3>|h4>|h5>|h6>|- /',$c_content);
$i=0;
$j=0;
foreach ($content as $item) {
	$item_x = strip_tags($item);
	$item_x = rtrim($item_x); 
	$item_x  = trim($item_x);

	if(isset($item_x) && !empty($item_x) && strlen($item_x) > 10) {
		$i++;
		$item_x;
		$results= check_dulicate($item_x);
		if($results == 1) {
			$new_item = '<span class="dupli">'.$item_x.'</span>';
			$new_content = str_replace($item_x, $new_item, $new_content);
		}else if($results == -1){
			$new_item = $item_x;
			$new_content = str_replace($item_x, $new_item, $new_content);
		} else {
			$results_cse = $service->cse->listCse( '"'.getWord(30, $item_x).'"', $optParams);
			if(!$results_cse) {
			} else {
						if(!empty($results_cse-> items)) { // check cách 2 , bị dulucate
							$new_item = '<span class="dupli">'.$item_x.'</span>';
							$new_content = str_replace($item_x, $new_item, $new_content);
						}
					}
				}
		// echo 'mm_'.$results;
			}
			$j++;
		}
		echo $new_content;


		function check_dulicate($phare){

			$phare = strtolower($phare);
			$phare = str_replace('&nbsp;', ' ',$phare);
			$phare = html_entity_decode($phare);
			$phare = getWord(30, $phare);
			$query = '"'.$phare.'"';
			$contents = connect_remote(1,'https://www.google.com/search?q='.urlencode($query).'&aqs=chrome.0.69i59l3j69i57j46l2j0j69i61.2127j1j7&sourceid=chrome&ie=UTF-8');
			if($contents) {
				$contents = mb_convert_encoding($contents, 'UTF-8',
					mb_detect_encoding($contents, 'UTF-8, ISO-8859-1', true));
				$text = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $contents);
				$text = strip_tags($text);
    // $substring = substr($text,strpos($text,"<style"),strpos($text,"</style>")+2);
    // $text = str_replace($substring,"",$text);
				$text = str_replace(array("\t","\r","\n"),"",$text);
				$text = trim($text);
				$text = strtolower($text);
				$text = html_entity_decode($text);
				$text = str_replace(':', '-', $text);
				$text = str_replace('. ', '.', $text);
				$text = str_replace('? ', '?', $text);
	// echo ($phare);
	// echo $text;
	// echo '==';
				$substr_phare =  mb_substr($phare,2,-2,"UTF-8");
		// $substr_phare = getWord(32, $substr_phare);
		// echo $substr_phare = substr($phare,2,120);
		// echo '</br>';
	// mb_substr($string, 0, -1);
				$substr_phare = str_replace(':', '-', $substr_phare);

	// echo '<br>';
	// echo mb_substr($phare, 0,1000,"UTF-8");die;
				if(substr_count($text, $substr_phare) > 1) {
			return 1; // check cách 1 , bị duplicate
		}else {
			return -1; // check cách 1 , không bị duplicate
		};
	}
	else {
		return 0; // không check được bằng cách 1,chuyển sang check cách 2
	}
}


function connect_remote($get_type,$link)
{
    // echo $link."<br/>";
	if(!$link)
		return;
	$conts = "";
            //---------------------------------------------------
	if($get_type=="1")
	{
		$file=@fopen($link,'rb');
		if($file)
		{
			while (!feof($file)) {
				$conts.= fread($file, 16384 );
			}
			fclose($file);

			if(!$conts)
				return false;
		}
		else
			return false;

	}

            //---------------------------------------------------
	if($get_type=="2")
	{
		$conts=file_get_contents($link);
		if(!$conts)
			return false;
	}

            //---------------------------------------------------
	if($get_type=="3")
	{
//              $link=str_replace('news.zing.vn','www.zing.vn',$link);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$link);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_POST, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		$conts=curl_exec($ch);
		curl_close ($ch);
	}
	if(!$conts){
		echo "ko lấy đc";
		return false;
	}
	return $conts;
}

function getWord($noWord,$str){

	$noCountWord = count_words(strip_tags($str));
	if($noCountWord >= $noWord){
		$content = implodeWord(strip_tags($str),$noWord).'';
	} else {
		$content = strip_tags($str);
	}
	$k = chr(92); 
	$content = str_replace($k,"",$content);
	return $content;
}

function count_words($str) {
	$words = 0;

	$str =  preg_replace("/ +/i", " ", $str);
	$array = explode(" ", $str);
	for($i=0;$i < count($array);$i++){

		if (preg_match("/[0-9A-Za-zÀ-ÖØ-öø-ÿ]/i", $array[$i]))

			$words++;
	}
	return $words;
}

function implodeWord($str,$noWord){

	$str = preg_replace("/ +/i", " ", $str);
	$array = explode(" ", $str);

	
	for($i=0;$i<$noWord;$i++){       
		if (preg_match("/[0-9A-Za-zÀ-ÖØ-öø-ÿ]/i", $array[$i])) $aryContent[] = $array[$i];

	}
	$strContent = implode(" ",$aryContent);
	return $strContent;
}
?>