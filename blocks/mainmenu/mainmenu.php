<?php 
	$group = isset($parameters['group']) ? $parameters['group'] : '2';
	$style = isset($parameters['style']) ? $parameters['style'] : 'default';
	$path = PATH_BASE . DS . 'blocks' . DS . 'mainmenu' . DS . 'controllers' . DS . 'mainmenu' . ".php";
	if(!file_exists($path))
		echo FSText :: _("Not found controller");
	else
		require_once 'controllers/mainmenu.php';
		
	$c =  'MainMenuBControllersMainMenu';
	$controller = new $c();
	$controller->display($group,$style);
?>