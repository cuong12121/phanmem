<?php

/*
 * Huy write
 */
	// models 
	
	
	class SearchBControllersSearch
	{
		function __construct()
		{
		}
		function display($parameters = array(),$title = '')
		{
			$style = $parameters->getParams('style');
			$style = $style ? $style : 'default';
			if($style == 'filter'){
				include 'blocks/search/models/search.php';
				$model = new SearchBModelsSearch();
				$manufactories = $model->get_manufactories();
				
				$module = FSInput::get('module');
				$view = FSInput::get('view');
				if($module == 'filter'){
					$link_rewrite = 'index.php?module=sims&view=home';
					$array_paras_need_get = array('filter','Itemid','year','length','excludes','summers');
					$url = 'index.php?module='.$module.'&view='.$view;
					foreach($array_paras_need_get as $item){
						$value_of_param = FSInput::get($item);
						if($value_of_param){
							$url .= "&".$item."=".$value_of_param;
						}
					}
					$manu = FSInput::get('manu');
					if($manu){
						$url .= "&manu=".$manu;
					}else{
						$url .= "&manu=all";
					}
					$keyword = FSInput::get('keyword');
					if($keyword){
						$url .= "&keyword=".$keyword;
					}else{
						$url .= "&keyword=search";
					}
					$link_rewrite =  FSRoute :: _($url);
				}else{
					$link_rewrite = FSRoute::_('index.php?module=sims&view=home&keyword=search');	
				}
			
			}
			// call views
			include 'blocks/search/views/search/'.$style.'.php';
		}
		 function get_ajax_search(){
	        $result =  array();
	        $list = $this->model->get_ajax_search();
	        if($list){
	            foreach($list as $item){
	                $result[] = array(
	                    'id' => $item->id,
	                    'label' => $item->name,
	                    'value' => $item->name
	                );
	            }
	        }
	        echo json_encode($result); exit();
    	}
	}
	
?>