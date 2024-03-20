<?php
	$module = FSInput::get('module');
	$view = FSInput::get('view','members');
	$path = PATH_ADMINISTRATOR . DS . 'modules' . DS . $module . DS . 'controllers' . DS . $view. ".php";
	if(!file_exists($path))
		echo FSText::_("Not found controller");
	else
		require_once 'controllers/'.$view.".php";
		
	$c =  ucfirst($module).'Controllers'.ucfirst($view);
	$controller = new $c();
	
	$task = FSInput::get('task');
	$task  = $task ? $task : 'display' ;
	
	$controller->$task();
?>