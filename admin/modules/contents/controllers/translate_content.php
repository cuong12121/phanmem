<?php
	class ContentsControllersTranslate_content  extends Controllers
	{
		function __construct()
		{
			$this->view = 'booth' ; 
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
			$tid = FSInput::get('etemplate_id');
			if($tid)
			{
				$template = $model->get_all_template();
				include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
			}
			else{
				$template = $model->get_all_template();
				
				include 'modules/'.$this->module.'/views/'.$this -> view.'/select_template.php';
			}
		}
		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			$data = $model->get_record_by_id($id);
			
			// extend template
			$template = $model->get_all_template();
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
	}
	
?>