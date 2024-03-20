<?php
/*
 * Huy write
 */
	// models 
	include 'blocks/facebook/models/facebook.php';
	class FacebookBControllersFacebook
	{
		function __construct()
		{
		}
		function display($parameters,$title)
		{
			$limit = $parameters->getParams('limit');
			$style = $parameters->getParams('style');
			$limit = $limit? $limit : '4';
			$style = $style ? $style : 'default';
			$fanpage = $parameters->getParams('fanpage');
			if(!$fanpage)
				return;
			$fanpage_name = $parameters->getParams('fanpage_name');
			$width = $parameters->getParams('width');
			$width = $width? $width : '280';
			$height = $parameters->getParams('height');
			$height = $height? $height : '300';

			// call models
			$model = new FacebookBModelsFacebook();
			
			include 'blocks/facebook/views/facebook/'.$style.'.php';
		}
	}
	
?>