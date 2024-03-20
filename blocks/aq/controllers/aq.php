<?php
/*
 * Huy write
 */
	// models 
	include 'blocks/aq/models/aq.php';
	class AqBControllersAq 
	{
		function __construct()
		{
		}
		function display($parameters,$title)
		{
		
			$ordering = $parameters->getParams('ordering'); 
		    $type  = $parameters->getParams('type'); 
			$limit = $parameters->getParams('limit');
			$limit = $limit ? $limit:5; 
			$str_pcat = $parameters->getParams('str_pcat');
			// call models

			$model = new AqBModelsAq();

			$list = $model -> get_list($ordering,$limit,$type,$str_pcat);
			// print_r($list);
			// die;
			$style = $parameters->getParams('style');
			$summary = $parameters->getParams('summary');
			$style = $style?$style:'default';
			$categories = $model -> categories();
		
			include 'blocks/aq/views/aq/'.$style.'.php';
		}
	}
	
?>