<?php 
	$path = PATH_BASE . DS . 'blocks' . DS . 'tags' . DS . 'controllers' . DS . 'warranty' . ".php";
	if(!file_exists($path))
		echo FSText :: _("Not found controller");
	else
		require_once 'controllers/warranty.php';
		
	$c =  'WarrantyBControllersWarranty';
	$controller = new $c();
	$controller->display();
?>