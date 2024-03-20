<?php

$alowTask = array(
                'uploadProductImages',
                'getProductImages',
            );
//define('PATH_ADMINISTRATOR', str_replace("\\", "/", rtrim(dirname(__file__), '/') . '/'));
define('PATH_ADMINISTRATOR', dirname(__FILE__) );
//define('PATH_BASE', str_replace("\\", "/", rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/'));
require_once("../includes/config.php");
require_once ("includes/defines.php");
require_once ('../libraries/database/pdo.php');
global $db;
$db = new FS_PDO();
require_once("../includes/functions.php");
require_once("../libraries/fsinput.php");
require_once("../libraries/fstext.php");
//require_once ('../libraries/database/mysql_log.php');
require_once('../libraries/errors.php');
require_once('../libraries/fsfactory.php');
require_once ("libraries/fssecurity.php");
require_once (PATH_ADMINISTRATOR.'libraries/toolbar/toolbar.php');
require_once (PATH_ADMINISTRATOR.'libraries/pagination.php');
require_once (PATH_ADMINISTRATOR.'libraries/template_helper.php');
require_once (PATH_ADMINISTRATOR.'libraries/controllers.php');
require_once (PATH_ADMINISTRATOR.'libraries/models.php');
$module = FSInput::get('module');
$view = FSInput::get('view', $module);
$path = PATH_ADMINISTRATOR . 'modules' . DS . $module . DS . 'controllers' . DS . $view . ".php";
if (!file_exists($path))
    die(FSText::_("Not found controller"));
require_once($path);
$class = ucfirst($module) . 'Controllers' . ucfirst($view);
$controller = new $class();
$task = FSInput::get('task');
if(!in_array($task, $alowTask))
    $task = 'display';
$controller->$task();