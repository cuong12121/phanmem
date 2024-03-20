<?php
class ReceiptControllersReceipt extends Controllers
{
	function __construct()
	{
		$this->view = 'receipt' ; 
		parent::__construct(); 
		$this -> arr_sv = array(1=>'Dịch vụ thay thế',2=>'Dịch vụ ép kính',3=>'Bảo hành sửa chữa',4=>'Bảo hành bán máy', 5=> 'Bảo hành cửa hàng');

		$this -> arr_step = array(0=>'<span class="new">Mới tiếp nhận</span>',1=>'<span class="new">Mới chuyển cho kỹ thuật</span>',2=>'<span class="yeucau">Yêu cầu linh kiện</span>',3=>'<span class="suaing">Đã duyệt linh kiện</span>',4=>'<span class="suaing">Đang sửa chữa</span>',5=>'<span class="sua_xong">Mới sửa xong</span>', 6=> '<span class="cho_khach">Chờ khách lấy</span>', 7=>'<span class="hoan_tat">Đã hoàn tất</span>');

		$this -> arr_step_loc = array(1=>'<span class="new">Mới tiếp nhận</span>',2=>'<span class="new">Mới chuyển cho kỹ thuật</span>',3=>'<span class="yeucau">Yêu cầu linh kiện</span>',4=>'<span class="suaing">Đã duyệt linh kiện</span>',5=>'<span class="suaing">Đang sửa chữa</span>',6=>'<span class="sua_xong">Mới sửa xong</span>', 7=> '<span class="cho_khach">Chờ khách lấy</span>', 8=>'<span class="hoan_tat">Đã hoàn tất</span>');

		$this -> arr_cstatus = array(1=>'Màn hình hiển thị',2=>'Mặt kính / Cảm ứng',3=>'Wifi / Bluetooth / NFC / GPS',4=>'Sóng 2G / 3G', 5=> 'Bộ nhớ trong / Thẻ nhớ', 6=>'Camera / Đèn Flash',7=>'Loa / Mic / Rung',8=>'Cảm biến tiệm cận / Xoay',9=>'Cảm biến vân tay (IP/SS)',10=>'Các phím cứng',11=>'Hình thức',12=>'Nội dung khác',13=>'Tk iCloud (Apple)',14=>'Mật khẩu máy');
	}
	function display()
	{
		parent::display();
		$sort_field = $this -> sort_field;
		$sort_direct = $this -> sort_direct;
		$model  = $this -> model;
		$list = $model->get_data();	
		$services = $this -> arr_sv;
		$step = $this -> arr_step_loc;
		$pagination = $model->getPagination();
		$province = $model->get_categories_tree2();
		include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';

	}

	function add()
	{
		$model = $this -> model;
		$dataCity = $model->get_city(); 
		$arrsv = $this -> arr_sv;
		include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
	}
	
	function edit(){
		$id = FSInput::get('id');
		$model  = $this -> model;
		$data = $model->get_record_by_id($id);
		//print_r($customer);
		$categories = $model->get_categories_tree();
		$days = $model -> get_days($data -> id);
		include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
	}

	function view(){
		global $is_kythuat,$is_letan;
		$id = FSInput::get('id');
		$model  = $this -> model;
		$data = $model->get_record_by_id($id);
		$customer_id = $data-> customer_id;
		$customer =  $model->get_customer_by_id($customer_id);
		$list_lk = $model-> get_records('receipt_id = '.$data-> id,'fs_accessories_coupon_detail');
		$list_lk_c = $model-> get_records('receipt_id = '.$data-> id.' AND status=1','fs_accessories_coupon_detail');
		if($is_letan){
			$kythuat = $model->get_kythuat_chuyen(); 
			if($data-> create_user_id ==  $_SESSION['ad_userid']){
				$permission_letan = 1;
			}
			else {
				$permission_letan = 0;
			}
		}

		if($is_kythuat) {
			if($data-> technical_id != $_SESSION['ad_userid']) {
				echo 'Bạn không có quyền xử lý phiếu này';
				return;
			}
		}

		$coupon = $model->get_coupon_by_id($id);
		//print_r($kythuat);
		$arrsv = $this -> arr_sv;
		//print_r($customer);
		$dataCity = $model->get_city(); 
		$categories = $model->get_categories_tree();
		$days = $model -> get_days($data -> id);
		include 'modules/'.$this->module.'/views/'.$this->view.'/view.php';
	}

	function see(){
		$id = FSInput::get('id');
		$model  = $this -> model;
		$data = $model->get_record_by_id($id);
		$configs = $model -> get_config();
		$customer_id = $data-> customer_id;
		$customer =  $model->get_customer_by_id($customer_id);
		$config = array();
		$model = $this->model;
		$arrsv = $this -> arr_sv;
		$arrsts = $this -> arr_cstatus ;
	//	FSFactory::include_class ( 'tfpdf', 'tfpdf' );
		foreach ($configs as $itemcf) {
			$config[$itemcf->name] = $itemcf->value;
		}

		$fpdf = tFPDF(); 
		$fpdf->AddPage();
		$fpdf->SetFont('Arial','B',16);
		$fpdf->AddFont('Roboto','','Roboto-Regular.ttf',true);
		$fpdf->AddFont('RobotoBold','','Roboto-Bold.ttf',true);

		$fpdf-> SetX(95);
		$fpdf->Cell(40, 20, $fpdf->Image(URL_ROOT.$config['logo'], $fpdf->GetX(), $fpdf->GetY(), 0), 0, 0, 'C');
		$fpdf-> Ln();

		$fpdf->SetFont('RobotoBold','',20);
		$fpdf->Cell(190,10,'PHIẾU NHẬN MÁY',0,0,'C');
		$fpdf-> Ln();

		$date = getdate();
		$time = 'Ngày '.$date['mday'].' tháng '.$date['mon'].' năm '.$date['year'];
		
		$fpdf->SetFont('Roboto','',9);
		// $fpdf->Cell(100,5,'');	
		$fpdf->Cell(190,5,'Số phiếu: '.$id,0,0,'R');	
		$fpdf-> Ln();

		$fpdf->SetFont('Roboto','',9);
		// $fpdf->Cell(100,5,'');	
		$fpdf->Cell(190,5,$time,0,0,'R');	
		$fpdf-> Ln();
		$fpdf-> Ln();

		$fpdf->SetFont('Roboto','',11);
		//$fpdf->Cell(100,5,'');	
		$fpdf->Cell(100,5,'Khách hàng: '.@$data-> customer_name,0,0,'L');	
		$fpdf->Cell(100,5,'Điện thoại: '.@$data-> customer_phone,0,0,'L');	
		$fpdf-> Ln();
		$fpdf->Cell(100,5,'Địa chỉ: '.@$customer-> address,0,0,'L');	
		$fpdf-> Ln();
		$fpdf->Cell(100,5,'Loại máy: '.@$data-> machine_type,0,0,'L');	
		$fpdf->Cell(100,5,'IMEI: '.@$data-> imei,0,0,'L');
		$fpdf-> Ln();
		$fpdf-> Ln();
		$fpdf->Cell(190,6,'Thông tin tình trạng máy',1,0,'C');	
		$fpdf-> Ln();
		$j=0;
		for($i=1; $i<=12; $i++) {
			$txt_i = 'status'.$i;
			if($data-> $txt_i != 'Bình thường') {
				$j++;
				$fpdf->Cell(95,6,$arrsts[$i].':'.$data-> $txt_i,1,0,'L');
				if($j%2 == 0) {
					$fpdf-> Ln();
				}
			}
		}
		$k = 0;
		for($h=1; $h<=12; $h++) {
			$txt_h = 'status'.$h;
			if($data-> $txt_i != 'Bình thường') {
				$k++;
			}
		}
		if($k==0) {
			$fpdf->Cell(190,6,'Tình trạng bình thường',1,0,'L');	
		}
		
	//	die();
		$fpdf-> Ln();
		$fpdf-> Ln();
		$fpdf->Cell(100,5,'Nội dung sửa chữa: '.@$data-> more_info,0,0,'L');
		$fpdf-> Ln();
		$fpdf->Cell(100,5,'Loại hình dịch vụ: '.@$arrsv[@$data-> services],0,0,'L');
		$fpdf->Cell(100,5,'Xác xuất rủi ro: '.@$data-> sxrr,0,0,'L');
		$fpdf-> Ln();
		$return_time = new DateTime($data-> return_time);
		$fpdf->Cell(100,5,'Thời gian nhận máy: '.@$return_time-> format('H:i:s d/m/Y'),0,0,'L');
		$fpdf-> Ln();
		$fpdf->Cell(100,5,'Giá thanh toán: '.number_format(@$data-> total).' VNĐ',0,0,'L');
		$fpdf-> Ln();
		$fpdf-> Ln();
		$fpdf->Cell(100,5,'Lưu ý: '.$config['note'],0,0,'L');
		$fpdf-> Ln();
		$fpdf-> Ln();
		$fpdf->Cell(100,5,'Nhân viên kỹ thuật',0,0,'C');
		$fpdf->Cell(100,5,'Khách hàng',0,0,'C');
		$fpdf-> Ln();
		$fpdf->SetFont('Roboto','',8);
		$fpdf->Cell(100,4,'(Ký & ghi rõ họ tên)',0,0,'C');
		$fpdf->Cell(100,4,'(Ký & ghi rõ họ tên)',0,0,'C');
		//$fpdf->Cell(100,5,'Điện thoại: '.$data-> customer_phone,0,0,'L');
		$fpdf->Output('Phieu_nhan_'.$data->id,'I'); // Send to browser and display
	}



	function loadDistricts(){
		$city_id = FSInput::get('city_id');
		global $config;
		$listDistricts = $this->model->getListDistricts($city_id);
		$html = '';
		foreach($listDistricts as $item){
			$html .= '<option  value="'.$item->id.'">'.$item->name.'</option>';
		}
		echo $html;
	}

	function loadcustomer(){
		$phone = FSInput::get('phone');
		global $config;
		$listcustomer = $this->model->getListCustomer($phone);
		$html = '';
		if(!empty($listcustomer)) {
			foreach($listcustomer as $item){
				$html .= '<li onclick="add_cus(`'.$item-> phone.'`,`'.$item-> name.'`,`'.$item-> imei.'`,`'.$item-> device_name.'`)">'.$item-> phone.' - '.$item-> name.'</li>';
			}
		} else {
			// $html = '<li class="customer_empty"></li>';
		}
		echo $html;
	}

	function loadcustomer3(){
		$imei = FSInput::get('imei');
		global $config;
		$listcustomer = $this->model->getListCustomer3($imei);
		$html = '';
		if(!empty($listcustomer)) {
			foreach($listcustomer as $item){
				$html .= '<li onclick="add_cus(`'.$item-> phone.'`,`'.$item-> name.'`,`'.$item-> imei.'`,`'.$item-> device_name.'`)">'.$item-> phone.' - '.$item-> name.'</li>';
			}
		} else {
			// $html = '<li class="customer_empty"></li>';
		}
		echo $html;
	}

	function loadcustomer2(){
		$name = FSInput::get('name');
		global $config;
		$listcustomer = $this->model->getListCustomer2($name);
		$html = '';
		if(!empty($listcustomer)) {
			foreach($listcustomer as $item){
				$html .= '<li onclick="add_cus(`'.$item-> phone.'`,`'.$item-> name.'`,`'.$item-> imei.'`,`'.$item-> device_name.'`)">'.$item-> phone.' - '.$item-> name.'</li>';
			}
		} else {
			// $html = '<li class="customer_empty"></li>';
		}
		echo $html;
	}

	function loadcustomer_receipt(){
		$name = FSInput::get('name');
		$stt = FSInput::get('stt');
		global $config;
		$listcustomer = $this->model->getListCustomer_receip($name);
		$html = '';
		if(!empty($listcustomer)) {
			foreach($listcustomer as $item){
				if($stt==0) {
					$html .= '<li onclick="add_cus('.$item-> id.',`'.$item-> name.'`,`0`)">'.$item-> name.'</li>';
				}else {
					$html .= '<li onclick="add_cus('.$item-> id.',`'.$item-> name.'`,`'.$stt.'`)">'.$item-> name.'</li>';
				}
				
			}
		} else {
			// $html = '<li class="customer_empty"></li>';
		}
		echo $html;
	}

	function savetechnical(){
		$model  = $this -> model;
		$tech = $model -> savetechnical();
	}

	function savelinh_kien(){
		$model  = $this -> model;
		$tech = $model -> savelinh_kien();
	}

	function saveylinh_kien(){
		$model  = $this -> model;
		$tech = $model -> saveylinh_kien();
	}

	

	function savestep7(){
		$model  = $this -> model;
		$tech = $model -> savestep7();
	}

	function savestep4(){
		$model  = $this -> model;
		$tech = $model -> savestep4();
	}

	function savestep5(){
		$model  = $this -> model;
		$tech = $model -> savestep5();
	}

	function savestep6(){
		$model  = $this -> model;
		$tech = $model -> savestep6();
	}




}

function view_services($controle ,$sevices) {
	$arr_sv = $controle ->arr_sv;
	if ($sevices > 0)
		return $arr_sv[$sevices];
}

function view_step($controle ,$step) {
	$arr_step = $controle ->arr_step;
	return $arr_step[$step];
}

?>
