<?php
	class Order_itemsControllersItems extends Controllers
	{
		function __construct()
		{
			$this->view = 'items'; 
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

			if(isset($_SESSION[$this -> prefix.'text1']))
			{
				$date_from = $_SESSION[$this -> prefix.'text1'];
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

			
			$start = microtime(true);

			$end = microtime(true);

			// Tính thời gian chạy
			$executionTime1 = $end - $start;

			echo "Thời gian thực thi server là: " . number_format($executionTime1, 6) . " giây <br>";


			$start = microtime(true);
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			$model  = $this -> model;
			$wrap_id_warehouses = $model->get_wrap_id_warehouses();
			$warehouses = $model -> get_records('published = 1 AND id IN ('.$wrap_id_warehouses.')','fs_warehouses');
			$platforms = $model -> get_records('published = 1','fs_platforms');
			$houses = $model -> get_records('published = 1','fs_house');
			
			$shipping_unit = $model -> get_records('published = 1','fs_shipping_unit');

			$end = microtime(true);

			// Tính thời gian chạy
			$executionTime2 = $end - $start;

			echo "Thời gian thực thi tác vụ 1 là: " . number_format($executionTime2, 6) . " giây <br>";



			$start = microtime(true);
			
			static $list = null;  //biến tĩnh dùng làm cache

		    if ($list === null) {

		    	// Kết nối Redis
				$redis = new Redis();
				$redis->pconnect('127.0.0.1', 6379); // IP & Port Redis server
				$key = "list_xuat_kho";
				if($_SESSION['ad_userid']==9){
					$cache_data = $redis->get($key);

					$list = json_decode($cache_data);

					echo "redis <br>";
				}
				else{
					$list = $this -> model->get_data();
				}	
		    	
				
		    }
		    else{
		    	echo "cache <br>";
		    }
			

			$pagination = $model->getPagination();

			$end = microtime(true);

			// Tính thời gian chạy
			$executionTime = $end - $start;

			echo "Thời gian thực thi: " . number_format($executionTime, 6) . " giây";

			$users = $model -> get_record('id = ' . $_SESSION['ad_userid'],'fs_users');

			
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';	

			


		}

		function checksv()
		{
			$start = microtime(true);



			$end = microtime(true);

			
		}

		function cache()
		{
			$start = microtime(true);

			$redis = new Redis();
			$redis->connect('127.0.0.1', 6379); // IP & Port Redis server
			$key = "list_xuat_kho";
			$cache_data = $redis->get($key);

			$list = json_decode($cache_data);

			// Lấy cache
			$data = apcu_fetch('list_xuat_kho');

			if ($data == false) {
			    apcu_store('list_xuat_kho', $list, 3600); // TTL 3600s = 1h
			    $data = apcu_fetch('list_xuat_kho');
			} 
			$end = microtime(true);

			// Tính thời gian chạy
			$executionTime = $end - $start;

			echo "Thời gian thực thi: " . number_format($executionTime, 6) . " giây";

			// $list = $this -> model->get_data();



			// $redis->set($key, json_encode($list));
			
			
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
			if($data-> is_shoot == 1 || $data-> is_refund == 1){
				$link = FSRoute::_('index.php?module=order_items&view=items');
				setRedirect($link,FSText :: _('Đơn ID '.$data->id.' đã được Bắn ra kho hoặc Hoàn hàng nên không sửa được'),'error');
			}
			// $warehouses = $model -> get_records('published = 1','fs_warehouses');
			// $platforms = $model -> get_records('published = 1','fs_platforms');
			// $houses = $model -> get_records('published = 1','fs_house');

			// $users = $model -> get_record('id = ' . $_SESSION['ad_userid'],'fs_users');
			// if($users->shop_id){
			// 	$shops = $model -> get_records('id IN ('.$users->shop_id.')','fs_shops');
			// }
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}

		public function details()
		{

			$etag = md5_file(__FILE__);
			header("ETag: \"$etag\"");
			header("Cache-Control: max-age=360000");

			if (isset($_SERVER['HTTP_IF_NONE_MATCH']) && 
			    $_SERVER['HTTP_IF_NONE_MATCH'] === "\"$etag\"") {
			    header("HTTP/1.1 304 Not Modified");
			    exit;
			}

			$start = microtime(true);
			global $db;

			$page = !empty($_GET['page'])?$_GET['page']:1;

			// $query = " SELECT * FROM run_check_file_order_pdf_excel
   			// 			  WHERE user_id = 208";

			$query = " SELECT * FROM fs_order_uploads_detail  WHERE is_package = 1 ORDER BY date_package DESC" ;

   			$sql = $db->query_limit($query, 10, $page);
			$result = $db->getObjectList();	



			$kho = ['Kho','Kho Hà nội','Kho HCM'];

			

			$san = ['Sàn','Lazada','Shopee','Tiki','Lex ngoài HCM','Đơn ngoài','','Best','Ticktok','Viettel','Shopee ngoài'];

			$end = microtime(true);

			// Tính thời gian chạy
			$executionTime = $end - $start;

			echo "Thời gian thực thi: " . number_format($executionTime, 6) . " giây";


			include 'modules/'.$this->module.'/views/'.$this->view.'/details.php';	
		}

		public function searchByTracking()
		{
			$start = microtime(true);
			$search = !empty($_GET['search'])?$_GET['search']:'';

			
			$context = stream_context_create(array(
	            'http' => array(
	                
	                'method' => 'GET',

	                'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
	                            "token: 7ojTLYXnzV0EH1wRGxOmvLFga",
	                
	            )
	        ));

	        $page =  !empty($_GET['page'])?$_GET['page']:1;

	        // Send the request

	       

	        static $response = null;  // 👈 biến tĩnh dùng làm cache

		    if ($response === null) {
		        
		       $response = file_get_contents('https://api.'.DOMAIN.'/api/search-data-order-to-date?&search='.$search,FALSE, $context);
		    }

		   

	        $results = json_decode($response);



	        $result = $results;

	      

	        $kho = ['Kho','Kho Hà nội','Kho HCM'];

			
			$san = ['Sàn','Lazada','Shopee','Tiki','Lex ngoài HCM','Đơn ngoài','','Best','Ticktok','Viettel','Shopee ngoài'];

			$end = microtime(true);

			// Tính thời gian chạy
			$executionTime = $end - $start;

			echo "Thời gian thực thi: " . number_format($executionTime, 6) . " giây";


	        include 'modules/'.$this->module.'/views/'.$this->view.'/details.php';

		}

		public function searchByTrackingToWarehouses()
		{
			
			global $db;

			$option = 0;

			if(!empty($_GET['options'])){

				$option = $_GET['options'];
			}

			$kho = $_GET['kho'];

			if($kho ==0){

				$link = 'https://'.DOMAIN.'/admin/order_items/items/details';
				$msg = 'kho chưa được chọn, vui lòng kiểm tra lại';

				setRedirect($link,$msg,'error');
			}

			if($option == 0){
				$link = 'https://'.DOMAIN.'/admin/order_items/items/details';
				$msg = 'bạn chưa chọn xuất file excel, vui lòng kiểm tra lại';

				setRedirect($link,$msg,'error');
			}

			$kho_define = ['Kho','Kho Hà nội','Kho HCM', 'Kho test', 'Kho hàng Cao Duy Hoan','Kho tầng 1', 'Kho Văn La', 'Kho Văn Phú'];

			$date1 = !empty($_GET['date1'])?$_GET['date1']:'';

			$date2 = !empty($_GET['date1'])?$_GET['date2']:'';

			

			$filename = 'danh_sach_don_hang_cua_kho';



			$context = stream_context_create(array(
	            'http' => array(
	                
	                'method' => 'GET',

	                'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
	                            "token: 7ojTLYXnzV0EH1wRGxOmvLFga",
	                
	            )
	        ));



	        // Send the request

	        $response = file_get_contents('https://api.'.DOMAIN.'/api/search-data-user-id-package-to-ware-houses?kho='.$kho.'&date1='.$date1.'&date2='.$date2, FALSE, $context);

	        $info_data  = json_decode($response);

	        

	        // nếu xuất excel bằng 1

	        if($option ==1 && !empty($info_data->data)){
	        	 FSFactory::include_class('excel','excel');

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

				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('B')->setWidth(80);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('C')->setWidth(90);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('M')->setWidth(30);

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


				$excel->obj_php_excel->getActiveSheet()->setCellValue('A1', 'STT');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('B1', 'Tracking code');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('C1', 'Tên sản phẩm');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('D1', 'Tên shop');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('E1', 'Mã shop');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('F1', 'Số lượng');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('G1', 'Id đơn hàng');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('H1', 'Người đánh đơn');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('I1', 'Ngày đánh đơn');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('J1', 'Thời gian đóng đơn hàng');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('K1', 'Thành tiền');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('L1', 'Đơn vị vẩn chuyển');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('M1', 'Kho');

				$key=1;
				$stt =0;

				if(!empty($info_data->data)){

					foreach ($info_data->data as $item){
						$key++;
						$stt++;

						
						$excel->obj_php_excel->getActiveSheet()->setCellValue('A'.$key, $stt);		
						$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.$key, $item->tracking_code);	
						$excel->obj_php_excel->getActiveSheet()->setCellValue('C'.$key, $item->product_name); 
						$excel->obj_php_excel->getActiveSheet()->setCellValue('D'.$key, $item->shop_name);
						$excel->obj_php_excel->getActiveSheet()->setCellValue('E'.$key, $item->shop_code);
						$excel->obj_php_excel->getActiveSheet()->setCellValue('F'.$key, $item->count);
						$excel->obj_php_excel->getActiveSheet()->setCellValue('G'.$key, $item->record_id);



		                $sql = " SELECT username FROM  fs_users WHERE id = '$item->user_package_id'";
		                $name = $db->getResult($sql);
		            
						$excel->obj_php_excel->getActiveSheet()->setCellValue('H'.$key, $name);
						$excel->obj_php_excel->getActiveSheet()->setCellValue('I'.$key, date("d/m/Y", strtotime($item->date)));
						$excel->obj_php_excel->getActiveSheet()->setCellValue('J'.$key, date("d/m/Y, H:i:s", strtotime($item->date_package)));
						$excel->obj_php_excel->getActiveSheet()->setCellValue('K'.$key, number_format((float)$item->total_price, 0, ',', '.'));
						$excel->obj_php_excel->getActiveSheet()->setCellValue('L'.$key, $item->shipping_unit_name??'');
						$excel->obj_php_excel->getActiveSheet()->setCellValue('M'.$key, $kho_define[$item->warehouse_id]??'');

					}
				}	
				$output = $excel->write_files();

				$path_file =   PATH_ADMINISTRATOR.DS.str_replace('/',DS, $output['xls']);
				header("Pragma: public");
				header("Expires: 0");
				header("Cache-Control:no-cache, must-revalidate, post-check=0, pre-check=0");
				header("Cache-Control: private",false);		
				header("Content-type: application/force-download");		
				header("Content-Disposition: attachment; filename=\"".$filename.'.xlsx'."\";" );
				header("Content-Transfer-Encoding: binary");
				header("Content-Length: ".filesize($path_file));	

				echo $link_excel = URL_ROOT.LINK_AMIN.'/export/excel/'. $filename.'.xlsx';	

				setRedirect($link_excel);
				readfile($path_file);

	        }


	        include 'modules/'.$this->module.'/views/'.$this->view.'/details.php';

		}

		function test_excel_nhat()
		{
			 $model  = $this -> model;
			$id = $_GET['id'];
			$combo_code = $model->show_product_combo($id);
			echo "<pre>";
			var_dump($combo_code);
			echo "</pre>";


		}

		function view_record_id($controle, $id)
		{
			$model = $controle -> model;
			$data = $model->get_record('id = ' .$id,'fs_order_uploads_detail','record_id');
			
			return $data->record_id;
		}


		function get_list_detail_tong(){
			global $db;


			$query = 'SELECT * FROM fs_order_uploads_detail AS a  WHERE 1=1 AND is_print = 1    AND a.date =  "2025-05-30"  AND a.house_id =  "9"  AND a.warehouse_id =  "1"  AND a.platform_id =  "2"  ORDER BY sku_fisrt ASC,ABS(sku_fisrt),sku_last ASC,ABS(sku_last),color ASC,ABS(color),size ASC,ABS(size),created_time DESC , id DESC';

			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}

		function generateDailyPath($baseDir = 'uploads') {
		    // Get the current year, month, and day
		    $year = date('Y');
		    $month = date('m');
		    $day = date('d');

		    // Construct the path
		    $path = $baseDir . '/' . $year . '/' . $month . '/' . $day;

		    if (!is_dir($path)) {

			    mkdir($path, 0755, true);
			}

		    return $path;
		}

		function showTongNgayFileNhatTiktok()
		{
			$model  = $this -> model;
			global $db;
			$baseDir =  PATH_BASE.'admin/export/excel/order_item';

			$warehouse_id = $_GET['warehouse_id'];

			$date = date('Y-m-d');

			$dates_fix = date('d_m_y');

			$platform_id = 9;

			$H = date('G');
			$M = date('i');

			if ($H < 12) {
			    $house_id = 13;
			}
			
			else {
			    $house_id = 18;
			} 

			
			

			$filename = 'file_nhat_tiktok'.$warehouse_id .'_'.$platform_id.'_'.$dates_fix.'_'.$house_id;

			

			$query = "SELECT id,count,product_id,sku,product_name,`date`,is_print,product_id,house_id,warehouse_id,color,size,platform_id,shipping_unit_id FROM fs_order_uploads_detail AS a where 1=1 AND is_print = 1    AND a.date =  '$date'  AND a.house_id =  '$house_id'  AND a.warehouse_id =  '$warehouse_id'  AND a.platform_id =  '$platform_id'  AND warehouse_id IN (1,2,4,6,7) ORDER BY sku_fisrt ASC,ABS(sku_fisrt),sku_last ASC,ABS(sku_last),color ASC,ABS(color),size ASC,ABS(size),created_time DESC , id DESC";

			$sql = $db->query($query);

			$list = $db->getObjectList();

			$querys = "SELECT  id FROM fs_order_uploads_history_prints WHERE platform_id = '$platform_id' AND warehouse_id = '$warehouse_id' AND house_id = $house_id ORDER BY id DESC";

			$sqls = $db->query($querys);

			$id_xlsx = $db->getResult();



			$querys = "SELECT * FROM fs_order_uploads_detail AS a  WHERE 1=1 AND is_print = 1    AND a.date =  '$date'  AND a.house_id =  '$house_id'  AND a.warehouse_id =  '$warehouse_id'  AND a.platform_id =  '$platform_id'  ORDER BY sku_fisrt ASC,ABS(sku_fisrt),sku_last ASC,ABS(sku_last),color ASC,ABS(color),size ASC,ABS(size),created_time DESC , id DESC";

			$sqls = $db->query($querys);
			$result = $db->getObjectList();



			// phần xuất file excel 

			if(empty($list)){
				echo 'Không có đơn nào được tìm thấy !';exit;
			}else {

				

				//tính tổng
				$arr_total_count = array();
				foreach($list as $item) {
					$item->sku = strtoupper($item->sku);
					if(empty($arr_total_count[$item->sku])){
						$arr_total_count[$item->sku] = $item;
					}else{
						$arr_total_count[$item->sku]->count = $arr_total_count[$item->sku]->count + $item->count;
					}
				}
				$list = $arr_total_count;
				// printr($arr_total_count);
				FSFactory::include_class('excel','excel');
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
				$excel->obj_php_excel->getActiveSheet()->setTitle("Tổng In Tiktok");
				$excel->obj_php_excel->getActiveSheet()->mergeCells('A1:E1');
				$excel->obj_php_excel->getActiveSheet()->setCellValue ('A1', $filename);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

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
				// printr($list);
				foreach ($list as $item){
					$key = isset($key)?($key+1):3;
					$excel->obj_php_excel->getActiveSheet()->setCellValue('A'.$key, $item->sku);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.$key, $item->product_name);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('C'.$key, $item->count);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('D'.$key,'');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('E'.$key, '');
				}

				
				$excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray( $style_header );
				$excel->obj_php_excel->getActiveSheet()->duplicateStyle( $excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:E1' );




				// Add new sheet

				
			    $total_sheet = $excel->obj_php_excel->createSheet(1);
			    $total_sheet->setTitle("Tổng đơn 1");

			   
				$total_sheet->getColumnDimension('A')->setWidth(20);
				$total_sheet->getColumnDimension('B')->setWidth(20);
				$total_sheet->getColumnDimension('C')->setWidth(20);
				$total_sheet->getColumnDimension('D')->setWidth(20);
				$total_sheet->getColumnDimension('E')->setWidth(20);
				$total_sheet->getColumnDimension('F')->setWidth(20);
				$total_sheet->getColumnDimension('G')->setWidth(25);
				$total_sheet->getColumnDimension('H')->setWidth(20);
				$total_sheet->getColumnDimension('I')->setWidth(40);
				$total_sheet->getColumnDimension('J')->setWidth(40);
				// $total_sheet->getColumnDimension('K')->setWidth(15);
				// $total_sheet->getColumnDimension('L')->setWidth(20);
				// $total_sheet->getColumnDimension('M')->setWidth(20);
				// $total_sheet->getColumnDimension('N')->setWidth(30);
				// $total_sheet->getColumnDimension('O')->setWidth(15);
				$total_sheet->getColumnDimension('K')->setWidth(20);
				$total_sheet->getColumnDimension('L')->setWidth(30);
		
				$total_sheet->setCellValue('A1', 'Tên gian hàng');
				$total_sheet->setCellValue('B1', 'Số chứng từ');
				$total_sheet->setCellValue('C1', 'Mã SKU đúng');
				$total_sheet->setCellValue('D1', 'Mã đơn hàng');
				$total_sheet->setCellValue('E1', 'Mã kiện hàng');
				$total_sheet->setCellValue('F1', 'Ngày đặt hàng');
				$total_sheet->setCellValue('G1', 'Mã vận đơn');
				$total_sheet->setCellValue('H1', 'Ngày gửi hàng');
				$total_sheet->setCellValue('I1', 'Tên sản phẩm');
				$total_sheet->setCellValue('J1', 'SKU phân loại hàng');
				// $total_sheet->setCellValue('K1', 'Giá gốc');
				// $total_sheet->setCellValue('L1', 'Người bán trợ giá');
				// $total_sheet->setCellValue('M1', 'Được Shopee trợ giá');
				// $total_sheet->setCellValue('N1', 'Tổng số tiền được người bán trợ giá');
				// $total_sheet->setCellValue('O1', 'Giá ưu đãi');
				$total_sheet->setCellValue('K1', 'Số lượng');
				$total_sheet->setCellValue('L1', 'Tổng giá bán (sản phẩm)');
				$list_detail = $result;
				
				foreach ($list_detail as $item_dt){
					if($item_dt->ma_kien_hang == 'null'){
						$item_dt->ma_kien_hang = '';
					}
					$key_sheet_2 = isset($key_sheet_2)?($key_sheet_2+1):2;
					$total_sheet->setCellValue('A'.$key_sheet_2, $item_dt->shop_name);
					$total_sheet->setCellValue('B'.$key_sheet_2, $item_dt->shop_code);
					$total_sheet->setCellValue('C'.$key_sheet_2, $item_dt->sku);
					$total_sheet->setCellValue('D'.$key_sheet_2, $item_dt->code);
					$total_sheet->setCellValue('E'.$key_sheet_2, $item_dt->ma_kien_hang);
					$total_sheet->setCellValue('F'.$key_sheet_2, $item_dt->created_at);
					$total_sheet->setCellValue('G'.$key_sheet_2, $item_dt->tracking_code);
					$total_sheet->setCellValue('H'.$key_sheet_2, $item_dt->ngay_gui_hang);
					$total_sheet->setCellValue('I'.$key_sheet_2, $item_dt->product_name);
					$total_sheet->setCellValue('J'.$key_sheet_2, $item_dt->sku_nhanh);
					// $total_sheet->setCellValue('K'.$key_sheet_2, $item_dt->gia_goc);
					// $total_sheet->setCellValue('L'.$key_sheet_2, $item_dt->nguoi_ban_tro_gia);
					// $total_sheet->setCellValue('M'.$key_sheet_2, $item_dt->shopee_tro_gia);
					// $total_sheet->setCellValue('N'.$key_sheet_2, $item_dt->tong_so_tien_duoc_nguoi_ban_tro_gia);
					// $total_sheet->setCellValue('O'.$key_sheet_2, $item_dt->gia_uu_dai);
					$total_sheet->setCellValue('K'.$key_sheet_2, $item_dt->count);
					$total_sheet->setCellValue('L'.$key_sheet_2, $item_dt->don_ngoai_tong_gia_tri_don);
				}
				$total_sheet->getRowDimension(1)->setRowHeight(20);
				$total_sheet->getStyle('A1')->getFont()->setSize(12);
				$total_sheet->getStyle('A1')->getFont()->setName('Arial');
				$total_sheet->getStyle('A1')->applyFromArray($style_header);
				$total_sheet->duplicateStyle( $total_sheet->getStyle('A1'),'B1:L1');

				$path = $this->generateDailyPath($baseDir);

				$link_excel = $path.'/'. $filename.'.xlsx';

				$excel->set_params(array('out_put_xls'=>$link_excel,'out_put_xlsx'=>$link_excel));

				$output = $excel->write_files();

				$dir_file = str_replace('/www/wwwroot/'.DOMAIN, '', $link_excel);



				
				$sql_xls_query= "UPDATE fs_order_uploads_history_prints SET file_xlsx = '$dir_file'  WHERE `id`=".$id_xlsx;

				$db->query($sql_xls_query);
				
				echo "thành công";

			}	// end xuất file
		}


		function showTongNgayFileNhat()
		{
			$baseDir =  PATH_BASE.'admin/export/excel/order_item/';

			$warehouse_id = $_GET['warehouse_id'];

			$date = date('Y-m-d');

			$dates_fix = date('d_m_y');

			$platform_id = 2;

			$H = date('G');
			$M = date('i');

			if ($H < 8) {
			    $house_id = 13;
			}
			elseif ($H >= 8 && $H < 12){
				$house_id = 14;
			} elseif ($H >= 12 && $H < 13) {
			    $house_id = 18;
			}
			elseif ($H >= 14 && $H < 15) {
				$platform = [1,3,4,6,8,9,10,11];
			    $house_id = 15;
			} 
			else {
			    $house_id = 8;
			} 

			

			$filename = 'file_nhat_'.$warehouse_id .'_'.$platform_id.'_'.$dates_fix.'_'.$house_id;

			global $db;

			$query = "SELECT id,count,product_id,sku,product_name,`date`,is_print,product_id,house_id,warehouse_id,color,size,platform_id,shipping_unit_id FROM fs_order_uploads_detail AS a where 1=1 AND is_print = 1    AND a.date =  '$date'  AND a.house_id =  '$house_id'  AND a.warehouse_id =  '$warehouse_id'  AND a.platform_id =  '$platform_id'  AND warehouse_id IN (1,2,4,6,7) ORDER BY sku_fisrt ASC,ABS(sku_fisrt),sku_last ASC,ABS(sku_last),color ASC,ABS(color),size ASC,ABS(size),created_time DESC , id DESC";

			$sql = $db->query($query);

			$list = $db->getObjectList();

			$querys = "SELECT  id FROM fs_order_uploads_history_prints WHERE platform_id = '$platform_id' AND warehouse_id = '$warehouse_id' AND house_id = $house_id ORDER BY id DESC";

			$sqls = $db->query($querys);

			$id_xlsx = $db->getResult();



			$querys = "SELECT * FROM fs_order_uploads_detail AS a  WHERE 1=1 AND is_print = 1    AND a.date =  '$date'  AND a.house_id =  '$house_id'  AND a.warehouse_id =  '$warehouse_id'  AND a.platform_id =  '$platform_id'  ORDER BY sku_fisrt ASC,ABS(sku_fisrt),sku_last ASC,ABS(sku_last),color ASC,ABS(color),size ASC,ABS(size),created_time DESC , id DESC";

			$sqls = $db->query($querys);
			$result = $db->getObjectList();

		

			// phần xuất file excel 

			if(empty($list)){
				echo 'Không có đơn nào được tìm thấy !';exit;
			}else {

				//tính tổng
				$arr_total_count = array();
				foreach($list as $item) {
					$item->sku = strtoupper($item->sku);
					if(empty($arr_total_count[$item->sku])){
						$arr_total_count[$item->sku] = $item;
					}else{
						$arr_total_count[$item->sku]->count = $arr_total_count[$item->sku]->count + $item->count;
					}
				}
				$list = $arr_total_count;
				// printr($arr_total_count);
				FSFactory::include_class('excel','excel');
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

				$excel->obj_php_excel->getActiveSheet()->setTitle("Tổng In");
				$excel->obj_php_excel->getActiveSheet()->mergeCells('A1:E1');
				$excel->obj_php_excel->getActiveSheet()->setCellValue ('A1', $filename);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('B')->setWidth(60);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
				$excel->obj_php_excel->getActiveSheet()->setCellValue('A2', 'Mã');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('B2', 'Tên sản phẩm');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('C2', 'Mã màu');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('D2', 'Mã size');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('E2', 'SL');
				
				$excel->obj_php_excel->getActiveSheet()->setCellValue('G2', 'Tổng đơn');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('H2', 'Thực xuất');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('I2', 'NV đóng gói');
				// printr($list);
				foreach ($list as $item){
					$key = isset($key)?($key+1):3;
					
					$excel->obj_php_excel->getActiveSheet()->setCellValue('A'.$key, $item->sku);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.$key, $item->product_name);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('C'.$key, $item->color);
					$excel->obj_php_excel->getActiveSheet()->setCellValueExplicit('D'.$key,$item->size,PHPExcel_Cell_DataType::TYPE_STRING);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('E'.$key, $item->count);
					

					$excel->obj_php_excel->getActiveSheet()->setCellValue('G'.$key, $item->count);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('H'.$key,'');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('I'.$key, '');
				}

				
				$excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray( $style_header );
				$excel->obj_php_excel->getActiveSheet()->duplicateStyle( $excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:E1' );


				// Add new sheet

				
			    $total_sheet = $excel->obj_php_excel->createSheet(1);
			    $total_sheet->setTitle("Tổng đơn 1");

			    // echo $_SESSION[$this -> prefix.'filter2'];
			    // die;
			  
			    $total_sheet->getColumnDimension('A')->setWidth(20);
				$total_sheet->getColumnDimension('B')->setWidth(20);
				$total_sheet->getColumnDimension('C')->setWidth(20);
				$total_sheet->getColumnDimension('D')->setWidth(20);
				$total_sheet->getColumnDimension('E')->setWidth(20);
				$total_sheet->getColumnDimension('F')->setWidth(20);
				$total_sheet->getColumnDimension('G')->setWidth(25);
				$total_sheet->getColumnDimension('H')->setWidth(20);
				$total_sheet->getColumnDimension('I')->setWidth(40);
				$total_sheet->getColumnDimension('J')->setWidth(40);
				// $total_sheet->getColumnDimension('K')->setWidth(15);
				// $total_sheet->getColumnDimension('L')->setWidth(20);
				// $total_sheet->getColumnDimension('M')->setWidth(20);
				// $total_sheet->getColumnDimension('N')->setWidth(30);
				// $total_sheet->getColumnDimension('O')->setWidth(15);
				$total_sheet->getColumnDimension('K')->setWidth(20);
				$total_sheet->getColumnDimension('L')->setWidth(30);
		
				$total_sheet->setCellValue('A1', 'Tên gian hàng');
				$total_sheet->setCellValue('B1', 'Số chứng từ');
				$total_sheet->setCellValue('C1', 'Mã SKU đúng');
				$total_sheet->setCellValue('D1', 'Mã đơn hàng');
				$total_sheet->setCellValue('E1', 'Mã kiện hàng');
				$total_sheet->setCellValue('F1', 'Ngày đặt hàng');
				$total_sheet->setCellValue('G1', 'Mã vận đơn');
				$total_sheet->setCellValue('H1', 'Ngày gửi hàng');
				$total_sheet->setCellValue('I1', 'Tên sản phẩm');
				$total_sheet->setCellValue('J1', 'SKU phân loại hàng');
				// $total_sheet->setCellValue('K1', 'Giá gốc');
				// $total_sheet->setCellValue('L1', 'Người bán trợ giá');
				// $total_sheet->setCellValue('M1', 'Được Shopee trợ giá');
				// $total_sheet->setCellValue('N1', 'Tổng số tiền được người bán trợ giá');
				// $total_sheet->setCellValue('O1', 'Giá ưu đãi');
				$total_sheet->setCellValue('K1', 'Số lượng');
				$total_sheet->setCellValue('L1', 'Tổng giá bán (sản phẩm)');

				$list_detail = $result;
				
				foreach ($list_detail as $item_dt){
					if($item_dt->ma_kien_hang == 'null'){
						$item_dt->ma_kien_hang = '';
					}
					$key_sheet_2 = isset($key_sheet_2)?($key_sheet_2+1):2;
					$total_sheet->setCellValue('A'.$key_sheet_2, $item_dt->shop_name);
					$total_sheet->setCellValue('B'.$key_sheet_2, $item_dt->shop_code);
					$total_sheet->setCellValue('C'.$key_sheet_2, $item_dt->sku);
					$total_sheet->setCellValue('D'.$key_sheet_2, $item_dt->code);
					$total_sheet->setCellValue('E'.$key_sheet_2, $item_dt->ma_kien_hang);
					$total_sheet->setCellValue('F'.$key_sheet_2, $item_dt->created_at);
					$total_sheet->setCellValue('G'.$key_sheet_2, $item_dt->tracking_code);
					$total_sheet->setCellValue('H'.$key_sheet_2, $item_dt->ngay_gui_hang);
					$total_sheet->setCellValue('I'.$key_sheet_2, $item_dt->product_name);
					$total_sheet->setCellValue('J'.$key_sheet_2, $item_dt->sku_nhanh);
					// $total_sheet->setCellValue('K'.$key_sheet_2, $item_dt->gia_goc);
					// $total_sheet->setCellValue('L'.$key_sheet_2, $item_dt->nguoi_ban_tro_gia);
					// $total_sheet->setCellValue('M'.$key_sheet_2, $item_dt->shopee_tro_gia);
					// $total_sheet->setCellValue('N'.$key_sheet_2, $item_dt->tong_so_tien_duoc_nguoi_ban_tro_gia);
					// $total_sheet->setCellValue('O'.$key_sheet_2, $item_dt->gia_uu_dai);
					$total_sheet->setCellValue('K'.$key_sheet_2, $item_dt->count);
					$total_sheet->setCellValue('L'.$key_sheet_2, $item_dt->don_ngoai_tong_gia_tri_don);
				}
				$total_sheet->getRowDimension(1)->setRowHeight(20);
				$total_sheet->getStyle('A1')->getFont()->setSize(12);
				$total_sheet->getStyle('A1')->getFont()->setName('Arial');
				$total_sheet->getStyle('A1')->applyFromArray($style_header);
				$total_sheet->duplicateStyle( $total_sheet->getStyle('A1'),'B1:L1');

				$path = $this->generateDailyPath($baseDir);

				$link_excel = $path.'/'. $filename.'.xlsx';

				$excel->set_params(array('out_put_xls'=>$link_excel,'out_put_xlsx'=>$link_excel));

				$output = $excel->write_files();

				$dir_file = str_replace('/www/wwwroot/'.DOMAIN, '', $link_excel);

				
				$sql_xls_query= "UPDATE fs_order_uploads_history_prints SET file_xlsx = '$dir_file'  WHERE `id`=".$id_xlsx;

				$db->query($sql_xls_query);
				
				echo "thành công";
				// end xuất file

			}

		}



		function excel_nhat(){
			 $model  = $this -> model;
		    
		    $combo_code = $model->show_product_combo(23538660);
		    
			// xóa các file cũ trong thư mục cho nhẹ server
			$path_remove_file = PATH_ADMINISTRATOR.DS.'export'.DS.'excel'.DS.'order_item'.DS;

			if (is_file($path_remove_file) && file_exists($path_remove_file)) {
			    array_map('unlink', array_filter(
	       		(array) array_merge(glob($path_remove_file."*"))));
			}

			
			FSFactory::include_class('excel','excel');
			
			$filename = 'FILE_NHAT'.$this->file_export_name;
			$filename = strtoupper($filename);
			
			$list = $model->get_excel_nhat(0,50000);

			// printr($list);
			if(empty($list)){
				echo 'Không có đơn nào được tìm thấy !';exit;
			}else {
				//tính tổng
				$arr_total_count = array();
				foreach($list as $item) {
					if(empty($arr_total_count[$item->product_id])){
						$arr_total_count[$item->product_id] = $item;
					}else{
						$arr_total_count[$item->product_id]->count = $arr_total_count[$item->product_id]->count + $item->count;
					}
				}
				$list = $arr_total_count;
				
				// echo "<pre>";
    //               print_r($list);
    //             echo "</pre>";
				
			
				
				// die;
				// printr($arr_total_count);

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
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
		
				$excel->obj_php_excel->getActiveSheet()->setCellValue('A2', 'Mã SKU');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('B2', 'Tên sản phẩm');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('C2', 'Mã màu');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('D2', 'Mã size');
				
				$excel->obj_php_excel->getActiveSheet()->setCellValue('E2', 'SL');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('F2', 'Mã con');

				foreach ($list as $item){
					$key = isset($key)?($key+1):3;
					
					$combo_code = $model->show_product_combo($item->product_id);
				    $combo_code = $combo_code[0]->code_combo;
					$excel->obj_php_excel->getActiveSheet()->setCellValue('A'.$key, $item->sku);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.$key, $item->product_name);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('C'.$key, $item->color);
					$excel->obj_php_excel->getActiveSheet()->setCellValueExplicit('D'.$key,$item->size,PHPExcel_Cell_DataType::TYPE_STRING);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('E'.$key, $item->count);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('F'.$key, $combo_code);

					
					
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

			if (is_file($path_remove_file) && file_exists($path_remove_file)) {
			    array_map('unlink', array_filter(
       			(array) array_merge(glob($path_remove_file."*"))));
			}
			

			FSFactory::include_class('excel','excel');
			$model  = $this -> model;
			$filename = 'FILE_TONG'.$this->file_export_name;
			$filename = strtoupper($filename);
			
			$list = $model->get_excel_tong();

			if(empty($list)){
				echo 'Không có đơn nào được tìm thấy !';exit;
			}else {

				//tính tổng
				$arr_total_count = array();
				foreach($list as $item) {
					$item->sku = strtoupper($item->sku);
					if(empty($arr_total_count[$item->sku])){
						$arr_total_count[$item->sku] = $item;
					}else{
						$arr_total_count[$item->sku]->count = $arr_total_count[$item->sku]->count + $item->count;
					}
				}
				$list = $arr_total_count;
				// printr($arr_total_count);

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

				$excel->obj_php_excel->getActiveSheet()->setTitle("Tổng In");
				$excel->obj_php_excel->getActiveSheet()->mergeCells('A1:E1');
				$excel->obj_php_excel->getActiveSheet()->setCellValue ('A1', $filename);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

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
				// printr($list);
				foreach ($list as $item){
					$key = isset($key)?($key+1):3;
					$excel->obj_php_excel->getActiveSheet()->setCellValue('A'.$key, $item->sku);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.$key, $item->product_name);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('C'.$key, $item->count);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('D'.$key,'');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('E'.$key, '');
				}

				
				$excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray( $style_header );
				$excel->obj_php_excel->getActiveSheet()->duplicateStyle( $excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:E1' );


				// Add new sheet

				
			    $total_sheet = $excel->obj_php_excel->createSheet(1);
			    $total_sheet->setTitle("Tổng đơn 1");

			    // echo $_SESSION[$this -> prefix.'filter2'];
			    // die;
			    if($_SESSION[$this -> prefix.'filter2'] == 2){

				    $total_sheet->getColumnDimension('A')->setWidth(20);
					$total_sheet->getColumnDimension('B')->setWidth(20);
					$total_sheet->getColumnDimension('C')->setWidth(20);
					$total_sheet->getColumnDimension('D')->setWidth(20);
					$total_sheet->getColumnDimension('E')->setWidth(20);
					$total_sheet->getColumnDimension('F')->setWidth(20);
					$total_sheet->getColumnDimension('G')->setWidth(25);
					$total_sheet->getColumnDimension('H')->setWidth(20);
					$total_sheet->getColumnDimension('I')->setWidth(40);
					$total_sheet->getColumnDimension('J')->setWidth(40);
					$total_sheet->getColumnDimension('K')->setWidth(15);
					$total_sheet->getColumnDimension('L')->setWidth(20);
					$total_sheet->getColumnDimension('M')->setWidth(20);
					$total_sheet->getColumnDimension('N')->setWidth(30);
					$total_sheet->getColumnDimension('O')->setWidth(15);
					$total_sheet->getColumnDimension('P')->setWidth(15);
					$total_sheet->getColumnDimension('Q')->setWidth(40);
			
					$total_sheet->setCellValue('A1', 'Tên gian hàng');
					$total_sheet->setCellValue('B1', 'Số chứng từ');
					$total_sheet->setCellValue('C1', 'Mã SKU đúng');
					$total_sheet->setCellValue('D1', 'Mã đơn hàng');
					$total_sheet->setCellValue('E1', 'Mã kiện hàng');
					$total_sheet->setCellValue('F1', 'Ngày đặt hàng');
					$total_sheet->setCellValue('G1', 'Mã vận đơn');
					$total_sheet->setCellValue('H1', 'Ngày gửi hàng');
					$total_sheet->setCellValue('I1', 'Tên sản phẩm');
					$total_sheet->setCellValue('J1', 'SKU phân loại hàng');
					$total_sheet->setCellValue('K1', 'Giá gốc');
					$total_sheet->setCellValue('L1', 'Người bán trợ giá');
					$total_sheet->setCellValue('M1', 'Được Shopee trợ giá');
					$total_sheet->setCellValue('N1', 'Tổng số tiền được người bán trợ giá');
					$total_sheet->setCellValue('O1', 'Giá ưu đãi');
					$total_sheet->setCellValue('P1', 'Số lượng');
					$total_sheet->setCellValue('Q1', 'Tổng giá bán (sản phẩm)');
					$list_detail = $model->get_list_detail_tong();
					
					foreach ($list_detail as $item_dt){

						$key_sheet_2 = isset($key_sheet_2)?($key_sheet_2+1):2;
						$total_sheet->setCellValue('A'.$key_sheet_2, $item_dt->shop_name);
						$total_sheet->setCellValue('B'.$key_sheet_2, $item_dt->shop_code);
						$total_sheet->setCellValue('C'.$key_sheet_2, $item_dt->sku);
						$total_sheet->setCellValue('D'.$key_sheet_2, $item_dt->code);
						$total_sheet->setCellValue('E'.$key_sheet_2, $item_dt->ma_kien_hang);
						$total_sheet->setCellValue('F'.$key_sheet_2, $item_dt->created_at);
						$total_sheet->setCellValue('G'.$key_sheet_2, $item_dt->tracking_code);
						$total_sheet->setCellValue('H'.$key_sheet_2, $item_dt->ngay_gui_hang);
						$total_sheet->setCellValue('I'.$key_sheet_2, $item_dt->product_name);
						$total_sheet->setCellValue('J'.$key_sheet_2, $item_dt->sku_nhanh);
						$total_sheet->setCellValue('K'.$key_sheet_2, $item_dt->gia_goc);
						$total_sheet->setCellValue('L'.$key_sheet_2, $item_dt->nguoi_ban_tro_gia);
						$total_sheet->setCellValue('M'.$key_sheet_2, $item_dt->shopee_tro_gia);
						$total_sheet->setCellValue('N'.$key_sheet_2, $item_dt->tong_so_tien_duoc_nguoi_ban_tro_gia);
						$total_sheet->setCellValue('O'.$key_sheet_2, $item_dt->gia_uu_dai);
						$total_sheet->setCellValue('P'.$key_sheet_2, $item_dt->count);
						$total_sheet->setCellValue('Q'.$key_sheet_2, $item_dt->tong_gia_ban);
					}
					$total_sheet->getRowDimension(1)->setRowHeight(20);
					$total_sheet->getStyle('A1')->getFont()->setSize(12);
					$total_sheet->getStyle('A1')->getFont()->setName('Arial');
					$total_sheet->getStyle('A1')->applyFromArray($style_header);
					$total_sheet->duplicateStyle( $total_sheet->getStyle('A1'),'B1:Q1');

				}elseif($_SESSION[$this -> prefix.'filter2'] == 1){
					
					$total_sheet->getColumnDimension('A')->setWidth(40);
					$total_sheet->getColumnDimension('B')->setWidth(20);
					$total_sheet->getColumnDimension('C')->setWidth(20);
					$total_sheet->getColumnDimension('D')->setWidth(20);
					$total_sheet->getColumnDimension('E')->setWidth(60);
					$total_sheet->getColumnDimension('F')->setWidth(20);
					$total_sheet->getColumnDimension('G')->setWidth(25);
					$total_sheet->getColumnDimension('H')->setWidth(25);
					$total_sheet->getColumnDimension('I')->setWidth(40);
					$total_sheet->getColumnDimension('J')->setWidth(30);
					$total_sheet->getColumnDimension('K')->setWidth(25);
					$total_sheet->getColumnDimension('L')->setWidth(25);
				
			
					$total_sheet->setCellValue('A1', 'TÊN GIAN HÀNG');
					$total_sheet->setCellValue('B1', 'KÝ HIỆU');
					$total_sheet->setCellValue('C1', 'SỐ LƯỢNG');
					$total_sheet->setCellValue('D1', 'MÃ SKU ĐÚNG');
					$total_sheet->setCellValue('E1', 'Seller SKU');
					$total_sheet->setCellValue('F1', 'Created at');
					$total_sheet->setCellValue('G1', 'Updated at');
					$total_sheet->setCellValue('H1', 'Order Number');
					$total_sheet->setCellValue('I1', 'Tracking Code');
					$total_sheet->setCellValue('J1', 'Paid Price');
					$total_sheet->setCellValue('K1', 'Unit Price');
					$total_sheet->setCellValue('L1', 'Shipping Fee');
					$list_detail = $model->get_list_detail_tong();
					// printr($list_detail);
					foreach ($list_detail as $item_dt){
						$key_sheet_2 = isset($key_sheet_2)?($key_sheet_2+1):2;
						$total_sheet->setCellValue('A'.$key_sheet_2, $item_dt->shop_name);
						$total_sheet->setCellValue('B'.$key_sheet_2, $item_dt->shop_code);
						$total_sheet->setCellValue('C'.$key_sheet_2, $item_dt->count);
						$total_sheet->setCellValue('D'.$key_sheet_2, $item_dt->sku);
						$total_sheet->setCellValue('E'.$key_sheet_2, $item_dt->sku_nhanh);
						$total_sheet->setCellValue('F'.$key_sheet_2, $item_dt->created_at);
						$total_sheet->setCellValue('G'.$key_sheet_2, $item_dt->updated_at);
						$total_sheet->setCellValue('H'.$key_sheet_2, $item_dt->code);
						$total_sheet->setCellValue('I'.$key_sheet_2, $item_dt->tracking_code);
						$total_sheet->setCellValue('J'.$key_sheet_2, $item_dt->paid_price);
						$total_sheet->setCellValue('K'.$key_sheet_2, $item_dt->unit_price);
						$total_sheet->setCellValue('L'.$key_sheet_2, $item_dt->shipping_fee);
					}
					$total_sheet->getRowDimension(1)->setRowHeight(20);
					$total_sheet->getStyle('A1')->getFont()->setSize(12);
					$total_sheet->getStyle('A1')->getFont()->setName('Arial');
					$total_sheet->getStyle('A1')->applyFromArray($style_header);
					$total_sheet->duplicateStyle( $total_sheet->getStyle('A1'),'B1:L1');
				}elseif($_SESSION[$this -> prefix.'filter2'] == 3){
					$total_sheet->getColumnDimension('A')->setWidth(40);
					$total_sheet->getColumnDimension('B')->setWidth(20);
					$total_sheet->getColumnDimension('C')->setWidth(20);
					$total_sheet->getColumnDimension('D')->setWidth(20);
					$total_sheet->getColumnDimension('E')->setWidth(25);
					$total_sheet->getColumnDimension('F')->setWidth(20);
					$total_sheet->getColumnDimension('G')->setWidth(25);
					$total_sheet->getColumnDimension('H')->setWidth(60);
					$total_sheet->getColumnDimension('I')->setWidth(50);
					$total_sheet->getColumnDimension('J')->setWidth(30);
					$total_sheet->getColumnDimension('K')->setWidth(25);
					$total_sheet->getColumnDimension('L')->setWidth(25);
				
			
					$total_sheet->setCellValue('A1', 'TÊN GIAN HÀNG');
					$total_sheet->setCellValue('B1', 'Mã gian hàng');
					$total_sheet->setCellValue('C1', 'MÃ SKU ĐÚNG');
					$total_sheet->setCellValue('D1', 'Tên NCC');
					$total_sheet->setCellValue('E1', 'Mã đơn hàng');
					$total_sheet->setCellValue('F1', 'Ngày đặt hàng');
					$total_sheet->setCellValue('G1', 'SSKU');
					$total_sheet->setCellValue('H1', 'Tên sản phẩm');
					$total_sheet->setCellValue('I1', 'Mã sản phẩm');
					$total_sheet->setCellValue('J1', 'SL bán');
					$total_sheet->setCellValue('K1', 'Đơn giá');
					$total_sheet->setCellValue('L1', 'Giá trị hàng hóa');
					$list_detail = $model->get_list_detail_tong();
					// printr($list_detail);
					foreach ($list_detail as $item_dt){
						$key_sheet_2 = isset($key_sheet_2)?($key_sheet_2+1):2;
						$total_sheet->setCellValue('A'.$key_sheet_2, $item_dt->shop_name);
						$total_sheet->setCellValue('B'.$key_sheet_2, $item_dt->shop_code);
						$total_sheet->setCellValue('C'.$key_sheet_2, $item_dt->sku);
						$total_sheet->setCellValue('D'.$key_sheet_2, $item_dt->shop_name);
						$total_sheet->setCellValue('E'.$key_sheet_2, $item_dt->code);
						$total_sheet->setCellValue('F'.$key_sheet_2, $item_dt->created_at);
						$total_sheet->setCellValue('G'.$key_sheet_2, $item_dt->ssku);
						$total_sheet->setCellValue('H'.$key_sheet_2, $item_dt->product_name);
						$total_sheet->setCellValue('I'.$key_sheet_2, $item_dt->sku_nhanh);
						$total_sheet->setCellValue('J'.$key_sheet_2, $item_dt->count);
						$total_sheet->setCellValue('K'.$key_sheet_2, $item_dt->don_gia);
						$total_sheet->setCellValue('L'.$key_sheet_2, $item_dt->gia_tri_hang_hoa_tiki);
					}
					$total_sheet->getRowDimension(1)->setRowHeight(20);
					$total_sheet->getStyle('A1')->getFont()->setSize(12);
					$total_sheet->getStyle('A1')->getFont()->setName('Arial');
					$total_sheet->getStyle('A1')->applyFromArray($style_header);
					$total_sheet->duplicateStyle( $total_sheet->getStyle('A1'),'B1:L1');
				}else{

				    $total_sheet->getColumnDimension('A')->setWidth(20);
					$total_sheet->getColumnDimension('B')->setWidth(20);
					$total_sheet->getColumnDimension('C')->setWidth(20);
					$total_sheet->getColumnDimension('D')->setWidth(20);
					$total_sheet->getColumnDimension('E')->setWidth(20);
					$total_sheet->getColumnDimension('F')->setWidth(20);
					$total_sheet->getColumnDimension('G')->setWidth(25);
					$total_sheet->getColumnDimension('H')->setWidth(20);
					$total_sheet->getColumnDimension('I')->setWidth(40);
					$total_sheet->getColumnDimension('J')->setWidth(40);
					// $total_sheet->getColumnDimension('K')->setWidth(15);
					// $total_sheet->getColumnDimension('L')->setWidth(20);
					// $total_sheet->getColumnDimension('M')->setWidth(20);
					// $total_sheet->getColumnDimension('N')->setWidth(30);
					// $total_sheet->getColumnDimension('O')->setWidth(15);
					$total_sheet->getColumnDimension('K')->setWidth(20);
					$total_sheet->getColumnDimension('L')->setWidth(30);
			
					$total_sheet->setCellValue('A1', 'Tên gian hàng');
					$total_sheet->setCellValue('B1', 'Số chứng từ');
					$total_sheet->setCellValue('C1', 'Mã SKU đúng');
					$total_sheet->setCellValue('D1', 'Mã đơn hàng');
					$total_sheet->setCellValue('E1', 'Mã kiện hàng');
					$total_sheet->setCellValue('F1', 'Ngày đặt hàng');
					$total_sheet->setCellValue('G1', 'Mã vận đơn');
					$total_sheet->setCellValue('H1', 'Ngày gửi hàng');
					$total_sheet->setCellValue('I1', 'Tên sản phẩm');
					$total_sheet->setCellValue('J1', 'SKU phân loại hàng');
					// $total_sheet->setCellValue('K1', 'Giá gốc');
					// $total_sheet->setCellValue('L1', 'Người bán trợ giá');
					// $total_sheet->setCellValue('M1', 'Được Shopee trợ giá');
					// $total_sheet->setCellValue('N1', 'Tổng số tiền được người bán trợ giá');
					// $total_sheet->setCellValue('O1', 'Giá ưu đãi');
					$total_sheet->setCellValue('K1', 'Số lượng');
					$total_sheet->setCellValue('L1', 'Tổng giá bán (sản phẩm)');
					$list_detail = $model->get_list_detail_tong();
					
					foreach ($list_detail as $item_dt){
						if($item_dt->ma_kien_hang == 'null'){
							$item_dt->ma_kien_hang = '';
						}
						$key_sheet_2 = isset($key_sheet_2)?($key_sheet_2+1):2;
						$total_sheet->setCellValue('A'.$key_sheet_2, $item_dt->shop_name);
						$total_sheet->setCellValue('B'.$key_sheet_2, $item_dt->shop_code);
						$total_sheet->setCellValue('C'.$key_sheet_2, $item_dt->sku);
						$total_sheet->setCellValue('D'.$key_sheet_2, $item_dt->code);
						$total_sheet->setCellValue('E'.$key_sheet_2, $item_dt->ma_kien_hang);
						$total_sheet->setCellValue('F'.$key_sheet_2, $item_dt->created_at);
						$total_sheet->setCellValue('G'.$key_sheet_2, $item_dt->tracking_code);
						$total_sheet->setCellValue('H'.$key_sheet_2, $item_dt->ngay_gui_hang);
						$total_sheet->setCellValue('I'.$key_sheet_2, $item_dt->product_name);
						$total_sheet->setCellValue('J'.$key_sheet_2, $item_dt->sku_nhanh);
						// $total_sheet->setCellValue('K'.$key_sheet_2, $item_dt->gia_goc);
						// $total_sheet->setCellValue('L'.$key_sheet_2, $item_dt->nguoi_ban_tro_gia);
						// $total_sheet->setCellValue('M'.$key_sheet_2, $item_dt->shopee_tro_gia);
						// $total_sheet->setCellValue('N'.$key_sheet_2, $item_dt->tong_so_tien_duoc_nguoi_ban_tro_gia);
						// $total_sheet->setCellValue('O'.$key_sheet_2, $item_dt->gia_uu_dai);
						$total_sheet->setCellValue('K'.$key_sheet_2, $item_dt->count);
						$total_sheet->setCellValue('L'.$key_sheet_2, $item_dt->don_ngoai_tong_gia_tri_don);
					}
					$total_sheet->getRowDimension(1)->setRowHeight(20);
					$total_sheet->getStyle('A1')->getFont()->setSize(12);
					$total_sheet->getStyle('A1')->getFont()->setName('Arial');
					$total_sheet->getStyle('A1')->applyFromArray($style_header);
					$total_sheet->duplicateStyle( $total_sheet->getStyle('A1'),'B1:L1');

				}



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
			
			$list = $model->get_excel_nhat(0,50000);
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
				$excel->obj_php_excel->getActiveSheet()->setCellValue('U1', 'NV bắn hàng');
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
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AV1', 'Hàng hóa giữ hộ/bắn hộ');
	
				
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


		


		function plus_quantity_product($warehouse_id,$product_id,$count = 1,$is_shoot = 0){
			$model = $this -> model;
			$data = $model->get_record('warehouses_id = ' . $warehouse_id . ' AND product_id = '. $product_id,'fs_warehouses_products');

			if(!empty($data)){
				$row = array();
				if($is_shoot == 1){ // đã bắn hàng thành công
					$row['amount'] = (float)$data->amount + (float)$count;
				}else{
					$row['amount_hold'] = (float)$data->amount_hold - (float)$count;
				}
				$update = $model->_update($row,'fs_warehouses_products','id = '.$data->id);
				return $update;
			}else{
				return 0;
			}
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
		if($data-> is_shoot == 0 && $data-> is_refund == 0){
			$permission_refund = FSSecurity::check_permission_groups('order_items','items','ajax_add_refund');
        	if($permission_refund){
				$txt .="<a class='btn-row btn-row-refund-".$id."' onclick='is_refund(".$id.")' href='javascript:void(0)'>Hoàn hàng</a>";
			}

			$txt .="<div class='label label-primary hide content-refund-".$id."'>Đã hoàn hàng</div>";
			if($data-> is_package == 1){
				$permission_shoot = FSSecurity::check_permission_groups('order_items','items','ajax_add_shoot');
				if($permission_shoot){
					$txt .="<a class='btn-row btn-is-shoot btn-row-shoot-".$id."' onclick='is_shoot(".$id.")' href='javascript:void(0)'>Bắn hàng ra kho</a>";
				}
				$txt .="<div class='label label-success hide content-shoot-".$id."'>Đã bắn hàng ra kho</div>";
			}
			
		}elseif($data-> is_shoot == 1 && $data-> is_refund == 0){
			$permission_refund = FSSecurity::check_permission_groups('order_items','items','ajax_add_refund');
        	if($permission_refund){
				$txt .="<a class='btn-row btn-row-refund-".$id."' onclick='is_refund(".$id.")' href='javascript:void(0)'>Hoàn hàng</a>";
			}
			$txt .="<div class='label label-primary hide content-refund-".$id."'>Đã hoàn hàng</div>";
			$txt .="<div class='label label-success'>Đã bắn hàng ra kho</div>";
		}elseif($data-> is_shoot == 0 && $data-> is_refund == 1){
			$txt .="<div class='label label-primary'>Đã hoàn hàng</div>";
		}else{
			$txt .="<div class='label label-primary'>Đã hoàn hàng</div>";
			$txt .="<div class='label label-success'>Đã bắn hàng ra kho</div>";
		}
		if($data-> is_package == 0){
			$txt .="<div class='label label-danger'>Chưa đóng hàng</div>";
		}elseif($data-> is_package != 0 && $data-> is_shoot == 0 && $data-> is_refund == 0){
			$txt .="<div class='label label-primary'>Đã đóng hàng</div>";
		}
		return $txt;

	}
	
	
?>