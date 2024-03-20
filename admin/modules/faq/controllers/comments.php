<?php
	class RecommendationsControllersComments extends Controllers{
	
		function __construct()
		{
			$this->view = 'comments' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $model->get_data();
			$pagination = $model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
			function add()
		{
			die;
		}
		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;

			$data = $model->get_record_by_id($id);
			$recommendation =  $model -> get_record_by_id($data -> record_id,'fs_recommendations');
	// data from fs_news_categories
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
	}
	
?>