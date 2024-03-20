<?php
class EmployeeControllersUpdate_products extends Controllers
{
	function __construct()
	{
		$this->view = 'update_products' ; 
		parent::__construct();
		$array_find = array('1'=>'Chưa tìm được','2'=>'Đã tìm được');
		$this -> array_find = $array_find; 

		$array_status = array('1'=>'Chưa xử lý','2'=>'Hoàn thành');
		$this -> arr_status = $array_status; 

		$array_plan = array('1'=>'Mua trực tiếp','2'=>'Xin hoặc mua kèm lô tiếp');
		$this -> arr_plan = $array_plan; 

		$array_import = array('1'=>'Chưa duyệt','2'=>'Đã duyệt');
		$this -> arr_import = $array_import;
	}
	function display()
	{
		parent::display();
		$sort_field = $this -> sort_field;
		$sort_direct = $this -> sort_direct;

		$model  = $this -> model;
		$list = $model->get_data();
		// dd($list);
		$array_status = $this -> arr_status;
		$array_find = $this -> array_find;
		$array_import = $this -> arr_import;
		$pagination = $model->getPagination();
		//$platforms = $model -> get_records('published = 1','fs_platforms');
		include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';

		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Nâng cấp chất lượng sản phẩm', 1 => '');	

		global $tmpl;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );
	}

	function add()
	{
		$model = $this -> model;
		//$platforms = $model -> get_records('published = 1','fs_platforms');
		$maxOrdering = $model->getMaxOrdering();
		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Nâng cấp chất lượng sản phẩm', 1 => 
			FSRoute::_("index.php?module=".$this-> module."&view=".$this-> view));	
		global $tmpl;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );
		$array_status = $this -> arr_status;
		$array_find = $this -> array_find;
		$array_import = $this -> arr_import;
		include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
	}

	function edit()
	{
		$ids = FSInput::get('id',array(),'array');
		$id = $ids[0];
		$model = $this -> model;
		$data = $model->get_record_by_id($id);
		$array_status = $this -> arr_status;
		$array_find = $this -> array_find;
		$array_import = $this -> arr_import;
		$employees = $model -> get_records('group_id = 3','fs_users');
		//$platforms = $model -> get_records('published = 1','fs_platforms');
		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Nâng cấp chất lượng sản phẩm', 1 => 
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


function view_find($controle,$status){
	$model = $controle -> model;
	$array_find = array('1'=>'Chưa tìm được','2'=>'Đã tìm được');
	return !empty($array_find[$status]) ? $array_find[$status] : $array_find[1];
}


function view_employee($controle,$user_id){
	$model = $controle -> model;
	$employees = $model -> get_records('group_id = 3','fs_users','id,fullname,username','','','id');
	if(!$user_id){
		return "";
	}
	if(!empty($employees[$user_id])){
		return $employees[$user_id]->fullname ? $employees[$user_id]->fullname : $employees[$user_id]->username;
	}else{
		return "";
	}
	
}

function view_import($controle,$status){
	$model = $controle -> model;
	$array_import = array('1'=>'Chưa duyệt','2'=>'Đã duyệt');
	if(empty($array_import[$status])){
		return "";
	}
	return $array_import[$status];
}

function view_status($controle,$status){
	$model = $controle -> model;
	$array_status = array('1'=>'Chưa xử lý','2'=>'Hoàn thành');
	return $array_status[$status];
}
function view_star($controle,$star){
	$model = $controle -> model;
	if($star == 0 || $star == ''){
		return '';
	}
	return $star;
}

function view_creator($controle,$id){
	$model = $controle -> model;
	$users = $model -> get_record('id = ' . $id,'fs_users');
	
	return $users->fullname ? $users->fullname : $users->username;
}
	
	

?>