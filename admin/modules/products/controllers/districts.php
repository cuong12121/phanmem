<?php
	// models 

		  
	class ProductsControllersDistricts extends Controllers
	{
		function __construct()
		{
			$this->limit = 40;
			$this->view = 'districts' ; 
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
			$cities = $model -> get_records('published = 1','fs_cities');
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}	

		function add()
		{
			$model = $this -> model;
			$cities = $model -> get_records('published = 1','fs_cities');
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}

		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			$cities = $model -> get_records('published = 1','fs_cities');
			$data = $model->get_record_by_id ( $id );
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
	}
	
?>