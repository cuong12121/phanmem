<?php
	class OrderControllersOrder  extends Controllers
	{
		function __construct()
		{
			$this->view = 'order' ; 
			parent::__construct(); 
			// $array_status = array( 0 => 'Mới tiếp nhận',1 => 'Đang xử lý',2=>'Đã chuyển qua kho',3=>'Đã đóng gói',4=>'Đang giao hàng',5=>'Hoàn thành',6=>'Hủy');
			$array_status = array( 0 => 'Mới tiếp nhận',1 => 'Đang xử lý',2=>'Chuyển qua kho đóng gói',4=>'Đang giao hàng',5=>'Hoàn thành',6=>'Hủy');
			$this -> arr_status = $array_status;
		}
		function display()
		{

			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			$text2 = FSInput::get('text2');
			if($text2){
				$_SESSION[$this -> prefix.'text2'] = $text2;
			}
			
			$model  = $this -> model;
		
			// $list = $this -> model->get_data();

			$query_body = $model->set_query_body();
			$list = $model->get_data2($query_body);
			$total = $model->getTotal2($query_body);
			$pagination = $model->getPagination2($total);
			$total_all = $model->getTotalAllPage();
			$total_all_id = $model->getTotalAllId();

			

			$array_status = $this -> arr_status;
			$array_obj_status = array();
			foreach($array_status as $key => $name){
				$array_obj_status[] = (object)array('id'=>($key+1),'name'=>$name);
			}
			
			$order_ids = '';
			foreach($list as $item){
				$order_ids .= $order_ids? ',':'';
				$order_ids .= $item -> id;
			}

			$list_order_details = $model -> get_order_details_by_order($order_ids);
			
		 	
		 	$array_shipping_unit = array( 1 => 'Hải Linh',2 => 'GHTK');

			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		function showShipUnit($shipping_unit){
			if($shipping_unit == 1){
				echo "Hải Linh";
			}elseif($shipping_unit == 2){
				echo "GHTK";
			}else{
				echo "Chưa xác định";
			}
		}

		function set()
		{
			global $db;

			$page = !empty($_GET['page'])?$_GET['page']:1;

			// $query = " SELECT * FROM run_check_file_order_pdf_excel
   			// 			  WHERE user_id = 208";

			$query = " SELECT * FROM fs_order_uploads ORDER BY id DESC" ;

   			$sql = $db->query_limit($query, 10, $page);
			$result = $db->getObjectList();	

			$kho = ['Kho','Kho Hà nội','Kho HCM'];

			

			$san = ['Sàn','Lazada','Shopee','Tiki','Lex ngoài HCM','Đơn ngoài','','Best','Ticktok','Viettel','Shopee ngoài'];


			include 'modules/'.$this->module.'/views/'.$this->view.'/list-pd.php';		
		}

		function showCheckErrorFile()
		{
			global $db;

			$page = !empty($_GET['page'])?$_GET['page']:1;

			// $query = " SELECT * FROM run_check_file_order_pdf_excel
   			// 			  WHERE user_id = 208";

			$query = " SELECT * FROM run_check_file_order_pdf_excel";

			$querys = " SELECT id FROM fs_info_run_check_pdf_excel WHERE 1=1 AND active = 0";

			$queryss = " SELECT id FROM fs_info_run_check_pdf_excel WHERE  active = 1";

   			$sql = $db->query_limit($query, 10, $page);
			$result = $db->getObjectList();	

			$total = $db->getTotal($query);

			$count = $db->getTotal($querys); 

			$testcount = $db->getTotal($queryss); 

			include 'modules/'.$this->module.'/views/'.$this->view.'/list-err.php';		  
  
		}

		public function details()
		{
			$page = !empty($_GET['page'])?$_GET['page']:1;

			$user_id = $_SESSION['ad_userid'];

			$context = stream_context_create(array(
	            'http' => array(
	                
	                'method' => 'GET',

	                'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
	                            "token: 7ojTLYXnzV0EH1wRGxOmvLFga",
	                
	            )
	        ));

	        // Send the request



	        if($user_id==='9'||$user_id==='251'){
	        	
	        	$link_api = 'https://api.'.DOMAIN.'/api/get-data-order-details?page='.$page;

	        	
	        }
	        else{
	        	$link_api ='https://api.'.DOMAIN.'/api/get-data-order-details?page='.$page.'&id_user='.$user_id;
	        }

	      
	        $response = file_get_contents($link_api, FALSE, $context);
	       
	        $info_data = json_decode($response);

	        include 'modules/'.$this->module.'/views/'.$this->view.'/details.php';
	    	
		}


		function connect_redis(){

			$redis = new Redis();

		    // Thiết lập kết nối
		    $redis->connect('127.0.0.1', 6379);

		    return $redis;


		}

		public function checkrealtime()
		{
			$redis = $this->connect_redis();

			$check = 0;

		    if ($redis->exists('refresh')) {

		    	$check = $redis->get("refresh");
		    }

		    return $check;
		   
		}


		function search_order_by_date()
		{
			
			

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

	        $response = file_get_contents('https://api.'.DOMAIN.'/api/search-data-order-to-date?&search='.$search,FALSE, $context);



	        $results = json_decode($response);



	        $result = $results;

	      

	        $kho = ['Kho','Kho Hà nội','Kho HCM'];

			
			$san = ['Sàn','Lazada','Shopee','Tiki','Lex ngoài HCM','Đơn ngoài','','Best','Ticktok','Viettel','Shopee ngoài'];


	        include 'modules/'.$this->module.'/views/'.$this->view.'/list-pd.php';

		}



		function search_order_by_Name()
		{
			$name = !empty($_GET['name'])?$_GET['name']:'';

			$date1 = !empty($_GET['date1'])?$_GET['date1']:'';

			$date2 = !empty($_GET['date1'])?$_GET['date2']:'';

			$user_id ='9';




			

			$context = stream_context_create(array(
	            'http' => array(
	                
	                'method' => 'GET',

	                'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
	                            "token: 7ojTLYXnzV0EH1wRGxOmvLFga",
	                
	            )
	        ));

	        // Send the request

	        $response = file_get_contents('https://api.'.DOMAIN.'/api/search-data-user-id-package?name='.$name.'&date1='.$date1.'&date2='.$date2, FALSE, $context);

	        $info_data = json_decode($response);


	        include 'modules/'.$this->module.'/views/'.$this->view.'/details.php';

		}

		public function search_order_details()
		{
			global $db;

			$define_id = ['$'=>252, '@'=>253, '%'=>254,'?'=>255, '+'=>251, '&'=>9,'#'=>256, '*'=>257,'/'=>258,'>'=>259,'<'=>260];

			$searchs = trim($_GET['search']);

			$kytudefine = substr(trim($searchs), -1);

			$search = str_replace($kytudefine, '', $searchs);

			$page =1;

			$user_id = $define_id[$kytudefine];

			$active =$_GET['active'];


			date_default_timezone_set('Asia/Ho_Chi_Minh');

			$link = 'index.php?module=order&view=order&task=details';


			// thử

			// Kết nối PDO
			$host = 'localhost';
			$db = 'sql_dienmayai_co';
			$user = 'sql_dienmayai_co';
			$pass = 'jGT6D533rw8yHSsk';
			$charset = 'utf8mb4';

			$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
			$options = [
			    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			    PDO::ATTR_EMULATE_PREPARES   => false,
			];

			try {
			    $pdo = new PDO($dsn, $user, $pass, $options);
			} catch (\PDOException $e) {
			    throw new \PDOException($e->getMessage(), (int)$e->getCode());
			}

			

			if(!empty($searchs)):

	    		if($active ==1):

			        // Thực hiện truy vấn
			
					$sql = "SELECT id FROM fs_order_uploads_detail 
					        WHERE is_package = :is_package 
					        AND tracking_code = :tracking_code 
					        ORDER BY id DESC 
					        LIMIT 100";

					$stmt = $pdo->prepare($sql);
					$stmt->execute(['is_package' => 0, 'tracking_code' => $search]);
					$results = $stmt->fetchAll();

					// Lấy phần tử cuối cùng
					$checkorders = !empty($results) ? end($results) : null;
	
			        if(!empty($checkorders)):

			        	$checkorders_id = $checkorders['id'];  // ID của đơn hàng (từ kết quả trước)
						$user_package_id = $user_id; // Giá trị của $user_package_id

					    $sql = "UPDATE fs_order_uploads_detail 
						        SET is_package = :is_package, 
						            user_package_id = :user_package_id, 
						            date_package = :date_package 
						        WHERE id = :id";

						$stmt = $pdo->prepare($sql);

						// Các giá trị cần bind
						$params = [
						    'is_package' => 1,
						    'user_package_id' => $user_package_id,
						    'date_package' => date("Y-m-d H:i:s"),
						    'id' => $checkorders_id
						];

						// Thực hiện câu lệnh
						$update = $stmt->execute($params);

						if ($update) {

							$msg ='Đóng hàng thành công';

							setRedirect($link,$msg);

						    
						} else {
							$msg = 'Có lỗi trong quá trình đóng hàng';

							setRedirect($link,$msg,'error');
						    
						}
					        
				        				       
			        else:

			       		$msg = 'Đóng hàng không thành công, vui lòng kiểm tra lại mã đơn';

			       		setRedirect($link,$msg,'error');
				    endif;	 	


			    else:

			    	if($active ==0):
				    	$id = $request->search;

				    	$checkorders_id = $id;  

						$user_package_id = $user_id;

					    $sql = "UPDATE fs_order_uploads_detail 
						        SET is_package = :is_package, 
						            user_package_id = :user_package_id, 
						            date_package = :date_package 
						        WHERE id = :id";

						$stmt = $pdo->prepare($sql);

						// Các giá trị cần bind
						$params = [
						    'is_package' => 0,
						    'user_package_id' => $user_package_id,
						    'date_package' => date("Y-m-d H:i:s"),
						    'id' => $checkorders_id
						];

						// Thực hiện câu lệnh
						$update = $stmt->execute($params);

						$msg ='Hoàn thành công đơn hàng';

						setRedirect($link,$msg);


				    endif;	

				    $msg = 'Quá trình đóng hàng bị lỗi';

			       	setRedirect($link,$msg,'error');
				   	
			    endif;    	

		    endif; 

		    die;

	        $redis = $this->connect_redis();

	        $keyExists = $redis->exists('refresh');

			if ($keyExists) {
			    $redis->del("refresh");

			    $redis->set("refresh", 1);

			} 


			$_SESSION['notification'] = $response; //khởi tạo session

			// unset($_SESSION['name']); // Huỷ session name

	      	header("Location: https://".DOMAIN."/admin/order/detail");

		}

		public function tracking_code_big()
		{
			$page = !empty($_GET['page'])?$_GET['page']:1;
			$context = stream_context_create(array(
	            'http' => array(
	                
	                'method' => 'GET',

	                'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
	                            "token: 7ojTLYXnzV0EH1wRGxOmvLFga",
	                
	            )
	        ));

	        // Send the request
	        $response = file_get_contents('https://api.'.DOMAIN.'/api/get-data-order-details?page='.$page, FALSE, $context);

	       

	        $info_data = json_decode($response);

	        include 'modules/'.$this->module.'/views/'.$this->view.'/trackingcodebig.php';
		}


		function showStatus($status){
			$arr_status = $this -> arr_status;
			echo @$arr_status[$status];
		}
		function edit()
		{
			$model = $this -> model;
			$order  = $model -> getOrderById();
			$data = $model -> get_data_order();
			$config = $model->getConfig();
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}


		function change_satus_order(){
			$model = $this -> model;
			$status = FSInput::get('status');
			$arr_status = $this -> arr_status;
			$rs  = $model -> change_satus_order($status);
			$Itemid = 61;	
			$id = FSInput::get('id');
			$order = $model -> getOrderById($id);
			$check_voucher = $model->get_record('order_id = '. $id ,'fs_sale');
			$link = 'index.php?module=order&view=order&task=edit&id='.$id;
			if(!$rs){
				$msg = 'Không chuyển được trạng thái đơn hàng';
				setRedirect($link,$msg,'error');
			}else{
				$msg = 'Chuyển trạng thái thành công !';
				setRedirect($link,$msg);
			}
		}
		
		function cancel_order(){
			$model = $this -> model;
			
			$rs  = $model -> cancel_order();
			
			$Itemid = 61;	
			$id = FSInput::get('id');
			$link = 'index.php?module=order&view=order&task=edit&id='.$id;
			if(!$rs){
				$msg = 'Không hủy được đơn hàng';
				setRedirect($link,$msg,'error');
			}
			else {
				$msg = 'Đã hủy được đơn hàng';

				
				setRedirect($link);
			}
		}
		function finished_order(){
			$model = $this -> model;
			$rs  = $model -> finished_order();
			$Itemid = 61;	
			$id = FSInput::get('id');
			$link = 'index.php?module=order&view=order&task=edit&id='.$id;
			if(!$rs){
				$msg = 'Không hoàn tất được đơn hàng';
				setRedirect($link,$msg,'error');
			}
			else {
				$msg = 'Đã hoàn tất được đơn hàng thành công';
				setRedirect($link);
			}
		}


	// Excel toàn bộ danh sách copper ra excel
		function export(){
			setRedirect('index.php?module='.$this -> module.'&view='.$this -> view.'&task=export_file&raw=1');
		}
			
		function export_file(){
			FSFactory::include_class('excel','excel');
			$model  = $this -> model;
			$filename = 'danh_sach_don_hang';
			$list = $model->get_member_info(0,2000);
			$array_status = $this -> arr_status;
				// print_r($list);die;
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
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('G')->setWidth(13);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('H')->setWidth(50);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('I')->setWidth(60);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('J')->setWidth(60);
				$excel->obj_php_excel->getActiveSheet()->setCellValue('A1', 'Mã đơn hàng');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('B1', 'Người mua');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('C1', 'Số điện thoại');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('D1', 'Sản phẩm');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('E1', 'Giá trị');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('F1', 'Ngày mua');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('G1', 'Số lượng');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('H1', 'Ghi chú');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('I1', 'Địa chỉ');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('J1', 'Trạng thái');
				// $excel->obj_php_excel->getActiveSheet()->setCellValue('J1', 'Các trường thêm');

				foreach ($list as $item){
					$string_info_extent = '';
					$products_name = $model->get_data_order_name($item->id);
					$all_name = array();
					$arr_info_extent = array();


					foreach ($products_name as $product_name) {
						$all_name[] = $product_name->product_name;

						$total_price_extent = 0; 
						$arr_extend_item = explode(',',$product_name -> string_info_extent);
						foreach ($arr_extend_item as $extend_item_val ){
							if($extend_item_val != 0){
								$extend_item = $model -> get_record_by_id($extend_item_val,'fs_products_price_extend');

								$arr_info_extent[] = $extend_item-> extend_name . ": " . format_money2($extend_item-> price);
								$total_price_extent  += $extend_item-> price; 
							}
						}

						// echo "<pre>";
						// print_r($product_name);
						// die;
							
						if(!empty($product_name -> color_name)){
							$string_info_extent .= "Màu " .$product_name -> color_name ." ";
						}
						if(!empty($product_name -> color_price)){
							$string_info_extent .= ":".format_money2($product_name-> color_price) .",";
						}
						
				
					}

					if(!empty($arr_info_extent)){
						$string_info_extent .=  implode(' , ',$arr_info_extent);
					}

					
					// echo "<pre>";
					// print_r($item);die;
					// echo $string_info_extent;
					// die;
					$str_all_name = implode(",", $all_name);
					
					
					// echo $string_info_extent;
					// die;
					
					$key = isset($key)?($key+1):2;
					$excel->obj_php_excel->getActiveSheet()->setCellValue('A'.$key, 'DH'.str_pad($item -> id, 8 , "0", STR_PAD_LEFT) );
					$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.$key, $item->sender_name);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('C'.$key, $item->sender_telephone);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('D'.$key, $str_all_name);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('E'.$key, format_money($item -> total_after_discount));
					$excel->obj_php_excel->getActiveSheet()->setCellValue('F'.$key, $item->created_time);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('G'.$key, $item->products_count);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('H'.$key, $item->sender_comments);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('I'.$key, $item->sender_address . ', ' . $item->ward_name . ', ' . $item->district_name . ', ' . $item->city_name);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('J'.$key, $array_status[$item->status]);


					// $excel->obj_php_excel->getActiveSheet()->setCellValue('J'.$key, $string_info_extent);
				}


				
				$excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray( $style_header );
				$excel->obj_php_excel->getActiveSheet()->duplicateStyle( $excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:J1' );

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