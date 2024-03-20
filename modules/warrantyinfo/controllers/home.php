<?php
/*
 * Huy write
 */
	// controller
class WarrantyinfoControllersHome extends FSControllers
{
	var $module;
	var $view;
	function display()
	{
			// call models
		$model = $this -> model;
		$query_body = $model->set_query_body();
		$list = $model->get_list($query_body);
		$total = $model->getTotal($query_body);
		$pagination = $model->getPagination($total);
		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Thông tin bảo hành',1=> '',2=>"h1");
		global $tmpl;	
		$tmpl -> assign('breadcrumbs', $breadcrumbs);
		$tmpl -> set_seo_special();

			// call views			
		include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
	}


	function warranty_save(){
		$return = FSInput::get ( 'return' );
		$url = base64_decode ( $return );
		$model = $this->model;
		$imei =  $model->get_imei();
		if (mysqli_num_rows(mysqli_query("SELECT imei FROM fs_warranty_info WHERE imei='".$imei."'")) > 0)
		{
			echo "IMEI máy này đã được sử dụng, mời bạn nhập mã máy khác.";
			exit;
		}
		else{
			$id = $model->warranty_save ();
			if (! $id) {
				$msg = 'Chưa gửi thành công!';
				setRedirect ( $url, $msg, 'error' );
			} else {
				setRedirect ( $url, 'Kích hoạt bảo hành thành công, xin cảm ơn' );
			}
		}

	}

	function fetch_warranty(){
		$phone = FSInput::get('phone');
		if(!$phone){
			return;
		}
		$model = $this -> model;
		$data = $model->get_records("published = 1 AND (phone = '".$phone."' OR imei = '".$phone."') ",'fs_warranty_info');
		include 'modules/'.$this->module.'/views/'.$this->view.'/default_ajax.php';
		return;
	}

	function fetch_warranty2(){
		$phone = FSInput::get('phone');
		if(!$phone){
			return;
		}
		$model = $this -> model;
		$info = $data = $model->get_record("published = 1 AND (phone = '".$phone."' OR imei = '".$phone."') ",'fs_warranty_info');
		$data = $model->get_record("end_time = '0000-00-00' AND (phone = '".$phone."' OR imei = '".$phone."')",'fs_receipt');
		include 'modules/'.$this->module.'/views/'.$this->view.'/default_ajax2.php';
		return;
	}
}

?>