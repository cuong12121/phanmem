<?php 

// https://cse.google.com/all  
$phrase = 'Nguyễn Duy Mạnh';
include_once __DIR__ . '/vendor/autoload.php';
// $GCSE_API_KEY = "AIzaSyDbbMMydJ0-ybOr6zFze37VoAJeAjohiLs";
// $GCSE_SEARCH_ENGINE_ID = "015866630168840540940:dbg6nifcpvb";
$GCSE_API_KEY = "AIzaSyAttvshhBKy6gBJBudDAB_lf0Li_u-ZrUQ";
$GCSE_SEARCH_ENGINE_ID = "006418234064356500738:sty2lqhrn29";
$client = new Google_Client();
$client->setApplicationName("My Project");
$client->setDeveloperKey($GCSE_API_KEY);
$service = new Google_Service_Customsearch($client);
$optParams = array("cx"=>$GCSE_SEARCH_ENGINE_ID); 
// $content = strip_tags($c_content);
$results = $service->cse->listCse($phrase, $optParams);
// print_r($content);
// $results = $service->cse->listCse($phase, $optParams);
print($results);
?>