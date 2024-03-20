<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
session_start();
	
require_once("../includes/config.php");
require_once ("includes/defines.php");
require_once ('../libraries/database/pdo.php');
global $db;
$db = new FS_PDO();
require_once("../includes/functions.php");
require_once("../libraries/fsinput.php");
require_once("../libraries/fstext.php");
require_once ("libraries/fstable.php");

// language
$lang_request = FSInput::get('ad_lang');
if($lang_request){
	$_SESSION['ad_lang']  = $lang_request;
} else {
	$_SESSION['ad_lang'] = isset($_SESSION['ad_lang'])?$_SESSION['ad_lang']:'vi';	
}
$module = FSInput::get('module');

$translate = FSText::load_languages('backend',$_SESSION['ad_lang'],$module);

require_once("libraries/toolbar/toolbar.php");
require_once("../libraries/fsrouter.php");
require_once("libraries/pagination.php");
require_once("libraries/template_helper.php");

//require_once('../libraries/modules/controllers.php');
require_once('../libraries/errors.php');
require_once('../libraries/fsfactory.php');
require_once ("libraries/fssecurity.php");
require_once('libraries/controllers.php');
require_once('libraries/models.php');
include_once '../libraries/ckeditor/fckeditor.php';
require_once ('libraries/controllers_categories.php');
require_once ('libraries/models_categories.php');
define('PATH_ADMINISTRATOR', dirname(__FILE__) );
//define('PATH_BASE',str_replace(DS.'administrator','',PATH_ADMINISTRATOR));
/* Task của uploadify */
$freeTask = array(
                'uploadProductImages',
                'getProductImages'
            );
$task = FSInput::get('task');
if(!in_array($task, $freeTask)){
    $loginpath = "login.php";
    if (!isset($_SESSION["ad_logged"]) || ($_SESSION["ad_logged"] != 1))
    {
        header("Location: login.php");
    }
}



/*
 * function Load Main content
 */ 

function loadMainContent($module)
{
	if($module)
	{
		$view = FSInput::get('view',$module);
		$path = PATH_ADMINISTRATOR . DS . 'modules' . DS . $module . DS . 'controllers' . DS . $view. ".php";
		if(!file_exists($path))
			die(FSText :: _("Not found controller"));
		require_once $path;
		
		$c =  ucfirst($module).'Controllers'.ucfirst($view);
		$controller = new $c();
		
		$task = FSInput::get('task');
		$task  = $task ? $task : 'display' ;
		$controller->$task();
//		if(file_exists(PATH_ADMINISTRATOR . DS . 'modules' . DS . $module . DS . $module . '.php'))
//		{
//			require 'modules/'.$module.'/'.$module.'.php';
//		}
	}	
 	
}


// load main content 
ob_start();
loadMainContent($module);
$main_content = ob_get_contents();
ob_end_clean(); 
// fwrite_stream('error.txt',$main_content);

$raw = FSInput::get('raw');
if($raw)
{
	echo $main_content;
    $db->close();
}
else
{
	include_once("templates/default/index2.php");
	$db->close(); 
//	echo Benchmark::showTimer(5) . ' sec. ';
//echo Benchmark::showMemory('kb') . ' kb' ;	
}
?>
