<?php
/*
 * Tuan write
 */
	// controller
	
	class UsersControllersHistory extends Controllers
	{
	
	
		function display()
		{
			parent::display();
			if(	isset($_POST['service'])){
				$_SESSION[$this -> prefix.'service']  =  $_POST['service'] ;
			}
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			// call models
			$model = $this->model;
		
			$query_body = $model -> setQuery();
			$list = $model->get_list();			
			$pagination = $model->getPagination();
						
			$service = $model->get_service_name(FSInput::get('type'));	
			
			$type = FSInput::get('type');
//				
//			if($type == 'deposit'){
//				$title = 'Lịch sử nạp tiền';
//				$services = $model->get_service_name('deposit');
//				
//			}else if($type == 'buy'){
//				$title = 'Lịch sử tiêu tiền';
//				$services = $model->get_service_name('buy');
//			}
//			
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
	}
?>
