<?php
	// models 
//	include 'modules/'.$module.'/models/'.$view.'.php';

class EmployeeControllersCreate_order extends Controllers
{
	function __construct()
	{
		$this->view = 'create_order' ; 
		parent::__construct();
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
		$array_status = $this -> arr_status;
		$array_plan = $this -> arr_plan;
		$array_import = $this -> arr_import;
		$pagination = $model->getPagination();
	
		include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';

		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Yêu cấp nhập sản phẩm, link kiện', 1 => '');	

		global $tmpl;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );
	}

	function add()
	{
		$model = $this -> model;
		
	
		$maxOrdering = $model->getMaxOrdering();
		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Yêu cấp nhập sản phẩm, link kiện', 1 => 
			FSRoute::_("index.php?module=".$this-> module."&view=".$this-> view));	
		global $tmpl;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );
		$array_status = $this -> arr_status;
		$array_plan = $this -> arr_plan;
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
		$array_plan = $this -> arr_plan;
		$array_import = $this -> arr_import;
		$employees = $model -> get_records('group_id = 3','fs_users');
		// dd($employees);
		// $users = $model -> get_record('id = ' . $_SESSION['ad_userid'],'fs_users');
	
		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Yêu cấp nhập sản phẩm, link kiện', 1 => 
			FSRoute::_("index.php?module=".$this-> module."&view=".$this-> view));	
		global $tmpl;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );

		if($_SESSION['ad_groupid'] == 1 && $data->creator_id != $_SESSION['ad_userid']){
			echo "Đây không phải bài bạn tạo!";
		}else{
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
		
	}


	function ajax_warranty_change(){
		$id = FSInput::get('id');
		$warehouses_id = FSInput::get('warehouses_id');
		$respon = array();
		$respon ['error'] = true;
		$model = $this -> model;

		$row = array();
		$row['agree_id'] = $_SESSION['ad_userid'];
		$row['warehouses_id'] = $warehouses_id;
		$row['status_type_1'] = 1;
		$update_id = $model-> _update($row,'fs_warranty','id = '.$id);
		if($update_id){
			$respon ['error'] = false;
			$respon ['message'] = 'Đã duyệt';
			echo json_encode ( $respon );
		}else{
			$respon ['message'] = 'Có lỗi xảy ra !';
			echo json_encode ( $respon );
		}
		return;
	}

	function ajax_return(){
		$id = FSInput::get('id');
		$warehouses_id = FSInput::get('warehouses_id');
		$respon = array();
		$respon ['error'] = true;
		$model = $this -> model;

		$row = array();
		$row['agree_id'] = $_SESSION['ad_userid'];
		$row['warehouses_id'] = $warehouses_id;
		$row['status_type_2'] = 1;
		$update_id = $model-> _update($row,'fs_warranty','id = '.$id);
		if($update_id){
			$data = $model-> get_record('id = '.$id,'fs_warranty');
			$product = $model-> get_record('code = "'.$data->code.'"','fs_products');
			$warehouses_product = $model-> get_record('product_id ='.$product->id. ' AND warehouses_id = '.$warehouses_id,'fs_warehouses_products');
			if(!empty($warehouses_product)){
				$row2 = array();
				$row2['amount'] = $warehouses_product->amount + $data->amount;
				$update_id2 = $model-> _update($row2,'fs_warehouses_products','id = '.$warehouses_product->id);
			}else{
				$row2 = array();
				$row2['amount'] = $data->amount;
				$row2['product_id'] = $product->id;
				$row2['warehouses_id'] = $warehouses_id;
				$add_id = $model-> _add($row2,'fs_warehouses_products');
			}
			$respon ['error'] = false;
			$respon ['message'] = 'Đã duyệt';
			echo json_encode ( $respon );
		}else{
			$respon ['message'] = 'Có lỗi xảy ra !';
			echo json_encode ( $respon );
		}
		return;
	}


	function ajax_warranty_accept(){
		$id = FSInput::get('id');
		$respon = array();
		$respon ['error'] = true;
		$model = $this -> model;
		$row = array();
		$row['agree_id'] = $_SESSION['ad_userid'];
		$row['status_type_3'] = 1;
		$update_id = $model-> _update($row,'fs_warranty','id = '.$id);
		if($update_id){
			$respon ['error'] = false;
			$respon ['message'] = 'Đã mang đi sửa';
			echo json_encode ( $respon );
		}else{
			$respon ['message'] = 'Có lỗi xảy ra !';
			echo json_encode ( $respon );
		}
		return;
	}

	function ajax_warranty_return(){
		$id = FSInput::get('id');
		$respon = array();
		$respon ['error'] = true;
		$model = $this -> model;
		$row = array();
		$row['agree_id'] = $_SESSION['ad_userid'];
		$row['status_type_3'] = 2;
		$update_id = $model-> _update($row,'fs_warranty','id = '.$id);
		if($update_id){
			$respon ['error'] = false;
			$respon ['message'] = 'Đã sửa xong';
			echo json_encode ( $respon );
		}else{
			$respon ['message'] = 'Có lỗi xảy ra !';
			echo json_encode ( $respon );
		}
		return;
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

function view_plan($controle,$status){
	$model = $controle -> model;
	$array_plan = array('1'=>'Mua trực tiếp','2'=>'Xin hoặc mua kèm lô tiếp');
	if(empty($array_plan[$status])){
		return "";
	}
	return $array_plan[$status];
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



	
	

?>