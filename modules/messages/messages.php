<?php
	$view = CInput::get('view','messages');
	$path = PATH_BASE . DS . 'modules' . DS . 'messages' . DS . 'controllers' . DS . $view . ".php";
	if(!file_exists($path))
		echo Text::_("Not found controller");
	else
		require_once 'controllers/'.$view.'.php';
		
	$c =  'MessagesControllers'.ucfirst($view);
	$controller = new $c();
	$task = CInput::get('task','inbox');
	$controller->$task();
?>