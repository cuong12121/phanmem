<?php
/*
 * Huy write
 */
	// models 
	include 'blocks/partners/models/partners.php';
	class PartnersBControllersPartners
	{
		function __construct()
		{
		}
		function display($parameters,$title)
		{
			$limit = $parameters->getParams('limit');
			$style = $parameters->getParams('style');
			$limit = $limit? $limit : '16';
			$style = $style ? $style : 'default';
			$ordering = $parameters->getParams('ordering'); 
			
			// call models
			$model = new PartnersBModelsPartners();
			$list = $model -> get_data($limit);
			if(!count($list))
				return;
			include 'blocks/partners/views/partners/'.$style.'.php';
		}
	}
	
?>