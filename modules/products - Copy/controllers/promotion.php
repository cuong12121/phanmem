<?php
/*
 * Huy write
 */
	// controller
	
	class ProductsControllersPromotion  extends FSControllers
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
			

			$types = $model->get_types ();

			$sort = FSInput::get ( 'sort', 'moi-nhat' );			


			$page = FSInput::get('page');
			

			$array_menu = array (array ('gia-thap-nhat', 'Giá từ thấp tới cao' ),array ('gia-cao-nhat', 'Giá từ cao tới thấp' ),array ('moi-nhat', 'Mới nhất' ));
			$title = 'Sản phẩm khuyến mại';
			
			// breadcrumbs
			$breadcrumbs = array();
			$breadcrumbs [] = array (0 => $title, 1 => FSRoute::_('index.php?module=products&view=promotion' ) );
			
			global $tmpl,$module_config;
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			// seo
			$tmpl -> set_seo_special();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
			
		}
		
	}
	
?>