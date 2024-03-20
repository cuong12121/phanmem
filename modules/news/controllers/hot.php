<?php
/*
 * Huy write
 */
	// controller
	
	class NewsControllersHot
	{
		var $module;
		var $view;
		function __construct()
		{
			$this->module  = 'news';
			$this->view  = 'hot';
			include 'modules/'.$this->module.'/models/'.$this->view.'.php';
		}
		function display()
		{
			// call models
			$model = new NewsModelsHot();
			
			$news_list = $model->getNewsList();
			$pagination = $model->getPagination();
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
	}
	
?>