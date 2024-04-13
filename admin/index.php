<?php


session_start();
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
ini_set('precision', '15');
// ini_set('session.gc_maxlifetime', 5);
date_default_timezone_set('Asia/Ho_Chi_Minh');
ini_set('memory_limit', '-1');
ini_set ('max_execut_time', 100000); // 500 giây
// print_r($_SESSION);
// print_r($_REQUEST);
// die;

error_reporting(E_ALL);




require_once("../includes/config.php");
require_once ("includes/defines.php");
require_once ("../includes/functions.php");
//require_once('../libraries/database/mysql.php');
require_once ('../libraries/database/pdo.php');
global $db;
$db = new FS_PDO();

$query = " SELECT *
FROM fs_config";
global $db;
$sql = $db->query($query);
$configs =  $db->getObjectList();
$config = array();
foreach ($configs as $itemcf) {
    $config[$itemcf->name] = $itemcf->value;
}

if(isset($_SESSION['ad_userid'])){
    global $db;
    $db->query('SELECT u.id, u.username, u.email,u.published
        FROM fs_users AS u
        WHERE u.id = \''.$_SESSION['ad_userid'].'\' AND u.published = 1
        LIMIT 1');
    $user = $db->getObject();
    if(!$user){

        echo '<script type="text/javascript">alert(\'Tài khoản đang chưa được kích hoạt!\')</script>';
        session_start();    
        if(isset($_SESSION['ad_logged']) )  
            unset($_SESSION['ad_logged'])   ;

        if (isset( $_SESSION['ad_username'] ))   
            unset( $_SESSION['ad_username'] ) ;

//      if ( isset( $_SESSION['email']))    
//          unset ( $_SESSION['email']);

        if ( isset( $_SESSION['ad_userid']))     
            unset ( $_SESSION['ad_userid']);

        if ( isset( $_SESSION['ad_groupid']))     
            unset ( $_SESSION['ad_groupid']);
    }
}



// print_r($_SESSION);
//echo '<span style="color:#FFF;">';print_r($_SESSION['ad_groupid']);echo '</span>';
//if(!empty($_SESSION['ad_logged'])){
//	session_regenerate_id(true);
//}

require_once ("../includes/config.php");
require_once ("includes/defines.php");
require_once ('../libraries/database/pdo.php');
global $db;
$db = new FS_PDO();

require_once ("../includes/functions.php");
require_once ("../libraries/fsinput.php");
require_once('../libraries/fsfactory.php');
require_once ("../libraries/fstext.php");
require_once ("libraries/fstable.php");
//require_once ('../libraries/database/mysql_log.php');
//$db -> connect();


include("libraries/templates.php");
    // global $tmpl;
$tmpl = new Templates();


$lang_request = FSInput::get('ad_lang');
if ($lang_request){
    $_SESSION['ad_lang'] = $lang_request;
} else{
    $_SESSION['ad_lang'] = isset($_SESSION['ad_lang']) ? $_SESSION['ad_lang'] : 'vi';
}
$module = FSInput::get('module', 'home');
$translate = FSText::load_languages('backend', $_SESSION['ad_lang'], $module);

require_once ("libraries/toolbar/toolbar.php");
require_once ("libraries/fsrouter.php");
require_once ("libraries/pagination.php");
require_once ("libraries/template_helper.php");
require_once ('../libraries/errors.php');
require_once ('../libraries/fsfactory.php');
require_once ("libraries/fssecurity.php");
require_once ('libraries/controllers.php');
require_once ('libraries/models.php');
include_once '../libraries/ckeditor/fckeditor.php';
require_once ('libraries/controllers_categories.php');
require_once ('libraries/models_categories.php');

$check_permission_status_warehouses = FSSecurity::check_permission_status_warehouses();

define('PATH_ADMINISTRATOR', dirname(__file__));
$loginpath = "login.php";
if (!isset($_SESSION["ad_logged"]) || ($_SESSION["ad_logged"] != 1)){
//$fssecurity  = FSSecurity::check_login();
    $redi = base64_encode($_SERVER['REQUEST_URI']);
    $redirect = (URL_ADMIN.'login.php?redirect='.$redi);
    $url = base64_decode($redi);
    // echo $redirect;
    // die();
    $msg = '';
    setRedirect($redirect,$msg,'error');
   // header("Location: login.php");
}
function loadMainContent($module){
    if($module){
        if(!isset($_GET['module'])) $_GET['module'] = 'home';
        $view = FSInput::get('view', $module);
        $task = FSInput::get('task', 'display');
        $task = $task ? $task : 'display';
        $path = PATH_ADMINISTRATOR . DS . 'modules' . DS . $module . DS . 'controllers' .
        DS . $view . ".php";

        if (!file_exists($path))
            die(FSText::_("Not found controller"));
        require_once $path;
        $c = ucfirst($module) . 'Controllers' . ucfirst($view);
        $controller = new $c();
        // $permission = FSSecurity::check_permission($module, $view, $task);
        $permission = FSSecurity::check_permission_groups($module, $view, $task);
        if (!$permission){

            var_dump($module);

            die;
            echo FSText::_("Bạn không có quyền thực hiện chức năng này nhé");
            return;
        }
        FSSecurity::save_history($module, $view, $task);
        $controller->$task();
    }
}
$global_class = FSFactory::getClass('FsGlobal');
$config = $global_class -> get_all_config();

$toolbar = new ToolbarHelper();
ob_start();
loadMainContent($module);
$main_content = ob_get_contents();
ob_end_clean();
$raw = FSInput::get('raw');
$print = FSInput::get('print');
if ($raw){
    echo $main_content;
    $db->close();
}else{

    if ($print)
        include_once ("templates/default/print.php");
    else
        include_once ("templates/default/index.php");
    $db->close(); 
}
if($module == 'update'){
	rewrite_log($main_content);
}

function rewrite_log($main_content){
  $fn = "log/log_".time().".txt";
  $fp = fopen($fn,"w+") or die ("Error opening file in write mode!"); 
  $content .= '\n================'.time().'===================\n';
  $content .= $main_content;
  fputs($fp,$content); 
  fclose($fp) or die ("Error closing file!"); 
}
?>