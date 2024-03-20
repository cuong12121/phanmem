<?php
	// models 
//	include 'modules/'.$module.'/models/'.$view.'.php';

class WarehousesControllersImport_warning extends Controllers
{
	function __construct()
	{
			// parent::display();
			// $sort_field = $this -> sort_field;
			// $sort_direct = $this -> sort_direct;
		$this->view = 'import_warning' ; 
		parent::__construct(); 
	}
	function display()
	{
		parent::display();
		$sort_field = $this -> sort_field;
		$sort_direct = $this -> sort_direct;

		$model  = $this -> model;

		if(@$_SESSION [$model->prefix . 'text0']) {
			$check_number_day = $_SESSION [$model->prefix . 'text0'];
		} else {
			$check_number_day = 20;
		}

		$date = date('Y-m-d');
		$day_check_start = strtotime ( '-'.$check_number_day.' day' , strtotime ( $date ) ) ;
		$day_check_start = date ( 'Y-m-d' , $day_check_start ).' 00:00:00';

		$where = '';
		$where .= 'AND d.created_time > "'.$day_check_start.'"';

		if(@$_SESSION [$model->prefix . 'keysearch']) {
			$where .= ' AND (a.name LIKE "%'.$_SESSION [$model->prefix . 'keysearch'].'%" OR a.code LIKE "%'.$_SESSION [$model->prefix . 'keysearch'].'%")';
		}


		$list_order_details_products = $model-> get_records('1=1 '.$where.' GROUP BY a.id','fs_products AS a 
			INNER JOIN fs_order_uploads_detail as d
			ON a.id = d.product_id','a.id,a.name,a.code, sum(d.count) as total');

		$list = array();

		foreach ($list_order_details_products as $key=> &$product) {
			$amount_w = $model-> get_record('product_id = '.$product-> id,'fs_warehouses_products','sum(amount) as sum_amount, sum(amount_hold) as sum_amount_hold, sum(amount_wait_transfer) as sum_amount_wait_transfer');
			if(!empty($amount_w)) {
				$product-> amount_sell = $amount_w-> sum_amount + $amount_w-> sum_amount_wait_transfer - $amount_w-> sum_amount_hold;
			} else {
				$product-> amount_sell = 0;
			}
			$product-> amount_import = $product-> total - $product-> amount_sell;

			if($product-> amount_sell < $product-> total) {
				$list[] = $product;
			} 
			// code...
		}

		usort($list, function($a, $b) {
			return $a->amount_import < $b->amount_import ? 1 : -1;
		});

		// echo '====<pre>';
		// print_r($list_order_details_products);
		// echo '</pre>';
		// echo $day_check_start;

		
		// $list = $model->get_data();
		// $categories = $model->get_categories_tree();
		// $pagination = $model->getPagination();
		include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';

		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Cảnh báo nhập hàng', 1 => '');	

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