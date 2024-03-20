<?php
class WarehousesControllersPositions_categories extends Controllers
{
	function __construct()
	{
		$this->view = 'positions_categories' ; 
		parent::__construct(); 
	}
	function display()
	{
		parent::display();
		$sort_field = $this -> sort_field;
		$sort_direct = $this -> sort_direct;

		$model  = $this -> model;
		// $list = $this -> model->get_data('');
		$list = $this -> model->get_categories_tree();

		$warehouses_all = $model-> get_records('1 = 1','fs_warehouses','*');

		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Danh mục vị trí', 1 => '');	
		global $tmpl;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );

		// print_r($list);

		$pagination = $model->getPagination('');
		include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
	}

	function add(){

		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Danh mục vị trí', 1 => 
			FSRoute::_("index.php?module=".$this-> module."&view=".$this-> view));	
		global $tmpl;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );

		$model = $this -> model;
		$warehouses_id = FSInput::get('warehouses_id');

		if($warehouses_id){
			$warehouses = $model-> get_record('id = '.$warehouses_id,'fs_warehouses','*');
			$categories = $model->get_categories_tree_warehouses($warehouses_id);
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		} else {
			$warehouses = $model->get_warehouses_tree();
			include 'modules/'.$this->module.'/views/'.$this -> view.'/select_categories.php';
		}
	}

	function edit(){

		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Danh mục vị trí', 1 => 
			FSRoute::_("index.php?module=".$this-> module."&view=".$this-> view));	
		global $tmpl;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );

		$ids = FSInput::get('id',array(),'array');
		$id = $ids[0];
		$model = $this -> model;

		$data = $model->get_record_by_id($id);

		$list_positions = $model-> get_records('category_id = '.$data-> id,'fs_warehouses_positions','*');

		$warehouses = $model-> get_record('id = '.$data-> warehouses_id,'fs_warehouses','*');
		$categories = $model->get_categories_tree_warehouses($data-> warehouses_id);

		include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
	}

			function cdelete(){
			$model  = $this -> model;
			$rs = $model -> cdelete();
		}
}

function count_position($controle, $id){
	$model  = $controle -> model;
	$count = $model-> get_record('category_id = '.$id,'fs_warehouses_positions','count(id) as count') -> count;

	return $count;
}

?>