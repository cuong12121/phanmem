<?php
	class BankingsControllersBankings extends Controllers
	{
		function __construct()
		{
			$array_type = array(1 => 'Image', 2=> 'Flash', 3 => 'HTML',4=>'TEXT');
			$this -> array_type = $array_type;
			$this->view = 'banking' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $model->get_data();
			
			
			$pagination = $model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		function add()
		{
			$model = $this -> model;
			$maxOrdering = $model->getMaxOrdering();
			$array_type = $this -> array_type;

			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
		
		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			$data = $model->get_record_by_id($id);
			$array_type = $this -> array_type;
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
	}
	
?>