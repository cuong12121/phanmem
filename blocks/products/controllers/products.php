<?php
/*
 * Huy write
 */
	// models 
	include 'blocks/products/models/products.php';
	
	class ProductsBControllersProducts extends FSControllers
	{
		function __construct()
		{
		}
		function display($parameters,$title,$block_id = 0, $link_title = '',$showTitlte = 0){
			$ordering = $parameters->getParams('ordering'); 
		    $type  = $parameters->getParams('type'); 
			$limit = $parameters->getParams('limit');
			$link_more = $parameters->getParams('link');
			$cat_id = $parameters->getParams('catid');

			$module = FSInput::get('module');

			if($module == 'products' && $type == 'is_hotdeal') {
				$cat_id = FSInput::get('cid');
			}

			// $time_hotdeal = $parameters->getParams('time_hotdeal');

			$limit = $limit ? $limit:8; 
			$filter_category_auto = $parameters->getParams('filter_category_auto');
			// call models
			$model = new ProductsBModelsProducts();
			$list = $model -> get_list($cat_id,$ordering,$limit,$type,$filter_category_auto);
			//print_r($list);
			if($cat_id) {
				$cat = $model -> get_cat($cat_id);	
			}
			
			if(!$list)
				return;

			$types = $model -> get_types();

			$identity = $block_id;
			$style = $parameters->getParams('style');
			$style = $style ? $style : 'default';
			$types = $model->get_types ();
					//$types = $model -> get_types();
			// call views
			include 'blocks/products/views/products/'.$style.'.php';
	
		}
	}
	
?>