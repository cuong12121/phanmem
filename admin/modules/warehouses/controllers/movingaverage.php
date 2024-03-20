<?php
	// models 
//	include 'modules/'.$module.'/models/'.$view.'.php';

class WarehousesControllersMovingaverage extends Controllers
{
	function __construct()
	{
			// parent::display();
			// $sort_field = $this -> sort_field;
			// $sort_direct = $this -> sort_direct;
		$this->view = 'movingaverage' ; 
		$this-> arr_type = array('1'=>'Phiếu nhập','2'=>'Phiếu xuất','3' => 'Phiếu Chuyển kho');

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

		$id = FSInput::get('id');

		if($id) {
			$movingaverage = $model->get_record('id = '.$id,'fs_warehouses_movingaverage','*');
			if(!empty($movingaverage)) {
				@$_SESSION [$model->prefix . 'filter0'] = $movingaverage-> filter0;
				@$_SESSION [$model->prefix . 'filter1'] = $movingaverage-> filter1;
				@$_SESSION [$model->prefix . 'filter2'] = $movingaverage-> filter2;
				@$_SESSION [$model->prefix . 'keysearch'] = $movingaverage-> keysearch;
				@$_SESSION [$model->prefix . 'text0'] = $movingaverage-> text0;
				@$_SESSION [$model->prefix . 'text1'] = $movingaverage-> text1;
				@$_SESSION [$model->prefix . 'text2'] = $movingaverage-> text2;
			}
		}

		$warehouses = $model->get_records('1=1','fs_warehouses','*');
		$categories = $model->get_records('1=1','fs_products_categories','*');

		if (( @$_SESSION[$model -> prefix.'text0'] && @$_SESSION[$model -> prefix.'text1'])) {
			$list = $model->get_data();

			// print_r($list);
		} else {
			$list = array();
			echo '<div class="alert alert-warning">Vui lòng chọn Ngày bắt đầu, Ngày kết thúc!</div>';
			$pagination = $model->getPagination();

			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>'Dự kiến nhập hàng', 1 => '');	
			global $tmpl;
			$tmpl->assign ( 'breadcrumbs', $breadcrumbs );

			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
			return;
		}

		$first_date = strtotime($_SESSION[$model -> prefix.'text0']);
		$second_date = strtotime($_SESSION[$model -> prefix.'text1']);
		$datediff_time = abs($first_date - $second_date);

		$datediff  = floor($datediff_time / (60*60*24));

		$date_continue = $_SESSION[$model -> prefix.'text2'];		

		// $categories = $model->get_categories_tree();



		$statistical2 = array();
		$statistical2['row'] = array(
			0=> array(
				'0% - 25%',0,25,'red'
			),
			1=>array(
				'26% - 50%',25.1,50,'blue'
			),
			2=>array(
				'51% - 75%',50.1,75,'yellow'
			),
			3=>array(
				'76% - 100%',75.1,100,'green'
			),
			4=>array(
				'> 100%',100.1,999999,'orange'
			)
		);

		$statistical2['count'] = array(0,0,0,0,0);
		$statistical2['total_ton'] = array(0,0,0,0,0);
		$statistical2['buy'] = array(0,0,0,0,0);

		if(!empty($list)) {
			foreach ($list as $item) {
				$ton = show_warehouses_product($this,$item-> id);
				$ban = $item-> total;
				$buy = show_warehouses_product_buy($this,$item);
				foreach ($statistical2['row'] as $key => $value) {
					if($ban+$ton) {
						$percen = $ban/($ban+$ton)*100;
					}
					
					if(@$percen >= @$value[1] && @$percen <= @$value[2]) {
						$statistical2['count'][$key] ++;
						$statistical2['total_ton'][$key] += $ton;
							// $statistical2['total_price'][$key] += $item-> import_price*$ton;
						$statistical2['buy'][$key] +=  $buy;
						$check = 1;
					}
				}
			}
		}






		$statistical1 = array();
		$statistical1['row'] = array(
			0=> array(
				'0 - 30 ngày',0,30,'red'
			),
			1=>array(
				'31 - 60 ngày',31,60,'blue'
			),
			2=>array(
				'61 - 90 ngày',61,90,'yellow'
			),
			3=>array(
				'>91 ngày',91,9999,'green'
			),
			4=>array(
				'Không xác định',0,-1,'orange'
			)
		);

		$statistical1['count'] = array(0,0,0,0,0);
		$statistical1['total_ton'] = array(0,0,0,0,0);
		$statistical1['total_price'] = array(0,0,0,0,0);

		$statistical_buy = array();
		$statistical_buy['total_p'] = 0;
		$statistical_buy['total_count'] = 0;
		$statistical_buy['total_price'] = 0;

		if(!empty($list)) {
			foreach ($list as $item) {

				$c9 = show_warehouses_product_buy($this, $item);

				if($c9) {
					$statistical_buy['total_p']++;
					$statistical_buy['total_count'] += $c9;
					$statistical_buy['total_price'] += $c9*$item-> import_price;
				}

				// tính số sp từng nhóm, tổng số lượng sp

				$c10 = show_warehouses_product_day($this, $item);

				$ton = show_warehouses_product($this,$item-> id);

				$check = 0;
				foreach ($statistical1['row'] as $key => $value) {
					if($c10 >= @$value[1] && $c10 <= @$value[2]) {
						$statistical1['count'][$key] ++;
						$statistical1['total_ton'][$key] += $ton;
						$statistical1['total_price'][$key] += $item-> import_price*$ton;
						$check = 1;
					}
				}
				if(!$check) {
					$statistical1['count'][4] ++;
					$statistical1['total_ton'][4] += $ton;
				}
			}
		}

		// echo '<pre>';
		// print_r($statistical1);
		// die;


		$pagination = $model->getPagination();

		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Dự kiến nhập hàng', 1 => '');	
		global $tmpl;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );

		include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
	}


	function save_ajax(){

		$model  = $this -> model;

		$keysearch = FSInput::get('keysearch');

		$text0 = FSInput::get('text0');
		$text1 = FSInput::get('text1');
		$text2 = FSInput::get('text2');
		$filter0 = FSInput::get('filter0');
		$filter1 = FSInput::get('filter1');
		$filter2 = FSInput::get('filter2');

		$row = array();
		if(!$text0 || !$text1 || !$filter0) {
			echo 'Không lưu được!';
			return;
		} else {

			$time = date('Y-m-d H:i:s');

			$row = array();

			$row['keysearch'] = $keysearch;
			$row['text0'] = $text0;
			$row['text1'] = $text1;
			$row['text2'] = $text2;
			$row['filter0'] = $filter0;
			$row['filter1'] = $filter1;
			$row['filter2'] = $filter2;
			$row['created_time'] = $time;

			$model-> _add($row,'fs_warehouses_movingaverage',1);
			echo 'Đã lưu!';
			return;
		}
	}

	function add()
	{
		$model = $this -> model;
		$warehouses = $model->get_records('1=1','fs_warehouses','*');
		$supplier = $model->get_records('1=1','fs_supplier','*');
		$maxOrdering = $model->getMaxOrdering();

		
		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Danh sách Kiểm kho', 1 => 
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

		$list_products = $model-> get_records('bill_id = '.$id,'fs_warehouses_check_detail','*');

		$warehouses = $model->get_records('1=1','fs_warehouses','*');




		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Danh sách Kiểm kho', 1 => 
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

		$list_products = $model-> get_records('bill_id = '.$id,'fs_warehouses_check_detail','*');

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

	function ajax_products_search_keyword_genarate($data){
		if(empty($data)) return;
		$html = '';
		foreach ($data as $item) {
			$html .= '<div class="item"><a class="cls" href="javascript:void(0)" onclick="set_products('.$item-> id.')"><div class="image"><img src="'.URL_ROOT.str_replace('/original','/resized/',$item-> image).'"></div><div class="item_inner"><div class="name">'.$item-> code.' - '.$item->name.'</div><div class="info">('.format_money($item-> price,'đ','0đ').') (Tồn: '.$item-> amount.')</div></div></a><input type="hidden" id="data_product_name_'.$item->id.'" value="'.$item-> name.'"><input type="hidden" id="data_product_weight_'.$item->id.'" value="'.$item-> weight.'"><input type="hidden" id="data_product_price_'.$item->id.'" value="'.format_money($item-> price,'','0').'"><input type="hidden" id="data_product_price_name_'.$item->id.'" value="'.format_money($item-> price,'đ','0đ').'"><input type="hidden" id="data_product_amount_'.$item->id.'" value="'.$item-> amount.'"><input type="hidden" id="data_product_amount_deliver_'.$item->id.'" value="'.$item-> amount_deliver.'"><input type="hidden" id="data_product_amount_hold_'.$item->id.'" value="'.$item-> amount_hold.'"></div>';
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
		$text_type = $controle-> arr_type[$data-> type].' '.$controle-> arr_type_import[$data-> type_import];
	} elseif($data-> type == 2) {
		$class ='alert-danger';
		$text_type = $controle-> arr_type[$data-> type].' '.$controle-> arr_type_import[$data-> type_import];
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

function show_total_avg($controle,$total){
	$model = $controle-> model;
	$first_date = strtotime($_SESSION[$model -> prefix.'text0']);
	$second_date = strtotime($_SESSION[$model -> prefix.'text1']);
	$datediff_time = abs($first_date - $second_date);
	$datediff  = floor($datediff_time / (60*60*24));	

	return round($total/$datediff,2);
}

function show_total_cont($controle,$total){

	$model = $controle-> model;

	$first_date = strtotime($_SESSION[$model -> prefix.'text0']);
	$second_date = strtotime($_SESSION[$model -> prefix.'text1']);
	$datediff_time = abs($first_date - $second_date);
	$datediff  = floor($datediff_time / (60*60*24));	

	$date_continue = $_SESSION[$model -> prefix.'text2'];

	return round($total/$datediff*(int)$date_continue);

}

function show_warehouses_product($controle,$id){
	$model = $controle-> model;
	$where = "";
	if(@$_SESSION [$model->prefix . 'filter0']){
		$warehouses_id =  @$_SESSION [$model->prefix . 'filter0'];
		$where .= " AND warehouses_id = " . $warehouses_id;
	}

	$warehouses_product = $model-> get_records('product_id = '.$id.$where,'fs_warehouses_products','*');
	
	$ton = 0;
	if(!empty($warehouses_product)){
		foreach ($warehouses_product as $value) {
			$ton +=  @$value-> amount - @$value-> amount_hold + @$value -> amount_wait_transfer;
		}
	}

	//return @$warehouses_product-> amount - @$warehouses_product-> amount_hold + @$warehouses_product -> amount_wait_transfer;
	return $ton;
}

function show_warehouses_ss_product($controle,$id){
	$model = $controle-> model;
	$warehouses_id =  @$_SESSION [$model->prefix . 'filter1'];

	if(@$warehouses_id)  {
		$warehouses_product = $model-> get_record('product_id = '.$id.' AND warehouses_id = '.$warehouses_id,'fs_warehouses_products','*');
		return @$warehouses_product-> amount?@$warehouses_product-> amount:0;
	} else {
		return 0;
	}
}


function show_warehouses_name($controle,$id){
	$model = $controle-> model;
	// dd($_SESSION [$model->prefix . 'filter0']);
	if(@$_SESSION [$model->prefix . 'filter0']){
		
		$model = $controle-> model;
		$data = $model-> get_record('id = '.$id,'fs_warehouses','*');
		return $data-> name;
	}else{
		return "Tổng các kho";
	}
}

function show_warehouses_product_day($controle,$row){
	$model = $controle-> model;

	$c7 = show_warehouses_product($controle,$row-> id);
	$c5 = show_total_avg($controle,$row-> total);

	return(floor($c7/$c5));
}

function show_warehouses_product_buy($controle,$row){
	$model = $controle-> model;

	$c6 = show_total_cont($controle,$row-> total );
	$c7 = show_warehouses_product($controle,$row-> id);

	$c = $c6 - $c7;

	if($c < 0) {
		return 0;
	} else {
		return $c;
	}

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
	return '<span class="'.$class.'">'.$controle-> arr_status[$status].'</span>';
}


function show_import_product($controle,$row){
	$amount =  show_warehouses_product_buy($controle,$row);
	$text = '<a href="/admin/manager_import_product/forecast/add?amount='.$amount.'&product_id='.$row->id.'" class="show_import_product">Nhập hàng</a>';
	return $text;
}



?>