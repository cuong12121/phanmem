<?php
	class MaterialControllersCategories extends Controllers
	{
		function __construct()
		{
			$this->view = 'categories' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $this -> model->get_data('');
			$pagination = $model->getPagination('');
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
	}
	
?>