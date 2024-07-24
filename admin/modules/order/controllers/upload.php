<?php

	class OrderControllersUpload extends Controllers
	{
		function __construct()
		{
			$this->view = 'upload'; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			global $config;
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			$model  = $this -> model;
			$wrap_id_warehouses = $model->get_wrap_id_warehouses();
			$warehouses = $model -> get_records('published = 1 AND id IN ('.$wrap_id_warehouses.')','fs_warehouses');

			$platforms = $model -> get_records('published = 1','fs_platforms');
			$houses = $model -> get_records('published = 1','fs_house');
			$users = $model -> get_record('id = ' . $_SESSION['ad_userid'],'fs_users');
			$list = $this -> model->get_data();

			// $iddd="";
			// foreach ($list as $key => $l) {
			// 	$iddd .= $l->id.',';
			// }
			// echo $iddd;


			// foreach ($list as $key => $l) {
			// 	$row = array();
			// 	$row['house_id'] = $l->house_id;
			// 	$row['warehouse_id'] = $l->warehouse_id;
			// 	$model->_update($row,'fs_order_uploads_detail','record_id = '.$l->id);
			// }
		


			$pagination = $model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}

		function add()
		{
			global $config;
			$model = $this -> model;
			$wrap_id_warehouses = $model->get_wrap_id_warehouses();
			$warehouses = $model -> get_records('published = 1 AND id IN ('.$wrap_id_warehouses.')','fs_warehouses');
			$platforms = $model -> get_records('published = 1','fs_platforms');
			$houses = $model -> get_records('published = 1','fs_house');
			$users = $model -> get_record('id = ' . $_SESSION['ad_userid'],'fs_users');
			if($users->group_id == 1 && $users->shop_id){
				$users->shop_id = substr($users->shop_id, 1, -1);
				$shops = $model -> get_records('id IN ('.$users->shop_id.')','fs_shops');
			}else{
				$shops = $model -> get_records('','fs_shops');
			}
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}

		function edit()
		{
			global $config;
			$model = $this -> model;
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$data = $model->get_record_by_id($id);
			$wrap_id_warehouses = $model->get_wrap_id_warehouses();
			$warehouses = $model -> get_records('published = 1 AND id IN ('.$wrap_id_warehouses.')','fs_warehouses');
			$platforms = $model -> get_records('published = 1','fs_platforms');
			$houses = $model -> get_records('published = 1','fs_house');

			$users = $model -> get_record('id = ' . $_SESSION['ad_userid'],'fs_users');
			if($users->group_id == 1 && $users->shop_id){
				$users->shop_id = substr($users->shop_id, 1, -1);
				$shops = $model -> get_records('id IN ('.$users->shop_id.')','fs_shops');
			}else{
				$shops = $model -> get_records('','fs_shops');
			}
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}

		function insert_order_id_check(){
			global $db;

			$date = date('Y-m-d H:i:s');

			$platform_id = $_GET['platform'];

			$query = " SELECT id,platform_id FROM  fs_order_uploads WHERE 1=1 AND platform_id = $platform_id AND created_time >= '2024-07-23'"; 

			$values = $db->getObjectList($query);

			foreach ($values as $key => $value) {
				$id = $value->id;

				$sql = " INSERT INTO fs_info_run_check_pdf_excel
					(`platform`,record_id, created_at, update_at)
					VALUES ('$platform_id','$id', '$date', '$date')";

					$db->query($sql);
					$db->insert();
 				echo "thêm thành công id = ".$id.'<br>';

			}	
		}

		function convertArFilePDfToDB($filePdf)
		{
			$file_pdf_rep = explode(',', $filePdf);

            $file_pdf_rep1 = [];

            for ($i=0; $i < count($file_pdf_rep) ; $i++) { 
              
                $link_pdf = PATH_BASE.str_replace('pdft', 'pdf', $file_pdf_rep[$i]);

                if($i>0){

                    $link_pdf_v =  str_replace('pdft', 'pdf', $file_pdf_rep[0]);

                    $path = str_replace(basename($link_pdf_v), '', $link_pdf_v);

                    $basename = str_replace('pdft', 'pdf',  substr($file_pdf_rep[$i], 1));

                    $link_pdf = PATH_BASE.$path.$basename;

                }
              
                array_push($file_pdf_rep1, $link_pdf);

            }
            return $file_pdf_rep1;
		}

		function run_check_pdf_excel()
		{
			global $db;

			$model  = $this -> model;

			$querys_id = "SELECT record_id FROM  fs_info_run_check_pdf_excel WHERE 1=1 AND active = 0 ORDER BY id DESC"; 

			$id = $db->getResult($querys_id);

			if(!empty($id)){
				$query = " SELECT id,file_pdf, user_id, file_xlsx, platform_id FROM  fs_order_uploads WHERE 1=1 AND id = $id"; 

				$values = $db->getObjectList($query);

				$excel_kytu[2] = ['S','F'];

			    $excel_kytu[11] = ['L','D'];

				$excel_kytu[1] = ['F','BG'];

				$excel_kytu[4] = ['L','D'];

				$excel_kytu[9] = ['L','D'];

				$excel_kytu[10] = ['L','D'];

				$excel_kytu[8] = ['L','D'];

				foreach ($values as $key => $value) {

					$user_id = $value->user_id;
					 
					$file_path = PATH_BASE.$value->file_xlsx;

					$file_ar_pdf = $this->convertArFilePDfToDB($value->file_pdf);

					$platform_id = $value->platform_id;
				}

				$excel_row = $excel_kytu[$platform_id];

				$data  = $model->showDataExcel($file_path,$excel_row[0], $excel_row[1]);

				$data['maVanDon'] = array_unique($data['maVanDon']);

				$data_pdf = $this->dataPDF($file_ar_pdf, $platform_id);


			
				if($platform_id !=2){

					$data_pdfs = $data_pdf;

				}
				else{
					$data_pdfs['sku'] = array_merge(...array_values($data_pdf['sku']));

					$data_pdfs['mavandon'] = array_merge(...array_values($data_pdf['mavandon']));
				}

				$result = $this->resultcheckPdfAndEx($data, $data_pdfs, $id, $user_id, $db);

				echo 'Đơn hàng có id '.$id.' '.$result ;
			}

			die;


			$query = " SELECT record_id,id FROM  fs_info_run_check_pdf_excel WHERE 1=1 AND active =0 ORDER BY id DESC"; 

			$record_id = $db->getResult($query);

			$querys = " SELECT id FROM  fs_info_run_check_pdf_excel WHERE 1=1 AND active =0 ORDER BY id DESC"; 

			$order_id = $db->getResult($querys);

			if(!empty($record_id) && !empty($order_id)){
				$id= $record_id;

				$ids = $order_id;

				$ar = [$id];

				$dem = 0;

				if(count($ar)>0){
					for ($i=0; $i < count($ar); $i++) { 
						
						$query = " SELECT id,file_excel_drive,file_pdf,file_xlsx,id_file_pdf_google_drive,user_id,platform_id FROM  fs_order_uploads WHERE 1=1 AND id = $ar[$i]"; 

						$values = $db->getObjectList($query);

						foreach ($values as $key => $value) {

							$dem++;
								
							$this->	test($value->file_xlsx,$value->file_pdf,$value->id,$value->id_file_pdf_google_drive, $value->file_excel_drive,$value->platform_id, $value->user_id, $db);
						}

						$sql= "UPDATE fs_info_run_check_pdf_excel SET active='1'  WHERE `id`=".$ids;

	          			$db->query($sql);

	          			echo "update thành công order_id ".$id."\n" ;
					
					}
				}
			}

		}

		function dataPDFLazada($file)
		{
			$model  = $this -> model;

			

			$filePath =  $file;


			$number_page = shell_exec('pdftk '.$filePath.' dump_data | grep NumberOfPages');



			$number_page = str_replace('NumberOfPages:', '', $number_page);


			$data = [];

			if( intval($number_page)>0){
				
				for ($i=1; $i<=$number_page; $i++) {
					

					$datas = shell_exec('pdftotext  -raw -f '.$i.' -l '.$i.' '.$filePath.' -');

					$data_convert = $model->convertContentLazada($datas);

				    $pattern = "/\d{10}VNA/";

					// Kiểm tra và lấy chuỗi phù hợp
					if (preg_match($pattern, $datas, $matches)) {
					    // In chuỗi phù hợp

					    $known = $matches[0];
					  
					   	$pattern = "/(.*?)" . preg_quote($known) . "/";

						// Kiểm tra và lấy phần chuỗi trước chuỗi đã biết
						if (preg_match($pattern, $datas, $matchess)) {
						    // In phần chuỗi phù hợp
						    // echo "Phần chuỗi trước '$known' là: " . $matchess[1];

						    $results = $matchess[1].$known;

						    $data['mavandon'][] = $results;

						     $data['sku'][] =  $replaced_string = preg_replace('/\s/', '', @$data_convert[0][0]); 

						    // array_push($data, $results);
						}
					}



				}

			}
			return $data;
		}

		function dataPDFViettel($filePath){

			$model  = $this -> model;

			$number_page = shell_exec('pdftk '.$filePath.' dump_data | grep NumberOfPages');

			$number_page = str_replace('NumberOfPages:', '', $number_page);

			

			$data = [];

			for ($i=1; $i <= intval($number_page); $i++) { 
				
				$datas = shell_exec('pdftotext  -raw -f '.$i.' -l '.$i.' '.$filePath.' -');

				// // thay thế ký tự xuống dòng bằng chuỗi rỗng

				$datas =  preg_replace("/\r?\n/", '', $datas);

				$mau_regex = '/\d{13}/'; // s cho phép . khớp với cả newline

				if (preg_match($mau_regex, $datas, $matches)) {

					$data['mavandon'][] = $matches[0];
				   
				} 

				$data_convert = $model->convertContentviettel($datas);

				// $data_convert = $model->convertContentCheck($datas);

				$data['sku'][] =  $data_convert[0][0];
			
			}

			return $data;

		}

		function dataPDFTiktok($filePath)
		{
			$model  = $this -> model;


			$number_page = shell_exec('pdftk '.$filePath.' dump_data | grep NumberOfPages');

			$number_page = str_replace('NumberOfPages:', '', $number_page);

			$data = [];

			for ($i=0; $i < intval($number_page); $i++) { 
				
				$datas = shell_exec('pdftotext -raw -f '.$i.' -l '.$i.' '.$filePath.' -');

				// echo $datas;

				// die;

				// // thay thế ký tự xuống dòng bằng chuỗi rỗng

				// $datas =  preg_replace("/\r?\n/", '-', $datas);


				$mau_regex = '/\d{12}/'; // s cho phép . khớp với cả newline

				if (preg_match($mau_regex, $datas, $matches)) {

					$data['mavandon'][] = $matches[0];
				   
				} 

				$data_convert = $model->convertContenttiktok($datas);

				var_dump($data_convert);

				die;


				$data['sku'][] =  $data_convert[0];

			
			}
			return $data;
			
		}

		function dataPDFBest($filePath)
		{

			$model  = $this -> model;


			$number_page = shell_exec('pdftk '.$filePath.' dump_data | grep NumberOfPages');

			$number_page = str_replace('NumberOfPages:', '', $number_page);

			$data = [];

			for ($i=1; $i <= intval($number_page); $i++) { 
				
				$datas = shell_exec('pdftotext  -raw -f '.$i.' -l '.$i.' '.$filePath.' -');


				// // thay thế ký tự xuống dòng bằng chuỗi rỗng

				$datas =  preg_replace("/\r?\n/", '', $datas);


				$mau_regex = '/\d{14}/'; // s cho phép . khớp với cả newline

				if (preg_match($mau_regex, $datas, $matches)) {

					$data['mavandon'][] = $matches[0];
				   
				} 

				$data_convert = $model->convertContentCheck($datas);

				$data['sku'][] =  $data_convert[0][0];

			
			}


			return $data;


		}


		function resultcheckPdfAndEx($test, $data_pdf,$id,$user_id, $db)
		{
			$date = date('Y-m-d');

			$dates = date('Y-m-d H:i:s');

			$checkMVD =  array_diff($test['maVanDon'], $data_pdf['mavandon']);

		    $checkSku =  array_diff($test['Sku'], $data_pdf['sku']);

		    $mvd_pdf = implode(',', $data_pdf['sku']);

		    $sku_pdf = implode(',', $data_pdf['mavandon']);

		    $mvd_ex = implode(',', $test['maVanDon']);

		    $sku_ex = implode(',', $test['Sku']);

		    $sqls= "UPDATE fs_info_run_check_pdf_excel SET active='1', sku_excel='$sku_ex',sku_pdf = '$sku_pdf', tracking_code_pdf ='$mvd_pdf', tracking_code_excel='$mvd_ex',update_at = $dates   WHERE `record_id`=".$id;

	         $db->query($sqls);


		    if(!empty($checkMVD)|| !empty($checkSku)){
		    	$erMVD = '';
		    	$erSku = '';
		    	if(!empty($checkMVD)){

		    		$erMVD = implode(',', $checkMVD);
		    	}
		    	if(!empty($checkSku)){

		    		$erSKU = implode(',', $checkSku);
		    	}
		    	$pdf_text =1;

	 			$sql = " INSERT INTO run_check_file_order_pdf_excel
				(`pdf_link`,excel_link,record_id, mvd_pdf,sku_pdf,mvd_ex,sku_ex,er_sku,er_mvd,created_at,platform_id,pdf_text,user_id)
				VALUES ('$file_pdf','$file_xlsx','$id', '$mvd_pdf', '$sku_pdf','$date','$mvd_ex',' $sku_ex','$erSku','$erMVD','$platform_id','$pdf_text','$user_id')";

				$db->query($sql);
				$id = $db->insert();

				$result_return = 'bị lỗi ';

		    }
		    else{
		    	$result_return = 'không bị lỗi ';
		    }
		    return $result_return;
		}

		function test($file_xlsx,$file_pdf,$id,$id_file_pdf_google_drive,$file_excel_drive,$platform_id,$user_id, $db)
		{
			
			$file_exc = $file_excel_drive;

			$date = date('Y-m-d');
			
			$model  = $this -> model;
		    $path_run_excel =   'https://drive.'.DOMAIN.'/file_upload/downloaded1.xlsx';

		    $path_excel = 'https://drive.'.DOMAIN.'/get.php?mime=xlsx&showfile='.trim($file_exc);
		    $savePath_excel = PATH_BASE.'files/print/excel'.$id.'.xlsx';

		    file_get_contents($path_excel);

		   	$ch = curl_init($path_run_excel);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		    $data = curl_exec($ch);
		    curl_close($ch);
		    if ($data) {
		        file_put_contents($savePath_excel, $data);
		    } else {
		        throw new Exception("Không thể tải tệp từ URL.");

		        die;
		    }

		
		    $excel_kytu[2] = ['S','F'];

		    $excel_kytu[11] = ['L','D'];

			$excel_kytu[1] = ['F','BG'];

			$excel_kytu[4] = ['L','D'];

			$excel_kytu[9] = ['L','D'];

			$excel_kytu[10] = ['L','D'];

			$excel_kytu[8] = ['L','D'];

			$excel_row = $excel_kytu[$platform_id];


		    $test =  $model->showDataExcel($savePath_excel, $excel_row[0], $excel_row[1]);



		    $ar_file_pdf_run = explode(',', $id_file_pdf_google_drive);

		    $ar_savePath_pdf = [];

		    if(!empty($ar_file_pdf_run)){

		    	foreach ($ar_file_pdf_run as $key => $vals) {

		    		$file_pdf_run = trim($vals);
		    		$stt = intval($key)+1;
				    $savePath_pdf = PATH_BASE.'files/print/'.$stt.'pdf'.'.pdf';

				    $path_run_pdf ='https://drive.'.DOMAIN.'/get.php?mime=pdf&showfile='.$file_pdf_run;
				    

				     $chs = curl_init($path_run_pdf);
				    curl_setopt($chs, CURLOPT_RETURNTRANSFER, true);
				    curl_setopt($chs, CURLOPT_FOLLOWLOCATION, true);
				    $datas = curl_exec($chs);

				    curl_close($chs);
				    if ($datas) {
				        file_put_contents($savePath_pdf, $datas);
				    } else {
				        throw new Exception("Không thể tải pdf tệp từ URL.");
				        die;
				    }

				    array_push($ar_savePath_pdf, $savePath_pdf);
		    	}

		    	
		    }

		    unlink($savePath_excel);

		    
		    $filePDF = $ar_savePath_pdf;

		    if(!empty($filePDF)){

		    	$data_pdf = $this->dataPDF($filePDF, $platform_id);

		    	// echo "<pre>";var_dump($data_pdf); echo"</pre>";

		    	// die;

			    $checkMVD =  array_diff($test['maVanDon'], $data_pdf['mavandon']);

			    $checkSku =  array_diff($test['Sku'], $data_pdf['sku']);

			    $mvd_pdf = implode(',', $data_pdf['sku']);

			    $sku_pdf = implode(',', $data_pdf['mavandon']);

			    $mvd_ex = implode(',', $test['maVanDon']);

			    $sku_ex = implode(',', $test['Sku']);

			  
			    foreach ($filePDF as $filePDFs) {

			    	unlink($filePDFs);
			    }

			    if(!empty($checkMVD)|| !empty($checkSku)){

			    	$erMVD = '';
			    	$erSku = '';

			    	if(!empty($checkMVD)){

			    		$erMVD = implode(',', $checkMVD);
			    	}

			    	if(!empty($checkSku)){

			    		$erSKU = implode(',', $checkSku);
			    	}
			    	$pdf_text =1;

		 			$sql = " INSERT INTO run_check_file_order_pdf_excel
					(`pdf_link`,excel_link,record_id, mvd_pdf,sku_pdf,mvd_ex,sku_ex,er_sku,er_mvd,created_at,platform_id,pdf_text,user_id)
					VALUES ('$file_pdf','$file_xlsx','$id', '$mvd_pdf', '$sku_pdf','$date','$mvd_ex',' $sku_ex','$erSku','$erMVD','$platform_id','$pdf_text','$user_id')";

					$db->query($sql);
					$id = $db->insert();

					$result_return = 'file bị lỗi ';

			    	
			    }
			    else{
			    	$result_return = 'file không bị lỗi ';
			    }

			    echo $result_return;
		    }
		   
		}

		function runAutoPrintPage(){
			global $db;

			$model  = $this -> model;

			$query =  "SELECT id FROM check_auto_print WHERE active = 0";

			$dem = $db->getTotal($query);

		
			for ($i=1; $i <= $dem; $i++) { 
				
				$querys = 'SELECT * FROM check_auto_print WHERE active = 0';
	    		
	     		$sql = $db->query($querys);

   				$result = $db->getObjectListByKey('id');
     			

	     		if(!empty($result)){
	     			foreach ($result as  $value) {

		     			$id = $value->id;
		     			
		     			$list_ar_str = $value->list_ar_str;

						$data_info['house_id'] = $value->house_id;

				        $data_info['platform_id'] = $value->platform_id;

				        $data_info['warehouse_id'] = $value->warehouse_id;

				        try 
						{

							$model->prints_auto($list_ar_str, $data_info);

						    $sql= "UPDATE check_auto_print SET active='1'  WHERE `id`=".$id;

		          			$db->query($sql);

		          			echo "update thành công id ".$id ;
						} 
						catch (Exception $e) 
						{    
						    echo 'Message: ' .$e->getMessage();
						     continue;
						}
				        

		     		}
	     		}



				sleep(10);
			}
			// $query_string = "delete from check_auto_print  WHERE `active`= 1";
			// $query_string =  "DELETE FROM check_auto_print WHERE `active` = 1";

			// $db->query($query_string);
		}

		function returnDataPDF($path)
		{
			$model  = $this -> model;

			$data  = [];

			$datas = shell_exec('pdftk '.$path.' dump_data | grep NumberOfPages');

		    $number_page = intval(str_replace('NumberOfPages: ', '', $datas));


		   	if($number_page>0){

		   		for($i =0; $i<$number_page; $i++){

		   			$page = $i+1;

		   			$mvd = $model->contendTextFindMvd($path,$page);

				    $sku = $model->contendTextFindSku($path,$page);

				    $data['mavandon'][] = $mvd??'';

				    $data['sku'][] = $sku??'';

		   		}

		   	}

		   	return $data;
		}

		function dataPDF($files, $platforms)
		{

			$all_data = [];

			$mvd = [];

			$sku = [];



			$dem = 0;

			$dems =0;

			$model = $this -> model;


			foreach ($files as $key => $value) {
				
				$file  = $value;
		   
			    $path  = $file;

			    switch ($platforms) {
			    	case 8:
			    		$data  = $this->dataPDFBest($path);
			    		break;

			    	case 1:		
			    		$data = $this->dataPDFLazada($path);
			    		break;

			    	case 4:		
			    		$data = $this->dataPDFLazada($path);
			    		break;	
			    	case 10:		
			    		$data = $this->dataPDFViettel($path);
			    		break;
			    	case 9:		
			    		$data = $this->dataPDFTiktok($path);	
			    		break;

			    	default:
			    		
			    		// shopee
			    		$data  = $this->returnDataPDF($path);
			    	
			    }

			    array_push($all_data, $data);

			}
	
			if(!empty($all_data) && count($all_data)>0){

				foreach ($all_data as $key => $vals) {

					
					if(!empty($vals['mavandon'])  && !empty($vals['sku'])){
						if(count($vals['mavandon'])>0){

							foreach ($vals['mavandon'] as $key => $value) {
								$dem++;

								$mvd[$dem] = $value;
							
							}

						}

						if(count($vals['sku'])>0){

							foreach ($vals['sku'] as $key => $vals) {
								$dems ++;

								$sku[$dems] = $vals;
								

							}

						}
					}
					
					
				}

			}

			$result['mavandon'] = $mvd;

			$result['sku'] = $sku;

			return $result;

			 // echo'<pre>'; var_dump($result); echo '</pre>';

			
		}

		function fix_uploads_page_pdf(){
			$model = $this -> model;
			$model->fix_uploads_page_pdf();
		}

		function add_uploads_page_pdf(){
			$model = $this -> model;
			$model->add_uploads_page_pdf();
		}

		function prints_fix_err()
		{
			// echo 111;
			// die;
			$model = $this -> model;
			$rows = $model->prints_fix_err();
			$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
			$page = FSInput::get('page',0);
			if($page > 1){
				$link .= '&page='.$page;
			}
				$link = FSRoute::_('index.php?module='.$this -> module.'&view='.$this -> view);	
			if($rows)
			{
				setRedirect($link,$rows.' '.FSText :: _('hóa đơn đã được in'));	
			}
			else
			{
				setRedirect($link,FSText :: _('Không có đơn nào được in, vui lòng kiểm tra lại file đã nhập lên có khớp nhau không'),'error');	
			}
		}

		

		function prints()
		{
			$model = $this -> model;
			$rows = $model->prints(1);
			$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
			$page = FSInput::get('page',0);
			if($page > 1){
				$link .= '&page='.$page;
			}
				$link = FSRoute::_('index.php?module='.$this -> module.'&view='.$this -> view);	
			if($rows)
			{
				setRedirect($link,$rows.' '.FSText :: _('hóa đơn đã được in'));	
			}
			else
			{
				setRedirect($link,FSText :: _('Không có đơn nào được in, vui lòng kiểm tra lại file đã nhập lên có khớp nhau không'),'error');	
			}
		}

		function print_auto(){

			$run =  !empty($_GET['run'])?$_GET['run']:'';

			global $db;

			$model  = $this -> model;

			if($run==="1"){
				

		        $platform = [1,2,3,4,6,8,9,10,11];

		        $data_order = [];

		        $info_house = [];

		        // chạy đơn lúc 7h10

		        $H = date('G');

		        $house_id =  $H<8?13:18; 

		        $data_info = [];

		        for($i=1; $i<3; $i++){

		            foreach ($platform as  $platforms) {
		                
		                 $query =  "SELECT id FROM fs_order_uploads AS a WHERE 1=1 AND warehouse_id = ".$i." AND house_id = ".$house_id." AND platform_id = ".$platforms." AND date ='".date('Y-m-d')."' ORDER BY created_time DESC , id DESC";

		                $sql = $db->query ($query);
		                $result = $db->getObjectList ();

		                $list_Ar = [];

		                if(!empty($result)){

		                    foreach ($result as $key => $value) {
		                   
		                        array_push($list_Ar, $value->id);
		                    }

		                } 

		                $list_ar_str = implode(',', $list_Ar);

		                if(!empty($list_ar_str)){
		                	$data_info['house_id'] = $house_id;

			                $data_info['platform_id'] = $platforms;

			                $data_info['warehouse_id'] = $i;

			                $list_ar_str = implode(',', $list_Ar);

			                $data_info['list_ar_str'] = $list_ar_str;

			                $data_info['date'] = date('Y-m-d');

			                $sql = " INSERT INTO check_auto_print
		     							(list_ar_str, platform_id, warehouse_id, house_id)
		     							VALUES ('$list_ar_str','$platforms','$i','$house_id')
		    							";
		    				
		    				$db->insert($sql);
		                }

		                

		             

		                // if(!empty($list_ar_str)){

		                // 	array_push($info_house, $data_info);

		                // 	array_push($data_order, $list_ar_str);

		                // 	// $model->prints_auto($list_ar_str, $data_info);
		                // }

		            }
		        } 
			}
			elseif($run==="2"){

				global $db;

	    		$query = 'SELECT * FROM check_auto_print WHERE active = 0';
	    		
	     		$sql = $db->query($query);

   				$result = $db->getObjectListByKey('id');
     			
	     		// echo "<pre>"; var_dump($result); echo "</pre>";

	     		// die;

	     		if(!empty($result)){
	     			foreach ($result as  $value) {

		     			$id = $value->id;
		     			
		     			$list_ar_str = $value->list_ar_str;

						$data_info['house_id'] = $value->house_id;

				        $data_info['platform_id'] = $value->platform_id;

				        $data_info['warehouse_id'] = $value->warehouse_id;

				        try 
						{

							$model->prints_auto($list_ar_str, $data_info);

						    $sql= "UPDATE check_auto_print SET active='1'  WHERE `id`=".$id;

		          			$db->query($sql);

		          			echo "update thành công id ".$id ;
						} 
						catch (Exception $e) 
						{    
						    echo 'Message: ' .$e->getMessage();
						}
				        

		     		}
	     		}

			}
			else{
				echo "print bị lỗi";
			}


	        // print_r($data_order[0]);

	        // $list_ar_str = "227948,227840,227838,227833,227831,227829,227826,227813,227812,227804,227797,227795,227793,227791,227789,227786,227785,227784,227779,227777,227776,227774,227771,227769,227766,227765,227764,227762,227759,227758,227757,227756,227752";

	        // $data_info['house_id'] = 13;

	        // $data_info['platforms'] = 2;

	        // $data_info['warehouse_id'] = 1;


	        // $model->prints_auto($list_ar_str, $data_info);

	        // echo "<pre>";print_r($data_order); echo "</pre>";

	        // echo'<br>';

	        // echo "<pre>";print_r($info_house); echo "</pre>";
	       

		}
		
	}

	// public function print_auto_after($value='')
	// {
		
	// }



	// phần này bên ngoài class chưa rõ lý do

		function view_pdf($controle,$id){
			$model = $controle -> model;

			$data = $model->get_record('id = ' .$id,'fs_order_uploads','id,file_pdf,total_page_pdf');
			if(!$data-> file_pdf){
				$html ='<strong style="color:red">Lỗi thiếu file</strong>';
				return $html;
			}
			$link = $data-> file_pdf;
			
			$arr_name = explode('t,t',$link);
			
			$html ="";
			if(!empty($arr_name)){
				$i=0;
				foreach ($arr_name as $name_item) {
					$base_name = basename($name_item);
					if($i == 0){
						$path = str_replace($base_name,'',$name_item);
					}

					$file_namesss = str_replace('admin/order/','',PATH_BASE.$path.$base_name);
					if(!file_exists(str_replace('admin/order/','',PATH_BASE.$path.$base_name))){ 
					    
					    $file_direct_check = trim($path.$base_name); 
					    
					    $checkfile = $model->get_record('file_name = "' .$base_name.'"','file_id_drive','id_file_drive,file_name ');
					    
					//     	$query = " SELECT " . $select . "
					// 	  FROM " . $table_name . "
					// 	  WHERE " . $where;
						 
			
	    //             		global $db;
	    //             		$db->query ( $query );
	    //             		$result = $db->getObject ();

					    // check tháng 3
					    if( $id>189222 && $id< 199425){

					    	$paths = str_replace('files/orders/2024','', $path); 
					    	$url =  'https://cachsuadienmay.vn/public/uploads'.$paths.urlencode($base_name);

					    	$pathInfo = parse_url($url, PHP_URL_PATH);
						         
						    $html .= '<a target="_blank" style="color: rgba(255, 153, 0, 0.79);" href="'.$url.'">'.$base_name.'</a><br/>';
					    }
					    else{
					    	if(!empty($checkfile)){
						         $url = 'https://drive.'.DOMAIN.'/get.php?mime=pdf&showfile='.$checkfile->id_file_drive;
						         
						        $html .= '<a target="_blank" style="color: rgba(255, 153, 0, 0.79);" href="'.$url.'">'.$base_name.'</a><br/>';
						    }
						    else{


						    	$html .= '<a target="_blank" style="color: red;" href="'.basename($file_namesss).'">'.basename($file_namesss).'</a><br/>';

						       
						    }
					    }
					   
					   
					}else{
					    
						$html .= '<a target="_blank" style="color: rgba(255, 153, 0, 0.79);" href="'.URL_ROOT.$path.$base_name.'">'.$base_name.'</a><br/>';
					}
					
					$i++;
				}
			}else{
			    
				$html .= '<a style="color: rgba(255, 153, 0, 0.79);" target="_blink" href="'.URL_ROOT.$value.'">'.$value.'</a><br/>';
			}

			//kiểm tra page cod cắt đủ ko
			$data_file_pdf = $model->get_records('record_id = ' .$id,'fs_order_uploads_page_pdf','id');
			if($id > 3571800000000000000000000){
				if(empty($data_file_pdf) || count($data_file_pdf) != $data -> total_page_pdf){
					return '<a style="color: red;" target="_blink" href="' . $link . '">Lỗi không nhận đủ trang PDF, Vui lòng up lại file</a>';
				}
			}
			
		
			$data_detail = $model->get_record('record_id = ' .$id,'fs_order_uploads_detail','id');
			if(empty($data_detail)){
			    
			    if(!empty($link)){
			        return '<a style="color: rgba(255, 153, 0, 0.79);" target="_blink" href="/'. $link .'">'.basename($link).'</a>';
			    }
			    else{
			        return '<a style="color: red;" target="_blink" href="' . $link . '">Lỗi file</a>';
			    }
				
			}else{
				return $html;
			}
			
		}

	function view_excel($controle,$id){
		$model = $controle -> model;
		
		
		$data = $model->get_record('id = ' .$id,'fs_order_uploads','id,file_xlsx,file_excel_drive');
		
	
		if(!$data-> file_xlsx){
			$html ='<strong style="color:red">Lỗi thiếu file</strong>';
			return $html;
		}
		$link = URL_ROOT.$data-> file_xlsx;
		
		if(!file_exists(str_replace('admin/order/','',PATH_BASE.$data-> file_xlsx))){
		    
		    $url = 'https://drive.'.DOMAIN.'/get.php??mime=excel&showfile='.$data->file_excel_drive;
		    
		    if (!empty($data->file_excel_drive)) {
		        
              return '<a style="color: rgba(255, 153, 0, 0.79);" target="_blink" href="' . $url . '">'.basename($data-> file_xlsx).'</a>';
              
            } else {
              	return '<a style="color: red;" target="_blink" href="javascript:void(0)">Lỗi file</a>';
            }
		    
		   
		}

		$data_detail = $model->get_record('record_id = ' .$id,'fs_order_uploads_detail','id');
		
		
		if(empty($data_detail)){
		   
			return '<a style="color: red;" target="_blink">Lỗi </a>';
		}else{
			return '<a style="color: rgba(255, 153, 0, 0.79);" target="_blink" href="' . $link . '">'.basename($data-> file_xlsx).'</a>';
		}

		
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