<?php

include 'blocks/register/models/register.php'; 
class RegisterBControllersRegister 
{
	function __construct()
	{
	}
	function display($parameters,$title){
		$model = new RegisterBModelsRegister();
		$style = $parameters->getParams('style');
		$style = $style ? $style : 'default';
		// $game =  $model -> get_game();
			// call views
		include 'blocks/register/views/register/'.$style.'.php';
	}
}

?>