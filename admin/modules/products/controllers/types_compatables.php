<?php
	// models 

		  
	class ProductsControllersTypes_compatables extends Controllers
	{
		function __construct()
		{
			$this->view = 'types_compatables' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $this -> model->get_data();
			$pagination = $model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		
//		function add()
//		{
//			$model =  $this -> model;
//			
//			$maxOrdering = $model->getMaxOrdering();
//			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
//		}
//		function edit()
//		{
//			$model =  $this -> model;
//			$ids = FSInput::get('id',array(),'array');
//			$id = $ids[0];
//			$data = $model->get_record_by_id($id);			
//          
//			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
//		}
	
		
	}
	
?>