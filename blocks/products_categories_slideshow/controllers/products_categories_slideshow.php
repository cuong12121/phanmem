<?php
/*
 * Huy write
 */
	// models 
	include 'blocks/products_categories_slideshow/models/products_categories_slideshow.php';
	class Products_categories_slideshowBControllersProducts_categories_slideshow
	{
		function __construct()
		{
		}
		function display($parameters,$title)
		{
			global $folder_admin,$check_edit;
			$link_admin_banner = $folder_admin.'module=products&view=categories_slideshow&task=edit&id=';
			$limit = $parameters->getParams('limit');
			$style = $parameters->getParams('style');
			$category_id = $parameters->getParams('category_id');

			$limit = $limit? $limit : '4';
			$style = $style ? $style : 'default';
			// call models
			$model = new Products_categories_slideshowBModelsProducts_categories_slideshow();
			$data = $model -> get_data($category_id,$limit);
			
			if(!count($data))
				return;
			include 'blocks/products_categories_slideshow/views/products_categories_slideshow/'.$style.'.php';
		}
	}
	
?>