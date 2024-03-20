<?php
	// models 
	class UsersControllersMoney  extends Controllers
	{
		function display(){
		
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $model->get_data();
			
			$pagination = $model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		/*
		 * Deposit money
		 */
		function deposit()
		{
			$model = $this -> model;
			$data = $model -> get_detail();
			include 'modules/'.$this->module.'/views/'.$this -> view.'/deposit.php';
		}
	}
?>