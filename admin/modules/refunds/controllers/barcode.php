<?php
	class RefundsControllersBarcode extends Controllers
	{
		function __construct()
		{
			$this->view = 'barcode';
			$this->not_ss_keysearch = 1; 
			parent::__construct();

			$model = $this -> model;
			$file_export_name = "";
			// printr($_SESSION);
			if(isset($_SESSION[$this -> prefix.'filter1'])){
				$warehouse_id = $_SESSION[$this -> prefix.'filter1'];
				if($warehouse_id){
					$warehouse = $model->get_record('id = '.$warehouse_id,'fs_warehouses','code');
					$file_export_name .= '_'.$warehouse->code;
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter2'])){
				$platform_id = $_SESSION[$this -> prefix.'filter2'];
				if($platform_id){
					$platform = $model->get_record('id = '.$platform_id,'fs_platforms','code');
					$file_export_name .= '_'.$platform->code;
				}
			}


			if(isset($_SESSION[$this -> prefix.'text0']))
			{
				$date_from = $_SESSION[$this -> prefix.'text0'];
				if($date_from){
					$date_from = strtotime($date_from);
					$date_new = date('Y-m-d',$date_from);
					$file_export_name .= '_'.$date_new;
				}
			}


			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$house_id = $_SESSION[$this -> prefix.'filter0'];
				if($house_id){
					$house = $model->get_record('id = '.$house_id,'fs_house','name');
					$file_export_name .= '_'.$house->name;
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter3'])){
				$shipping_unit_id = $_SESSION[$this -> prefix.'filter3'];
				$fsstring = FSFactory::getClass('FSString','','../');
				if($shipping_unit_id){
					$shipping_unit = $model->get_record('id = '.$shipping_unit_id,'fs_shipping_unit','name');
					$file_export_name .= '_'.$fsstring -> stringStandart($shipping_unit->name);
				}
			}

			$this->file_export_name = $file_export_name;
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			$model  = $this -> model;
			$wrap_id_warehouses = $model->get_wrap_id_warehouses();
			$warehouses = $model -> get_records('published = 1 AND id IN ('.$wrap_id_warehouses.')','fs_warehouses');
			$platforms = $model -> get_records('published = 1','fs_platforms');
			$houses = $model -> get_records('published = 1','fs_house');
			$shipping_unit = $model -> get_records('published = 1','fs_shipping_unit');
			$list = $this -> model->get_data();
			$pagination = $model->getPagination();
			$users = $model -> get_record('id = ' . $_SESSION['ad_userid'],'fs_users');
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}

		function add()
		{
			$model = $this -> model;
			$warehouses = $model -> get_records('published = 1','fs_warehouses');
			$platforms = $model -> get_records('published = 1','fs_platforms');
			$houses = $model -> get_records('published = 1','fs_house');
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}

		function edit()
		{
			$model = $this -> model;
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$data = $model->get_record_by_id($id);
			$warehouses = $model -> get_records('published = 1','fs_warehouses');
			$platforms = $model -> get_records('published = 1','fs_platforms');
			$houses = $model -> get_records('published = 1','fs_house');

			$users = $model -> get_record('id = ' . $_SESSION['ad_userid'],'fs_users');
			if($users->shop_id){
				$shops = $model -> get_records('id IN ('.$users->shop_id.')','fs_shops');
			}
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}


		


		//cộng số lượng của sản phẩm khi hoàng hàng thành công
		// function plus_quantity_product($warehouse_id,$product_id,$count = 1){
		// 	$model = $this -> model;
		// 	$data = $model->get_record('warehouses_id = ' . $warehouse_id . ' AND product_id = '. $product_id,'fs_warehouses_products');
		// 	if(!empty($data)){
		// 		$row = array();
		// 		$row['amount'] = (int)$data->amount + (int)$count;
		// 		$update = $model->_update($row,'fs_warehouses_products','id = '.$data->id);
		// 		return $update;
		// 	}else{
		// 		return 0;
		// 	}
		// }

		function refunds_multiple(){
			$model = $this -> model;
			$rows = $model->refunds_multiple(1);
			$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
			$page = FSInput::get('page',0);
			if($page > 1){
				$link .= '&page='.$page;
			}
			$link = FSRoute::_($link);
			if($rows)
			{
				setRedirect($link,$rows.' '.FSText :: _('đơn được hoàn'));	
			}
			else
			{
				setRedirect($link,FSText :: _('Đơn này chưa xác nhận đã đóng hàng hoặc đã hoàn hàng'),'error');	
			}
		}



	}


	

	

	function view_excel($controle,$id){
		$model = $controle -> model;
		$data = $model->get_record('id = ' .$id,'fs_order_uploads','id,file_xlsx');
		$link = URL_ROOT.$data-> file_xlsx;
		return '<a target="_blink" href="' . $link . '">'.basename($data-> file_xlsx).'</a>';
	}

	function view_print($controle,$id){
		$model = $controle -> model;
		$data = $model->get_record('id = ' .$id,'fs_order_uploads','id,is_print');
		if($data-> is_print == 1){
			$txt = 'Đã In';
		}else{
			$txt = 'Chưa In';
		}
		return $txt;
	}

	function view_actions($controle,$id){
		$model = $controle -> model;
		$data = $model->get_record('id = ' .$id,'fs_order_uploads_detail','*');
		$txt ="";
		if($data-> is_shoot == 0 && $data-> is_refund == 0){
			$txt .="<a class='btn-row btn-row-refund-".$id."' onclick='is_refund(".$id.")' href='javascript:void(0)'>Hoàn hàng</a>";
			$txt .="<div class='label label-primary hide content-refund-".$id."'>Đã hoàn hàng</div>";
			if($data-> is_package == 1){
			
			$txt .="<div class='label label-success hide content-shoot-".$id."'>Đã bắn hàng ra kho 1</div>";
			}
			
		}elseif($data-> is_shoot == 1 && $data-> is_refund == 0){
			$txt .="<a class='btn-row btn-row-refund-".$id."' onclick='is_refund(".$id.")' href='javascript:void(0)'>Hoàn hàng</a>";
			$txt .="<div class='label label-primary hide content-refund-".$id."'>Đã hoàn hàng</div>";
			$txt .="<div class='label label-success'>Đã bắn hàng ra kho</div>";
		}elseif($data-> is_shoot == 0 && $data-> is_refund == 1){
			$txt .="<div class='label label-primary'>Đã hoàn hàng</div>";
		}else{
			$txt .="<div class='label label-primary'>Đã hoàn hàng</div>";
			$txt .="<div class='label label-success'>Đã bắn hàng ra kho</div>";
		}
		if($data-> is_package == 0){
			$txt .="<div class='label label-danger'>Chưa đóng hàng</div>";
		}
		return $txt;
	}
	
	
?>