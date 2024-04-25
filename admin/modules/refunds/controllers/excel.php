<?php
	class RefundsControllersExcel extends Controllers
	{
		function __construct()
		{
			$this->view = 'excel'; 
			parent::__construct();

			$model = $this -> model;
			$file_export_name = "";
			// printr($_SESSION);
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

			if(isset($_SESSION[$this -> prefix.'filter3'])){
				$shipping_unit_id = $_SESSION[$this -> prefix.'filter3'];
				$fsstring = FSFactory::getClass('FSString','','../');
				if($shipping_unit_id){
					$shipping_unit = $model->get_record('id = '.$shipping_unit_id,'fs_shipping_unit','name');
					$file_export_name .= '_'.$fsstring -> stringStandart($shipping_unit->name);
				}
			}

			$this->file_export_name = $file_export_name;
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			$model  = $this -> model;
			// $warehouses = $model -> get_records('published = 1','fs_warehouses');
			// $platforms = $model -> get_records('published = 1','fs_platforms');
			// $houses = $model -> get_records('published = 1','fs_house');
			// $shipping_unit = $model -> get_records('published = 1','fs_shipping_unit');
			// $list = $this -> model->get_data();
			// $pagination = $model->getPagination();
			// $users = $model -> get_record('id = ' . $_SESSION['ad_userid'],'fs_users');
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


		function import_excel(){
			$model = $this -> model;
			$fsFile = FSFactory::getClass('FsFiles');
			$path = PATH_BASE.'files/excel/refunds';
			$path = str_replace('/', DS,$path);
			
	        $excel = $fsFile -> upload_file("excel", $path ,100000000, '_'.time());
	   
	        if(	!$excel){
				return false;
			}
			else{
			    $file_path = $path.$excel;
				require_once("../libraries/PHPExcel-1.8/Classes/PHPExcel.php");
				// Đọc file Excel
                $objPHPExcel = PHPExcel_IOFactory::load($file_path);
                
               
                
                // Lấy sheet đầu tiên
                $sheet = $objPHPExcel->getActiveSheet();
                
                $highestColumn = $sheet->getHighestColumn();
                
                $dem = 0;
                
                foreach ($sheet->getRowIterator() as $row) {
                    $isEmpty = true;
                    foreach ($row->getCellIterator() as $cell) {
                        if (!is_null($cell->getValue())) {
                            $isEmpty = false;
                            break;
                        }
                    }
                
                    if (!$isEmpty) {
                        $dem++;
                    }
                }
                
                $highestRow = $dem;
                
				// unset($heightRow);	
				// $heightRow=$objexcel->setActiveSheetIndex()->getHighestRow();
				// unset($j);

				$count_ss = 0;
				$i = 0;
				$l = 0;
				$row_error = "";
				
				$data_tracking = [];
				
				$data_to_warehouses =[];
				
				
				for ($row = 2; $row <= $highestRow; $row++) {
                // Duyệt qua từng cột
                    for ($column = 'A'; $column <= 'B'; $column++) {
                
                        if($column === 'A'){
                            
                            $tracking_code = trim($sheet->getCell($column . $row)->getValue());
                            
                            $data_tracking[] = $tracking_code;
                            
                        }
                        else{
                            $to_warehouses = trim($sheet->getCell($column . $row)->getValue());
                            $data_to_warehouses[] = $to_warehouses;
                            
                        }
                      
                        
                    }
				    
				}
			
				
    			foreach($data_tracking as $key =>$tracking_code){
                            
                    $list = $model->get_records('tracking_code = "'.$tracking_code.'"','fs_order_uploads_detail','*');
                    
                    
                
    				// printr($list);
    
    				if(empty($list)){
    					$l++;
    					$row_error .= $row.",";
    					continue;
    				}
    				
    				
    
    				foreach ($list as $data) {
    				    
    				    
    					if($data-> is_print == 0){
    						continue;
    					}
    					
    				
    	
    					if($data-> is_refund == 1){
    						$i++;
    						continue;
    					}
    					
    					
    					
    					$add_id = $model->add_refund($data);
    					
    					if($add_id){
    						if($data-> is_package == 1){
    							$model->plus_money($data);
    						}
    
    						$row2 = array();
    						$row2['is_refund'] = 1;
    						$row2['date_refund'] = date('Y-m-d H:i:s');
    						
    						$row2['to_warehouses'] = $data_to_warehouses[$key];
    						
    						$model-> _update($row2,'fs_order_uploads_detail','id ='.$data->id);
    						//nếu tất cả sản phẩm ở đơn này hoàn thì chuyển trạng thái hoàn ở lợi nhuận sang 1
    						$model->update_profits_refund($data);
    						// nếu sản phẩm của đơn này chưa bắn ra kho thì trừ tạm giữ đi
    						if($data-> is_shoot == 0){
    							$product_in_warehouse = $model->get_record('warehouses_id = ' . $data-> warehouse_id . ' AND product_id = '. $data-> product_id,'fs_warehouses_products');
    							$model->minus_quantity_product($data-> count,$product_in_warehouse);  //trừ tạm giữ đi
    						}
    						$i++;
    						
    					}
    					
    					else{
    						$l++;
    						$row_error .= $j.",";
    						continue;
    					}
    				
    				}
                              
    			} 
    			
            
				$link = FSRoute::_('index.php?module=refunds&view=excel');
				$message = 'Thành công '.$i.' dòng .';
				
				
				
				if($l > 0){
					$message .= 'Lỗi dòng ở các dòng '.$row_error . ' kiểm tra lại mã có tồn tại không';
				}
				setRedirect($link,$message);
			}
		}

		
		
		


		

		function download_file(){
		
			$path_file = PATH_BASE.LINK_AMIN.'export'.DS.'excel'.'mau_hoan_hang.xlsx'; 
			$fsstring = FSFactory::getClass('FSString');
			$file_export_name = 'mau_hoan_hang';
			$file_ext = $this -> getExt(basename('export'.DS.'excel'.DS.'mau_hoan_hang.xlsx'));
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

			echo $link_excel = URL_ADMIN.'/export/mau_excel/'. $file_export_name;
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