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

		function test()
		{
			$model  = $this -> model;
		   
		    $path = 'files/orders/2024/07/09/kat-2_1720520511.xlsx';

		    $path_run_excel = PATH_BASE.'files/print/excel2.xlsx';

		    file_put_contents($path_run_excel, file_get_contents('https://dienmayai.com/files/orders/2024/07/09/kat-2_1720520511.xlsx'));


		    $test =  $model->showDataExcel($path_run_excel);

		    $path_run_pdf = PATH_BASE.'files/print/pdf1.pdf';

		    file_put_contents($path_run_pdf, file_get_contents('https://drive.dienmayai.com/get.php?mime=pdf&showfile=1AZAh5AC31RaGtSi_6GaW0ElSpkhnH04z'));
		   
		    $filePDF = [$path_run_pdf];

		    $data_pdf = $this->dataPDF($filePDF);

		    $checkMVD =  array_diff($data_pdf['mavandon'], $test['maVanDon']);

		    $checkSku =  array_diff($data_pdf['sku'], $test['Sku']);

		    unlink($path_run_excel);

		    unlink($path_run_pdf);

		    // echo"<pre>"; var_dump($data_pdf['sku']); echo"</pre>"; echo "<br>"; echo"<pre>";var_dump($test['Sku']); echo"</pre>";

		    // die;

		    if(empty($checkMVD) && empty($checkSku)){

		    	echo "đơn hàng không bị lỗi";
		    }
		    else{

		    	if(!empty($checkMVD)){

		    		// print_r($checkMVD);
		    		echo 'kiểm tra lại các mã vận đơn sau ở file pdf <br>'. implode("<br>",$checkMVD). '<br>
		    		 không giống với file excel';
		    	}

		    	if(!empty($checkSku)){

		    		echo 'kiểm tra lại sku sau ở file pdf <br>'. implode("<br>",$checkSku). '<br>
		    		 không giống với file excel';
		    	}
		    }

		   
		}

		function runAutoPrintPage(){
			$page = $_GET['page'];

			for ($i=1; $i <= $page; $i++) { 
				
				file_get_contents('https://dienmayai.com/admin/order/upload/auto_print?run=2');
			}
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

				    $data['mavandon'][$i] = $mvd[0]??'';

				    $data['sku'][$i] = $sku[0]??'';

		   		}

		   	}

		   	return $data;
		}

		function dataPDF($files)
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
				
				$data  = $this->returnDataPDF($path);
	
			    array_push($all_data, $data);



			}
			if(count($all_data)){

				

				foreach ($all_data as $key => $vals) {


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

			$result['mavandon'] = $mvd;

			$result['sku'] = $sku;

			return $result;

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

		        $house_id = $H<8?13:18; 

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
						         $url = 'https://drive.dienmayai.com/get.php?mime=pdf&showfile='.$checkfile->id_file_drive;
						         
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
		    
		    $url = 'https://drive.dienmayai.com/get.php??mime=excel&showfile='.$data->file_excel_drive;
		    
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