<?php

	include 'blocks/by_fast/models/by_fast.php'; 
	class By_fastBControllersBy_fast
	{
		function __construct()
		{
		}
		function display($parameters,$title){

			$style = $parameters->getParams('style');
			$style = $style ? $style : 'by_fast';
			// call views
			include 'blocks/by_fast/views/by_fast/'.$style.'.php';
		}
	}
	
?>