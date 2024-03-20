<?php
/*
 * Huy write
 */
	// models 
	include 'blocks/warranty/models/warranty.php';
	
	class WarrantyBControllersWarranty
	{
		function __construct()
		{
		}
		function display($parameters,$title)
		{
			$code = FSInput::get('phone');
			
			// call models
			$model = new WarrantyBModelsWarranty();

			if($code){
				$list = $model->getList($code);
				if(!$list)
				return;
			}
			

			// call views
			include 'blocks/warranty/views/warranty/default.php';
		}
		
	}
	
?>