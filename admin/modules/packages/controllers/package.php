<?php
	class PackagesControllersPackage extends Controllers
	{
		function __construct()
		{
			$this->view = 'package';
			$this->not_ss_keysearch = 1; // không set sesstion của ô tìm kiếm
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
			$list = $model->get_data();
			// die;s
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



		function packages(){
			$model = $this -> model;
			$rows = $model->packages(1);
			$link = FSRoute::_('index.php?module='.$this -> module.'&view='.$this -> view);
			$page = FSInput::get('page',0);
			if($page > 1){
				$link .= '&page='.$page;
			}
			$link = FSRoute::_($link);
			if($rows)
			{
				if(isset($_SESSION[$this -> prefix.'keysearch'])){
					unset($_SESSION[$this -> prefix.'keysearch']);
				}

				if(isset($_SESSION[$this -> prefix.'text0'])){
					unset($_SESSION[$this -> prefix.'text0']);
				}
				setRedirect($link,$rows.' '.FSText :: _('đã đóng hàng'));	
			}
			else
			{
				setRedirect($link,FSText :: _('Có lỗi xảy ra'),'error');	
			}
		}


		function ajax_package(){
			$id = FSInput::get('id');
			$respon = array();
			$respon ['error'] = true;
			$model = $this -> model;
			$data = $model->get_record('id = '.$id,'fs_order_uploads_detail','*');

			if(!empty($data) && $data-> is_package != 1){
				$user = $model->get_record('id = '.$data-> user_id_manage_shop,'fs_users');
				// if(empty($user) || @$user-> money < $data-> total_price){
				// 	$respon ['message'] = 'Số tiền của tài khoản này không đủ để đóng đơn hàng này !';
				// 	echo json_encode ( $respon );
				// 	return;
				// }
				$row = array();
				$row['is_package'] = 1;
				$row['date_package'] = date('Y-m-d H:i:s');
				$row['user_package_id'] = $_SESSION ['ad_userid'];
				$product = $model->get_record('code = "'.$data-> product_code.'"','fs_products','id,price_pack');
				if(!empty($product)){
					$row['price_package'] = $product-> price_pack ? $product-> price_pack : 0;
				}
				$update_id = $model-> _update($row,'fs_order_uploads_detail','id ='.$id);
				if($update_id){
					$respon ['error'] = false;
					$respon ['message'] = 'Đóng hàng thành công.';
				}else{
					$respon ['message'] = 'Có lỗi xảy ra!';
				}
				$model->minus_money($data); //trừ tiền của tài khoản
				echo json_encode ( $respon );
				
			}else{
				$respon ['message'] = 'Có lỗi xảy ra, không tìm được, vui lòng f5 lại.';
				echo json_encode ( $respon );
			}
			return;
		}


		function ajax_back_package(){
			$id = FSInput::get('id');
			$respon = array();
			$respon ['error'] = true;
			$model = $this -> model;
			$data = $model->get_record('id = '.$id,'fs_order_uploads_detail','*');
			// printr($data);
			if(!empty($data) && $data-> is_package == 1 && $data-> user_package_id == $_SESSION ['ad_userid'] ){
				$row = array();
				$row['is_package'] = 0;
				$row['date_package'] = date('Y-m-d H:i:s');
				$row['user_package_id'] = 0;
				$row['price_package'] = 0;
				$update_id = $model-> _update($row,'fs_order_uploads_detail','id ='.$id);
				if($update_id){
					$respon ['error'] = false;
					$respon ['message'] = 'Chuyển trạng thái chưa đóng thành công';
					$this->plus_money($data);
				}else{
					$respon ['message'] = 'Có lỗi xảy ra!';
				}
				echo json_encode ( $respon );
			}else{
				$respon ['message'] = 'Có lỗi xảy ra, có thể đơn này không phải do bạn đóng.';
				echo json_encode ( $respon );
			}
			return;
		}

		//cộng tiền của tài khoản
		function plus_money($data){
			$model = $this -> model;
			$user = $model->get_record('id = '.$data-> user_id_manage_shop,'fs_users');
			$row = array();
			$row['money'] = (float)$user-> money + (float)$data-> total_price;
			$id_update = $model->_update($row,'fs_users','id = '.$data-> user_id_manage_shop);
			if($id_update){
				$row2 = array();
				$row2['money'] = $data-> total_price;
				$row2['user_id_manage_shop'] = $data-> user_id_manage_shop;
				$row2['list_user_id_manage_shop'] = $data-> list_user_id_manage_shop;
				$row2['order_detail_id'] = $data-> id;
				$row2['type'] = 'plus';
				$row2['summary'] = 'Cộng tiền hoàn hàng trên đơn hàng có ID: ' . $data-> id ;
				$row2['tracking_code'] = $data-> tracking_code;
				$row2['created_time'] = date('Y-m-d H:i:s');
				$row2['action_userid'] = $_SESSION['ad_userid'];
				$row2['action_username'] = $_SESSION['ad_username'];
				$model->_add($row2,'fs_shops_money_order_history');
			}
		}

		function show_packed()
		{
			$page = !empty($_GET['page'])?$_GET['page']:1;

			$user_id = $_SESSION['ad_userid'];

			$context = stream_context_create(array(
	            'http' => array(
	                
	                'method' => 'GET',

	                'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
	                            "token: 7ojTLYXnzV0EH1wRGxOmvLFga",
	                
	            )
	        ));

	        // Send the request
			$skip_user = [9,208,251,206];


	        if(in_array($user_id, $skip_user)){
	        	
	        	$link_api = 'https://api.'.DOMAIN.'/api/get-data-order-details?page='.$page;

	        	
	        }
	        else{
	        	$link_api ='https://api.'.DOMAIN.'/api/get-data-order-details?page='.$page.'&id_user='.$user_id;
	        }

	      
	        $response = file_get_contents($link_api, FALSE, $context);
	       
	        $info_data = json_decode($response);

	        dd($info_data)

	        // include 'modules/'.$this->module.'/views/'.$this->view.'/details.php';
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
		if($data-> is_package != 1){
			$permission_refund = FSSecurity::check_permission_groups('packages','package','ajax_package');
        	if($permission_refund){
				$txt .="<a class='btn-row btn-row-package-".$id."' onclick='is_package(".$id.")' href='javascript:void(0)'>Xác nhận đã đóng hàng</a>";
			}
			$txt .="<div class='hide content-package-".$id."'>Đã đóng hàng</div>";
		}else{
			$txt .="<div class='label label-primary content-package-".$id."'>Đã đóng hàng</div>";
		}
		return $txt;
	}
	
	
?>