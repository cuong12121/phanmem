<?php
/*
 * Huy write
 */
	// models 
	include 'blocks/slideshow/models/slideshow.php';
	class SlideshowBControllersSlideshow
	{
		function __construct()
		{
		}
		function display($parameters,$title)
		{
			global $folder_admin,$check_edit;
			$link_admin_banner = $folder_admin.'module=slideshow&view=slideshow&task=edit&id=';
			$limit = $parameters->getParams('limit');
			$style = $parameters->getParams('style');
			$category_id = $parameters->getParams('category_id');
			$limit = $limit? $limit : '4';
			$style = $style ? $style : 'default';
			// call models
			$model = new SlideshowBModelsSlideshow();
			$data = $model -> get_data($category_id,$limit);
			
			if(empty($data))
				return;
			include 'blocks/slideshow/views/slideshow/'.$style.'.php';
		}
	}
	
?>