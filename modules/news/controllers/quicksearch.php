<?php
/*
 * Huy write
 */
	// controller
	
	class NewsControllersQuicksearch
	{
		var $module;
		var $view;
		function __construct()
		{
			$this->module  = 'news';
			$this->view  = 'quicksearch';
			include 'modules/'.$this->module.'/models/'.$this->view.'.php';
		}
		function display()
		{
			// call models
			$model = new NewsModelsQuicksearch();
			
			$news_list = $model->getData();
			$total = $model -> getTotal();
			$pagination = $model->getPagination($total);
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
	}
	
?>