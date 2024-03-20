<?php
/*
 * Huy write
 */
	// controller
	
	class ProductsControllersHome
	{
		var $module;
		var $view;
		function __construct()
		{
			
			$this->module  = 'products';
			$this->view  = 'home';
			include 'modules/'.$this->module.'/models/'.$this->view.'.php';
		}
		function display()
		{
			// use cache
			global $page_cache;
			$page_cache   = 0;
			
			$model = new ProductsModelsHome();
			
			// cat list
			$list_cats = $model -> getCats();
			
			$array_cats = array();
			$array_products = array();
			$i = 0;
			foreach (@$list_cats as $item)
			{
				$products_in_cat = $model -> getProducts($item->id );
				if(count($products_in_cat)){
					$array_cats[] = $item;
					$array_products[$item->id] = $products_in_cat;	
					$i ++;
				}
				if($i >5)
					break;
			}
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>FSText::_('Product'), 1 => '');
			
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			$tmpl -> set_seo_special();
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/'.'default'.'.php';
		}
		
			
	}
	
?>