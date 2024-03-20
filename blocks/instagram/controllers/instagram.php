<?php
/*
 * Huy write
 */
	// models 
	include 'blocks/instagram/models/instagram.php';
	class InstagramBControllersInstagram
	{
		function __construct()
		{
		}
		function display($parameters,$title)
		{
			//$limit = $parameters->getParams('limit');
			$style = $parameters->getParams('style');
			//$limit = $limit? $limit : '4';
			$style = $style ? $style : 'default';
			$code = $parameters->getParams('code');
			if(!$code)
				return;
			$summary = $parameters->getParams('summary');
			$link = $parameters->getParams('link');
			//$width = $width? $width : '280';
			//$height = $parameters->getParams('height');
			//$height = $height? $height : '300';

			// call models
			$model = new InstagramBModelsInstagram();
			
			include 'blocks/instagram/views/instagram/'.$style.'.php';
		}
	}
	
?>