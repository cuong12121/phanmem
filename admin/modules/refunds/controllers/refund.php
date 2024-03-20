<?php
	class RefundsControllersRefund extends Controllers
	{
		function __construct()
		{
			$this->view = 'refund'; 
			parent::__construct();
			$model = $this -> model;

			$file_export_name = "";

			if(isset($_SESSION[$this -> prefix.'text0']))
			{
				$date_from = $_SESSION[$this -> prefix.'text0'];
				if($date_from){
					$date_from = strtotime($date_from);
					$date_new = date('Y-m-d',$date_from);
					$file_export_name .= '_'.$date_new;
				}
			}
			

			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$house_id = $_SESSION[$this -> prefix.'filter0'];
				if($house_id){
					$house = $model->get_record('id = '.$house_id,'fs_house','name');
					$file_export_name .= '_'.$house->name;
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter1'])){
				$warehouse_id = $_SESSION[$this -> prefix.'filter1'];
				if($warehouse_id){
					$warehouse = $model->get_record('id = '.$warehouse_id,'fs_warehouses','code');
					$file_export_name .= '_'.$warehouse->code;
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter2'])){
				$platform_id = $_SESSION[$this -> prefix.'filter2'];
				if($platform_id){
					$platform = $model->get_record('id = '.$platform_id,'fs_platforms','code');
					$file_export_name .= '_'.$platform->code;
				}
			}


			if(isset($_SESSION[$this -> prefix.'filter3'])){
				$shipping_unit_id = $_SESSION[$this -> prefix.'filter3'];
				$fsstring = FSFactory::getClass('FSString','','../');
				if($shipping_unit_id){
					$shipping_unit = $model->get_record('id = '.$shipping_unit_id,'fs_shipping_unit','name');
					$file_export_name .= '_'.$fsstring -> stringStandart($shipping_unit->name);
				}
			} 

			$this->file_export_name = $file_export_name;


			// $list_rf = $model->get_records('','fs_order_uploads_detail_refund');
			// foreach ($list_rf as $item) {
			// 	$row = array();
			// 	$row['date_refund'] = $item-> date_refund;
			// 	$model->_update($row,'fs_order_uploads_detail','id = '.$item-> order_uploads_detail_id);
			// }
			// die;

		}



		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			$model  = $this -> model;
			$wrap_id_warehouses = $model->get_wrap_id_warehouses();
			$warehouses = $model -> get_records('published = 1 AND id IN ('.$wrap_id_warehouses.')','fs_warehouses');
			$platforms = $model -> get_records('published = 1','fs_platforms');
			$houses = $model -> get_records('published = 1','fs_house');
			$shipping_unit = $model -> get_records('published = 1','fs_shipping_unit');
			$list = $this -> model->get_data();
			$pagination = $model->getPagination();
			$users = $model -> get_record('id = ' . $_SESSION['ad_userid'],'fs_users');
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

		function excel_hoan_hang(){
			$link = FSRoute::_('index.php?module='.$this -> module.'&view='.$this -> view);

			if(!isset($_SESSION[$this -> prefix.'text0']) || $_SESSION[$this -> prefix.'text0'] == ''){
				setRedirect($link,FSText :: _('Vui lòng chọn ngày trước khi xuất file!'),'error');
			}
			
			// xóa các file cũ trong thư mục cho nhẹ server
			$path_remove_file = PATH_ADMINISTRATOR.DS.'export'.DS.'excel'.DS.'refund'.DS;
			array_map('unlink', array_filter(
       		(array) array_merge(glob($path_remove_file."*"))));

			FSFactory::include_class('excel','excel');
			$model  = $this -> model;
			$filename = 'FILE_HOAN_HANG'.$this->file_export_name;
		
			$filename = strtoupper($filename);
			
			$list = $model->get_data_excel();

			// printr($list);
			if(empty($list)){
				echo 'Không có đơn nào được tìm thấy !';exit;
			}else {
	
				$excel = FSExcel();
				// dd($excel);
				$excel->set_params(array('out_put_xls'=>'export/excel/refund/'.$filename.'.xlsx','out_put_xlsx'=>'export/excel/refund/'.$filename.'.xlsx'));
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


				$excel->obj_php_excel->getActiveSheet()->mergeCells('A1:I1');
				$excel->obj_php_excel->getActiveSheet ()->setCellValue ('A1', $filename);
				$excel->obj_php_excel->getActiveSheet ()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('B')->setWidth(8);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
		
				$excel->obj_php_excel->getActiveSheet()->setCellValue('A2', 'Mã vận đơn');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('B2', 'Shop');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('C2', 'Mã SKU');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('D2', 'Mã màu');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('E2', 'Mã size');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('F2', 'Mã SKU nhanh');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('G2', 'Số lượng');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('H2', 'Khối lượng');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('I2', 'Ngày hoàn');

				foreach ($list as $item){
					$key = isset($key)?($key+1):3;
					$excel->obj_php_excel->getActiveSheet()->setCellValue('A'.$key, $item->tracking_code);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.$key, $item->shop_code);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('C'.$key, $item->sku);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('D'.$key, $item->color);
					$excel->obj_php_excel->getActiveSheet()->setCellValueExplicit('E'.$key,$item->size,PHPExcel_Cell_DataType::TYPE_STRING);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('F'.$key, $item->sku.'-'.$item->color.'-'.$item->size);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('G'.$key, $item->count);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('H'.$key, '');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('I'.$key, date('d/m/Y',strtotime($item->date_refund)));
				}

				$excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray( $style_header );
				$excel->obj_php_excel->getActiveSheet()->duplicateStyle( $excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:I1' );

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
				echo $link_excel = URL_ROOT.'admin/export/excel/refund/'. $filename.'.xlsx';
				setRedirect($link_excel);
				readfile($path_file);
			}
		}
	}

	function view_pdf($controle,$id){
		$model = $controle -> model;
		$data = $model->get_record('id = ' .$id,'fs_order_uploads','id,file_pdf');
		$link = URL_ROOT.$data-> file_pdf;
		return '<a target="_blink" href="' . $link . '">'.basename($data-> file_pdf).'</a>';
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

	
	
?>