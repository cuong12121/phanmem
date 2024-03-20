<?php
	$path = PATH_BASE . DS . 'blocks' . DS . 'newslist' . DS . 'controllers' . DS . 'newslist' . ".php";
	if(!file_exists($path))
		die("Not found controller");
	else
		require_once 'controllers/newslist.php';
		
	$c =  'NewslistBControllersNewslist';
	$controller = new $c();

	$controller->display($parameters,$title);
?>