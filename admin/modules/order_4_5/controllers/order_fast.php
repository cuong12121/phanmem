<?php
	class OrderControllersOrder_fast  extends Controllers
	{
		function __construct()
		{
			$this->view = 'order' ; 
			parent::__construct(); 
			$array_status = array( 0 => 'Chưa hoàn tất',1 => 'Đã hoàn tất',2=>'Đã hủy');
			$this -> arr_status = $array_status;
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			$model  = $this -> model;
			
		
			$list = $this -> model->get_data();
			
			$array_status = $this -> arr_status;
			$array_obj_status = array();
			foreach($array_status as $key => $name){
				$array_obj_status[] = (object)array('id'=>($key+1),'name'=>$name);
			}
			
			$pagination = $this -> model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		function showStatus($status){
			$arr_status = $this -> arr_status;
			echo @$arr_status[$status];

		}
		function edit()
		{
			$model = $this -> model;
			$order  = $model -> getOrderById();
			$data = $model -> get_data_order();
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
		
		function cancel_order(){
			$model = $this -> model;
			
			$rs  = $model -> cancel_order();
			
			$Itemid = 61;	
			$id = FSInput::get('id');
			$link = FSRoute::_('index.php?module=order&view=order&task=edit&id='.$id);
			if(!$rs){
				$msg = 'Không hủy được đơn hàng';
				setRedirect($link,$msg,'error');
			}
			else {
				$msg = 'Đã hủy được đơn hàng';
				setRedirect($link);
			}
		}
		function finished_order(){
			$model = $this -> model;
			
			$rs  = $model -> finished_order();
			
			$Itemid = 61;	
			$id = FSInput::get('id');
			$link = 'index.php?module=order&view=order&task=edit&id='.$id;
			if(!$rs){
				$msg = 'Không hoàn tất được đơn hàng';
				setRedirect($link,$msg,'error');
			}
			else {
				$msg = 'Đã hoàn tất được đơn hàng thành công';
				setRedirect($link);
			}
		}
	}
	
?>