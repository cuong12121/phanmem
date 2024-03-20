<?php
// echo 'xx';die;

//Include Google Client Library for PHP autoload file
require_once 'vendor/autoload.php';

//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Set the OAuth 2.0 Client ID
$google_client->setClientId('458806344674-lg4ghhdkffjd16afpfa3s78oshg59hlr.apps.googleusercontent.com');

//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('ft6Jvb7Tu-Aff_Qh0V96O2Yz');

//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri('https://vinalnk.com/oauth2callback');


// $client_id = '205237843052-bqr6qho4vlnfhdk77h8nub466msfpur3.apps.googleusercontent.com';
// $client_secret = 'C7iloQ1IYxgfWtaOVePM-eca';
// $redirect_uri = 'https://austores.vn/oauth2callback';


//
$google_client->addScope('email');

$google_client->addScope('profile');

//start session on web page
if (!isset($_SESSION)) {
session_start();
}

?>