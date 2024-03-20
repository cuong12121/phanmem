<?php 
$c_content = $_POST['c_content'];
$new_content = $c_content;

$content = preg_split('/\.|\?|!|p>|li>|div>/',$c_content);
$i=0;
$j=0;
foreach ($content as $item) {
	$item_x = strip_tags($item);
	if(isset($item_x) && !empty($item_x) && strlen($item_x) > 10) {
		$i++;
		echo $results = check_dulicate($item_x);
		if($results) {
			$new_item = '<span class="dupli">'.$item_x.'</span>';
			$new_content = str_replace($item_x, $new_item, $new_content);
		}
	}
	$j++;
}
echo $new_content;

function check_dulicate($phare){
	$phare = strtolower($phare);
	$phare = html_entity_decode($phare);
	$arr_decima = array('ả'=>'&#7843;','ạ' => '&#7841;', 'ề' => '&#7873;', 'ế' => '&#7871;', 'ể' => '&#7875;', 'ễ' => '&#7877;', 'ệ' => '&#7879;', 'ẻ' => '&#7867;', 'ẽ' => '&#7869;', 'ẹ' => '&#7865;', 'ỉ' => '&#7881;', 'ĩ' => '&#297;', 'ị' => '&#7883;', 'ă'=> '&#259;', 'ằ'=> '&#7857;', 'ắ'=> '&#7855;', 'ẳ'=> '&#7859;', 'ẵ'=> '&#7861;', 'ặ'=> '&#7863;', 'ầ'=> '&#7847;', 'ấ'=> '&#7845;', 'ẩ'=> '&#7849;', 'ẫ'=> '&#7851;', 'ậ'=> '&#7853;', 'ồ'=> '&#7891;', 'ố'=> '&#7889;', 'ổ'=> '&#7893;', 'ỗ'=> '&#7895;', 'ộ'=> '&#7897;', 'ơ'=> '&#417;', 'ờ'=> '&#7901;', 'ớ'=> '&#7899;', 'ở'=> '&#7903;', 'ỡ'=> '&#7905;', 'ợ'=> '&#7907;', 'ủ'=> '&#7911;', 'ũ'=> '&#361;', 'ụ'=> '&#7909;', 'ư'=> '&#432;', 'ừ'=> '&#7915;', 'ứ'=> '&#7913;', 'ử'=> '&#7917;', 'ữ'=> '&#7919;', 'ự'=> '&#7921;', 'đ'=> '&#273;', '& ' => '&amp; ');
	$query = '"'.$phare.'"';
	include 'simple_html_dom.php';
	$contents = file_get_html('https://www.google.com/search?q='.urlencode($query).'&aqs=chrome.0.69i59l3j69i57j46l2j0j69i61.2127j1j7&sourceid=chrome&ie=UTF-8');
	$contents = $contents-> find('body',0) -> plaintext;
    // $url = 'http://www.google.co.in/search?q='.urlencode($query).'';
    // $contents = connect_remote(1,'https://www.google.com/search?q='.urlencode($query).'&aqs=chrome.0.69i59l3j69i57j46l2j0j69i61.2127j1j7&sourceid=chrome&ie=UTF-8');
	$contents = mb_convert_encoding($contents, 'UTF-8',
		mb_detect_encoding($contents, 'UTF-8, ISO-8859-1', true));
    // $text = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $contents);
	$text = strip_tags($contents);
    // $substring = substr($text,strpos($text,"<style"),strpos($text,"</style>")+2);
    // $text = str_replace($substring,"",$text);
	$text = str_replace(array("\t","\r","\n"),"",$text);
	$text = trim($text);
	$text = strtolower($text);
	$text = html_entity_decode($text);
	echo htmlspecialchars($text);
	echo '<br>';
	echo htmlspecialchars($phare);
	echo '<br>';
	echo substr_count($text, $phare);
	if(substr_count($text, $phare) > 1) {
		return 1;
	}else {
		return 0;
	};
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
		$file=fopen($link,'rb');
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
?>