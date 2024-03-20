<?php
	// models 
//	include 'modules/'.$module.'/models/'.$view.'.php';

class WarehousesControllersPositions_bill extends Controllers
{
	function __construct()
	{
			// parent::display();
			// $sort_field = $this -> sort_field;
			// $sort_direct = $this -> sort_direct;
		$this->view = 'positions_bill' ; 
		$this-> arr_type = array('1'=>'Phiếu nhập vị trí','2'=>'Phiếu xuất vị trí');

		$this-> arr_type_import = array('1'=>'Nhà cung cấp','2'=>'Bán lẻ', '3' => 'Bán sỉ','4' => 'Khác');

		$this-> arr_type_discount = array('1'=>'Tiền mặt','2'=>'%');

		$this-> arr_status = array('1' => 'Phiếu tạm', '4'=> 'Hoàn thành', '5' => 'Hủy');
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

		$pagination = $model->getPagination();

		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Xuất nhập vị trí', 1 => '');	
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
		$breadcrumbs[] = array(0=>'Danh sách Xuất nhập vị trí', 1 => 
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



		$list_products = $model-> get_records('bill_id = '.$id,'fs_warehouses_bill_positions_detail','*');

		$warehouses = $model->get_records('1=1','fs_warehouses','*');

		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Danh sách Xuất nhập vị trí', 1 => 
			FSRoute::_("index.php?module=".$this-> module."&view=".$this-> view));	
		global $tmpl;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );


		include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
	}

	function print(){
		$ids = FSInput::get('id',array(),'array');
		$id = $ids[0];
		$model = $this -> model;
		$data = $model->get_record_by_id($id);

		$list_products = $model-> get_records('bill_id = '.$id,'fs_warehouses_bill_positions_detail','*');

		include 'modules/'.$this->module.'/views/'.$this->view.'/print.php';
	}

	function ajax_products_search_keyword(){
		$model = $this -> model;
		$type_products_search = FSInput::get('type_products_search');
		$products_search_keyword = FSInput::get('products_search_keyword');
		$warehouses_id = FSInput::get('warehouses_id');

		$list_products = $model-> get_records('name LIKE "%'.$products_search_keyword.'%" OR code LIKE "%'.$products_search_keyword.'%"','fs_products','name,code,id,barcode,image,price');

		// print_r($list_products);

		if(!empty($list_products)) {
			foreach ($list_products as &$product) {
				$record_amount = $model-> get_record('product_id = '.$product-> id.' AND warehouses_id = '.$warehouses_id,'fs_warehouses_products','amount,amount_deliver,amount_hold');
				if(!empty($record_amount)) {
					$product-> amount = $record_amount-> amount;
					$product-> amount_deliver = $record_amount-> amount_deliver;
					$product-> amount_hold = $record_amount-> amount_hold;
				} else {
					$product-> amount = 0;
					$product-> amount_deliver = 0;
					$product-> amount_hold = 0;
				}
			}
		}

		$html = $this -> ajax_products_search_keyword_genarate($list_products);
		echo $html;
		return;

		// echo $products_search_keyword;
	}

	function ajax_positions_search_keyword(){
		$model = $this -> model;
		$type_products_search = FSInput::get('type_products_search');
		$positions_search_keyword = FSInput::get('positions_search_keyword');
		$warehouses_id = FSInput::get('warehouses_id');

		// $list_products = $model-> get_records('name LIKE "%'.$products_search_keyword.'%" OR code LIKE "%'.$products_search_keyword.'%"','fs_products','name,code,id,price,image,weight');

		$list_positions = $model -> get_records(' warehouses_id = '.$warehouses_id.' AND name LIKE "%'.$positions_search_keyword.'%" OR code LIKE "%'.$positions_search_keyword.'%" OR list_code LIKE "%'.$positions_search_keyword.'%"','fs_warehouses_positions','*');

		// print_r($list_products);

		$html = $this -> ajax_positions_search_keyword_genarate($list_positions);
		echo $html;
		return;

		// echo $products_search_keyword;
	}


	function ajax_positions_search_keyword_genarate($data){
		if(empty($data)) return;
		$html = '';
		foreach ($data as $item) {
			$html .= '<div class="item"><a class="cls" href="javascript:void(0)" onclick="set_positions('.$item-> id.')"><div class="item_inner"><div class="name">'.$item->name.' ('.$item-> list_code.')</div><div class="info">'.$item-> list_parents_name.'</div></div></a><input type="hidden" id="data_position_name_'.$item->id.'" value="'.$item-> name.'"><input type="hidden" id="data_position_list_code_'.$item->id.'" value="'.$item-> list_code.'"></div>';
		}
		return $html;
	}


	

	function ajax_products_search_keyword_genarate($data){
		if(empty($data)) return;
		$html = '';
		foreach ($data as $item) {
			$html .= '<div class="item"><a class="cls" href="javascript:void(0)" onclick="set_products('.$item-> id.')"><div class="image"><img src="'.URL_ROOT.str_replace('/original','/resized/',$item-> image).'"></div><div class="item_inner"><div class="name">'.$item-> code.' - '.$item->name.'</div><div class="info">('.format_money($item-> price,'đ','0đ').') (Tồn: '.$item-> amount.')</div></div></a><input type="hidden" id="data_product_name_'.$item->id.'" value="'.$item-> name.'"><input type="hidden" id="data_product_code_'.$item->id.'" value="'.$item-> code.'"><input type="hidden" id="data_product_barcode_'.$item->id.'" value="'.$item-> barcode.'"></div>';
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
		$text_type = $controle-> arr_type[$data-> type];
	} elseif($data-> type == 2) {
		$class ='alert-danger';
		$text_type = $controle-> arr_type[$data-> type];
	} elseif($data-> type == 3) {
		$class ='alert-warning';
		$text_type = $controle-> arr_type[$data-> type];
	}elseif($data-> type == 4) {
		$class ='alert-dark';
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
	} else {
		$class ='alert-warning';
	}
	return '<span class="'.$class.'">'.@$controle-> arr_status[$status].'</span>';
}



?>