<?php
/*
 * Huy write
 */
	// controller
	
	class ProductsControllersCombo extends FSControllers{
		var $module;
		var $view;
		function __construct()
		{
			//parent::__construct ();
			$this->module  = 'products';
			$this->view  = 'combo';
			include 'modules/'.$this->module.'/models/'.$this->view.'.php';
		}
		function display()
		{
			// use cache
			global $page_cache;
			$page_cache   = 0;
			
			$model = new ProductsModelsCombo();
			
			// cat list
			$list_cats = $model -> getCats();

			$types = $model->get_types ();
			
			
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
				
			}
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>FSText::_('Combo'), 1 => '');
			
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			$tmpl -> set_seo_special();
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/'.'default'.'.php';
	}
	
	


}

?>