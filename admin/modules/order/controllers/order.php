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

		function update_pack_order()
		{
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {

	        		$file = $_FILES['file'];

	        		$fileName = $file['name']; // Tên file gốc
			        $fileTmp = $file['tmp_name']; // Đường dẫn tạm thời
			        $fileSize = $file['size']; // Kích thước file (byte)
			        $fileType = $file['type'];

			        $uploadDir = PATH_BASE."files/pack/";

			        

			        $allowedMimeTypes = [
			            'application/vnd.ms-excel', // .xls (Excel 97-2003)
			            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // .xlsx
			            'application/vnd.ms-excel.sheet.macroEnabled.12', // .xlsm
			            'application/vnd.ms-excel.addin.macroEnabled.12', // .xlam
			            'text/csv' // .csv
			        ];

			        // Kiểm tra MIME type của file
			        if (in_array($fileType, $allowedMimeTypes)) {
			            
			            // Bạn có thể xử lý tệp ở đây, ví dụ: di chuyển tệp hoặc đọc nội dung// Đường dẫn đích để lưu file
				        $uploadPath = $uploadDir . basename($fileName);

				        // Di chuyển file từ thư mục tạm sang thư mục đích
				        if (move_uploaded_file($fileTmp, $uploadPath)) {

				            $this->update_pack($uploadPath);
				        } else {
				            echo "Lỗi khi di chuyển tệp.";
				        }
			        } 

			        else{
			        	echo "file không đúng định dạng";
			        }

				} 
			}
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

		function update_by_api_packed()
		{
			$config = require PATH_BASE.'/includes/configs.php';

			$host = $config['dbHost'];
			$db = $config['dbName'];
			$user = $config['dbUser'];
			$pass = $config['dbPass'];
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
			
	        $context = stream_context_create(array(
	            'http' => array(
	                
	                'method' => 'GET',

	                'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
	                            "token: 7ojTLYXnzV0EH1wRGxOmvLFga",
	                
	            )
	        ));

	        $link_api ='https://phanmemttp.xyz/api/data-update-packed';

	        $link_delete_redis_api = 'https://phanmemttp.xyz/api/delete-packed-redis';

	        $response = file_get_contents($link_api, FALSE, $context);

	        $delete_redis = file_get_contents($link_delete_redis_api, FALSE, $context);

	      
	        $data = json_decode($response);

	        $result = [];

	        if(!empty($data)){

	        	foreach ($data as $key => $value) {

	        		$active = $value->is_package;

	        		$user_package_id = $value->user_package_id;

	        		$date_package = $value->date_package;

	        		$id = $value->id;


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
					    'id' => $id
					];

					// Thực hiện câu lệnh
					$update = $stmt->execute($params);

					if($update){
						array_push($result, $id);
					}
					else{
						echo "có lỗi xảy ra trong quá trình update";

						die;
					}


		        }
	        }
	        // update lai db hỗ trợ để xử lý tiếp khi update thành công
	        if(count($result)>0){
	        	$this->resetDBApi();
	        }

	        echo "update được ".count($result)." đơn hàng";

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

		function update_pack($file_path)
		{
			
			
			require_once("../libraries/PHPExcel-1.8/Classes/PHPExcel.php");
			$objReader = PHPExcel_IOFactory::createReaderForFile($file_path);
			// $data = new PHPExcel_IOFactory();
			// $data->setOutputEncoding('UTF-8');
			$objReader->setLoadAllSheets();
			$objexcel = $objReader->load($file_path);
			$data =$objexcel->getActiveSheet()->toArray('null',true,true,true);
			// $data->load($file_path);
			unset($heightRow);  
			$heightRow=$objexcel->setActiveSheetIndex()->getHighestRow();
			// printr($data);
			unset($j);

			date_default_timezone_set('Asia/Ho_Chi_Minh');

			$set_ky_tu = ['$','@','%','?','+','&','#','*','/','>','<','-'];

			$define_id = ['$'=>252, '@'=>253, '%'=>254,'?'=>255, '+'=>251, '&'=>9,'#'=>256, '*'=>257,'/'=>258,'>'=>259,'<'=>260,'-'=>266];

			$config = require PATH_BASE.'/includes/configs.php';

			// thử

			// Kết nối PDO
			$host = $config['dbHost'];
			$db = $config['dbName'];
			$user = $config['dbUser'];
			$pass = $config['dbPass'];
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


			$link = 'index.php?module=order&view=order&task=view_pack';

			$error = '';

		
			//kiểm tra lần đầu để check lỗi 

			for($j=2;$j<=$heightRow;$j++){

				if(trim($data[$j]['A']) === 'null'|| trim($data[$j]['B'])==='null'){

					$error .="Mã tracking hoặc trường ngày tháng của dòng $j không tồn tại, vui lòng kiểm tra lại <br>";

					// $msg = "";

					// setRedirect($link,$msg, 'error');
				}

				$row_tracks = trim($data[$j]['A']);

			
				$kytudefine = substr(trim($row_tracks), -1);

				if(!in_array($kytudefine, $set_ky_tu)){
					$kytudefine = '&';
				}

				$search = str_replace($kytudefine, '', $row_tracks);

				$sql = "SELECT id FROM fs_order_uploads_detail 
				        WHERE is_package = :is_package 
				        AND tracking_code = :tracking_code 
				        ORDER BY id DESC 
				        LIMIT 100";

				$stmt = $pdo->prepare($sql);
				$stmt->execute(['is_package' => 0, 'tracking_code' => $search]);
				$results = $stmt->fetchAll();

				if(empty($results)){

					$error .="Mã tracking của dòng $j không đúng, vui lòng kiểm tra lại <br>";
					
				}

			}	

			if(!empty($error)){
				setRedirect($link,$error,'error');
			}
			
			for($j=2;$j<=$heightRow;$j++){

				if(!empty($data[$j]['A'])  && !empty($data[$j]['B'])){
			
					$row_track = trim($data[$j]['A']);

					$kytudefine = substr(trim($row_track), -1);

					if(!in_array($kytudefine, $set_ky_tu)){
						$kytudefine = '&';
					}

					$row_time =  $row_time = str_replace('/', '-', trim($data[$j]['B']));

					$user_id = $define_id[$kytudefine];

					$search = str_replace($kytudefine, '', $row_track);

					// phần này là update vào db

					$sql = "SELECT id FROM fs_order_uploads_detail 
					        WHERE is_package = :is_package 
					        AND tracking_code = :tracking_code 
					        ORDER BY id DESC 
					        LIMIT 100";

					$stmt = $pdo->prepare($sql);
					$stmt->execute(['is_package' => 0, 'tracking_code' => $search]);
					$results = $stmt->fetchAll();

					if(!empty($results)){
						// Lấy phần tử cuối cùng
						$checkorders = !empty($results) ? end($results) : null;
						
				        if(!empty($checkorders)){
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
							    'date_package' =>   (new DateTime($row_time))->format('Y-m-d H:i:s'),
							    'id' => $checkorders_id
							];

							// Thực hiện câu lệnh
							$update = $stmt->execute($params);

							if (!$update) {
								$msg = "Có lỗi xảy ra với mã tracking của dòng $j vui lòng kiểm tra lại";

								setRedirect($link,$msg, 'error');
							}	
				        }


					}
					
				}
				
				
			}
			$count = intval($heightRow-1);

			$msg = "Đã đóng được $count kiện hàng thành công";	
			setRedirect($link,$msg);

		}

		function view_pack()
		{
			include 'modules/'.$this->module.'/views/'.$this->view.'/packing_handwork.php';
		}

		public function resetDBApi()
		{
			
			$username = "adminapi";
			$password = "123456123";
			$data = ["username"=>$username, "password"=>$password];
			// URL đăng nhập và trang đích
			$loginUrl = "https://phanmemttp.xyz/post-login";
			$targetUrl = "https://phanmemttp.xyz/show-data-api";


			

			// Khởi tạo cURL session
			$ch = curl_init($loginUrl);

			// Thiết lập các tùy chọn cURL
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);

			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt'); // Lưu cookie

			// Thực hiện yêu cầu đăng nhập
			$loginResponse = curl_exec($ch);    

			// Kiểm tra đăng nhập thành công
			if (curl_errno($ch)) {
			    echo 'Lỗi đăng nhập: ' . curl_error($ch);
			} else {
			    // Thiết lập tùy chọn cho yêu cầu đến trang đích
			    curl_setopt($ch, CURLOPT_POST, false);
			    curl_setopt($ch, CURLOPT_URL, $targetUrl);
			    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt'); // Gửi cookie đã lưu

			    // Thực hiện yêu cầu đến trang đích
			    $targetResponse = curl_exec($ch);

			    // Xử lý kết quả trả về từ trang đích
			    if (curl_errno($ch)) {
			        echo 'Lỗi truy cập trang đích: ' . curl_error($ch);
			    } else {
			        echo($targetResponse); // Hoặc xử lý kết quả theo ý muốn
			    }
			   
			}

			// Đóng cURL session
			curl_close($ch);
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

		function create_data_order_for_redis()
		{
			
			$start_of_month = date('Y-m-01');  // First day of the current month

			$today = date('Y-m-d');  // Today's date

			$config = require PATH_BASE.'/includes/configs.php';

			// th

			// Kết nối PDO
			$host = $config['dbHost'];
			$db = $config['dbName'];
			$user = $config['dbUser'];
			$pass = $config['dbPass'];
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


			$sql = "SELECT * FROM fs_order_uploads_detail WHERE user_package_id  IN  ('252','253','254','255','9','256','257','258','259','260') AND date_package BETWEEN :start_of_month AND :today";

			$stmt = $pdo->prepare($sql);
			$stmt->execute(['start_of_month' => $start_of_month, 'today' => $today]);
			$result = $stmt->fetchAll();

			$redis = new Redis();

		    // Thiết lập kết nối
		    $redis->connect('127.0.0.1', 6379);

		    $results = json_encode($result);

		    $keyExists = $redis->exists('complete_box');

			if ($keyExists) {
			    $redis->del("complete_box");

			} 	
			$redis->set("complete_box", $results);

			echo "thành công";

		}

		function return_list_total_complete_box($id)
		{
			$redis = new Redis();

		    // Thiết lập kết nối
		    $redis->connect('127.0.0.1', 6379);

		    $data = $redis->get("complete_box");

		    $data_code = json_decode($data);

		    $result = array_filter($data_code, function($item) use($id) {
			    return $item->user_package_id == $id;
			});

			return count($result);

		}

		function show_complete_box()
		{
			$config = require PATH_BASE.'/includes/configs.php';
			$host = $config['dbHost'];
			$db = $config['dbName'];
			$user = $config['dbUser'];
			$pass = $config['dbPass'];
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


			$sql = "SELECT * FROM fs_order_uploads_detail ORDER BY id DESC LIMIT 100";
			$stmt = $pdo->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll();

			$json = json_encode($result);

			print_r($json);

			// $id = 254;

			// $get_data = $this->return_list_total_complete_box($id);

			// dd($get_data);

			// $define_id = [252, 253, 254,255, 251,9,256,257,258, 259, 260];

			// $data = [];

			// foreach ($define_id as $key => $value) {
			// 	$data[$value] = $this->return_complete_box($value);
			// }

			// dd($data);

		}

		function return_complete_box($id)
		{
			global $db;

			$start_of_month = date('Y-m-01');  // First day of the current month

			$today = date('Y-m-d');  // Today's date

			$query = "SELECT id FROM fs_order_uploads_detail WHERE user_package_id = '$id' AND date_package BETWEEN '$start_of_month' AND '$today'";

			$sql = $db->query($query);

			$result = $db->getTotal();

			return $result;
		}

		function details()
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
			$skip_user = [9,208,251,206];


	        if(in_array($user_id, $skip_user)){
	        	
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

		function check_sale($model)
		{
			$redis = $this->connect_redis();

			$keyExists = $redis->exists('sale_model');


			$salePrice = 0;
				
			if ($keyExists) {

				$data_json = $redis->get('sale_model');

				$data = json_decode($data_json);

				$data = (array)$data;

				$filtered = array_filter($data, function($item) {
				    return $item->model === $model;
				});

				// Lấy giá của model 002E
				if (!empty($filtered)) {

				    $salePrice = reset($filtered)->sale; // Dùng reset để lấy phần tử đầu tiên

				    $salePrice = str_replace('.', '', $salePrice);    
				} 

			} 

			return $salePrice;
		}

		function convert_json_data($imageUrl, $model)
		{
			
			// Đường dẫn URL của ảnh
			

			// Tên file lưu trữ
			$imageName = $model.'.jpg'; // Lấy tên file từ URL
			$savePath = PATH_BASE . "images/products/2024/12/12/" . $imageName; // Đường dẫn thư mục cần lưu

			// Tạo thư mục nếu chưa tồn tại
			if (!is_dir(PATH_BASE . "images/products/2024/12/12")) {
			    mkdir(PATH_BASE . "images/products/2024/12/12", 0755, true);
			}

			try {
			    // Tải nội dung ảnh từ URL
			    $imageContent = file_get_contents($imageUrl);

			    if ($imageContent === false) {
			        throw new Exception("Không thể tải ảnh từ URL.");
			    }

			    // Lưu ảnh vào thư mục
			    $file = file_put_contents($savePath, $imageContent);

			    echo "Ảnh đã được lưu thành công vào: " . $savePath;
			} catch (Exception $e) {
			    echo "Lỗi: " . $e->getMessage();
			}
			return $savePath;
		}

		function convert_error(){

			$config = require PATH_BASE.'/includes/configs.php';

			// Kết nối PDO
			$host = $config['dbHost'];
			$db = $config['dbName'];
			$user = $config['dbUser'];
			$pass = $config['dbPass'];
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

			// Đường dẫn tới tệp JSON
			$file = 'https://dienmayai.com/files/data.json';

			// Đọc nội dung tệp JSON
			$jsonContent = file_get_contents($file);

			// Chuyển chuỗi JSON thành mảng PHP
			$data = json_decode($jsonContent, true); // true để trả về mảng, false để trả về đối tượng

			
			$dem = 0;


			foreach ($data as $key => $value) {


				$model = trim($value['model']);



				$name =  !empty($value['name'])?trim($value['name']):'';

				$new_name = str_replace(['Size 00','Size 03','Size 04', 'Size 05', 'Size 06'], ['Không size', 'Size S', 'Size M', 'Size L', 'Size XL'], $name);

				// $gia_ban_le = !empty($value['gia_ban_le'])?str_replace('.', '', trim($value['gia_ban_le'])):'';

				// $gia_dong_goi = !empty($value['gia_dong_goi'])?str_replace('.', '', trim($value['gia_dong_goi'])):'';

				// $gia_ban_thap_nhat = !empty($value['gia_ban_thap_nhat'])?str_replace('.', '', trim($value['gia_ban_thap_nhat'])):'';
				
				$barcode = $model;


				$sql = "UPDATE fs_products 
				        SET name = :new_name
				        WHERE barcode = :barcode";

				$stmt = $pdo->prepare($sql);

				// Các giá trị cần bind
				$params = [
				   
				    'new_name' => $new_name,
				   
				    'barcode'=>$barcode,
				   
				];

				$update = $stmt->execute($params);

				
				if ($update) {

					$dem++;
						
				}
						
			}
			echo "update thành công $dem sản phẩm" ;



		}


		function search_order_by_Name()
		{

			global $db;

			$option = 0;

			if(!empty($_GET['options'])){

				$option = $_GET['options'];
			}


			$name = !empty($_GET['name'])?$_GET['name']:'';

			$date1 = !empty($_GET['date1'])?$_GET['date1']:'';

			$date2 = !empty($_GET['date1'])?$_GET['date2']:'';

			$user_id ='9';

			$filename = 'danh_sach_don_hang';



			$context = stream_context_create(array(
	            'http' => array(
	                
	                'method' => 'GET',

	                'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
	                            "token: 7ojTLYXnzV0EH1wRGxOmvLFga",
	                
	            )
	        ));



	        // Send the request

	        $response = file_get_contents('https://api.'.DOMAIN.'/api/search-data-user-id-package?name='.$name.'&date1='.$date1.'&date2='.$date2, FALSE, $context);

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
						$excel->obj_php_excel->getActiveSheet()->setCellValue('J'.$key, date("d/m/Y", strtotime($item->date_package)));
						$excel->obj_php_excel->getActiveSheet()->setCellValue('K'.$key, number_format((float)$item->total_price, 0, ',', '.'));
						$excel->obj_php_excel->getActiveSheet()->setCellValue('L'.$key, $item->shipping_unit_name??'');

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

		function add_box_Order()
		{
			// phần kết nối DB
			$config = require PATH_BASE.'/includes/configs.php';

			$host = $config['dbHost'];
			$db = $config['dbName'];
			$user = $config['dbUser'];
			$pass = $config['dbPass'];
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
			// end kết nối DB

			date_default_timezone_set('Asia/Ho_Chi_Minh');

			$set_ky_tu = ['$','@','%','?','+','&','#','*','/','>','<','-'];

			$define_id = ['$'=>252, '@'=>253, '%'=>254,'?'=>255, '+'=>251, '&'=>9,'#'=>256, '*'=>257,'/'=>258,'>'=>259,'<'=>260,'-'=>266];

			$searchs = trim($_GET['search']);

			$link = '/admin/order/detail';

			$kytudefine = substr(trim($searchs), -1);

			if(!in_array($kytudefine, $set_ky_tu)){
				$kytudefine = '&';
			}

			$user_id = $define_id[$kytudefine];

			$search = str_replace($kytudefine, '', $searchs);


			$date_package = date("Y-m-d H:i:s");
			
			
			
			$sql = "SELECT id,product_id FROM fs_order_uploads_detail 
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

					if($user_package_id==266){

						$sql = "INSERT INTO fs_status_packed (product_id, status, created_at, order_id) VALUES (:product_id, :status, :created_at, :order_id)";

						$stmt = $pdo->prepare($sql);

						// Các giá trị cần bind
						$params = [
						    'product_id' => $checkorders['product_id'],
						    'status' => 0,
						    'order_id'=>$checkorders_id,
						    'created_at' => date("Y-m-d H:i:s"),

						    
						];

						$insert = $stmt->execute($params);
					}

				    
				} else {
					$error =1;
					$msg = 'Có lỗi trong quá trình đóng hàng';

				
				}
			        
			    				       
			else:
					$error =1;
					$msg = 'Đóng hàng không thành công, vui lòng kiểm tra lại mã đơn';

					
			endif;
			
			setRedirect($link,$msg, $error===1?'error':'');
			
			

		}

		public function search_order_details()
		{
			global $db;

			$define_id = ['$'=>252, '@'=>253, '%'=>254,'?'=>255, '+'=>251, '&'=>9,'#'=>256, '*'=>257,'/'=>258,'>'=>259,'<'=>260];

			$searchs = trim($_GET['search']);

			$active = $_GET['active'];

		
			$link = '/admin/order/detail';

			$config = require PATH_BASE.'/includes/configs.php';

			// thử

			// Kết nối PDO
			$host = $config['dbHost'];
			$db = $config['dbName'];
			$user = $config['dbUser'];
			$pass = $config['dbPass'];
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


	    			$redis = $this->connect_redis();


					$data_prepare =  json_decode($redis->get("data_box_order"));

					if(!empty($data_prepare)):

						foreach ($data_prepare as $key => $value) :
							
					        $user_id = $value->user_id;

					        $search = $value->search;


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

									

								    $keyExists = $redis->exists('refresh');

									if ($keyExists) {
										$redis->del("refresh");

										$redis->set("refresh", 1);

									} 

									$msg ='Đóng hàng thành công';

									if($user_package_id==266){

										$sql = "INSERT INTO fs_status_packed (product_id, status, created_at, order_id) VALUES (:product_id, :status, :created_at)";

										$stmt = $pdo->prepare($sql);

										// Các giá trị cần bind
										$params = [
										    'product_id' => $checkorders->product_id,
										    'status' => 0,
										    'order_id'=>$checkorders_id,
										    'created_at' => date("Y-m-d H:i:s"),

										    
										];
									}

								    
								} else {
									$msg = 'Có lỗi trong quá trình đóng hàng';

									
								    
								}
							        
						        				       
					        else:

					       		$msg = 'Đóng hàng không thành công, vui lòng kiểm tra lại mã đơn';

					       		
						    endif;

						endforeach;  

						$redis->del("data_box_order"); 

						setRedirect($link,$msg);

						
					endif;   


			    else:

			    	if($active ==0):
				    	$id = $_GET['search'];

				    	$checkorders_id = $id;  

						

					    $sql = "UPDATE fs_order_uploads_detail 
						        SET is_package = :is_package, 
						            
						            date_package = :date_package 
						        WHERE id = :id";

						$stmt = $pdo->prepare($sql);

						// Các giá trị cần bind
						$params = [
						    'is_package' => 0,
						   
						    'date_package' => date("Y-m-d H:i:s"),
						    'id' => $checkorders_id
						];

						// Thực hiện câu lệnh
						$update = $stmt->execute($params);

						if ($update) {

							 $redis = $this->connect_redis();

					        $keyExists = $redis->exists('refresh');

							if ($keyExists) {
							    $redis->del("refresh");

							    $redis->set("refresh", 1);

							} 	

							$msg ='Hoàn thành công đơn hàng';

							if($user_package_id==266){

								$sql = "DELETE FROM fs_status_packed WHERE order_id = :order_id";

								$stmt = $pdo->prepare($sql);

								// Bind giá trị cho product_id
								$params = ['order_id' => $checkorders_id];

								// Thực thi truy vấn
								$stmt->execute($params);

								
							}

							setRedirect($link,$msg);
						   
						} else {
						    $msg ='Hoàn hàng thất bại';

							setRedirect($link,$msg,'error');
						}

						


				    endif;	

				    $msg = 'Quá trình đóng hàng bị lỗi';

			       	setRedirect($link,$msg,'error');
				   	
			    endif;    	

		    endif; 

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