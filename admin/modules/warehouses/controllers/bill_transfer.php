<?php
	// models 
//	include 'modules/'.$module.'/models/'.$view.'.php';

class WarehousesControllersBill_transfer extends Controllers
{
	function __construct()
	{
			// parent::display();
			// $sort_field = $this -> sort_field;
			// $sort_direct = $this -> sort_direct;
		$this->view = 'bill' ; 
		global  $check_permission_status_warehouses;
		// $this-> arr_type = array('1'=>'Phiếu nhập','2'=>'Phiếu xuất');

		// $this-> arr_type_import = array('1'=>'Nhà cung cấp','2'=>'Bán lẻ', '3' => 'Bán sỉ','4' => 'Khác');

		// $this-> arr_type_discount = array('1'=>'Tiền mặt','2'=>'%');

		$this-> arr_status1 = array('1' => 'Phiếu tạm','2'=>'Chờ duyệt');

		$this-> arr_status = array('1' => 'Phiếu tạm','2'=>'Chờ duyệt','3' => 'Đang chuyển đi', '4' => 'Hoàn thành' ,'5' => 'Hủy');

		$this-> arr_status_action = array('2'=> array('value' => '3', 'text' => 'Duyệt'));
		
		$this-> arr_status2 = array('3' => 'Chờ chuyển tới' ,'4' => 'Hoàn thành', '5' => 'Hủy');

		$this-> arr_status2_action = array('3'=> array('value' => '4', 'text' => 'Xác nhận'));

		// $this-> arr_status2 = array('1' => 'Đang chuyển','2'=>'Đã nhận');
		$this-> arr_style_import = array('1'=>'Nhập tay','2'=>'Nhập file Excel');
		parent::__construct(); 
	}

	function display()
	{
		parent::display();
		$sort_field = $this -> sort_field;
		$sort_direct = $this -> sort_direct;

		$model  = $this -> model;
		$list = $model->get_data();

		// $categories = $model->get_categories_tree();

		$warehouses = $model->get_records('1=1','fs_warehouses','*');
		$supplier = $model->get_records('1=1','fs_supplier','*');


		$pagination = $model->getPagination();

		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Chuyển kho', 1 => '');	
		global $tmpl;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );

		include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
	}

	function add()
	{
		$model = $this -> model;
		$warehouses = $model->get_records('1=1','fs_warehouses','*');
		$supplier = $model->get_records('1=1','fs_supplier','*');
		$maxOrdering = $model->getMaxOrdering();

		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Danh sách chuyển kho', 1 => 
			FSRoute::_("index.php?module=".$this-> module."&view=".$this-> view));	
		global $tmpl;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );

		include 'modules/'.$this->module.'/views/'.$this -> view.'/add.php';
	}

	function edit(){

		$ids = FSInput::get('id',array(),'array');
		$id = $ids[0];
		$model = $this -> model;
		$data = $model->get_record_by_id($id);

		$list_products = $model-> get_records('bill_id = '.$id,$model-> table_name_detail,'*');

		$warehouses = $model->get_records('1=1','fs_warehouses','*');
		$supplier = $model->get_records('1=1','fs_supplier','*');

		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Danh sách chuyển kho', 1 => 
			FSRoute::_("index.php?module=".$this-> module."&view=".$this-> view));	
		global $tmpl;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );


		include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
	}

	function change_status_ajax(){
		$model = $this -> model;
		$id = FSInput::get('id');
		$data = $model-> get_record('id = '.$id,$model-> table_name);
		$status = FSInput::get('status');

		$row['status'] = $status;

		if($status == 3) {
			$row['create_username1'] = $_SESSION ['ad_username'];
			$row['create_userid1'] = $_SESSION ['ad_userid'];
			$row['updated_time1'] = date('Y-m-d H:i:s');
		}

		if($status == 4) {
			$row['create_username2'] = $_SESSION ['ad_username'];
			$row['create_userid2'] = $_SESSION ['ad_userid'];
			$row['updated_time2'] = date('Y-m-d H:i:s');
			
		}
		
		$model -> _update($row,$model-> table_name,'id = '.$id);

		$model-> add_products_warehouses($id);
	}

	function revoke(){
		global  $check_permission_status_warehouses;
		$model = $this -> model;
		$id = FSInput::get('id');
		$link = FSRoute::_('index.php?module='.$this -> module.'&view='.$this -> view);
		$data = $model-> get_record('id = '.$id,$model-> table_name);
		if(!$check_permission_status_warehouses) {
			setRedirect($link,FSText :: _('Bạn không có quyền thực hiện chức năng này!'),'error');
			return false;
		}
		if($data-> status == 4) {
			setRedirect($link,FSText :: _('Không thể hủy phiếu đã hoàn thành!'),'error');
			return false;
		}
		if($data-> status == 5) {
			setRedirect($link,FSText :: _('Phiếu đã được hủy!'),'error');
			return false;
		}
		$row['status'] = 5;
		
		$row['create_username2'] = $_SESSION ['ad_username'];
		$row['create_userid2'] = $_SESSION ['ad_userid'];
		$row['updated_time2'] = date('Y-m-d H:i:s');

		$row['create_username1'] = $_SESSION ['ad_username'];
		$row['create_userid1'] = $_SESSION ['ad_userid'];
		$row['updated_time1'] = date('Y-m-d H:i:s');


		$model -> _update($row,$model-> table_name,'id = '.$id);

		if($data -> status == 3) {
			$model-> return_products_warehouses($id);
		}
		setRedirect($link,FSText :: _('Đã hủy thành công!'));
		
	}

	function print(){
		$ids = FSInput::get('id',array(),'array');
		$id = $ids[0];
		$model = $this -> model;
		$data = $model->get_record_by_id($id);

		$list_products = $model-> get_records('bill_id = '.$id,$model-> table_name_detail,'*');

		include 'modules/'.$this->module.'/views/'.$this->view.'/print.php';
	}

	function ajax_products_search_keyword(){
		$model = $this -> model;
		$type_products_search = FSInput::get('type_products_search');
		$products_search_keyword = FSInput::get('products_search_keyword');
		$warehouses_id = FSInput::get('warehouses_id');

		$list_products = $model-> get_records('name LIKE "%'.$products_search_keyword.'%" OR code LIKE "%'.$products_search_keyword.'%"','fs_products','name,code,id,price,image,weight');

		// print_r($list_products);

		if(!empty($list_products)) {
			foreach ($list_products as &$product) {
				$record_amount = $model-> get_record('product_id = '.$product-> id.' AND warehouses_id = '.$warehouses_id,'fs_warehouses_products','amount');
				if(!empty($record_amount)) {
					$product-> amount = $record_amount-> amount;
				} else {
					$product-> amount = 0;
				}
			}
		}

		$html = $this -> ajax_products_search_keyword_genarate($list_products);
		echo $html;
		return;

		// echo $products_search_keyword;
	}

	function ajax_products_search_keyword_genarate($data){
		if(empty($data)) return;
		$html = '';
		foreach ($data as $item) {
			$html .= '<div class="item"><a class="cls" href="javascript:void(0)" onclick="set_products('.$item-> id.')"><div class="image"><img src="'.URL_ROOT.str_replace('/original','/resized/',$item-> image).'"></div><div class="item_inner"><div class="name">'.$item-> code.' - '.$item->name.'</div><div class="info">('.format_money($item-> price,'đ','0đ').') (Tồn: '.$item-> amount.')</div></div></a><input type="hidden" id="data_product_name_'.$item->id.'" value="'.$item-> name.'"><input type="hidden" id="data_product_weight_'.$item->id.'" value="'.$item-> weight.'"><input type="hidden" id="data_product_price_'.$item->id.'" value="'.format_money($item-> price,'','0').'"><input type="hidden" id="data_product_price_name_'.$item->id.'" value="'.format_money($item-> price,'đ','0đ').'"><input type="hidden" id="data_product_amount_'.$item->id.'" value="'.$item-> amount.'"></div>';
		}
		return $html;

	}

	function ajax_get_manufactory_related(){
		$model = $this -> model;
		$data = $model->ajax_get_manufactory_related();
		$html = $this -> manufactory_genarate_related($data);
		echo $html;
		return;
	}


	function manufactory_genarate_related($data){
		$str_exist = FSInput::get('str_exist');
		$html = '';
		$html .= '<div class="manufactory_related">';
		foreach ($data as $item){
			if($str_exist && strpos(','.$str_exist.',', ','.$item->id.',') !== false ){
				$html .= '<div class="red manufactory_related_item  manufactory_related_item_'.$item -> id.'" onclick="javascript: set_manufactory_related('.$item->id.')" style="display:none" >';	
				$html .= $item -> name;				
				$html .= '</div>';					
			}else{
				$html .= '<div class="manufactory_related_item  manufactory_related_item_'.$item -> id.'" onclick="javascript: set_manufactory_related('.$item->id.')">';	
				$html .= $item -> name;				
				$html .= '</div>';	
			}
		}
		$html .= '</div>';
		return $html;
	}

	function ajax_change_amount_item_bill(){
		$model = $this -> model;
		$id = FSInput::get('id');
		$amount_old = FSInput::get('amount_old',0,'int');
		$amount_new = FSInput::get('amount_new',0,'int');
		$bill_id = FSInput::get('bill');
		$data_bill = $model->get_record('id = '.$bill_id,'fs_warehouses_bill_transfer');
		$data_id = $model->get_record('id = '.$id,'fs_warehouses_bill_transfer_detail');
		if($amount_old == $amount_new){
			return false;
		}

		if($data_bill ->status >= 3){
			$warehouses_product = $model->get_record('product_id = '.$data_id->product_id . ' AND warehouses_id = '.$data_bill->warehouses_id,'fs_warehouses_products');

			$product = $model->get_record('id = '.$data_id->product_id,'fs_products','code,name,id');
		
			if($amount_new > $amount_old){
				$amount = $amount_new - $amount_old;
				$amount_update = $warehouses_product->amount - $amount;
			}else{
				$amount = $amount_old - $amount_new;
				$amount_update = $warehouses_product->amount + $amount;
			}

			$row2 = array();
			$row2['amount'] = $amount_update;
			$ud_warehouse = $model-> _update($row2,'fs_warehouses_products','id = '.$warehouses_product->id);

			if($ud_warehouse){
				$row = array();
				$row['amount'] = $amount_new;
				// $row['ton'] = $amount_update;
				$ud_bill_detail = $model-> _update($row,'fs_warehouses_bill_transfer_detail','id = '.$data_id->id);

				$row_10 = array();
				$row_10['type'] = 3;
				$row_10['type_action_name'] = $_SESSION['ad_username'] . " sửa phiếu chuyển ID ".$bill_id. ": từ ".$amount_old . " => ".$amount_new ;
				$row_10['bill_id'] = $bill_id;
				$row_10['bill_detail_id'] = $id;
				$row_10['product_id']   = $product-> id;
				$row_10['product_code'] = $product-> code;
				$row_10['product_name'] = $product-> name;
				$row_10['warehouses_id'] = $data_bill-> warehouses_id;
				$row_10['warehouses_name'] = $data_bill-> warehouses_name;
				$row_10['from_warehouses_id'] = $data_bill-> warehouses_id;
				$row_10['from_warehouses_name'] = $data_bill-> warehouses_name;
				$row_10['to_warehouses_id'] = $data_bill-> to_warehouses_id;
				$row_10['to_warehouses_name'] = $data_bill-> to_warehouses_name;
				$row_10['amount'] = $amount;
				$row_10['note'] = $data_bill-> note;
				$row_10['status'] = 4;
				$row_10['time_add'] = date('Y-m-d H:i:s');
				$row_10['created_time'] = date('Y-m-d H:i:s');
				$row_10['ton'] = $amount_update;
				$row_10['edit'] = 1;
				$ud_bill_detail_history = $model-> _add($row_10,'fs_warehouses_bill_detail_history');
				// dd($row_10);


			}
		}

		if($data_bill ->status == 4){
			$warehouses_product = $model->get_record('product_id = '.$data_id->product_id . ' AND warehouses_id = '.$data_bill->to_warehouses_id,'fs_warehouses_products');

			$product = $model->get_record('id = '.$data_id->product_id,'fs_products','code,name,id');
		
			if($amount_new > $amount_old){
				$amount = $amount_new - $amount_old;
				$amount_update = $warehouses_product->amount + $amount;
			}else{
				$amount = $amount_old - $amount_new;
				$amount_update = $warehouses_product->amount - $amount;
			}

			$row2 = array();
			$row2['amount'] = $amount_update;

			$ud_warehouse = $model-> _update($row2,'fs_warehouses_products','id = '.$warehouses_product->id);
			if($ud_warehouse){
				$row = array();
				$row['amount'] = $amount_new;
				// $row['ton'] = $amount_update;
				$ud_bill_detail = $model-> _update($row,'fs_warehouses_bill_transfer_detail','id = '.$data_id->id);

				$row_10 = array();
				$row_10['type'] = 4;
				$row_10['type_action_name'] = $_SESSION['ad_username'] . " sửa phiếu chuyển ID ".$bill_id. ": từ ".$amount_old . " => ".$amount_new ;
				$row_10['bill_id'] = $bill_id;
				$row_10['bill_detail_id'] = $id;
				$row_10['product_id']   = $product-> id;
				$row_10['product_code'] = $product-> code;
				$row_10['product_name'] = $product-> name;
				$row_10['warehouses_id'] = $data_bill-> warehouses_id;
				$row_10['warehouses_name'] = $data_bill-> warehouses_name;
				$row_10['from_warehouses_id'] = $data_bill-> warehouses_id;
				$row_10['from_warehouses_name'] = $data_bill-> warehouses_name;
				$row_10['to_warehouses_id'] = $data_bill-> to_warehouses_id;
				$row_10['to_warehouses_name'] = $data_bill-> to_warehouses_name;
				$row_10['amount'] = $amount;
				$row_10['note'] = $data_bill-> note;
				$row_10['status'] = 4;
				$row_10['time_add'] = date('Y-m-d H:i:s');
				$row_10['created_time'] = date('Y-m-d H:i:s');
				$row_10['ton'] = $amount_update;
				$row_10['edit'] = 1;
				$ud_bill_detail_history = $model-> _add($row_10,'fs_warehouses_bill_detail_history');
				// dd($row_10);
			}
		}


		$data = array();
		$data['error'] = true;
		if($ud_bill_detail_history){
			$data['error'] = false;
			$data['message'] = "Cập nhập thành công !";
			$data['ton'] = $amount_update;
		}else{
			$data['message'] = "Cập nhập tồn kho không thành công, vui lòng F5 thử lại!";
		}

		echo json_encode($data);
		return;
	}

	
}

function show_ware($controle,$id){
	$model = $controle-> model;
	$data = $model-> get_record('id = '.$id,$model-> table_name,'*');

	$txt = '';
	if($data-> type == 1 || $data-> type == 2) {
		$txt .= '<p>'.$data-> warehouses_name.'</p>';
	} elseif($data-> type == 3) {
		$txt .= '<p>'.$data-> warehouses_name.' &#8594; '.$data-> to_warehouses_name.'</p>';
	}

	$class ='';
	if($data-> type == 1) {
		$class ='alert-success';
		$text_type = $controle-> arr_type[$data-> type].' '.$controle-> arr_type_import[$data-> type_import];
	} elseif($data-> type == 2) {
		$class ='alert-danger';
		$text_type = $controle-> arr_type[$data-> type].' '.$controle-> arr_type_import[$data-> type_import];
	} elseif($data-> type == 3) {
		$class ='alert-warning';
		$text_type = $controle-> arr_type[$data-> type];
	}
	$txt .= '<span class="'.$class.'">'.$text_type.'</span>';
	return $txt;
}

function show_file($controle,$file){
	if(!$file) return;
	return '<a style="color:green" target="_blank" title="Xem file" href="'.URL_ROOT.$file.'">Xem file</a>';
}


function show_discount_type($controle,$type){
	return $controle-> arr_type_discount[$type];
}

function show_discount($controle,$discount){
	return format_money($discount,' ','0');
}

function show_status($controle,$id){

	$model = $controle-> model;
	$data = $model-> get_record('id = '.$id,$model-> table_name,'*');

	$status = $data-> status;

	if(!$controle-> arr_status[$status]) return;

	$class ='';
	if($status == 2) {
		$class ='alert-danger';
	} elseif($status == 3) {
		$class ='alert-info';
	} elseif($status == 4) {
		$class ='alert-success';
	} elseif($status == 5) {
		$class ='alert-dark';
	}else{
		$class ='alert-warning';
	}
	$txt;

	global  $check_permission_status_warehouses;

	if(!empty($controle-> arr_status_action[$status])) {
		$txt = $controle-> arr_status[$status];
		if($check_permission_status_warehouses) {
			$txt .= '<br>';
			$txt .= '<a href="javascript:void(0)" onclick="change_status_ajax('.$id.','.$controle-> arr_status_action[$status]['value'].')">'.'<i class="fa fa-arrow-right"></i>'.$controle-> arr_status_action[$status]['text'].'</a>';
		}
	} else {
		$txt = $controle-> arr_status[$status];
	}

	if($data-> create_username1) {
		$txt .= '<br>'.$data-> create_username1;
		$txt .= '<br>'.date('d/m/Y H:i',strtotime($data-> updated_time1));
	}
	return '<span class="'.$class.'">'.$txt.'</span>';
}

function show_status2($controle,$id){
	$model = $controle-> model;
	$data = $model-> get_record('id = '.$id,$model-> table_name,'*');

	$status = $data-> status;

	if(!@$controle-> arr_status2[$status]) return;

	$class ='';
	if($status == 2) {
		$class ='alert-danger';
	} elseif($status == 3) {
		$class ='alert-info';
	} elseif($status == 4) {
		$class ='alert-success';
	} elseif($status == 5) {
		$class ='alert-dark';
	}else{
		$class ='alert-warning';
	}
	$txt;

	global  $check_permission_status_warehouses;

	if(!empty($controle-> arr_status2_action[$status])) {
		$txt = $controle-> arr_status2[$status];
		if($check_permission_status_warehouses) {
			$txt .= '<br>';
			$txt .= '<a href="javascript:void(0)" onclick="change_status_ajax('.$id.','.$controle-> arr_status2_action[$status]['value'].')">'.'<i class="fa fa-arrow-right"></i>'.$controle-> arr_status2_action[$status]['text'].'</a>';
		}
	} else {
		$txt = $controle-> arr_status2[$status];
	}

	if($data-> create_username2) {
		$txt .= '<br>'.$data-> create_username2;
		$txt .= '<br>'.date('d/m/Y H:i',strtotime($data-> updated_time2));
	}
	return '<span class="'.$class.'">'.$txt.'</span>';
}



?>