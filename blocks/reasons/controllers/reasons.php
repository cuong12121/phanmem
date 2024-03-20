<?php
/*
 * Huy write
 */
	// models 
	include 'blocks/reasons/models/reasons.php';
	class ReasonsBControllersReasons extends FSControllers
	{
		function __construct()
		{
		}
		function display($parameters,$title){

			$limit = $parameters->getParams('limit');
			$limit = $limit ? $limit:6; 
//			$show_readmore = $parameters->getParams('show_readmore');
//			// call models
			$model = new ReasonsBModelsReasons();
			$cat_id = $parameters->getParams('catid');
			//$summary = $parameters->getParams('summary'); 
			//$link = $parameters->getParams('link');
			$cat = $model -> get_cat($cat_id);
			$style = $parameters->getParams('style');
			
			$list = $model -> get_list($cat_id,$limit);

			$arr_list = array(); 

			if($style == 'full_cat'){
				$list_cat = $model -> get_list_cat($limit);
				foreach ($list_cat as $cat_i) {
					$list = $model -> get_list($cat_i->id,'3');
					$arr_list[$cat_i->id] = $list;				
				}
				if(!$arr_list)
					return;

			}else{
				if(!$list)
					return;
			}

			// echo '<pre>';
			// print_r($arr_list);
			// die;

			$style = $style ? $style : 'default';
			// call views
			include 'blocks/reasons/views/reasons/'.$style.'.php';
		}
	}
	
?>