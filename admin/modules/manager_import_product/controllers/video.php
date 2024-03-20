<?php
	// models 
//	include 'modules/'.$module.'/models/'.$view.'.php';

class WarrantyControllersVideo extends Controllers
{
	function __construct()
	{
		$this->view = 'create_order' ; 
		parent::__construct();
		$array_status = array('0'=>'Chưa xử lý','1'=>'Đã quay');
		$this -> arr_status = $array_status; 
	}
	function display()
	{
		parent::display();
		$sort_field = $this -> sort_field;
		$sort_direct = $this -> sort_direct;

		$model  = $this -> model;
		$list = $model->get_data();
		$array_status = $this -> arr_status;
		$pagination = $model->getPagination();
		$platforms = $model -> get_records('published = 1','fs_platforms');
		include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';

		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Đổi trả', 1 => '');	

		global $tmpl;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );
	}

	function add()
	{
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


		$maxOrdering = $model->getMaxOrdering();
		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Đổi trả', 1 => 
			FSRoute::_("index.php?module=".$this-> module."&view=".$this-> view));	
		global $tmpl;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );
		$array_status = $this -> arr_status;
		include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
	}

	function edit()
	{
		$ids = FSInput::get('id',array(),'array');
		$id = $ids[0];
		$model = $this -> model;
		$data = $model->get_record_by_id($id);
		$array_status = $this -> arr_status;
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
		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Đổi trả', 1 => 
			FSRoute::_("index.php?module=".$this-> module."&view=".$this-> view));	
		global $tmpl;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );

		if($_SESSION['ad_groupid'] == 1 && $data->creator_id != $_SESSION['ad_userid']){
			echo "Đây không phải bài bạn tạo!";
		}else{
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
		
	}

}


function view_status($controle,$status){
	$model = $controle -> model;
	$array_status = array('0'=>'Chưa xử lý','1'=>'Đã quay');
	return $array_status[$status];
}
function view_star($controle,$star){
	$model = $controle -> model;
	if($star == 0 || $star == ''){
		return '';
	}
	return $star;
}


	
	

?>