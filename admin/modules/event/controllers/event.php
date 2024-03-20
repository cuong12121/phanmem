<?php
	// models 
//	include 'modules/'.$module.'/models/'.$view.'.php';
		  
	class EventControllersEvent extends Controllers
	{
		function __construct()
		{
			$this->view = 'event' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			$model  = $this -> model;
			//$list = $this -> model->get_data();
			$data = $model->get_record_by_id('1');
			//$pagination = $this -> model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
        
       
	}
	
?>