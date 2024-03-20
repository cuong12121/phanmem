<?php
	// models 
//	include 'modules/'.$module.'/models/'.$view.'.php';

class WarehousesControllersOverview extends Controllers
{
	function __construct()
	{
			// parent::display();
			// $sort_field = $this -> sort_field;
			// $sort_direct = $this -> sort_direct;
		$this->view = 'overview' ; 
		parent::__construct(); 
	}

	function get_pw_wrapper(){
		$model  = $this -> model;

		$list_products_warehouses = $model-> get_list_products_warehouses();
				$total_price_warehouses = 0;
		$total_count_warehouses = 0;

		if(!empty($list_products_warehouses)) {
			foreach ($list_products_warehouses as $item) {
				$p = $model-> get_record('id = '.$item-> product_id,'fs_products','import_price');
				if(!empty($p)) {
					$total_price_warehouses+= $p->import_price*$item-> amount;
				}
				
				$total_count_warehouses+= $item-> amount;
			}
		}

		include 'modules/'.$this->module.'/views/'.$this->view.'/pw_wrapper.php';

	}

	function display()
	{
		// die;
		parent::display();
		$sort_field = $this -> sort_field;
		$sort_direct = $this -> sort_direct;

		$model  = $this -> model;
		$list = $model->get_data();

		$list_month_now = $model-> get_list_month(4);
		$list_month_last = $model-> get_list_month(5);


		// $list_products_warehouses = $model-> get_list_products_warehouses();

		$list_month_now_day = array();
		$list_month_last_day = array();

		for ($i=1; $i < 32; $i++) { 
			$list_month_last_day[$i] = 0;
		}

		for ($i=1; $i <= (int)(date('d',time())); $i++) { 
			$list_month_now_day[$i] = 0;
		}



		foreach ($list_month_now as $item) {
			$total_price_item = $item-> total_price;
			$month = (int)(date('d',strtotime($item-> created_time)));
			$list_month_now_day[$month] += $total_price_item;
		}

		foreach ($list_month_last as $item) {
			$total_price_item = $item-> total_price;
			$month = (int)(date('d',strtotime($item-> created_time)));
			$list_month_last_day[$month] += $total_price_item;
		}


		$total_price_list = 0;
		$total_price_done = 0;
		$total_order = 0;
		$total_order_done = 0;
		foreach ($list as $item) {
			$total_price_item = $item-> total_price;
			$total_price_list += $total_price_item;
			if($item-> is_shoot == 1) {
				$total_price_done += $total_price_item;
				$total_order_done++;
			}
			$total_order++;
			// code...
		}

		$total_price_warehouses = 0;
		$total_count_warehouses = 0;

		// if(!empty($list_products_warehouses)) {
		// 	foreach ($list_products_warehouses as $item) {
		// 		$p = $model-> get_record('id = '.$item-> product_id,'fs_products','import_price');
		// 		if(!empty($p)) {
		// 			$total_price_warehouses+= $p->import_price*$item-> amount;
		// 		}
				
		// 		$total_count_warehouses+= $item-> amount;
		// 	}
		// }

	
		// print_r($list_month_last);

		$categories = $model->get_categories_tree();

		$warehouses = $model->get_records('1=1','fs_warehouses','*');

		$pagination = $model->getPagination();

		include 'modules/'.$this->module.'/views/'.$this->view.'/overview.php';

		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Tổng quan', 1 => '');	

		global $tmpl;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );
	}

	function add()
	{
		$model = $this -> model;
		$categories = $model->get_categories_tree();
		$maxOrdering = $model->getMaxOrdering();

		$categories_product = $model->get_categories_product_tree();
		$categories_filter = $model->get_categories_filter();

		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Danh sách kho', 1 => 
			FSRoute::_("index.php?module=".$this-> module."&view=".$this-> view));	
		global $tmpl;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );

		include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
	}

	function edit()
	{
		$ids = FSInput::get('id',array(),'array');
		$id = $ids[0];
		$model = $this -> model;
		$data = $model->get_record_by_id($id);

		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Danh sách kho', 1 => 
			FSRoute::_("index.php?module=".$this-> module."&view=".$this-> view));	
		global $tmpl;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );


		include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
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

?>