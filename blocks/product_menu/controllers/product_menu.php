<?php
/*
 * Huy write
 */
	// models 
	include 'blocks/product_menu/models/product_menu.php';
	
	class Product_menuBControllersProduct_menu 
	{
		function __construct()
		{
		}
		function display($parameters,$title)
		{
			$style = $parameters->getParams('style');
			$style = $style ? $style : 'default';
	
			// call models
			$model = new Product_menuBModelsProduct_menu();
			$list = $model->getListCat();
			
			if(!$list)
				return;
			if($style == 'drop_down' || $style == 'drop_down_2' || $style == 'drop_down_3'|| $style =='drop_down_right' || $style =='drop_down_filter' || $style=='drop_down_mobile_transform' || $style=='drop_down_mobile' || $style == 'amp'){				
				$level_0 = array();
				$level_1 = array();
				foreach ($list as $item) {
					if($item-> level == 0){
						$level_0[] = $item;
					}
					// if($item-> level == 1){
					// 	$level_1[] = $item;
					// }
				}

				foreach ($level_0 as $lv0) {
					$manf_by_cat = $model -> get_filter_manufactory($lv0 -> tablename);
					$array_manf[$lv0->id] = $manf_by_cat;

					$level_1 = $model -> getListCatLv1($lv0 -> id);
					$array_lv1[$lv0->id] = $level_1;
				}
			}
			// call views
			// echo "<pre>";
			// print_r($array_lv1);
			// echo "+++++";
			
			include 'blocks/product_menu/views/product_menu/'.$style.'.php';
		}
		
		function get_filters_has_calculate($cat){
			$model = new Product_menuBModelsProduct_menu();
			return $list = $model->get_filters_has_calculate($cat);
		}
	}	
?>