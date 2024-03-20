<?php 
	$path = PATH_BASE . DS . 'blocks' . DS . 'slideshow' . DS . 'controllers' . DS . 'slideshow' . ".php";
	if(!file_exists($path))
		echo FSText :: _("Not found controller");
	else
		require_once 'controllers/slideshow.php';
		
	$c =  'SlideshowBControllersSlideshow';
	$controller = new $c();
	$controller->display();
?>