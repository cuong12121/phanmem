<?php
	// models 

		  
	class ProductsControllersWards extends Controllers
	{
		function __construct()
		{
			$this->limit = 40;
			$this->view = 'wards' ; 
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
			$cities = $model -> get_records('','fs_cities');
			$where_d = '';
			// if (isset ( $_SESSION [$this->prefix . 'filter1'] )) {
			// 	$filter = $_SESSION [$this->prefix . 'filter1'];
			// 	if ($filter) {
			// 		$where_d .= ' AND city_id  =' . $filter . '';
			// 	}
			// }
			$districts = $model -> get_records('1=1 '.$where_d,'fs_districts');
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}	

		function add()
		{
			$model = $this -> model;
			$cities = $model -> get_records('','fs_cities');
			$districts = $model -> get_records('','fs_districts');
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}

		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			$cities = $model -> get_records('','fs_cities');
			$districts = $model -> get_records('','fs_districts');
			$data = $model->get_record_by_id ( $id );
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
	}
	
?>