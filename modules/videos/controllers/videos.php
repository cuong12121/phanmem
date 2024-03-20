<?php
/*
 * Huy write
 */
	// controller
	
	class VideosControllersVideos extends FSControllers
	{
 
		var $module;
		var $view;
		function display()
		{
			// call models
			$model = $this -> model;
            $id = FSInput::get('id');
			$cat  = $model->getCategory();
			$query_body = $model->set_query_body($cat->id);
			$list = $model->getNewsList($query_body);
			$total = $model->getTotal($query_body);
			
			// call views			
			include 'modules/videos/views/videos/default.php';
		}
	}
?>