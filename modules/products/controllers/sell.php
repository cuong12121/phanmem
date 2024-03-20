<?php
/*
 * Huy write
 */
	// controller
	
	class ProductsControllersSell  extends FSControllers
	{
		var $module;
		var $view;
		function __construct()
		{
			parent::__construct ();
		}
		function display()
		{
			// call models
			$model = $this -> model;
			
			$query_body = $model -> set_query_body();
			$list = $model -> get_list($query_body);
			$total = $model->getTotal ( $query_body );
			$pagination = $model->getPagination ( $total );
			// printr($list);
			// $list_cats = $model->get_categorys ();
			// $array_cats = array ();
			// $array_cats_child = array();
			// $array_products = array ();

			// $i = 0;
			// 	foreach ( @$list_cats as $cad ) 
			// 	{
					
			// 		$products_in_cat = $model->getProducts ( $cad->id );
			// 		if (count ( $products_in_cat )) {
			// 			$array_cats [] = $cad;
			// 			$array_products [$cad->id] = $products_in_cat;
			// 			$i ++;
			// 		}
					
				
			// 	}


			$types = $model->get_types ();

			$sort = FSInput::get ( 'sort', 'moi-nhat' );			


			$page = FSInput::get('page');
			

			$array_menu = array (array ('gia-thap-nhat', 'Giá từ thấp tới cao' ),array ('gia-cao-nhat', 'Giá từ cao tới thấp' ),array ('moi-nhat', 'Mới nhất' ));
			$title = 'Khuyến mại';
			
			// breadcrumbs
			$breadcrumbs = array();
			$breadcrumbs [] = array (0 => $title, 1 => FSRoute::_('index.php?module=products&view=hotdeal' ) );
			
			global $tmpl,$module_config;
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			// seo
			$tmpl -> set_seo_special();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
			
		}
		
	}
	
?>