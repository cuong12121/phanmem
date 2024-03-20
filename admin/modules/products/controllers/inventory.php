<?php	  
	class ProductsControllersInventory extends Controllers
	{
		function __construct()
		{
			$this->view = 'inventory' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $this -> model->get_data();
			$warehouses = $model -> get_records('published = 1','fs_warehouses');
			
			$pagination = $model->getPagination();

			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}

		function export_nomal(){
			// xóa các file cũ trong thư mục cho nhẹ server
			$path_remove_file = PATH_ADMINISTRATOR.DS.'export'.DS.'excel'.DS.'inventory'.DS;
			array_map('unlink', array_filter(
       		(array) array_merge(glob($path_remove_file."*"))));

			FSFactory::include_class('excel','excel');
			$model  = $this -> model;
			$filename = 'TON_KHO';
			$filename = strtoupper($filename);
			
			$list = $model -> get_records('','fs_products','name,id,code');
			$warehouses = $model -> get_records('published = 1','fs_warehouses');
			if(empty($list)){
				echo 'Không có sản phẩm nào !';exit;
			}else {
				
				$excel = FSExcel();
				$excel->set_params(array('out_put_xls'=>'export/excel/inventory/'.$filename.'.xlsx','out_put_xlsx'=>'export/excel/inventory/'.$filename.'.xlsx'));
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

				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('A')->setWidth(100);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);

				$excel->obj_php_excel->getActiveSheet()->setCellValue('A2', 'Sản phẩm');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('B2', 'SKU');

				$w = 1;
				foreach ($warehouses as $warehouses_item) {
					if($w == 1){
						$excel->obj_php_excel->getActiveSheet()->getColumnDimension("C")->setWidth(40);
						$excel->obj_php_excel->getActiveSheet()->setCellValue('C2', $warehouses_item->name);
					}elseif($w == 2){
						$excel->obj_php_excel->getActiveSheet()->getColumnDimension("D")->setWidth(40);
						$excel->obj_php_excel->getActiveSheet()->setCellValue('D2', $warehouses_item->name);
					}elseif($w == 3){
						$excel->obj_php_excel->getActiveSheet()->getColumnDimension("E")->setWidth(40);
						$excel->obj_php_excel->getActiveSheet()->setCellValue('E2', $warehouses_item->name);
					}elseif($w == 4){
						$excel->obj_php_excel->getActiveSheet()->getColumnDimension("F")->setWidth(40);
						$excel->obj_php_excel->getActiveSheet()->setCellValue('F2', $warehouses_item->name);
					}elseif($w == 5){
						$excel->obj_php_excel->getActiveSheet()->getColumnDimension("G")->setWidth(40);
						$excel->obj_php_excel->getActiveSheet()->setCellValue('G2', $warehouses_item->name);
					}elseif($w == 6){
						$excel->obj_php_excel->getActiveSheet()->getColumnDimension("H")->setWidth(40);
						$excel->obj_php_excel->getActiveSheet()->setCellValue('H2', $warehouses_item->name);
					}elseif($w == 7){
						$excel->obj_php_excel->getActiveSheet()->getColumnDimension("I")->setWidth(40);
						$excel->obj_php_excel->getActiveSheet()->setCellValue('I2', $warehouses_item->name);
					}elseif($w == 8){
						$excel->obj_php_excel->getActiveSheet()->getColumnDimension("K")->setWidth(40);
						$excel->obj_php_excel->getActiveSheet()->setCellValue('K2', $warehouses_item->name);
					}
					$w++;
				}

				if(count($warehouses) == 1){
					$excel->obj_php_excel->getActiveSheet()->getColumnDimension("D")->setWidth(40);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('D2', 'Tổng');
				}elseif(count($warehouses) == 2){
					$excel->obj_php_excel->getActiveSheet()->getColumnDimension("E")->setWidth(40);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('E2', 'Tổng');
				}elseif(count($warehouses) == 3){
					$excel->obj_php_excel->getActiveSheet()->getColumnDimension("F")->setWidth(40);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('F2', 'Tổng');
				}elseif(count($warehouses) == 4){
					$excel->obj_php_excel->getActiveSheet()->getColumnDimension("G")->setWidth(40);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('G2', 'Tổng');
				}elseif(count($warehouses) == 5){
					$excel->obj_php_excel->getActiveSheet()->getColumnDimension("H")->setWidth(40);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('H2', 'Tổng');
				}elseif(count($warehouses) == 6){
					$excel->obj_php_excel->getActiveSheet()->getColumnDimension("I")->setWidth(40);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('I2', 'Tổng');
				}elseif(count($warehouses) == 7){
					$excel->obj_php_excel->getActiveSheet()->getColumnDimension("K")->setWidth(40);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('K2', 'Tổng');
				}elseif(count($warehouses) == 8){
					$excel->obj_php_excel->getActiveSheet()->getColumnDimension("L")->setWidth(40);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('L2', 'Tổng');
				}

				
				foreach ($list as $item){
					$key = isset($key)?($key+1):3;
					$excel->obj_php_excel->getActiveSheet()->setCellValue('A'.$key, $item->name);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.$key, $item->code);
					$w = 1;
					$total=0;
					foreach ($warehouses as $warehouses_item) {
						$warehouses_product = $model -> get_record('product_id = '.$item->id . ' AND warehouses_id = ' . $warehouses_item->id,'fs_warehouses_products','amount');
						if(!empty($warehouses_product)){
							$total += $warehouses_product-> amount;
						}
						if($w == 1){
							$excel->obj_php_excel->getActiveSheet()->setCellValue('C'.$key, @$warehouses_product-> amount ? @$warehouses_product-> amount : 0);
						}elseif($w == 2){
							$excel->obj_php_excel->getActiveSheet()->setCellValue('D'.$key, @$warehouses_product-> amount ? @$warehouses_product-> amount : 0);
						}elseif($w == 3){
							$excel->obj_php_excel->getActiveSheet()->setCellValue('E'.$key, @$warehouses_product-> amount ? @$warehouses_product-> amount : 0);
						}elseif($w == 4){
							$excel->obj_php_excel->getActiveSheet()->setCellValue('F'.$key, @$warehouses_product-> amount ? @$warehouses_product-> amount : 0);
						}elseif($w == 5){
							$excel->obj_php_excel->getActiveSheet()->setCellValue('G'.$key, @$warehouses_product-> amount ? @$warehouses_product-> amount : 0);
						}elseif($w == 6){
							$excel->obj_php_excel->getActiveSheet()->setCellValue('H'.$key, @$warehouses_product-> amount ? @$warehouses_product-> amount : 0);
						}elseif($w == 7){
							$excel->obj_php_excel->getActiveSheet()->setCellValue('I'.$key, @$warehouses_product-> amount ? @$warehouses_product-> amount : 0);
						}elseif($w == 8){
							$excel->obj_php_excel->getActiveSheet()->setCellValue('K'.$key, @$warehouses_product-> amount ? @$warehouses_product-> amount : 0);
						}
						$w++;
					}

					if(count($warehouses) == 1){
						$excel->obj_php_excel->getActiveSheet()->setCellValue('D'.$key, $total);
					}elseif(count($warehouses) == 2){
						$excel->obj_php_excel->getActiveSheet()->setCellValue('E'.$key, $total);
					}elseif(count($warehouses) == 3){
						$excel->obj_php_excel->getActiveSheet()->setCellValue('F'.$key, $total);
					}elseif(count($warehouses) == 4){
						$excel->obj_php_excel->getActiveSheet()->setCellValue('G'.$key, $total);
					}elseif(count($warehouses) == 5){
						$excel->obj_php_excel->getActiveSheet()->setCellValue('H'.$key, $total);
					}elseif(count($warehouses) == 6){
						$excel->obj_php_excel->getActiveSheet()->setCellValue('I'.$key, $total);
					}elseif(count($warehouses) == 7){
						$excel->obj_php_excel->getActiveSheet()->setCellValue('K'.$key, $total);
					}elseif(count($warehouses) == 8){
						$excel->obj_php_excel->getActiveSheet()->setCellValue('L'.$key, $total);
					}
					
				}

				$excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray( $style_header );
				$excel->obj_php_excel->getActiveSheet()->duplicateStyle( $excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:L1' );

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
				echo $link_excel = URL_ROOT.'admin/export/excel/inventory/'. $filename.'.xlsx';
				setRedirect($link_excel);
				readfile($path_file);
			}
		}
	
	}

	

	function view_amount($controle,$warehouse_product_id){
		$model = $controle -> model;
		return $warehouse_product_id;
	}
	
?>