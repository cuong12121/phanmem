<?php
	class PackagesControllersStatistic extends Controllers
	{
		function __construct()
		{
			$this->view = 'statistic';
			parent::__construct();
			$model = $this -> model;
			
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			$model  = $this -> model;
			$warehouses = $model -> get_records('published = 1','fs_warehouses');
			$platforms = $model -> get_records('published = 1','fs_platforms');
			$houses = $model -> get_records('published = 1','fs_house');
			$shipping_unit = $model -> get_records('published = 1','fs_shipping_unit');
			$list = $this -> model->get_data();
			$pagination = $model->getPagination();
			$users_package = $model -> get_records('group_id = 5','fs_users','*','','','id');
			$statistic_for_user = $model->get_statistic_for_user();

			

			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}

		function add()
		{
			$model = $this -> model;
			$warehouses = $model -> get_records('published = 1','fs_warehouses');
			$platforms = $model -> get_records('published = 1','fs_platforms');
			$houses = $model -> get_records('published = 1','fs_house');
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}

		function edit()
		{
			$model = $this -> model;
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$data = $model->get_record_by_id($id);
			$warehouses = $model -> get_records('published = 1','fs_warehouses');
			$platforms = $model -> get_records('published = 1','fs_platforms');
			$houses = $model -> get_records('published = 1','fs_house');

			$users = $model -> get_record('id = ' . $_SESSION['ad_userid'],'fs_users');
			if($users->shop_id){
				$shops = $model -> get_records('id IN ('.$users->shop_id.')','fs_shops');
			}
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}


		function excel_nhat(){
			// xóa các file cũ trong thư mục cho nhẹ server
			$path_remove_file = PATH_ADMINISTRATOR.DS.'export'.DS.'excel'.DS.'order_item'.DS;
			array_map('unlink', array_filter(
       		(array) array_merge(glob($path_remove_file."*"))));

			FSFactory::include_class('excel','excel');
			$model  = $this -> model;
			$filename = 'FILE_NHAT'.$this->file_export_name;
			$filename = strtoupper($filename);
			
			$list = $model->get_excel_nhat(0,5000);
			// printr($list);
			if(empty($list)){
				echo 'Không có đơn nào được tìm thấy !';exit;
			}else {
				$excel = FSExcel();
				$excel->set_params(array('out_put_xls'=>'export/excel/order_item/'.$filename.'.xlsx','out_put_xlsx'=>'export/excel/order_item/'.$filename.'.xlsx'));
				$style_header = array(
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb'=>'fff'),
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


				$excel->obj_php_excel->getActiveSheet()->mergeCells('A1:E1');
				$excel->obj_php_excel->getActiveSheet ()->setCellValue ('A1', $filename);
				$excel->obj_php_excel->getActiveSheet ()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('B')->setWidth(60);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('E')->setWidth(5);
		
				$excel->obj_php_excel->getActiveSheet()->setCellValue('A2', 'Mã SKU');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('B2', 'Tên sản phẩm');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('C2', 'Mã màu');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('D2', 'Mã size');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('E2', 'SL');

				foreach ($list as $item){
					$key = isset($key)?($key+1):3;
					$excel->obj_php_excel->getActiveSheet()->setCellValue('A'.$key, $item->sku);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.$key, $item->product_name);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('C'.$key, $item->color);
					$excel->obj_php_excel->getActiveSheet()->setCellValueExplicit('D'.$key,$item->size,PHPExcel_Cell_DataType::TYPE_STRING);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('E'.$key, $item->count);
				}

				$excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray( $style_header );
				$excel->obj_php_excel->getActiveSheet()->duplicateStyle( $excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:E1' );

				$output = $excel->write_files();

				

				$path_file = PATH_ADMINISTRATOR.DS.str_replace('/',DS, $output['xls']);
				

				header("Pragma: public");
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Cache-Control: private",false);			
				header("Content-type: application/force-download");			
				header("Content-Disposition: attachment; filename=\"".$filename.'.xlsx'."\";" );			
				header("Content-Transfer-Encoding: binary");
				header("Content-Length: ".filesize($path_file));
				echo $link_excel = URL_ROOT.'admin/export/excel/order_item/'. $filename.'.xlsx';
				setRedirect($link_excel);
				readfile($path_file);
			}
		}


		function excel_tong_ngay(){
			// xóa các file cũ trong thư mục cho nhẹ server
			$path_remove_file = PATH_ADMINISTRATOR.DS.'export'.DS.'excel'.DS.'order_item'.DS;
			array_map('unlink', array_filter(
       		(array) array_merge(glob($path_remove_file."*"))));

			FSFactory::include_class('excel','excel');
			$model  = $this -> model;
			$filename = 'FILE_TONG'.$this->file_export_name;
			$filename = strtoupper($filename);
			
			$list = $model->get_excel_tong(0,5000);
			// printr($list);
			if(empty($list)){
				echo 'Không có đơn nào được tìm thấy !';exit;
			}else {
				$excel = FSExcel();
				$excel->set_params(array('out_put_xls'=>'export/excel/order_item/'.$filename.'.xlsx','out_put_xlsx'=>'export/excel/order_item/'.$filename.'.xlsx'));
				$style_header = array(
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb'=>'fff'),
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


				$excel->obj_php_excel->getActiveSheet()->mergeCells('A1:E1');
				$excel->obj_php_excel->getActiveSheet ()->setCellValue ('A1', $filename);
				$excel->obj_php_excel->getActiveSheet ()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('B')->setWidth(60);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		
				$excel->obj_php_excel->getActiveSheet()->setCellValue('A2', 'Mã');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('B2', 'Tên sản phẩm');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('C2', 'Tổng đơn');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('D2', 'Thực xuất');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('E2', 'NV đóng gói');

				foreach ($list as $item){
					$key = isset($key)?($key+1):3;
					$excel->obj_php_excel->getActiveSheet()->setCellValue('A'.$key, $item->sku);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.$key, $item->product_name);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('C'.$key, $item->total);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('D'.$key,'');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('E'.$key, '');
				}

				$excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray( $style_header );
				$excel->obj_php_excel->getActiveSheet()->duplicateStyle( $excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:E1' );

				$output = $excel->write_files();

				

				$path_file = PATH_ADMINISTRATOR.DS.str_replace('/',DS, $output['xls']);
				

				header("Pragma: public");
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Cache-Control: private",false);			
				header("Content-type: application/force-download");			
				header("Content-Disposition: attachment; filename=\"".$filename.'.xlsx'."\";" );			
				header("Content-Transfer-Encoding: binary");
				header("Content-Length: ".filesize($path_file));
				echo $link_excel = URL_ROOT.'admin/export/excel/order_item/'. $filename.'.xlsx';
				setRedirect($link_excel);
				readfile($path_file);
			}
		}


		function excel_misa(){
			// xóa các file cũ trong thư mục cho nhẹ server
			$path_remove_file = PATH_ADMINISTRATOR.DS.'export'.DS.'excel'.DS.'order_item'.DS;
			array_map('unlink', array_filter(
       		(array) array_merge(glob($path_remove_file."*"))));
		
			FSFactory::include_class('excel','excel');
			$model  = $this -> model;
			$filename = 'FILE_UP_MISA'.$this->file_export_name;
			$filename = strtoupper($filename);
			
			$list = $model->get_excel_nhat(0,5000);
			// printr($list);
			if(empty($list)){
				echo 'Không có đơn nào được tìm thấy !';exit;
			}else {
				$excel = FSExcel();
				$excel->set_params(array('out_put_xls'=>'export/excel/order_item/'.$filename.'.xlsx','out_put_xlsx'=>'export/excel/order_item/'.$filename.'.xlsx'));
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



				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
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
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('R')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('S')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('T')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('U')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('V')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('W')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('X')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('Y')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('Z')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('AA')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('AB')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('AC')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('AD')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('AE')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('AF')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('AG')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('AH')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('AI')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('AJ')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('AK')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('AL')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('AM')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('AN')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('AO')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('AP')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('AQ')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('AR')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('AS')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('AT')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('AU')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('AV')->setWidth(25);


		
				$excel->obj_php_excel->getActiveSheet()->setCellValue('A1', 'Hiển thị trên sổ');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('B1', 'Hiển thị trên sổ');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('C1', 'Phương thức thanh toán');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('D1', 'Kiêm phiếu xuất kho');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('E1', 'Lập kèm hóa đơn');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('F1', 'Đã lập hóa đơn');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('G1', 'Ngày hạch toán (*)');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('H1', 'Ngày chứng từ (*)');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('I1', 'Số chứng từ (*)');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('J1', 'Số phiếu xuất');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('K1', 'Lý do xuất');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('L1', 'Số hóa đơn');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('M1', 'Ngày hóa đơn');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('N1', 'Mã hàng lazada');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('O1', 'MÃ KHÁCH HÀNG');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('P1', 'Tên khách hàng');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('Q1', 'Địa chỉ');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('R1', 'Mã số thuế');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('S1', 'Diễn giải');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('T1', 'Nộp vào TK');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('U1', 'NV bán hàng');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('V1', 'MÃ HÀNG');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('W1', 'Tên hàng');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('X1', 'Hàng khuyến mại');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('Y1', 'TK Tiền/Chi phí/Nợ (*)');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('Z1', 'TK Doanh thu/Có (*)');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AA1', 'ĐVT');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AB1', 'SỐ LƯỢNG');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AC1', 'Đơn giá sau thuế');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AD1', 'Đơn giá');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AE1', 'Thành tiền');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AF1', 'Tỷ lệ CK (%)');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AG1', 'Tiền chiết khấu');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AH1', 'TK chiết khấu');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AI1', 'Giá tính thuế XK');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AJ1', '% thuế XK');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AK1', 'Tiền thuế XK');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AL1', 'TK thuế XK');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AM1', '% thuế GTGT');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AN1', 'Tiền thuế GTGT');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AO1', 'TK thuế GTGT');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AP1', 'HH không TH trên tờ khai thuế GTGT');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AQ1', 'Kho');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AR1', 'TK giá vốn');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AS1', 'TK Kho');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AT1', 'Đơn giá vốn');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AU1', 'Tiền vốn');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AV1', 'Hàng hóa giữ hộ/bán hộ');
	
				
				$platforms = $model->get_records('','fs_platforms','*','','','id');
				$houses = $model->get_records('','fs_house','*','','','id');


				foreach ($list as $item){
					$key = isset($key)?($key+1):2;
					$excel->obj_php_excel->getActiveSheet()->setCellValue('A'.$key,'');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.$key,'');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('C'.$key,'');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('D'.$key,'');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('E'.$key,'');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('F'.$key, '');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('G'.$key,date('d/m/Y',strtotime($item -> date)));
					$excel->obj_php_excel->getActiveSheet()->setCellValue('H'.$key,date('d/m/Y',strtotime($item -> date)));
					$excel->obj_php_excel->getActiveSheet()->setCellValue('I'.$key,$item -> shop_code.'-'.date('dmY',strtotime($item ->date )));
					$excel->obj_php_excel->getActiveSheet()->setCellValue('J'.$key,$item -> shop_code.'-'.date('dmY',strtotime($item ->date )));
					$excel->obj_php_excel->getActiveSheet()->setCellValue('K'.$key, '');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('L'.$key,$item -> shop_code.'-'.date('dmY',strtotime($item ->date )));
					$excel->obj_php_excel->getActiveSheet()->setCellValue('M'.$key,date('d/m/Y',strtotime($item -> date)));
					$excel->obj_php_excel->getActiveSheet()->setCellValue('N'.$key, $item -> code.'/'.$item -> tracking_code);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('O'.$key, $item -> shop_code);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('P'.$key, '');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('Q'.$key, '');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('S'.$key, $platforms[$item -> platform_id]->code.' '.$houses[$item -> house_id]->name);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('T'.$key, '');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('U'.$key, '');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('V'.$key, $item -> sku);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('W'.$key, '');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('X'.$key,'');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('Y'.$key, '131');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('Z'.$key, '5111');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('AA'.$key, '');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('AB'.$key, $item -> count);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('AC'.$key, '');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('AD'.$key, $item -> product_price);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('AE'.$key, '');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('AF'.$key, '');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('AG'.$key, '');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('AH'.$key, '');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('AI'.$key, '');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('AJ'.$key, '');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('AK'.$key,'');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('AL'.$key, '');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('AM'.$key, '');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('AN'.$key, '');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('AO'.$key, '');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('AP'.$key, '');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('AQ'.$key, 'KH1');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('AR'.$key, '632');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('AS'.$key, '1561');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('AT'.$key, '');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('AU'.$key, '');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('AV'.$key, '');
				}

				$excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(10 );
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray( $style_header );
				$excel->obj_php_excel->getActiveSheet()->duplicateStyle( $excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:AV1' );

				$output = $excel->write_files();
					

				$path_file = PATH_ADMINISTRATOR.DS.str_replace('/',DS, $output['xls']);
				

				header("Pragma: public");
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Cache-Control: private",false);			
				header("Content-type: application/force-download");			
				header("Content-Disposition: attachment; filename=\"".$filename.'.xlsx'."\";" );			
				header("Content-Transfer-Encoding: binary");
				header("Content-Length: ".filesize($path_file));
				echo $link_excel = URL_ROOT.'admin/export/excel/order_item/'. $filename.'.xlsx';
				setRedirect($link_excel);
				readfile($path_file);
			}
		}


		function ajax_package(){
			$id = FSInput::get('id');
			$respon = array();
			$respon ['error'] = true;
			$model = $this -> model;
			$data = $model->get_record('id = '.$id,'fs_order_uploads_detail','*');

			if(!empty($data)){
				$row = array();
				$row['is_package'] = 1;
				$row['date_package'] = date('Y-m-d H:i:s');
				$row['user_package_id'] = $_SESSION ['ad_userid'];
				$model-> _update($row,'fs_order_uploads_detail','id ='.$id);
				$respon ['error'] = false;
				$respon ['message'] = 'Đóng hàng thành công';
				echo json_encode ( $respon );
				
			}else{
				$respon ['message'] = 'Có lỗi xảy ra, không tìm được, vui lòng f5 lại.';
				echo json_encode ( $respon );
			}
			return;
		}

	}

	

	function view_excel($controle,$id){
		$model = $controle -> model;
		$data = $model->get_record('id = ' .$id,'fs_order_uploads','id,file_xlsx');
		$link = URL_ROOT.$data-> file_xlsx;
		return '<a target="_blink" href="' . $link . '">'.basename($data-> file_xlsx).'</a>';
	}

	function view_print($controle,$id){
		$model = $controle -> model;
		$data = $model->get_record('id = ' .$id,'fs_order_uploads','id,is_print');
		if($data-> is_print == 1){
			$txt = 'Đã In';
		}else{
			$txt = 'Chưa In';
		}
		return $txt;
	}

	function view_actions($controle,$id){
		$model = $controle -> model;
		$data = $model->get_record('id = ' .$id,'fs_order_uploads_detail','*');
		$txt ="";
		if($data-> is_package == 0){
			$txt .="<a class='btn-row btn-row-package-".$id."' onclick='is_package(".$id.")' href='javascript:void(0)'>Xác nhận đã đóng hàng</a>";
			$txt .="<div class='hide content-package-".$id."'>Đã đóng hàng</div>";
		}
		return $txt;
	}

	function view_user_package($controle,$id){
		if(!$id){
			return $txt ="";
		}
		$model = $controle -> model;
		$data = $model->get_record('id = ' .$id,'fs_users','*');
		
		if(!empty($data)){
			$txt = $data->username;
		}
		
		return $txt;
	}


	function back_status($controle,$id){
		$model = $controle -> model;
		$data = $model->get_record('id = ' .$id,'fs_order_uploads_detail','is_package,id,user_package_id');
		$txt ="";
		if($data-> is_package == 1 && $data-> user_package_id == $_SESSION ['ad_userid']){
			$permission_refund = FSSecurity::check_permission_groups('packages','statistic','ajax_back_package');
        	if($permission_refund){
				$txt .="<a class='btn-row btn-row-package-".$id."' onclick='is_not_package(".$id.")' href='javascript:void(0)'>Chưa đóng</a>";
			}
			$txt .="<div class='hide content-package-".$id."'>Đã chuyển trạng thái chưa đóng</div>";
		}else{
			$txt .="<div class='content-package-".$id."'>Không phải bạn đóng</div>";
		}
		return $txt;
	}

	

	
	
	
?>