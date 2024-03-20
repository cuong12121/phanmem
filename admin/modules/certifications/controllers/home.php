<?php
	class CertificationsControllersHome extends Controllers
	{
		function __construct()
		{
			$this->view = 'home' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			//$list = $this -> model->get_data('');
			//$cat_pro = $model->get_sproduct_categories_tree();
			$data = $model->get_record_by_id('1');
			//$pagination = $model->getPagination('');
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
	}
	
?>