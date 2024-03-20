<?php
	// models 
//	include 'modules/'.$module.'/models/'.$view.'.php';

class WarehousesControllersSupplier extends Controllers
{
	function __construct()
	{
			// parent::display();
			// $sort_field = $this -> sort_field;
			// $sort_direct = $this -> sort_direct;
		$this->view = 'supplier' ; 
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

		$pagination = $model->getPagination();
		include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';

		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Nhà cung cấp', 1 => '');	

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
		$breadcrumbs[] = array(0=>'Danh sách nhà cung cấp', 1 => 
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
		$breadcrumbs[] = array(0=>'Danh sách nhà cung cấp', 1 => 
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

?>