<?php
	// models 
//	include 'modules/'.$module.'/models/'.$view.'.php';
		  
	class SaleControllersSale_range_price extends Controllers
	{
		function __construct()
		{
			$this->view = 'sale_range_price' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$list = $this -> model->get_data();
			$pagination = $this -> model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
        
        function add()
		{
			$model = $this -> model;
			
			$maxOrdering = $model->getMaxOrdering();
			
			
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
		
		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			$data = $model->get_record_by_id($id);
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
	}
	
?>