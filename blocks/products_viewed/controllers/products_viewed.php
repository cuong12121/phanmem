<?php

	include 'blocks/products_viewed/models/products_viewed.php';
	class Products_viewedBControllersProducts_viewed
	{
		function __construct()
		{
		}
		function display($parameters,$title){ 
			$limit = $parameters->getParams('limit');
			$limit = $limit ? $limit:5; 
			// call models
			$model = new Products_viewedBModelsProducts_viewed();
			$list = $model -> setCookie();

			$types = $model -> get_types();
			if(!$list)
				return;
			$style = $parameters->getParams('style');
			$style = $style ? $style : 'default';
			// call views
			if(!empty($list) && !empty($list[0])){
				include 'blocks/products_viewed/views/products_viewed/'.$style.'.php';
			}
			
	
		}
	}
	
?>