

<?php

	class OrderControllersExternal extends Controllers
	{
		function __construct()
		{
			$this->view = 'external'; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			global $config;
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			$model  = $this -> model;

			include 'modules/order/views/external/form.php';
			die;
			// $wrap_id_warehouses = $model->get_wrap_id_warehouses();
			// $warehouses = $model -> get_records('published = 1 AND id IN ('.$wrap_id_warehouses.')','fs_warehouses');

			// $platforms = $model -> get_records('published = 1','fs_platforms');
			// $houses = $model -> get_records('published = 1','fs_house');
			// $users = $model -> get_record('id = ' . $_SESSION['ad_userid'],'fs_users');
			// $list = $this -> model->get_data();

			// $iddd="";
			// foreach ($list as $key => $l) {
			// 	$iddd .= $l->id.',';
			// }
			// echo $iddd;


			// foreach ($list as $key => $l) {
			// 	$row = array();
			// 	$row['house_id'] = $l->house_id;
			// 	$row['warehouse_id'] = $l->warehouse_id;
			// 	$model->_update($row,'fs_order_uploads_detail','record_id = '.$l->id);
			// }
		


			// $pagination = $model->getPagination();
			// include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}

		function add()
		{
			global $config;
			$model = $this -> model;
			$wrap_id_warehouses = $model->get_wrap_id_warehouses();
			$warehouses = $model -> get_records('published = 1 AND id IN ('.$wrap_id_warehouses.')','fs_warehouses');
			$platforms = $model -> get_records('published = 1','fs_platforms');
			$houses = $model -> get_records('published = 1','fs_house');
			$users = $model -> get_record('id = ' . $_SESSION['ad_userid'],'fs_users');
			if($users->group_id == 1 && $users->shop_id){
				$users->shop_id = substr($users->shop_id, 1, -1);
				$shops = $model -> get_records('id IN ('.$users->shop_id.')','fs_shops');
			}else{
				$shops = $model -> get_records('','fs_shops');
			}
			include 'modules/order/views/external/form.php';
		}

		function edit()
		{
			global $config;
			$model = $this -> model;
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$data = $model->get_record_by_id($id);
			$wrap_id_warehouses = $model->get_wrap_id_warehouses();
			$warehouses = $model -> get_records('published = 1 AND id IN ('.$wrap_id_warehouses.')','fs_warehouses');
			$platforms = $model -> get_records('published = 1','fs_platforms');
			$houses = $model -> get_records('published = 1','fs_house');

			$users = $model -> get_record('id = ' . $_SESSION['ad_userid'],'fs_users');
			if($users->group_id == 1 && $users->shop_id){
				$users->shop_id = substr($users->shop_id, 1, -1);
				$shops = $model -> get_records('id IN ('.$users->shop_id.')','fs_shops');
			}else{
				$shops = $model -> get_records('','fs_shops');
			}
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}	

		function save()
		{
			$requester = FSInput::get('requester');
			$storeName = FSInput::get('storeName');
			$deliveryPerson = FSInput::get('deliveryPerson');
			$department = FSInput::get('department');
			$storeCode = FSInput::get('storeCode');
			$customerPhone = FSInput::get('customerPhone');
			$customerPhone = FSInput::get('customerPhone');

			$diachinhanhang = FSInput::get('diachinhanhang');

			$tennguoinhan = FSInput::get('tennguoinhan');

			$link = FSRoute::_('index.php?module=order&view=external&task=add');

			var_dump($requester);

			die;

			if($requester=='null'){
				$msg = 'Không được để trống họ tên người yêu cầu xuất';
				setRedirect($link,$msg,'error');
			}


			if($storeName=='null'){
				$msg = 'Không được để trống tên gian hàng';
				setRedirect($link,$msg,'error');
			}
			if($deliveryPerson==''){
				$msg = 'Không được để trống họ tên nvc giao';
				setRedirect($link,$msg,'error');
			}

			if($department==''){
				$msg = 'Không được để trống bộ phận';
				setRedirect($link,$msg,'error');
			}

			if($storeCode==''){
				$msg = 'Không được để trống mã gian hàng';
				setRedirect($link,$msg,'error');
			}

			if($customerPhone==''){
				$msg = 'Không được để trống số điện thoại khách hàng';
				setRedirect($link,$msg,'error');
			}

			if($diachinhanhang==''){
				$msg = 'Không được để trống địa chỉ nhận hàng';
				setRedirect($link,$msg,'error');
			}

			if($tennguoinhan==''){
				$msg = 'Không được để trống tên người nhận hàng';
				setRedirect($link,$msg,'error');
			}	

		}

		function apply()
		{
			$name = FSInput::get('requester');

			echo $name;

			die;
		}

	}	
	
?>