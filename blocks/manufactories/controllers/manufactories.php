<?php
	class ManufactoriesBControllersManufactories
	{
		function __construct()
		{
		}
		function display($parameters,$title,$block_id = 0,$link_title = '',$show_title = '',$image_block)
		{
			$limit = $parameters->getParams('limit');
			$style = $parameters->getParams('style');

			$limit = $limit? $limit : '8';
			$style = $style ? $style : 'default';
			$ordering = $parameters->getParams('ordering'); 

			// call models
			// die;
			include 'blocks/manufactories/models/manufactories.php';
			$model = new ManufactoriesBModelsManufactories();
			$list = $model -> get_data($limit);
		
			include 'blocks/manufactories/views/manufactories/'.$style.'.php';

		}
	}
	
?>