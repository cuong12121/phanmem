<?php
	class ProfitsControllersProfist_shop extends Controllers
	{
		function __construct()
		{
			$this->view = 'profist_shop'; 
			parent::__construct();
			$model = $this -> model;
		}

		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			$model  = $this -> model;
			$users = $model -> get_record('id = ' . $_SESSION['ad_userid'],'fs_users');
			$list = $model->get_data();
			$pagination = $model->getPagination();

			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}

		function add()
		{
			$model = $this -> model;
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}

		function edit()
		{
			$model = $this -> model;
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$data = $model->get_record_by_id($id);
			$days = $model -> get_days($data -> id);
			if($data->user_id == $_SESSION['ad_userid']){
				include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
			}
			
		}
	}
	
?>