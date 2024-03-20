<?php
	class UsersControllersFiles extends Controllers
	{
		function __construct()
		{
			$this->view = 'files' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $this -> model->get_data('');
			$categories = $model->get_records('','fs_groups_file');
			$pagination = $model->getPagination('');
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}


		function add()
		{
			$model = $this -> model;
			$categories = $model->get_records('','fs_groups_file');
			$maxOrdering = $model->getMaxOrdering();
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
		
		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			$categories = $model->get_records('','fs_groups_file');
			$data = $model->get_record_by_id($id);
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
	}
	
?>