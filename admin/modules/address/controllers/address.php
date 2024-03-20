<?php
	class AddressControllersAddress extends Controllers
	{
		function __construct()
		{
			$this->view = 'address' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $model->get_data();
			$regions = $model->get_all_record('fs_address_regions');
			$pagination = $model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		function add()
		{
			$model = $this -> model;
			$maxOrdering = $model->getMaxOrdering();
			
			$regions = $model->get_all_record('fs_address_regions');
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
		
		function edit(){
			$id = FSInput::get('id');
			$model  = $this -> model;
			$data = $model->get_record_by_id($id);
			
			$regions = $model->get_all_record('fs_address_regions');
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
	}
	
?>