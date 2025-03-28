<?php
	class Add_productControllersExcel extends Controllers
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
			$warehouses = $model -> get_records('published = 1','fs_warehouses');
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

		function import_excel(){ //câp nhật
			$model = $this -> model;
			$fsFile = FSFactory::getClass('FsFiles');
			$path = PATH_BASE.'files/excel/warehouse_sales';
			$path = str_replace('/', DS,$path);
	        $excel = $fsFile -> upload_file("excel", $path ,100000000, '_'.time());
	        global $db;

	        $query_barcode = "SELECT id FROM fs_products ORDER BY id DESC LIMIT 1";

			$db->query($query_barcode);

			$barcodes = $db->getObject();

			$barcodes = intval($barcodes->id);

	        if(	!$excel){
				return false;
			}else{


				$file_path = $path.$excel;
				require_once("../libraries/PHPExcel-1.8/Classes/PHPExcel.php");
				$objReader = PHPExcel_IOFactory::createReaderForFile($file_path);
				$objReader->setLoadAllSheets();
				$objexcel = $objReader->load($file_path);
				$data_upload =$objexcel->getActiveSheet()->toArray('null',true,true,true);
				// printr($data);

				unset($heightRow);	
				$heightRow=$objexcel->setActiveSheetIndex()->getHighestRow();
				unset($j);



				$date = new DateTime();
				$dates = $date->format("Y/m/d");
				$dir_image = "images/products/".$dates;
				$savePath = PATH_BASE.'/'.$dir_image;

				if (!file_exists($savePath)) {
				    mkdir($savePath, 0775, true);
				}

				// echo "<pre>";

				// var_dump($data_upload);

				// echo "</pre>";

				// die;

				$count_ss = 0;
				$i = 0;
				$l = 0;
				$row_error = "";
				$dem=0;

				for($s=2;$s<=$heightRow;$s++){
					
					$imageUrl = trim($data_upload[$s]['V']);

					if(!$this->check_image($imageUrl)){

						$link = FSRoute::_('index.php?module=add_product&view=excel');

						$msg = "link ảnh sản phẩm $s bị lỗi, vui lòng kiểm tra lại";
						setRedirect($link,$msg,'error');
						
					}
				}	


				for($j=2;$j<=$heightRow;$j++){
					$dem++;
					//sản phẩm
					$row = array();
					$name = trim($data_upload[$j]['B']);
					if($name && $name != 'null'){
						$row['name'] = $name;

						$alias = $this->convertSlug($name);

						$row['alias'] = $alias;

					}
					$name_parent = trim($data_upload[$j]['C']);
					if($name_parent && $name_parent != 'null'){
						$row['parent_id_name'] = $name_parent;
					}	

					
					$code = trim($data_upload[$j]['F']);

					
					if(!$code && $code != 'null'){
						continue;
					}
					$row['code'] = $code;

					$row['created_time'] = date('Y-m-d H:i:s');
					
					$cat_name = trim($data_upload[$j]['N']);
					

					if($cat_name && $cat_name != 'null' ){
						$cat = $model->get_record('name = "'.$cat_name.'"','fs_products_categories','code,id,name');


						if(!empty($cat)){
							$row['category_name'] = $cat-> name;
							$row['category_id'] = $cat-> id;
							$row['category_id_wrapper'] = ','.$cat-> id.',';
						}
					}

					$type = trim($data_upload[$j]['D']);
					if($type && $type != 'null'){
						$type_data = $model->get_record('name = "'.$type.'"','fs_products_types','id,name');
						if(!empty($type_data)){
							$row['type_id'] = $type_data-> id;
						}
					}

					$imageUrl = trim($data_upload[$j]['V']);

					if($imageUrl && $imageUrl != 'null'){

					
						$extension = pathinfo(parse_url($imageUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
						$filename = basename(parse_url($imageUrl, PHP_URL_PATH));
						$saveFile = $savePath .'/'. $filename;

						$row['image'] = $dir_image.'/'.$filename;

						$this->downloadImage($imageUrl, $saveFile);

						$row['image'] = $dir_image.'/'.$filename;

					}



					$status = trim($data_upload[$j]['E']);
					if($status && $status != 'null'){
						$status_data = $model->get_record('name = "'.$status.'"','fs_products_status','id,name');
						if(!empty($status_data)){
							$row['status_id'] = $status_data-> id;
						}
					}
					
					$barcode_int = $barcodes+$dem;
				
					$row['barcode'] = $barcode_int;
					

					$import_price = trim($data_upload[$j]['H']);
					if($import_price && $import_price != 'null'){
						$import_price = str_replace(',','',$import_price);
						$import_price = str_replace('.','',$import_price);
						$row['import_price'] = (float)$import_price;
					}



		
					$price = trim($data_upload[$j]['J']);
					
					if($price && $price != 'null'){
						$price = str_replace(',','',$price);
						$price = str_replace('.','',$price);
						
					}
					

					$row['price'] = (int)$price;

					$price_pack = trim($data_upload[$j]['L']);
					$price_pack = 0;
					if($price_pack && $price_pack != 'null'){
						$price_pack = str_replace(',','',$price_pack);
						$price_pack = str_replace('.','',$price_pack);
						
					}
					$row['price_pack'] = (int)$price_pack;
		
					
					$price_wholesale = trim($data_upload[$j]['K']);
					if($price_wholesale && $price_wholesale != 'null' ){
						$price_wholesale = str_replace(',','',$price_wholesale);
						$price_wholesale = str_replace('.','',$price_wholesale);
						$row['price_wholesale'] = (int)$price_wholesale;
					}
					

					$price_old = trim($data_upload[$j]['M']);
					if($price_old  && $price_old != 'null' ){
						$price_old = str_replace(',','',$price_old);
						$price_old = str_replace('.','',$price_old);
						$row['price_old'] = (int)$price_old;
					}
					


					$price_min = trim($data_upload[$j]['AF']);
					if($price_min  && $price_min != 'null' ){
						$price_min = str_replace(',','',$price_min);
						$price_min = str_replace('.','',$price_min);
						$row['price_min'] = (int)$price_min;
					}
					
					
					$check = $model->get_record('code = "'.$code.'"','fs_products','code,id');

					if(!empty($check)){
						$row['price'] ===0?unset($row['price']):$row['price'];

						$row['price_pack'] ===0?unset($row['price_pack']):$row['price_pack'];

						$row['price_wholesale'] ===0?unset($row['price_wholesale']):$row['price_wholesale'];

						$row['price_old'] ===0?unset($row['price_old']):$row['price_old'];

						$row['price_min'] ===0?unset($row['price_min']):$row['price_min'];



						var_dump($row);

						die;

						// $update_id = $model-> _update($row,'fs_products','id ='.$check->id);


					}else{
						
						var_dump($row);

						die;
						// $add_id = $model-> _add($row,'fs_products');
					}

					$i++;
				}

				$link = FSRoute::_('index.php?module=add_product&view=excel');

				$msg = "Có " .$i. ' dòng thành công !';
				setRedirect($link,$msg);
	
			}
		}


		function export_product(){
			// xóa các file cũ trong thư mục cho nhẹ server
			$path_remove_file = PATH_ADMINISTRATOR.DS.'export'.DS.'excel'.DS.'order_item'.DS;
			array_map('unlink', array_filter(
       		(array) array_merge(glob($path_remove_file."*"))));

			FSFactory::include_class('excel','excel');
			$model  = $this -> model;
			$filename = 'DANH_SACH_SAN_PHAM';
			$filename = strtoupper($filename);
			
			$list = $model->get_records('','fs_products');

		
			if(empty($list)){
				echo 'Không có sản phẩm !';exit;
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


				// $excel->obj_php_excel->getActiveSheet()->mergeCells('A1:F1');
				// $excel->obj_php_excel->getActiveSheet ()->setCellValue ('A1', $filename);
				// $excel->obj_php_excel->getActiveSheet ()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
		
				$excel->obj_php_excel->getActiveSheet()->setCellValue('A1', 'Mã sản phẩm');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('B1', 'Giá nhập');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('C1', 'Giá bán lẻ');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('D1', 'Giá đón gói');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('E1', 'Giá sỉ');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('F1', 'Giá cũ');
				foreach ($list as $item){
					$key = isset($key)?($key+1):2;
					$excel->obj_php_excel->getActiveSheet()->setCellValue('A'.$key, $item->code);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.$key, $item->import_price);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('C'.$key, $item->price);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('D'.$key, $item->price_pack);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('E'.$key, $item->price_wholesale);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('F'.$key, $item->price_old);

				}

				$excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray( $style_header );
				$excel->obj_php_excel->getActiveSheet()->duplicateStyle( $excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:F1' );

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

		function import_excel_old(){ // thêm mới
			$model = $this -> model;
			$fsFile = FSFactory::getClass('FsFiles');
			$path = PATH_BASE.'files/excel/warehouse_sales';
			$path = str_replace('/', DS,$path);
	        $excel = $fsFile -> upload_file("excel", $path ,100000000, '_'.time());
	        if(	!$excel){
				return false;
			}else{
				$file_path = $path.$excel;
				require_once("../libraries/PHPExcel-1.8/Classes/PHPExcel.php");
				$objReader = PHPExcel_IOFactory::createReaderForFile($file_path);
				$objReader->setLoadAllSheets();
				$objexcel = $objReader->load($file_path);
				$data_upload =$objexcel->getActiveSheet()->toArray('null',true,true,true);
				// printr($data);

				unset($heightRow);	
				$heightRow=$objexcel->setActiveSheetIndex()->getHighestRow();
				unset($j);

				$count_ss = 0;
				$i = 0;
				$l = 0;
				$row_error = "";
				for($j=2;$j<=$heightRow;$j++){
					//sản phẩm
					$row = array();
					$row['id'] = trim($data_upload[$j]['A']);
					$row['name'] = trim($data_upload[$j]['B']);
					$row['code'] = trim($data_upload[$j]['C']);
					$row['barcode'] = trim($data_upload[$j]['D']);
					$row['import_price'] = trim($data_upload[$j]['E']);
					$row['price'] = trim($data_upload[$j]['F']);
					$row['price_pack'] = trim($data_upload[$j]['G']);
					$row['import_price'] = trim($data_upload[$j]['H']);
					$row['price_wholesale'] = trim($data_upload[$j]['I']);
					$row['price_old'] = trim($data_upload[$j]['J']);
					$row['vat'] = trim($data_upload[$j]['K']);
					$row['shipping_weight'] = trim($data_upload[$j]['L']);
					$row['unit'] = trim($data_upload[$j]['M']);
					$row['length'] = trim($data_upload[$j]['N']);
					$row['width'] = trim($data_upload[$j]['O']);
					$row['height'] = trim($data_upload[$j]['P']);
					$row['tutorial_link'] = trim($data_upload[$j]['Q']);
					$row['published'] = 1;
					$row['created_time'] = date('Y-m-d H:i:s');
					
					$check = $model->get_record('code = "'.$row['code'].'"','fs_products','id');
					if(!empty($check)){
						$update_id = $model-> _update($row,'fs_products','id = '.$check->id);
						if($update_id){
							$fields = $model->get_records ( '', 'fs_tables', '*', '', '', 'id' );
							$row_ex = array();
							$row_tb = $row;
							foreach ($fields as $key => $field) {
								if(isset($row_tb[$field->field_name])){
									$row_ex[$field->field_name] = $row_tb[$field->field_name];
								}
							}
							$model->_update($row_ex,'fs_products_parameter', 'record_id = '.$check->id );
						}else{
							continue;
						}

					}else{
						// $row['created_time'] = date('Y-m-d H:i:s');
						// $add_id = $model-> _add($row,'fs_products');

						// if($add_id){
						// 	$fields = $model->get_records ( '', 'fs_tables', '*', '', '', 'id' );
						// 	$row_ex = array();
						// 	$row_tb = $row;
						// 	foreach ($fields as $key => $field) {
						// 		if(isset($row_tb[$field->field_name])){
						// 			$row_ex[$field->field_name] = $row_tb[$field->field_name];
						// 		}
						// 	}
						// 	$row_ex['record_id'] = $add_id;
						// 	// printr($row_ex);
						// 	$model->_add($row_ex,'fs_products_parameter', 1 );
						// }else{
						// 	continue;
						// }

						// $extend_size = trim($data_upload[$j]['AZ']);
						// if($extend_size){
						// 	$get_size = $model->get_record('name = "'.$extend_size.'"','fs_extends_items','id');
						// 	$row2 = array();
						// 	$row2['kich_thuoc'] = $get_size-> id;
						// 	$model->_update($row2,'fs_products_parameter','record_id = '.$add_id);
						// }
						
						// $extend_color = trim($data_upload[$j]['BA']);
						// if($extend_color){
						// 	$get_color = $model->get_record('name = "'.$extend_color.'"','fs_extends_items','id');
						// 	$row3 = array();
						// 	$row3['mau_sac'] = $get_color-> id;
						// 	$model->_update($row3,'fs_products_parameter','record_id = '.$add_id);
						// }
					}

				}
				$link = FSRoute::_('index.php?module=add_product&view=excel');
				
				setRedirect($link);
			}
		}

		function convertSlug($title)
	    {
	       
	        $replacement = '-';
	        $map = array();
	        $quotedReplacement = preg_quote($replacement, '/');
	        $default = array(
	            '/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ|À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ|å/' => 'a',
	            '/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ|È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ|ë/' => 'e',
	            '/ì|í|ị|ỉ|ĩ|Ì|Í|Ị|Ỉ|Ĩ|î/' => 'i',
	            '/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ|Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ|ø/' => 'o',
	            '/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ|Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ|ů|û/' => 'u',
	            '/ỳ|ý|ỵ|ỷ|ỹ|Ỳ|Ý|Ỵ|Ỷ|Ỹ/' => 'y',
	            '/đ|Đ/' => 'd',
	            '/ç/' => 'c',
	            '/ñ/' => 'n',
	            '/ä|æ/' => 'ae',
	            '/ö/' => 'oe',
	            '/ü/' => 'ue',
	            '/Ä/' => 'Ae',
	            '/Ü/' => 'Ue',
	            '/Ö/' => 'Oe',
	            '/ß/' => 'ss',
	            '/[^\s\p{Ll}\p{Lm}\p{Lo}\p{Lt}\p{Lu}\p{Nd}]/mu' => ' ',
	            '/\\s+/' => $replacement,
	            sprintf('/^[%s]+|[%s]+$/', $quotedReplacement, $quotedReplacement) => '',
	        );
	        //Some URL was encode, decode first
	        $title = urldecode($title);
	        $map = array_merge($map, $default);
	        return strtolower(preg_replace(array_keys($map), array_values($map), $title));

	    }


		//trừ tạm giữ đi, và trừ số lượng chính đi
		function minus_quantity_product($count = 1,$data){
			$model = $this -> model;
			$row = array();
			$row['amount_hold'] = (float)$data->amount_hold - (float)$count;
			$row['amount'] = (float)$data->amount - (float)$count;
			$model->_update($row,'fs_warehouses_products','id = '.$data->id);
			
		}
		
		//cộng số lượng của sản phẩm khi hoàng hàng thành công
		function plus_quantity_product($warehouse_id,$product_id,$count = 1){
			$model = $this -> model;
			$data = $model->get_record('warehouses_id = ' . $warehouse_id . ' AND product_id = '. $product_id,'fs_warehouses_products');
			if(!empty($data)){
				$row = array();
				$row['amount'] = (int)$data->amount + (int)$count;
				$update = $model->_update($row,'fs_warehouses_products','id = '.$data->id);
				return $update;
			}else{
				return 0;
			}
		}


		function shoot_order(){
			$model = $this -> model;
			$rows = $model->shoot_order(1);
			$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
			$page = FSInput::get('page',0);
			if($page > 1){
				$link .= '&page='.$page;
			}
			$link = FSRoute::_($link);
			if($rows)
			{
				setRedirect($link,$rows.' '.FSText :: _('đơn được bắn ra kho'));	
			}
			else
			{
				setRedirect($link,FSText :: _('Đơn này chưa xác nhận đã đóng hàng hoặc đã hoàn hàng'),'error');	
			}
		}


		function download_file(){
		
			FSFactory::include_class('excel','excel');
			$model  = $this -> model;
			$filename = 'Danh_sach_san_pham';
			$list = $model->get_records('','fs_products');
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
				
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
			
				
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
		
	
				
				
				$excel->obj_php_excel->getActiveSheet()->setCellValue('A1', 'Tên');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('B1', 'Mã');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('C1', 'Mã danh mục');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('D1', 'Loại sản phẩm');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('E1', 'Trạng thái');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('F1', 'Mã vạch');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('G1', 'Giá nhập');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('H1', 'Giá bán lẻ');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('I1', 'Giá đóng gói');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('J1', 'Giá sỉ');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('K1', 'Giá cũ');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('L1', 'Giá min');

				$total_money = 0;
				$total_quantity = 0;
				$i=0;

				$manus = $model -> get_records('','fs_manufactories','id,name','','','id');
				$status = $model -> get_records('','fs_products_status','id,name','','','id');
				$types = $model -> get_records('','fs_products_types','id,name','','','id');
				$origins = $model -> get_records('','fs_products_origins','id,name','','','id');
				$categories = $model -> get_records('','fs_products_categories','id,name,code','','','id');
	

				foreach ($list as $item){
					$type_name = !empty($types[$item->type_id]) ? $types[$item->type_id]-> name : '';
					$manu_name = !empty($manus[$item->manufactory]) ? $manus[$item->manufactory]-> name : '';
					$status_name = !empty($status[$item->status_id]) ? $status[$item->status_id]-> name : '';
					$origin_name = !empty($origins[$item->origin_id]) ? $origins[$item->origin_id]-> name : '';
					$cat_name = !empty($categories[$item->category_id]) ? $categories[$item->category_id]-> name : '';
					$cat_code = !empty($categories[$item->category_id]) ? $categories[$item->category_id]-> code : '';
					

					
		

					$key = isset($key)?($key+1):2;
					$excel->obj_php_excel->getActiveSheet()->setCellValue('A'.$key, $item->name);		
					$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.$key, $item->code);	
					$excel->obj_php_excel->getActiveSheet()->setCellValue('C'.$key, $cat_code); 
					$excel->obj_php_excel->getActiveSheet()->setCellValue('D'.$key, $type_name);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('E'.$key, $status_name);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('F'.$key, $item->barcode);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('G'.$key, $item->import_price);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('H'.$key, $item->price);	
					$excel->obj_php_excel->getActiveSheet()->setCellValue('I'.$key, $item->price_pack);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('J'.$key, $item->price_wholesale);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('K'.$key, $item->price_old);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('L'.$key, $item->price_min);
					$i ++;
				}

				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray( $style_header );
				$excel->obj_php_excel->getActiveSheet()->duplicateStyle( $excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:L1');

				$excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(40);
				
//				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getAlignment()->setIndent(1);// padding cell
				
				$output = $excel->write_files();

				if(!empty($output['xlsx'])){
				
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

		function getExt($file){
			return strtolower(substr($file, (strripos($file, '.')+1),strlen($file)));
		}

		function check_image($url)
		{
			$ch = curl_init($url);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		    $data = curl_exec($ch);
		    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		    curl_close($ch);

		    if ($httpCode != 200 && !$data) {
		    	return false;
		    }
		    else{
		    	return true;
		    }	
		}

		function downloadImage($url, $saveTo) {
		    $ch = curl_init($url);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		    $data = curl_exec($ch);
		    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		    curl_close($ch);
		    
		    if ($httpCode == 200 && $data) {
		        file_put_contents($saveTo, $data);
		       
		    } else {

		       return false;
		    }
		}


	}

?>