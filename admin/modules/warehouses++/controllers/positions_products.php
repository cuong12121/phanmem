<?php
	// models 
//	include 'modules/'.$module.'/models/'.$view.'.php';

class WarehousesControllersPositions_products extends Controllers
{
	function __construct()
	{
			// parent::display();
			// $sort_field = $this -> sort_field;
			// $sort_direct = $this -> sort_direct;
		$this->view = 'positions_products' ; 
		parent::__construct(); 
	}
	function display()
	{
		parent::display();
		$sort_field = $this -> sort_field;
		$sort_direct = $this -> sort_direct;

		$model  = $this -> model;
		$list = $model->get_data();
		$categories = $model->get_categories_tree();

		$warehouses = $model->get_records('1=1','fs_warehouses','*');

		$pagination = $model->getPagination();
		include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';

		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Vị trí sản phẩm', 1 => '');	

		global $tmpl;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );
	}

	function add()
	{
		die;
		$model = $this -> model;
		$categories = $model->get_categories_tree();
		$maxOrdering = $model->getMaxOrdering();

		$categories_product = $model->get_categories_product_tree();
		$categories_filter = $model->get_categories_filter();



		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Danh sách Vị trí sản phẩm', 1 => 
			FSRoute::_("index.php?module=".$this-> module."&view=".$this-> view));	
		global $tmpl;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );

		include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
	}

	function edit()
	{
		die;
		$ids = FSInput::get('id',array(),'array');
		$id = $ids[0];
		$model = $this -> model;
		$data = $model->get_record_by_id($id);

		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Danh sách Vị trí sản phẩm', 1 => 
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


}

function show_type($controle, $type){
	$arr_type = array('1'=>'Cá nhân','2'=>'Doanh nghiệp');
	return $arr_type[$type];
}



function show_product_code($controle, $id){
	$model = $controle-> model;
	$product = $model-> get_record('id = '.$id,'fs_products','*');
	return $product-> code;
}

function show_product_barcode($controle, $id){
	$model = $controle-> model;
	$product = $model-> get_record('id = '.$id,'fs_products','*');
	return $product-> barcode;
}


function show_product_name($controle, $id){
	$model = $controle-> model;
	$product = $model-> get_record('id = '.$id,'fs_products','*');
	return $product-> name;
}

function show_position_list_code($controle, $id){
	$model = $controle-> model;
	$product = $model-> get_record('id = '.$id,'fs_warehouses_positions','*');
	return $product-> list_code;
}

function show_position_name($controle, $id){
	$model = $controle-> model;
	$product = $model-> get_record('id = '.$id,'fs_warehouses_positions','*');
	return $product-> list_parents_name.' > '.$product-> name;
}

?>