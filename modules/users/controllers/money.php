<?php
/*
 * Tuan write
 */
	// controller
	
	class UsersControllersMoney
	{
		var $module;
		var $view;
		function __construct()
		{
			
			$this->module  = 'users';
			$this->view  = 'money';
			include 'modules/'.$this->module.'/models/'.$this->view.'.php';
		}
		function deposit()
		{
			$model = new UsersModelsMoney();
			$data  = $model -> getConfig("content_deposit_money");
			include 'modules/'.$this->module.'/views/'.$this->view.'/deposit.php';
		}

		function display()
		{
			// call models
			$model = new UsersModelsMoney();
			
		
				
			$date_from = FSInput::get('date_from');
			$date_to = FSInput::get('date_to');
			$service = FSInput::get('service');
			
			$query_body = $model -> setQuery();				
			$list = $model->getusersList($query_body);
			$pagination = $model->getPagination($query_body);	

			$type = FSInput::get('type');
				
			if($type == 'deposit_history'){
				$title = 'Lịch sử nạp tiền';
				$data = $model->get_service_name('deposit');
				
			}else if($type == 'buy_history'){
				$title = 'Lịch sử tiêu tiền';
				$data = $model->get_service_name('buy');
			}
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
	}
?>
