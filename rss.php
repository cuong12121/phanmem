<?php
// alert error
ini_set('display_errors','1');
ini_set('display_startup_errors','1');
//error_reporting (E_ALL);

header("Content-Type: application/xml;  charset=utf-8");
// inlcude libraries
require_once("libraries/fsinput.php");
require_once("libraries/fsrouter.php");

include("includes/config.php");
include("includes/functions.php");
//include("includes/defines.php");
define('URL_ROOT','https://msmobile.com.vn/');
define('IS_REWRITE',1);

 
include("libraries/database/mysql.php");

die;

$db = new Mysql_DB();
	
include("libraries/rss/rss.php");
$rss = new RSS();
$instant_articles = isset($_REQUEST['instant_articles'])?$_REQUEST['instant_articles']:0;
$remarketing = isset($_REQUEST['remarketing'])?$_REQUEST['remarketing']:0;

if($instant_articles ){
  echo $rss->getFeedInstantArticles();  	
}elseif($remarketing){  
  echo $rss->getFeedRemarketing();  
}else{
  echo $rss->GetFeed(); 
	
}

?>