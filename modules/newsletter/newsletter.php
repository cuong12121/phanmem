<?php
	$view = FSInput::get('view','newsletter');
	$path = PATH_BASE . DS . 'modules' . DS . 'newsletter' . DS . 'controllers' . DS . $view . ".php";
	
	if(!file_exists($path))
		echo FSText :: _("Not found controller");
	else
		require_once 'controllers/'.$view.'.php';
		
	$c =  'NewsletterControllers'.ucfirst($view);
	$controller = new $c();
	$task = FSInput::get('task','display');
	$controller->$task();
?>