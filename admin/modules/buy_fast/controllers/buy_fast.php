<?php
	class Buy_fastControllersBuy_fast  extends Controllers
	{
		function __construct()
		{
			$this->view = 'buy_fast' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $model->get_data();
			$pagination = $model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		function add()
		{
			$model = $this -> model;
				
			$maxOrdering = $model->getMaxOrdering();
			
			
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
		
		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			$data = $model->get_record_by_id($id);
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}

		function export(){
			setRedirect('index.php?module='.$this -> module.'&view='.$this -> view.'&task=export_file&raw=1');
		}	


		function export_file(){
			FSFactory::include_class('excel','excel');
			$model  = $this -> model;
			$filename = 'danh_sach_dang_ki_nhan_thong_tin';
			$list = $model ->export();
	//			print_r($list);die;
			if(empty($list)){
				echo 'error';exit;
			}else {
				$excel = FSExcel();
				$excel->set_params(array('out_put_xls'=>'export/excel/'.$filename.'.xls','out_put_xlsx'=>'export/excel/'.$filename.'.xlsx'));
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
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);

				$excel->obj_php_excel->getActiveSheet()->setCellValue('A1', 'Tên');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('B1', 'Số điện thoại');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('C1', 'Email');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('D1', 'Tin nhắn');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('E1', 'Thời gian tạo');
			

				foreach ($list as $item){
					
					$key = isset($key)?($key+1):2;
					$excel->obj_php_excel->getActiveSheet()->setCellValue('A'.$key, $item->name );
					$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.$key, $item->phone);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('C'.$key, $item->email);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('D'.$key, $item->product_name);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('E'.$key, $item->created_time);
					$i ++;
				}
					$excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
					$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
					$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
					$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray( $style_header );
					$excel->obj_php_excel->getActiveSheet()->duplicateStyle( $excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:E1' );

					$output = $excel->write_files();

					$path_file =   PATH_ADMINISTRATOR.DS.str_replace('/',DS, $output['xls']);
					header("Pragma: public");
					header("Expires: 0");
					header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
					header("Cache-Control: private",false);			
					header("Content-type: application/force-download");			
					header("Content-Disposition: attachment; filename=\"".$filename.'.xls'."\";" );			
					header("Content-Transfer-Encoding: binary");
					header("Content-Length: ".filesize($path_file));
					echo $link_excel = URL_ROOT.LINK_AMIN.'/export/excel/'. $filename.'.xls';
					setRedirect($link_excel);
					readfile($path_file);
				
			}

		}
    	
		
	}
	
?>