<?php 
	$path = PATH_BASE . DS . 'blocks' . DS . 'tags' . DS . 'controllers' . DS . 'tags' . ".php";
	if(!file_exists($path))
		echo FSText :: _("Not found controller");
	else
		require_once 'controllers/tags.php';
		
	$c =  'TagsBControllersTags';
	$controller = new $c();
	$controller->display();
?>