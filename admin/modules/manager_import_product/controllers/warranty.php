<?php
	// models 
//	include 'modules/'.$module.'/models/'.$view.'.php';

class WarrantyControllersWarranty extends Controllers
{
	function __construct()
	{
		// parent::display();
		// $sort_field = $this -> sort_field;
		// $sort_direct = $this -> sort_direct;
		$this->view = 'warranty' ; 
		parent::__construct(); 
	}
	function display()
	{
		parent::display();
		$sort_field = $this -> sort_field;
		$sort_direct = $this -> sort_direct;

		$model  = $this -> model;
		$list = $model->get_data();
		$types = array('1'=>'Đổi','2'=>'Trả','3'=>'Bảo hành');
		$warrantys = $model->get_records('published = 1','fs_warehouses');

		
		$pagination = $model->getPagination();
		include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';

		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Bảo hành', 1 => '');	

		global $tmpl;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );
	}

	function add()
	{
		$model = $this -> model;
		$maxOrdering = $model->getMaxOrdering();
		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Bảo hành', 1 => 
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
		if($data-> status_type_1 != 0 || $data-> status_type_2 != 0 || $data-> status_type_3 != 0 ){
			setRedirect(FSRoute::_('index.php?module=warranty&view=warranty'),$rows.' '.FSText :: _('Đã duyệt, không sửa được nữa'),'error');	
		}

		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Bảo hành', 1 => 
			FSRoute::_("index.php?module=".$this-> module."&view=".$this-> view));	
		global $tmpl;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );


		include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
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

	function view_actions($controle,$id){
		$model = $controle -> model;
		$data = $model->get_record('id = ' .$id,'fs_warranty','*');
		$txt ="";
		if($data-> type == 1){
			$permission = FSSecurity::check_permission_groups('warranty','warranty','ajax_change');
        	if($permission && $data-> status_type_1 != 1){
				$txt .="<a class='btn-row btn-change-".$id."' onclick='is_change(".$id.")' href='javascript:void(0)'>Duyệt đổi</a>";
				$txt .="<div class='ct-change-".$id."'></div>";
			}elseif($data-> status_type_1 == 1){
				$txt .= "Đã duyệt";
			}else{
				$txt .= "Chưa duyệt";
			}
		}elseif($data-> type == 2){
			$permission = FSSecurity::check_permission_groups('warranty','warranty','ajax_return');
        	if($permission && $data-> status_type_2 != 1){
				$txt .="<a class='btn-row btn-return-".$id."' onclick='is_return(".$id.")' href='javascript:void(0)'>Duyệt trả</a>";
				$txt .="<div class='ct-return-".$id."'></div>";
			}elseif($data-> status_type_2 == 1){
				$txt .= "Đã duyệt";
			}else{
				$txt .= "Chưa duyệt";
			}
		}elseif($data-> type == 3){
			$permission = FSSecurity::check_permission_groups('warranty','warranty','ajax_warranty_accept');
			$permission_return = FSSecurity::check_permission_groups('warranty','warranty','ajax_warranty_return');
        	if($permission && $data-> status_type_3 == 0){
				$txt .="<a class='btn-row  btn-warranty-accept-".$id."' onclick='is_warranty_accept(".$id.")' href='javascript:void(0)'>Mang đi sửa</a>";
				//$txt .="<a class='btn-row btn-warranty-no-accept btn-warranty-no-accept-".$id."' onclick='is_warranty_no_accept(".$id.")' href='javascript:void(0)'>Không chấp nhận</a>";
				$txt .="<div class='ct-warranty-".$id."'></div>";
			}elseif($permission_return && $data-> status_type_3 == 1){
				$txt .="<a class='btn-row btn-warranty-return-".$id."' onclick='is_warranty_return(".$id.")' href='javascript:void(0)'>Đã sửa xong</a>";
				$txt .="<div class='ct-warranty-".$id."'></div>";
			}elseif($data-> status_type_3 == 2){
				$txt .= "Đã sửa xong";
			}
		}
		return $txt;
	}

?>