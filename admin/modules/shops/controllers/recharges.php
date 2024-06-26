<?php	  
	class ShopsControllersRecharges extends Controllers
	{
		function __construct()
		{
			$this->view = 'recharges' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $model->get_data();
			$shops = $model->get_records('published = 1','fs_shops');
			
			$pagination = $model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
        
        function add()
		{
			$model = $this -> model;
			$maxOrdering = $model->getMaxOrdering();
			$shops = $model->get_records('published = 1','fs_shops');
			$users_shop = $model->get_records('group_id = 1' ,'fs_users');
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
		
		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			$data = $model->get_record_by_id($id);
			$shops = $model->get_records('published = 1','fs_shops');
			$users_shop = $model->get_records('group_id = 1' ,'fs_users');
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
		

	}
	
?>