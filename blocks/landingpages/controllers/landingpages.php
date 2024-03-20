<?php

include 'blocks/landingpages/models/landingpages.php';
	
class LandingpagesBControllersLandingpages {
		function display($parameters)
		{
		$style = $parameters->getParams('style'); 
		$model = new LandingpagesBModelsLandingpages();
		$cat_id = $parameters->getParams('category_id');
		$limit = $parameters->getParams('limit');
			$limit = $limit ? $limit:2;  
		$list = $model -> get_list($limit);
	

	
		//print_r($images);
		include 'blocks/landingpages/views/landingpages/'.$style.'.php';
	}
}

	
?>