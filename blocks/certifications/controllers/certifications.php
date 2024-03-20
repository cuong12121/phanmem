<?php
 
	include 'blocks/certifications/models/certifications.php';
	class CertificationsBControllersCertifications
	{
		function __construct()
		{
		}
		function display($parameters,$title)
		{
			$limit = $parameters->getParams('limit');
			$style = $parameters->getParams('style');

			$cat_id = $parameters->getParams('catid');

			$model = new CertificationsBModelsCertifications();

			$cat = $model -> get_cat($cat_id);

			$limit = $limit? $limit : '4';
			$style = $style ? $style : 'default';
			$ordering = $parameters->getParams('ordering'); 
			
			
			$list = $model -> get_list($cat_id,$limit);		

			//$list = $model -> get_data($limit);
			if(empty($list))
				return;
			
			include 'blocks/certifications/views/certifications/'.$style.'.php';
		}
	}
	
?>