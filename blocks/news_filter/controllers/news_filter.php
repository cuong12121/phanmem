<?php
/*
 * Huy write
 */
	// models 
	include 'blocks/news_filter/models/news_filter.php';
	
	class News_filterBControllersNews_filter{
		function __construct()
		{
			global $module_name;
		}
		
		function display($parameters,$title){
			$style = $parameters->getParams('style');
			$style = $style ? $style : 'default';
			
			$model = new News_filterBModelsNews_filter();
			$product_category = $model -> get_product_category();
			$category_level1 = $model -> get_product_category_leve1();
			$category_level2 = $model -> get_product_category_leve2();
			
			if(!$product_category)
				return;
			// need_chek
			$module = FSInput::get('module');		
			$need_check = 0;
			if($module == 'products'){
				$ccode = FSInput::get('ccode');
				$need_check = 1;
			}

			include 'blocks/news_filter/views/'.$style.'.php';
		}
	}	
		
