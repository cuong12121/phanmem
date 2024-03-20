<?php
	class ProductsControllersUpdate_product_excel  extends Controllers
	{
		function __construct()
		{
			parent::__construct(); 
		}
		function display()
		{
			$model = $this -> model;
			$cid =  FSInput::get('cid');
			if($cid)
			{
				$cat =  $model->get_record('id='.$cid,'fs_products_categories');
			}
			
			include 'modules/'.$this->module.'/views/update_product_excel/default.php';
		}
		function import_product(){
			$excel_file = $this->upload_excel('excel');
                       
			if(!empty($excel_file)){
				echo json_encode(array('status'=>'success'));
			}else {
				echo json_encode(array('status'=>'empty_excel'));
			}
		} 
		function upload_excel($input_name)
		{
			$model = $this -> model;
			global $db;
			$cid =  FSInput::get('cid');
			$fsFile = FSFactory::getClass('FsFiles');
			// upload
			$path =  PATH_BASE.'images'.DS.'excel'.DS;
			$excel = $fsFile -> uploadExcel($input_name, $path,2000000, '_'.time());
                        
			if(	!$excel){
				return false;
			}
			else{
				if($cid){
                    echo $excel."ccc";die;
					$rs=$model->import_film_info_extend($excel,$path,$cid);
					file_put_contents("log.log", var_export($rs,true));
					if($rs)
					{
						setRedirect("index.php?module=products&view=update_product_excel&cid=$cid",FSText::_('Có').'<strong> '.$rs.'</strong> '.'bản ghi được cập nhật','suc');
					}
					else 
					{
						setRedirect("index.php?module=products&view=update_product_excel&cid=$cid",FSText::_('Không có bản ghi nào được cập nhật'),'alert');
					}	
				}else{
                                        // echo $path."ssss";die;
					// $rs=$model->import_film_info($excel,$path);
					$rs=$model->import_film_info_new($excel,$path);
					
					file_put_contents("log.log", var_export($rs,true));
					if($rs)
					{
						setRedirect("index.php?module=products&view=update_product_excel",$rs,'suc');
					}
					else 
					{
						setRedirect("index.php?module=products&view=update_product_excel",FSText::_('Không có bản ghi nào được cập nhật'),'alert');
					}	
				}
			
				return TRUE;
			}
		}
		
		function extract_file(){
			FSFactory::include_class('excel','excel');
			$cat_id =FSInput::get('cid',0,'int');
			
			$model  = $this -> model;
			
			$catagories =  $model->get_record_by_id($cat_id,'fs_products_categories');
			
			//Get tablename of catagory
			$tablename = $catagories->tablename;
			$tablename_name = explode('_', $tablename);
			$tablename_name = $tablename_name[2];
			
			$filename = 'export_table_'.$tablename_name;
			
			//Get list field name  of table extend
			$arr_data_extend = $model->get_records('table_name="'.$tablename.'"','fs_products_tables','id,field_name,field_name_display,foreign_id,foreign_name,foreign_tablename');
			
			//Get list of fs_products by tablename extend
			$list = $model->get_data_for_export($tablename);
//			if(empty($list)){
//				echo 'error';exit;
//			}else {
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
				
				
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
//				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
				
				$h =74;
				foreach ($arr_data_extend as $data_extend) {
					if($h <= 90){
						$str = chr ( $h );
					}else if($h <= 116)
					{
						$str ='A'.chr ( $h-26 );
					}else if($h <= 142)
					{
						$str ='B'.chr ( $h-52 );
					}
					else 
						break;
					$excel->obj_php_excel->getActiveSheet()->getColumnDimension($str)->setWidth(30);
					
					$excel->obj_php_excel->getActiveSheet()->setCellValue($str.'1', $data_extend->field_name);
					$h++;
				}
				
				
				$excel->obj_php_excel->getActiveSheet()->setCellValue('A1', 'Name');
			//	$excel->obj_php_excel->getActiveSheet()->setCellValue('B1', 'Image');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('B1', 'Code');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('C1', 'Partnumber');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('D1', 'Manufactory');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('E1', 'Summary');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('F1', 'Description');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('G1', 'Driver');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('H1', 'RetailPrice');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('I1', 'DealerPrice');
				
				
				$i = 0;
				$total_money = 0;
				$total_quantity = 0;
//				
//				foreach ($list as $item){
//						//Get list of table extend by tablename extend
//						$list_ext = $model->get_data_for_export_table_extentd($arr_data_extend,$tablename,$item->id);
//					
//					$key = isset($key)?($key+1):2;
//					$excel->obj_php_excel->getActiveSheet()->setCellValue('A'.$key, $item->name);
//					
//					$excel->obj_php_excel->getActiveSheet()->setCellValue('C'.$key, $item->code);
//					$excel->obj_php_excel->getActiveSheet()->setCellValue('D'.$key, $item->partnumber);
//					$excel->obj_php_excel->getActiveSheet()->setCellValue('E'.$key, $item->manufactory_name);
//					$excel->obj_php_excel->getActiveSheet()->setCellValue('F'.$key, $item->description);
//					$excel->obj_php_excel->getActiveSheet()->setCellValue('G'.$key, $item->summary);
//					$excel->obj_php_excel->getActiveSheet()->setCellValue('H'.$key, $item->driver);
//					$excel->obj_php_excel->getActiveSheet()->setCellValue('I'.$key, $item->price);
//					$excel->obj_php_excel->getActiveSheet()->setCellValue('J'.$key, $item->dealer_price);
//					$n=75;
//					foreach ($arr_data_extend as $data_extend) {
//						$field_name= $data_extend->field_name;
//						if($n <= 90){
//							$str = chr ( $n );
//						}else if($n <= 116)
//						{
//							$str ='A'.chr ( $n-26 );
//						}
//						else 
//							break;
//						$excel->obj_php_excel->getActiveSheet()->setCellValue($str.$key, $item->$field_name);	
//						$n++;
//					}
//					
//					$excel->obj_php_excel->getActiveSheet()->getRowDimension($i + 2)->setRowHeight(100);
//					$i ++;
//					
//				}
				$excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray( $style_header );
				
				$m =74;
				foreach ($arr_data_extend as $data_extend) {
					if($m <= 90){
						$str = chr ( $m );
					}else if($m <= 116)
					{
						$str ='A'.chr ( $m-26 );
					}else if($m <= 142){
						$str ='B'.chr ( $m-52 );
					}
					else 
						break;
					$excel->obj_php_excel->getActiveSheet()->duplicateStyle( $excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:'.$str.'1' );
					
					$m++;
				}
//				$excel->obj_php_excel->getActiveSheet()->duplicateStyle( $excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:F1' );
				
				
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
				readfile($path_file);
//			}
		}
		// function download_file(){
		
		// 	$path_file = PATH_BASE.'mau_import'.DS.'update_san_pham.xls'; 
		
		// 	$fsstring = FSFactory::getClass('FSString');
		// 	$file_export_name = 'update_san_pham';
		// 	$file_ext = $this -> getExt(basename('mau_import'.DS.'update_san_pham.xls'));
		// 	$file_export_name = $file_export_name.'.'.$file_ext;
		// 	header("Pragma: public");
		// 	header("Expires: 0");
		// 	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		// 	header("Cache-Control: private",false);			
		// 	header("Content-type: application/force-download");			
		// 	header("Content-Disposition: attachment; filename=\"".$file_export_name."\";" );			
		// 	header("Content-Transfer-Encoding: binary");
		// 	header("Content-Length: ".filesize($path_file));
		// 	readfile($path_file);
		// 	exit();	
		// }

		function download_file(){
		
			$path_file = PATH_BASE.LINK_AMIN.'export'.DS.'excel'.'update_san_pham.xls'; 
			$fsstring = FSFactory::getClass('FSString');
			$file_export_name = 'update_san_pham';
			$file_ext = $this -> getExt(basename('export'.DS.'excel'.DS.'update_san_pham.xls'));
			$file_export_name = $file_export_name.'.'.$file_ext;
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control: no-cache,must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false);			
			header("Content-type: application/force-download");			
			header("Content-Disposition: attachment; filename=\"".$file_export_name."\";" );
			header("Content-Transfer-Encoding: binary");
			header("Cache-Control:no-cache, must-revalidate, post-check=0, pre-check=0");

			header("Content-Length: ".filesize($path_file));

			echo $link_excel = URL_ROOT.LINK_AMIN.'/export/excel/'. $file_export_name;
			?>
			<?php setRedirect($link_excel); ?>
			<?php 
			readfile($path_file);
			exit();	
		}


		function download_file_tutorial(){
		
			$path_file = PATH_BASE.LINK_AMIN.'export'.DS.'excel'.'huong_dan_nhap_file_excel.docx';
			// echo $path_file;
			// die;
			$fsstring = FSFactory::getClass('FSString');
			$file_export_name = 'huong_dan_nhap_file_excel';
			$file_ext = $this -> getExt(basename('export'.DS.'excel'.DS.'huong_dan_nhap_file_excel.docx'));
			$file_export_name = $file_export_name.'.'.$file_ext;
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control: no-cache,must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false);			
			header("Content-type: application/force-download");			
			header("Content-Disposition: attachment; filename=\"".$file_export_name."\";" );
			header("Content-Transfer-Encoding: binary");
			header("Cache-Control:no-cache, must-revalidate, post-check=0, pre-check=0");

			header("Content-Length: ".filesize($path_file));

			echo $link_excel = URL_ROOT.LINK_AMIN.'/export/excel/'. $file_export_name;
			?>
			<?php setRedirect($link_excel); ?>
			<?php 
			readfile($path_file);
			exit();	
		}


		function getExt($file){
			return strtolower(substr($file, (strripos($file, '.')+1),strlen($file)));
		}
	}
	
?>