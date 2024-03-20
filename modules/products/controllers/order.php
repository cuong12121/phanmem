<?php
/*
 * Huy write
 * History of order product
 */
	// controller
	
	class ProductsControllersOrder extends FSControllers
	{
		var $module;
		var $view;
		function __construct()
		{
			$this->module  = 'products';
			$this->view  = 'order';
			$array_status = array( 0 => 'Đang chờ',1 => 'Đã hoàn tất',
									2=> 'Đã hủy');
			$this -> arr_status = $array_status;
			parent::__construct();
		}
		function display()
		{
			$fssecurity  = FSFactory::getClass('fssecurity');
            $fssecurity -> checkLogin();
            
			$model = $this -> model;
			$title = 'Quản lý mua hàng';
			$data  = $model -> getOrder();
			$str_sims = "";
			$arr_sims = array();
			$count_status = $model->get_count_follow_status();
			$array_status = $this -> arr_status ;
			$pagination = $model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		function status()
		{
			include 'modules/'.$this->module.'/views/'.$this->view.'/status.php';
		}
		function detail_status()
		{
			$fssecurity  = FSFactory::getClass('fssecurity');
            $fssecurity -> checkLogin();
			$model = $this -> model;
			$order  = $model -> get_order();
				$link =FSRoute::_('index.php?module=products&view=order&task=status');
			if(!$order){
				$msg = 'Đơn hàng không tồn tại';
				setRedirect($link,$msg,'error');
			}
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail_status.php';
		}
		function showStatus($status){
			$arr_status = $this -> arr_status;
			echo @$arr_status[$status];
		}
		
		function detail(){
			$fssecurity  = FSFactory::getClass('fssecurity');
            $fssecurity -> checkLogin();
			$model = $this -> model;
			
			$order  = $model -> getOrderById();
			if(!$order)
				return;
			$data = $model -> get_order_items($order->id);
			$str_ids = '';
			if(count($data)){
				$i = 0;
				foreach( $data as $item){
					if($i)
						$str_ids .= ',';
					$str_ids .= $item -> product_id;
					$i ++;						
				}
			}
			$arr_products = $model -> get_products_from_ids($str_ids);
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
		function change_status(){
			$fssecurity  = FSFactory::getClass('fssecurity');
            $fssecurity -> checkLogin();
			$model = $this -> model;
			
			$rs  = $model -> change_status();
			
			$id = FSInput::get('id');
			$Itemid = FSInput::get('Itemid');
			$link =FSRoute::_('index.php?module=products&view=order&id='.$id.'&task=detail&Itemid='.$Itemid);
			if(!$rs){
				$msg = 'Kh&#244;ng th&#7875; thay &#273;&#7893;i &#273;&#432;&#7907;c tr&#7841;ng th&#225;i &#273;&#417;n h&#224;ng';
				setRedirect($link,$msg,'error');
			}
			else {
				setRedirect($link);
			}
		}
		
		function payment_for_order(){
			$fssecurity  = FSFactory::getClass('fssecurity');
            $fssecurity -> checkLogin();
			$model = $this -> model;
			
			$rs  = $model -> payment_for_order();
			
			$id = FSInput::get('id');
//			$Itemid = FSInput::get('Itemid');
			$Itemid = 45;
			$link =FSRoute::_('index.php?module=products&view=order&id='.$id.'&task=detail&Itemid='.$Itemid);
			if(!$rs){
				$msg = 'Không thay đổi được trạng thái đơn hàng';
				setRedirect($link,$msg,'error');
			}
			else {
				setRedirect($link);
			}
		}
		
		function recieved_order(){
			$fssecurity  = FSFactory::getClass('fssecurity');
            $fssecurity -> checkLogin();
			$model = $this -> model;
			
			$rs  = $model -> recieved_order();
			
			$id = FSInput::get('id');
//			$Itemid = FSInput::get('Itemid');
			$Itemid = 45;
			$link =FSRoute::_('index.php?module=products&view=order&id='.$id.'&task=detail&Itemid='.$Itemid);
			if(!$rs){
				$msg = 'Không thay đổi được trạng thái đơn hàng';
				setRedirect($link,$msg,'error');
			}
			else {
				setRedirect($link);
			}
		}
		
		function cancel_order(){
			$fssecurity  = FSFactory::getClass('fssecurity');
            $fssecurity -> checkLogin();
			$model = $this -> model;
			
			$rs  = $model -> cancel_order();
			
			$id = FSInput::get('id');
//			$Itemid = FSInput::get('Itemid');
			$Itemid = 45;
			$link =FSRoute::_('index.php?module=products&view=order&id='.$id.'&task=detail&Itemid='.$Itemid);
			if(!$rs){
				$msg = 'Không hủy được đơn hàng';
				setRedirect($link,$msg,'error');
			}
			else {
				$msg = 'Đã hủy được đơn hàng';
				setRedirect($link);
			}
		}
	}
	
?>