<?php
	// models 
//	include 'modules/'.$module.'/models/'.$view.'.php';
		  
	class CertificationsControllersCertifications extends Controllers
	{
		function __construct()
		{
			$this->view = 'certifications' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$model = $this -> model;
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			//$categories = $model -> get_all_record('fs_manufactories');
			$list = $model->get_data();
			$categories = $model->get_categories_tree();
			$pagination = $model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
        
        function add()
		{
			$model = $this -> model;
			//$categories = $model -> get_all_record('fs_manufactories');
			$categories = $model->get_categories_tree();
			$maxOrdering = $model->getMaxOrdering();
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
		
		function edit()
		{
			$model = $this -> model;
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			//$categories = $model -> get_all_record('fs_manufactories');
			$categories = $model->get_categories_tree();
			$data = $model->get_record_by_id($id);
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}


	}
	
?>