<?php 
$c_content = $_POST['c_content'];
$new_content = $c_content;
include_once __DIR__ . '/vendor/autoload.php';
$GCSE_API_KEY = "AIzaSyDbbMMydJ0-ybOr6zFze37VoAJeAjohiLs";
$GCSE_SEARCH_ENGINE_ID = "015866630168840540940:dbg6nifcpvb";
$client = new Google_Client();
$client->setApplicationName("My Project");
$client->setDeveloperKey($GCSE_API_KEY);
$service = new Google_Service_Customsearch($client);
$optParams = array("cx"=>$GCSE_SEARCH_ENGINE_ID); 
// $content = strip_tags($c_content);
$content = preg_split('/\.|\?|!|>/',$c_content);
$i=0;
$j=0;
foreach ($content as $item) {
	$item_x = strip_tags($item);
	if(isset($item_x) && !empty($item_x) && strlen($item_x) > 10) {
		// echo $item_x.'</br>';
		$i++;
		$results = $service->cse->listCse($item_x, $optParams);
		if(count($results-> items)) {
			$new_item = '<span class="dupli">'.$item_x.'</span>';
			$new_content = str_replace($item_x, $new_item, $new_content);
		}
	}
	$j++;
}
echo $new_content;

?>