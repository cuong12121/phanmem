<?php
ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting (E_ALL);
if (!defined('DS')) {
  define('DS', DIRECTORY_SEPARATOR);
}
$rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
$path = $rootDir.'/pdf_to_img/';
$path = str_replace('/',DS,$path);

$filename = $path.'page32.jpg';
$curl = curl_init();
curl_setopt_array($curl, array(
CURLOPT_URL => 'https://freeocrapi.com/api',
CURLOPT_RETURNTRANSFER => true,
CURLOPT_FOLLOWLOCATION => true,
CURLOPT_CUSTOMREQUEST => 'POST',
CURLOPT_POSTFIELDS => array('file'=> new CURLFILE($filename))));
$response = curl_exec($curl);

if(curl_errno($curl)) {
    $error_msg = curl_error($curl);
}
curl_close($curl);
if (isset($error_msg)) {
   echo $error_msg;
}

$arr = json_decode($response, true);
echo "<pre>";
print_r($arr['text']); 
// echo $response;




// $curl = curl_init();

// curl_setopt_array($curl, array(
//   CURLOPT_URL => "https://api.apilayer.com/image_to_text/url?url=http%3A%2F%2Fphanmemhdshop.delectech.vn%2Fpdf_to_img%2F123.jpg",
//   CURLOPT_HTTPHEADER => array(
//     "Content-Type: text/plain",
//     "apikey: pM1YLTkTlfN7IICFztsc6ma7RUxjxoqS"
//   ),
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_ENCODING => "",
//   CURLOPT_MAXREDIRS => 10,
//   CURLOPT_TIMEOUT => 0,
//   CURLOPT_FOLLOWLOCATION => true,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => "GET"
// ));

// $response = curl_exec($curl);


// if(curl_errno($curl)) {
//     $error_msg = curl_error($curl);
// }
// curl_close($curl);
// if (isset($error_msg)) {
//    echo $error_msg;
// }
// // echo $response->all_text;
// $arr = json_decode($response, true);
// // echo "<pre>";
// // print_r($arr); 
// echo $arr['all_text'];




?>