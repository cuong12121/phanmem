<?php
	class Service_centersControllersService_centers extends Controllers
	{
		function __construct()
		{
			$this->view = 'service_centers' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$model = $this -> model;
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			$manufactories = $model->get_records('','fs_manufactories');
			$provinces = $model->get_records('','province');
			$list = $this -> model->get_data();
			$pagination = $this -> model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
        
       	function add()
		{
			$model = $this -> model;
			$manufactories = $model->get_records('','fs_manufactories');
			$provinces = $model->get_records('','province');
			$maxOrdering = $model->getMaxOrdering();
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
		
		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			$manufactories = $model->get_records('','fs_manufactories');
			$provinces = $model->get_records('','province');
			$data = $model->get_record_by_id($id);
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
	}
	
?>