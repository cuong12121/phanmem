<?php
/*
 * Huy write
 */
	// controller
	
	class ProductsControllersFeed extends FSControllers {
	
		var $module;
		var $view;
		
		function display()
		{
			
			
			$model = new $this -> model;
			
			// cat list
			$list = $model -> get_list();
			
			
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/'.'default'.'.php';
		}
		
			
	}
	
?>