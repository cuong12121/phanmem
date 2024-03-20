<?php
/*
 * Huy write
 */
	// models 
	include 'blocks/videos/models/videos.php';
	
	class VideosBControllersVideos
	{
		function __construct()
		{
		}
		
		function display($parameters,$title,$block_id = 0, $link_title = '',$showTitlte = 0)
		{
	        $ordering = $parameters-> getParams('ordering'); 
			$limit = $parameters-> getParams('limit');
			$limit = $limit ? $limit:3;			
			
			// call models
			$model = new VideosBModelsVideos();
			$style = $parameters-> getParams('style');
			$style = $style?$style :'default';

			$list = $model -> get_list($ordering,$limit);

			if($style == 'video_home' || $style == 'default'){
				$list = $model -> get_list2($ordering,$limit);
			}
			if($style == 'video_product'){
				$link =  $parameters-> getParams('link');
				$img =  $parameters-> getParams('img');
				$title =  $parameters-> getParams('title');
				//$list = $model -> get_list2($ordering,$limit);
				include 'blocks/videos/views/videos/'.$style.'.php';
				return;
			}

			if(!$list)
				return;

			// call views
			include 'blocks/videos/views/videos/'.$style.'.php';
		}
	}
	
?>