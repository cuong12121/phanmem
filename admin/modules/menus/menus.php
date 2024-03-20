<?php
	$module = FSInput::get('module');
	$view = FSInput::get('view','groups');
	$c = FSInput::get('c',$view);
	$path = PATH_ADMINISTRATOR . DS . 'modules' . DS . $module . DS . 'controllers' . DS . $c . ".php";
	if(!file_exists($path))
		echo FSText :: _("Not found controller");
	else
		require_once 'controllers/'.$c.".php";
		
	$c =  'MenusControllers'.ucfirst($c);
	$controller = new $c();
	
	$task = FSInput::get('task','display');
	
	$task  = $task ? $task : 'display' ;

	$controller->$task();
?>