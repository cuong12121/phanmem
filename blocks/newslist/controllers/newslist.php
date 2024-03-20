<?php
/*
 * Huy write
 */
	// models 
	include 'blocks/newslist/models/newslist.php';
	class NewslistBControllersNewslist extends FSControllers
	{
		function __construct()
		{
		}
		function display($parameters,$title)
		{
			$cat_id = $parameters->getParams('catid'); 
			$ordering = $parameters->getParams('ordering'); 
		    $type  = $parameters->getParams('type'); 
			$limit = $parameters->getParams('limit');
			$limit = $limit ? $limit:3; 
			// call models
			$model = new NewslistBModelsNewslist();
			$list = $model -> get_list($cat_id,$ordering,$limit,$type);
			$style = $parameters->getParams('style');
			$link_more = FSRoute::_("index.php?module=news&view=home");
			if($cat_id) {
				$cat = $model -> get_Cat($cat_id);
				$link_more = FSRoute::_('index.php?module=news&view=cat&ccode='.$cat->alias.'&cid='.$cat_id);
			}
			$list_cats = $model -> get_cats();

			// print_r($list_cats);
			if($style == 'tabs'){
				$list_cats = $model -> get_cats();
				if(!$list_cats)
				return;
				$total_cat = count($list_cats);
				$array_cats = array();
				$array_news_by_cat = array();
				$children_cat_array = array();
				$i = 0;
				foreach (@$list_cats as $item)
				{
					$news_in_cat = $model -> get_list($item->id,$ordering,$limit,$type);
					if($item -> level){
						if(!isset($children_cat_array[$item -> parent_id]))
							$children_cat_array[$item -> parent_id] = array();
							$children_cat_array[$item -> parent_id][] = $item ;
					}else{
						if(count($news_in_cat)){
							$array_cats[] = $item;
							$array_news_by_cat[$item->id] = $news_in_cat;	
							$i ++;
						}
					}
						if($i >3)
						break;

				}
			}
			$style = $style?$style:'default';
			$authors = $model -> get_records('published = 1','fs_news_author','*','','','id');
			// call views
			include 'blocks/newslist/views/newslist/'.$style.'.php';
		}
	}
	
?>