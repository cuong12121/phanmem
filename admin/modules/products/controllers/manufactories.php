<?php
	// models 

		  
	class ProductsControllersManufactories extends Controllers
	{
		function __construct()
		{
			$this->view = 'manufactories' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			// $list = $this -> model->get_data();
			$list = $this -> model->get_manufactories_tree();
			$pagination = $model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		
		function add()
		{
			$model =  $this -> model;
			$manufactories = $model->get_categories_tree_all();
			
			$maxOrdering = $model->getMaxOrdering();
			$tables = $model->get_tablenames();
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
		function edit()
		{
			$model =  $this -> model;
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$data = $model->get_record_by_id($id);	
			$manufactories = $model->get_categories_tree_all();		
          
			$tables = $model->get_tablenames();
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
	
		
	}
	
?>