
<?php
/*
 *  Login and logout
 */
	require_once "controllers/log.php";
		
	$c =  'UsersControllersLog';
	$controller = new $c();
	
	$task  = 'display' ;
	
	$controller->$task();
?>