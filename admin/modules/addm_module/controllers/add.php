<?php
	class Addm_moduleControllersAdd extends Controllers
	{
		function __construct()
		{
			$this->view = 'add' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$model  = $this -> model;
			$list = $this -> model->get_data();
			$pagination = $model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';			
		}
		function add()
		{
			$model =  $this -> model;
			$categories = $model->get_menu_parent();
			$maxOrdering = $model->getMaxOrdering();
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
		function edit()
		{
			$model =  $this -> model;
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
//			$data = $model->get_record_by_id($id);
			$data = $model->getMemberById();
			$categories = $model->get_categories_tree();
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
		function changepass()
		{
			$model  = $this -> model;
			$data = $model->getMemberById();
			if(!$data)
				die('Not found url');
			$groups = $this -> arr_group;
			$categories  = $model -> get_categories_tree();
			include 'modules/'.$this->module.'/views/'.$this -> view.'/changepass.php';
		}
	}
	
?>