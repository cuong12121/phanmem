<?php
/*
 * Huy write
 */
	// models 
	include 'blocks/strengths/models/strengths.php';
	class StrengthsBControllersStrengths extends FSControllers
	{
		function __construct()
		{
		}
		function display($parameters,$title){

			$limit = $parameters->getParams('limit');
			$limit = $limit ? $limit:6; 
//			$show_readmore = $parameters->getParams('show_readmore');
//			// call models
			$model = new StrengthsBModelsStrengths();
			$cat_id = $parameters->getParams('catid');
			$summary = $parameters->getParams('summary'); 
			$link = $parameters->getParams('link');
			$link_name = $parameters->getParams('link_name');
			$link2 = $parameters->getParams('link2');
			$link_name2 = $parameters->getParams('link_name2');
			$cat = $model -> get_cat($cat_id);
			
			if($cat_id == "55"){

				$manuid = $parameters->getParams('manuid');
				$catproid = $parameters->getParams('catproid');

				$list = $model -> get_list2($cat_id,$limit,$manuid,$catproid);
				if(empty($list)){
					$list = $model -> get_list($cat_id,$limit);
				}
			}else{
				$list = $model -> get_list($cat_id,$limit);
			}
			
			if(!$list)
				return;

			$style = $parameters->getParams('style');

			$style = $style ? $style : 'default';
			// call views
			include 'blocks/strengths/views/strengths/'.$style.'.php';
		}
	}
	
?>