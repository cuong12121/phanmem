<?php
	// models 
//	include 'modules/'.$module.'/models/'.$view.'.php';

class WarehousesControllersBill extends Controllers
{
	function __construct()
	{
			// parent::display();
			// $sort_field = $this -> sort_field;
			// $sort_direct = $this -> sort_direct;
		$this->view = 'bill' ; 
		$this-> arr_type = array('1'=>'Phiếu nhập','2'=>'Phiếu xuất');

		$this-> arr_type_import = array('1'=>'Nhà cung cấp','2'=>'Bán lẻ', '3' => 'Bán sỉ','4' => 'Khác','5' => 'Hoàn hàng');

		$this-> arr_type_discount = array('1'=>'Tiền mặt','2'=>'%');

		global $check_permission_status_warehouses;

		if($check_permission_status_warehouses) {
			$this-> arr_status = array('1' => 'Phiếu tạm','2'=>'Chờ duyệt','3'=>'Đã duyệt', '4'=> 'Hoàn thành', '5' => 'Hủy');
		} else {
			$this-> arr_status = array('1' => 'Phiếu tạm','2'=>'Chờ duyệt');
		}

		$this-> arr_status_show = array('1' => 'Phiếu tạm','2'=>'Chờ duyệt','3'=>'Đã duyệt', '4'=> 'Hoàn thành', '5' => 'Hủy');
		
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
		$breadcrumbs[] = array(0=>'Xuất nhập kho', 1 => '');	
		global $tmpl;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );
		$tmpl->assign ( 'seo_title', 'Danh sách Xuất nhập kho');
		// $this->update_bill_detail();
		// $this->update_name_product_bill_detail();
		// $this->update_ton_bill_detail();
		include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
	}

	function update_bill_detail(){
		$model  = $this -> model;
		$bills = $model->get_records('id > 11','fs_warehouses_bill');
		foreach ($bills as $data_bill) {
			$row = array();
			$row['warehouses_id'] = $data_bill-> warehouses_id;
			$row['warehouses_name'] = $data_bill-> warehouses_name;
			$row['created_time'] = $data_bill-> created_time;
			$row['updated_time'] = $data_bill-> updated_time;
			$row['to_warehouses_id'] = $data_bill-> to_warehouses_id;
			$row['to_warehouses_name'] = $data_bill-> to_warehouses_name;
			$row['type'] = $data_bill-> type;
			$row['type_import'] = $data_bill-> type_import;
			$row['supplier_id'] = $data_bill-> supplier_id;
			$row['supplier_name'] = $data_bill-> supplier_name;
			$row['note'] = $data_bill-> note;
			$row['action_username'] = $data_bill-> action_username;
			$row['action_userid'] = $data_bill-> action_userid;
			$row['create_username'] = $data_bill-> create_username;
			$row['style_import'] = $data_bill-> style_import;
			$row['status'] = $data_bill-> status;
			$row['file'] = $data_bill-> file;
			$row['file_name'] = $data_bill-> file_name;
			// dd($row);
			// $product = $model->get_record('id = '.$row['product_id'],'fs_products','code,name');
			// if(!empty($product)){
			// 	$row['product_code'] = $product-> code;
			// 	$row['product_name'] = $product-> name;
			// }
			$model-> _update($row,'fs_warehouses_bill_detail','bill_id = '.$data_bill-> id);
		}
	}

	function update_name_product_bill_detail(){
		$model  = $this -> model;
		$list = $model->get_records('bill_detail > 11','fs_warehouses_bill_detail','id,product_id');
		foreach ($list as $item) {
			$row = array();
			$product = $model->get_record('id = '.$item->product_id,'fs_products','code,name');
			$row['product_code'] = $product-> code;
			$row['product_name'] = $product-> name;
			$model-> _update($row,'fs_warehouses_bill_detail','id = '.$item-> id);
		}
	}


	function update_ton_bill_detail(){
		$model  = $this -> model;
		$list = $model->get_records('','fs_warehouses_bill_detail','id,product_id,warehouses_id');
		foreach ($list as $item) {
			$ton = $model->get_record('product_id = '.$item->product_id . " AND warehouses_id = ".$item-> warehouses_id,'fs_warehouses_products','amount');
			$row = array();
			$row['ton'] = $ton-> amount;
			$model-> _update($row,'fs_warehouses_bill_detail','id = '.$item-> id);
		}
	}








	function add()
	{
		$model = $this -> model;
		$warehouses = $model->get_records('1=1','fs_warehouses','*');
		$supplier = $model->get_records('1=1','fs_supplier','*');
		$maxOrdering = $model->getMaxOrdering();

		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Danh sách Xuất nhập kho', 1 => 
			FSRoute::_("index.php?module=".$this-> module."&view=".$this-> view));	
		global $tmpl;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );

		$tmpl->assign ( 'seo_title', 'Xuất nhập kho');

		include 'modules/'.$this->module.'/views/'.$this -> view.'/add.php';
	}

	function edit(){

		$ids = FSInput::get('id',array(),'array');
		$id = $ids[0];
		$model = $this -> model;
		$data = $model->get_record_by_id($id);

		$list_products = $model-> get_records('bill_id = '.$id,'fs_warehouses_bill_detail','*');

		$warehouses = $model->get_records('1=1','fs_warehouses','*');
		$supplier = $model->get_records('1=1','fs_supplier','*');

		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Danh sách Xuất nhập kho', 1 => 
			FSRoute::_("index.php?module=".$this-> module."&view=".$this-> view));	
		global $tmpl;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );
		$tmpl->assign ( 'seo_title', 'Xuất nhập kho');


		include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
	}

	function print(){
		$ids = FSInput::get('id',array(),'array');
		$id = $ids[0];
		$model = $this -> model;
		$data = $model->get_record_by_id($id);

		$list_products = $model-> get_records('bill_id = '.$id,$model-> table_name_detail,'*');
		
		global $tmpl;
		$tmpl->assign ( 'seo_title', 'Xuất nhập kho');

		include 'modules/'.$this->module.'/views/'.$this->view.'/print.php';
	}

	function ajax_products_search_keyword(){
		// echo '111';die;
		$model = $this -> model;
		$type_products_search = FSInput::get('type_products_search');
		$products_search_keyword = FSInput::get('products_search_keyword');
		$warehouses_id = FSInput::get('warehouses_id');

		$list_products = $model-> get_records('name LIKE "%'.$products_search_keyword.'%" OR code LIKE "%'.$products_search_keyword.'%"','fs_products','name,code,id,price,image,weight', '', 50);

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

	function ajax_add_amount_item_bill(){
		$model = $this -> model;
		$code_product = FSInput::get('code_product');
		$code_product = trim($code_product);
		$amount_product = FSInput::get('amount_product');
		$price = FSInput::get('price_product');
		if(!$code_product || !$amount_product || !$price){
			$data = array();
			$data['error'] = true;
			$data['message'] = "Nhập đủ mã, số lượng, giá!";
			echo json_encode($data);
			return;
		}

		$bill_id = FSInput::get('bill_id');
		$data_bill = $model->get_record('id = '.$bill_id,'fs_warehouses_bill');
		$product = $model->get_record('code = "'.$code_product.'"','fs_products','id,code,name');
		
		if(empty($product)){
			$data = array();
			$data['error'] = true;
			$data['message'] = "Mã sản phẩm không đúng!";
			echo json_encode($data);
			return;
		}

		$warehouses_product = $model->get_record('product_id = '.$product->id . ' AND warehouses_id = '.$data_bill->warehouses_id,'fs_warehouses_products');


		if($data_bill -> type == 2){
			$amount_update = $warehouses_product-> amount - $amount_product;

		}elseif($data_bill -> type == 1){
			$amount_update = $warehouses_product-> amount + $amount_product;
		}


		$row2 = array();
		$row2['amount'] = $amount_update;
		$ud_warehouse = $model-> _update($row2,'fs_warehouses_products','id = '.$warehouses_product->id);

		if($ud_warehouse){
			$row = array();
			$row['amount'] = $amount_product;
			//$row['link'] = $link;
			$row['price'] = $price;
			// $row['typediscount'] = $typediscount;
			// $row['discount'] = $discount;
			// $row['weight'] = $weight;
			$row['ton'] = $amount_update;
			$row['bill_id'] = $bill_id;
			$row['product_id'] = $product->id;
			$row['warehouses_id'] = $data_bill-> warehouses_id;
			$row['warehouses_name'] = $data_bill-> warehouses_name;
			$row['created_time'] = $data_bill-> created_time;
			$row['updated_time'] = $data_bill-> updated_time;
			$row['to_warehouses_id'] = $data_bill-> to_warehouses_id;
			$row['to_warehouses_name'] = $data_bill-> to_warehouses_name;
			$row['type'] = $data_bill-> type;
			$row['type_import'] = $data_bill-> type_import;
			$row['supplier_id'] = $data_bill-> supplier_id;
			$row['supplier_name'] = $data_bill-> supplier_name;
			$row['note'] = $data_bill-> note;
			$row['action_username'] = $data_bill-> action_username;
			$row['action_userid'] = $data_bill-> action_userid;
			$row['create_username'] = $data_bill-> create_username;
			$row['style_import'] = $data_bill-> style_import;
			$row['status'] = $data_bill-> status;
			$row['file'] = $data_bill-> file;
			$row['file_name'] = $data_bill-> file_name;
			$row['product_code'] = $product-> code;
			$row['product_name'] = $product-> name;

			$ud_bill_detail = $model-> _add($row,'fs_warehouses_bill_detail');

			$row_10 = array();
			$row_10['bill_detail_id'] = $ud_bill_detail;
			$row_10['bill_id'] = $bill_id;
			$row_10['created_time'] = $data_bill-> created_time;
			$row_10['product_id']   = $product-> id;
			$row_10['product_code'] = $product-> code;
			$row_10['product_name'] = $product-> name;
			$row_10['warehouses_id'] = $data_bill-> warehouses_id;
			$row_10['warehouses_name'] = $data_bill-> warehouses_name;
			$row_10['type'] = $data_bill-> type;
			$row_10['amount'] =  $amount_product;
			$row_10['price'] = $price;
			$row_10['tong_tien'] = $price * $amount_product;
			$row_10['note'] = $data_bill-> note;
			$row_10['status'] = $data_bill-> status;
			$row_10['time_add'] = date('Y-m-d H:i:s');
			if($data_bill -> type == 1){
				$row_10['type_action_name'] = "Phiếu nhập";
			}else{
				$row_10['type_action_name'] = "Phiếu xuất";
			}
			$row_10['ton'] = $amount_update;;

			$ud_bill_detail_history = $model-> _add($row_10,'fs_warehouses_bill_detail_history');
		}

		$data = array();
		$data['error'] = true;
		if($ud_warehouse && $ud_bill_detail && $ud_bill_detail_history){
			$data['error'] = false;
			$data['message'] = "Cập nhập thành công !";
			$data['ton'] = $amount_update;
		}elseif($ud_warehouse && $ud_bill_detail && !$ud_bill_detail_history){
			$data['error'] = false;
			$data['message'] = "Cập nhập tồn kho thành công, Lỗi không cập nhập được lịch sử";
			$data['ton'] = $amount_update;
		}elseif($ud_warehouse && !$ud_bill_detail && $ud_bill_detail_history){
			$data['error'] = false;
			$data['message'] = "Cập nhập tồn kho thành công, Lỗi không cập nhập được phiếu chi tiết";
			$data['ton'] = $amount_update;
		}elseif($ud_warehouse && !$ud_bill_detail && !$ud_bill_detail_history){
			$data['error'] = false;
			$data['message'] = "Cập nhập tồn kho thành công, Lỗi không cập nhập được phiếu chi tiết, phiếu lịch sử";
			$data['ton'] = $amount_update;
		}else{
			$data['message'] = "Cập nhập tồn kho không thành công, vui lòng F5 thử lại!";
		}

		echo json_encode($data);
		return;
	}

	function ajax_change_amount_item_bill(){
		$model = $this -> model;
		$id = FSInput::get('id');
		$amount_old = FSInput::get('amount_old');
		$amount_new = FSInput::get('amount_new');
		$bill_id = FSInput::get('bill');
		$data_bill = $model->get_record('id = '.$bill_id,'fs_warehouses_bill');
		$data_id = $model->get_record('id = '.$id,'fs_warehouses_bill_detail');
		$warehouses_product = $model->get_record('product_id = '.$data_id->product_id . ' AND warehouses_id = '.$data_bill->warehouses_id,'fs_warehouses_products');
		
		// dd($data_bill);

		if($data_bill -> type == 2){
			if($amount_new > $amount_old){
				$amount = $amount_new - $amount_old;
				$amount_update = $warehouses_product->amount - $amount;
			}else{
				$amount = $amount_old - $amount_new;
				$amount_update = $warehouses_product->amount + $amount;
			}

		}elseif($data_bill -> type == 1){
			if($amount_new > $amount_old){
				$amount = $amount_new - $amount_old;
				$amount_update = $warehouses_product->amount + $amount;
			}else{
				$amount = $amount_old - $amount_new;
				$amount_update = $warehouses_product->amount - $amount;
			}
		}


		$row = array();
		$row['amount'] = $amount_new;
		$row['ton'] = $amount_update;

		$row2 = array();
		$row2['amount'] = $amount_update;
		// dd($row2);
		$ud_warehouse = $model-> _update($row2,'fs_warehouses_products','id = '.$warehouses_product->id);
		if($ud_warehouse){
			$ud_bill_detail = $model-> _update($row,'fs_warehouses_bill_detail','id = '.$data_id->id);
			$ud_bill_detail_history = $model-> _update($row,'fs_warehouses_bill_detail_history','bill_detail_id = '.$data_id->id);
			// dd($row);
		}

		$data = array();
		$data['error'] = true;
		if($ud_warehouse && $ud_bill_detail && $ud_bill_detail_history){
			$data['error'] = false;
			$data['message'] = "Cập nhập thành công !";
			$data['ton'] = $amount_update;
		}elseif($ud_warehouse && $ud_bill_detail && !$ud_bill_detail_history){
			$data['error'] = false;
			$data['message'] = "Cập nhập tồn kho thành công, Lỗi không cập nhập được lịch sử";
			$data['ton'] = $amount_update;
		}elseif($ud_warehouse && !$ud_bill_detail && $ud_bill_detail_history){
			$data['error'] = false;
			$data['message'] = "Cập nhập tồn kho thành công, Lỗi không cập nhập được phiếu chi tiết";
			$data['ton'] = $amount_update;
		}elseif($ud_warehouse && !$ud_bill_detail && !$ud_bill_detail_history){
			$data['error'] = false;
			$data['message'] = "Cập nhập tồn kho thành công, Lỗi không cập nhập được phiếu chi tiết, phiếu lịch sử";
			$data['ton'] = $amount_update;
		}else{
			$data['message'] = "Cập nhập tồn kho không thành công, vui lòng F5 thử lại!";
		}

		echo json_encode($data);
		return;
	}


	function ajax_remove_item_bill(){
		$model = $this -> model;
		$id = FSInput::get('id');
		$bill_id = FSInput::get('bill');
		$data_bill = $model->get_record('id = '.$bill_id,'fs_warehouses_bill');
		$data_id = $model->get_record('id = '.$id,'fs_warehouses_bill_detail');
		$amount = $data_id->amount;
		$warehouses_product = $model->get_record('product_id = '.$data_id->product_id . ' AND warehouses_id = '.$data_bill->warehouses_id,'fs_warehouses_products');
		

		if($data_bill -> type == 2){ //phiếu xuât
			$amount_update = $warehouses_product->amount + $amount;
		}elseif($data_bill -> type == 1){ //phiếu nhập
			$amount_update = $warehouses_product->amount - $amount;
		}

		$row2 = array();
		$row2['amount'] = $amount_update;

		$ud_warehouse = $model-> _update($row2,'fs_warehouses_products','id = '.$warehouses_product->id);

		if($ud_warehouse){
			$ud_bill_detail = $model-> _remove('id = '.$data_id->id,'fs_warehouses_bill_detail');
			$ud_bill_detail_history = $model-> _remove('bill_detail_id = '.$data_id->id,'fs_warehouses_bill_detail_history');
			$row3 = array();
			$row3['total_amount'] = $data_bill-> total_amount - $amount;
			$row3['total_price'] = $data_bill-> total_price - ($amount * $data_id->price);
			$row3['total_price_after'] = $data_bill-> total_price_after - ($amount * $data_id->price);
			$row3['total_weight'] = $data_bill-> total_weight - ($amount * $data_id->weight);;
			$model-> _update($row3,'fs_warehouses_bill','id = '.$bill_id);
		}

		$data = array();
		$data['error'] = true;
		if($ud_warehouse && $ud_bill_detail && $ud_bill_detail_history){
			$data['error'] = false;
			$data['message'] = "Xóa thành công !";
		}elseif($ud_warehouse && $ud_bill_detail && !$ud_bill_detail_history){
			$data['error'] = false;
			$data['message'] = "Cập nhập tồn kho thành công, Lỗi không xóa được lịch sử";
		}elseif($ud_warehouse && !$ud_bill_detail && $ud_bill_detail_history){
			$data['error'] = false;
			$data['message'] = "Cập nhập tồn kho thành công, Lỗi không xóa được phiếu chi tiết";
		}elseif($ud_warehouse && !$ud_bill_detail && !$ud_bill_detail_history){
			$data['error'] = false;
			$data['message'] = "Cập nhập tồn kho thành công, Lỗi không xóa được phiếu chi tiết, phiếu lịch sử";
			$data['ton'] = $amount_update;
		}else{
			$data['message'] = "Xóa không thành công, vui lòng F5 thử lại!";
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

function show_status($controle,$status){
	$class ='';
	if($status == 2) {
		$class ='alert-danger';
	} elseif($status == 3) {
		$class ='alert-info';
	} elseif($status == 4) {
		$class ='alert-success';
	} elseif($status == 5) {
		$class ='alert-dark';
	}else
	{
		$class ='alert-warning';
	}
	return '<span class="'.$class.'">'.$controle-> arr_status_show[$status].'</span>';
}



?>