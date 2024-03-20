<?php
class Manager_import_productControllersCreate_order extends Controllers
{
	function __construct()
	{
		$this->view = 'create_order' ; 
		parent::__construct();

		$array_find = array('1'=>'Chưa tìm được','2'=>'Đã tìm được');
		$this -> array_find = $array_find; 

		$array_status = array('1'=>'Chưa xử lý','2'=>'Hoàn thành','3'=>'Không hoàn thành','4'=>'Đang xử lý');
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
		$array_import = $this -> arr_import;
		$users = $model -> get_records('','fs_users','fullname,username,id','','','id');
		$array_plan = $this -> arr_plan;
		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Yêu cấp nhập sản phẩm, link kiện', 1 => '');	

		global $tmpl;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );
		include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
	}

	function add()
	{
		$model = $this -> model;
		//$platforms = $model -> get_records('published = 1','fs_platforms');
		$maxOrdering = $model->getMaxOrdering();
		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Yêu cấp nhập sản phẩm, link kiện', 1 => 
			FSRoute::_("index.php?module=".$this-> module."&view=".$this-> view));	
		global $tmpl;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );
		$array_status = $this -> arr_status;
		$array_find = $this -> array_find;
		$array_import = $this -> arr_import;
		$array_plan = $this -> arr_plan;
		$employees = $model -> get_records('group_id = 3','fs_users');
		include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
	}

	function edit()
	{
		$ids = FSInput::get('id',array(),'array');
		$id = $ids[0];
		$model = $this -> model;
		$data = $model->get_record_by_id($id);
		if($_SESSION['ad_groupid'] == 3 && $data-> status == 2){
			$msg = "Đã chuyển qua trạng thái Hoàn Thành, chỉ có Trưởng Phòng mới chỉnh sửa được!";
			setRedirect(FSRoute::_('index.php?module='.$this -> module.'&view='.$this -> view.'&task=display'),$msg,'error');
		}
		$array_status = $this -> arr_status;
		$array_find = $this -> array_find;
		$array_import = $this -> arr_import;
		$employees = $model -> get_records('group_id = 3','fs_users');
		$array_plan = $this -> arr_plan;
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

	function export(){
		FSFactory::include_class('excel','excel');
		$model  = $this -> model;
		$filename = 'Danh_sach_cong_viec';
		$list = $model->get_data_for_export();
		$users = $model -> get_records('','fs_users','fullname,username,id','','','id');
		
		if(empty($list)){
			echo 'error';exit;
		}else {
			$excel = FSExcel();
			$excel->set_params(array('out_put_xls'=>'export/excel/'.$filename.'.xlsx','out_put_xlsx'=>'export/excel/'.$filename.'.xlsx'));
			$style_header = array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb'=>'ffff00'),
				),
				'font' => array(
					'bold' => true,
				)
			);
			$style_header1 = array(
				'font' => array(
					'bold' => true,
				)
			);



			$excel->obj_php_excel->getActiveSheet ()->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$excel->obj_php_excel->getActiveSheet ()->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$excel->obj_php_excel->getActiveSheet ()->getDefaultStyle()->getAlignment()->setWrapText(true);
			
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('R')->setWidth(20);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('S')->setWidth(20);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('T')->setWidth(20);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('U')->setWidth(30);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('V')->setWidth(30);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('W')->setWidth(30);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('X')->setWidth(30);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('Y')->setWidth(30);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('Z')->setWidth(30);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('AA')->setWidth(30);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('AB')->setWidth(30);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('AC')->setWidth(30);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('AD')->setWidth(30);

			
			$excel->obj_php_excel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			$excel->obj_php_excel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			$excel->obj_php_excel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			$excel->obj_php_excel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			$excel->obj_php_excel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			$excel->obj_php_excel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			$excel->obj_php_excel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			$excel->obj_php_excel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			$excel->obj_php_excel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			$excel->obj_php_excel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			$excel->obj_php_excel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			$excel->obj_php_excel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			$excel->obj_php_excel->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			$excel->obj_php_excel->getActiveSheet()->getStyle('N')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			$excel->obj_php_excel->getActiveSheet()->getStyle('O')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			$excel->obj_php_excel->getActiveSheet()->getStyle('P')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			$excel->obj_php_excel->getActiveSheet()->getStyle('Q')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			$excel->obj_php_excel->getActiveSheet()->getStyle('R')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			$excel->obj_php_excel->getActiveSheet()->getStyle('S')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			$excel->obj_php_excel->getActiveSheet()->getStyle('T')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			
				$excel->obj_php_excel->getActiveSheet()->getStyle('U')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			$excel->obj_php_excel->getActiveSheet()->getStyle('V')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			$excel->obj_php_excel->getActiveSheet()->getStyle('W')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			$excel->obj_php_excel->getActiveSheet()->getStyle('X')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			$excel->obj_php_excel->getActiveSheet()->getStyle('Y')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			$excel->obj_php_excel->getActiveSheet()->getStyle('Z')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			$excel->obj_php_excel->getActiveSheet()->getStyle('AA')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			$excel->obj_php_excel->getActiveSheet()->getStyle('AB')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			$excel->obj_php_excel->getActiveSheet()->getStyle('AC')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			$excel->obj_php_excel->getActiveSheet()->getStyle('AD')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );



				
			
			$excel->obj_php_excel->getActiveSheet()->setCellValue('A1', 'STT');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('B1', 'Ngày đặt hàng');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('C1', 'Mã sản phẩm');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('D1', 'Tên');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('E1', 'Số lượng');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('F1', 'Số lượng nhập thực');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('G1', 'ĐVVC');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('H1', 'Mã đơn hàng');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('I1', 'Mã ký gửi');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('J1', 'Ngày phát hành');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('K1', 'Ngày đến kho TQ');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('L1', 'Ngày hàng đến kho');
	

			$excel->obj_php_excel->getActiveSheet()->mergeCells('M1:S1');
			$excel->obj_php_excel->getActiveSheet ()->setCellValue ('M1', 'Số lượng thực nhận');
			$excel->obj_php_excel->getActiveSheet ()->getStyle('M1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$excel->obj_php_excel->getActiveSheet()->mergeCells('T1:V1');
			$excel->obj_php_excel->getActiveSheet ()->setCellValue ('T1', 'Phân hàng MB');
			$excel->obj_php_excel->getActiveSheet ()->getStyle('T1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$excel->obj_php_excel->getActiveSheet()->mergeCells('W1:Y1');
			$excel->obj_php_excel->getActiveSheet ()->setCellValue ('W1', 'Phân hàng MN');
			$excel->obj_php_excel->getActiveSheet ()->getStyle('W1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


			$excel->obj_php_excel->getActiveSheet()->setCellValue('Z1', 'GHI CHÚ[Của NV nhập hàng]');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('AA1', 'Phản ánh chất lượng(Phòng bảo hành)');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('AB1', 'Hàng thiếu, lỗi vỡ');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('AC1', 'Nhập hàng khiếu nại');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('AD1', 'Phân việc cho nhân viên');



			$excel->obj_php_excel->getActiveSheet()->setCellValue('M2', 'Số kiện');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('N2', 'Số lượng 1 kiện');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('O2', 'Tổng số lượng sp');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('P2', 'Tổng cân nặng cả lô');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('Q2', 'Tổng thể tích cả lô');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('R2', 'Nhập kho');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('S2', 'Ghi chú của kho');


			$excel->obj_php_excel->getActiveSheet()->setCellValue('T2', 'Theo dự báo');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('U2', 'Số lượng thực');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('V2', 'Xuất kho');

			$excel->obj_php_excel->getActiveSheet()->setCellValue('W2', 'Theo dự báo');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('X2', 'Số lượng thực');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('Y2', 'Xuất kho');
			$i=1;
			foreach ($list as $item){
				
				$key = isset($key)?($key+1):3;
				$excel->obj_php_excel->getActiveSheet()->setCellValue('A'.$key, $i);		
				$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.$key, $item->ngay_dat_hang ? date('d/m/Y',strtotime($item->ngay_dat_hang)) : '');	
				$excel->obj_php_excel->getActiveSheet()->setCellValue('C'.$key, $item->code_product); 
				$excel->obj_php_excel->getActiveSheet()->setCellValue('D'.$key, $item->name);
				$excel->obj_php_excel->getActiveSheet()->setCellValue('E'.$key, $item-> count);
				$excel->obj_php_excel->getActiveSheet()->setCellValue('F'.$key, $item->so_luong_thuc_nhap);
				$excel->obj_php_excel->getActiveSheet()->setCellValue('G'.$key, $item->dvvc);
				$excel->obj_php_excel->getActiveSheet()->setCellValue('H'.$key, $item->code);	
				$excel->obj_php_excel->getActiveSheet()->setCellValue('I'.$key, $item->code_deposit);
				$excel->obj_php_excel->getActiveSheet()->setCellValue('J'.$key, $item->date_phat_hanh ? date('d/m/Y',strtotime($item->date_phat_hanh)) : '');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('K'.$key, $item->date_to_tq ? date('d/m/Y',strtotime($item->date_to_tq)) : '');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('L'.$key, $item->date_to_ha_noi ? date('d/m/Y',strtotime($item->date_to_ha_noi)) : '');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('M'.$key, $item->so_kien);
				$excel->obj_php_excel->getActiveSheet()->setCellValue('N'.$key, $item->so_luong_mot_kien);
				$excel->obj_php_excel->getActiveSheet()->setCellValue('O'.$key, $item->tong_so_luong_sp);
				$excel->obj_php_excel->getActiveSheet()->setCellValue('P'.$key, $item->tong_can_nang_cua_lo);
				$excel->obj_php_excel->getActiveSheet()->setCellValue('Q'.$key, $item->tong_the_tich_cua_lo);
				$excel->obj_php_excel->getActiveSheet()->setCellValue('R'.$key, $item->nhap_kho ? "Chưa nhập":"Đã nhập");
				$excel->obj_php_excel->getActiveSheet()->setCellValue('S'.$key, html_entity_decode($item-> ghi_chu_cua_kho));
				$excel->obj_php_excel->getActiveSheet()->setCellValue('T'.$key, $item->phan_theo_du_bao_mb);
				$excel->obj_php_excel->getActiveSheet()->setCellValue('U'.$key, $item->phan_luong_thuc_mb);
				$excel->obj_php_excel->getActiveSheet()->setCellValue('V'.$key, $item->xuat_kho_mb?"Chưa xuất":"Đã xuất");
				$excel->obj_php_excel->getActiveSheet()->setCellValue('W'.$key, $item->phan_theo_du_bao_mn);
				$excel->obj_php_excel->getActiveSheet()->setCellValue('X'.$key,$item->phan_luong_thuc_mn);
				$excel->obj_php_excel->getActiveSheet()->setCellValue('Y'.$key, $item->xuat_kho_mn?"Chưa xuất":"Đã xuất");
				$excel->obj_php_excel->getActiveSheet()->setCellValue('Z'.$key, html_entity_decode($item-> note_nhan_vien_nhan_hang));
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AA'.$key, html_entity_decode($item-> phan_anh_phong_bh));

				$excel->obj_php_excel->getActiveSheet()->setCellValue('AB'.$key, html_entity_decode($item-> product_error));
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AC'.$key, html_entity_decode($item-> nhap_hang_khieu_nai));
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AD'.$key, @$users[$item->employees_id]-> fullname);
			
				$i ++;
			}

			$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
			$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
			$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray( $style_header );
			$excel->obj_php_excel->getActiveSheet()->duplicateStyle( $excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:AD1');

			$excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(32);
			
//				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getAlignment()->setIndent(1);// padding cell
			
			$output = $excel->write_files();
			
			$path_file =   PATH_ADMINISTRATOR.DS.str_replace('/',DS, $output['xlsx']);
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control:no-cache, must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false);		
			header("Content-type: application/force-download");		
			header("Content-Disposition: attachment; filename=\"".$filename.'.xlsx'."\";" );
			header("Content-Transfer-Encoding: binary");
			header("Content-Length: ".filesize($path_file));	

			echo $link_excel = URL_ROOT.LINK_AMIN.'/export/excel/'. $filename.'.xlsx';
			?>
			<?php setRedirect($link_excel); ?>
			<?php 
			readfile($path_file);
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
	$array_status = array('1'=>'Chưa xử lý','2'=>'Hoàn thành','3'=>'Không hoàn thành','4'=>'Đang xử lý');
	return $array_status[$status];
}
	

?>