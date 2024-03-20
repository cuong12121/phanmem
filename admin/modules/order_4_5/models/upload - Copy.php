<?php
	include 'PDFMerger-tcpdf/PDFMerger.php'; 
	use PDFMerger\PDFMerger;
	class OrderModelsUpload extends FSModels
	{
		var $limit;
		var $page;
		function __construct()
		{
			$limit = 100;
			$page = FSInput::get('page');
			$this->limit = $limit;
			$this -> table_name = 'fs_order_uploads';
		
			parent::__construct();
		}
		
		function setQuery()
		{
			// ordering
			$ordering = '';
			$where = "  ";


			// from
			if(isset($_SESSION[$this -> prefix.'text0']))
			{
				$date_from = $_SESSION[$this -> prefix.'text0'];
				if($date_from){
					$date_from = strtotime($date_from);
					$date_new = date('Y-m-d H:i:s',$date_from);
					$where .= ' AND a.date >=  "'.$date_new.'" ';
				}
			}
			
				// to
			if(isset($_SESSION[$this -> prefix.'text1']))
			{
				$date_to = $_SESSION[$this -> prefix.'text1'];
				if($date_to){
					$date_to = $date_to . ' 23:59:59';
					$date_to = strtotime($date_to);
					$date_new = date('Y-m-d H:i:s',$date_to);
					$where .= ' AND a.date <=  "'.$date_new.'" ';
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					
					$where .= ' AND a.house_id =  "'.$filter.'" ';
				}
			}


			if(isset($_SESSION[$this -> prefix.'filter1'])){
				$filter = $_SESSION[$this -> prefix.'filter1'];
				if($filter){
					
					$where .= ' AND a.warehouse_id =  "'.$filter.'" ';
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter2'])){
				$filter = $_SESSION[$this -> prefix.'filter2'];
				if($filter){
					
					$where .= ' AND a.platform_id =  "'.$filter.'" ';
				}
			}

			// SP nổi bật theo hãng
			if (isset ( $_SESSION [$this->prefix . 'filter3'] )) {
				$filter = $_SESSION [$this->prefix . 'filter3'];
				if ($filter) {
					if($filter == 1)
						$where .= ' AND a.is_print = 1';
					else 
						$where .= ' AND a.is_print <> 1';
				}

			}





			if(isset($_SESSION[$this -> prefix.'sort_field']))
			{
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				$ordering = '';
				if($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
			}
			
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND name LIKE '%".$keysearch."%' OR shop_code LIKE '%".$keysearch."%' ";
				}
			}
			$query = "SELECT * FROM ".$this -> table_name." AS a WHERE 1=1 " . $where. $ordering. " ";
			return $query;
		}

		function upload_excel_shopee($file_path,$result_id){
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
			$count_ss = 0;
			for($j=2;$j<=$heightRow;$j++){
				$row = array();
				$row['code'] = trim($data[$j]['A']);
				if(!$row['code'] || $row['code'] == 'null' ){
					continue;
				}
				$row['sku_nhanh'] = trim($data[$j]['S']);
				if(!$row['sku_nhanh'] || $row['sku_nhanh'] == 'null' ){
					continue;
				}
				$row['count'] = trim($data[$j]['Z']);
				$row['shipping_unit_name'] = trim($data[$j]['G']);
				$row['tracking_code'] = trim($data[$j]['F']);
				if(!$row['tracking_code'] || $row['tracking_code'] == 'null' ){
					continue;
				}
				
				$upload_exel = $this->save_excel($row,$result_id);

				if(!$upload_exel){
					continue;
				}else{
					$count_ss++;
				}
			}
			return $count_ss;
		}

		function upload_excel_lazada($file_path,$result_id){
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
			$count_ss = 0;
			for($j=2;$j<=$heightRow;$j++){
				$row = array();
				$row['code'] = trim($data[$j]['A']);
				if(!$row['code'] || $row['code'] == 'null' ){
					continue;
				}
				$row['sku_nhanh'] = trim($data[$j]['F']);
				if(!$row['sku_nhanh'] || $row['sku_nhanh'] == 'null' ){
					continue;
				}
				$row['count'] = 1;
				$row['shipping_unit_name'] = trim($data[$j]['BC']);
				$row['lazada_sku'] = trim($data[$j]['G']);
				$row['tracking_code'] = trim($data[$j]['BG']);
				if(!$row['tracking_code'] || $row['tracking_code'] == 'null' ){
					continue;
				}
				$upload_exel = $this->save_excel($row,$result_id);

				if(!$upload_exel){
					continue;
				}else{
					$count_ss++;
				}
			}
			return $count_ss;
		}

		function upload_excel_tiki($file_path,$result_id){
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
			$count_ss = 0;
			for($j=2;$j<=$heightRow;$j++){
				$row = array();
				$row['code'] = trim($data[$j]['O']);
				if(!$row['code'] || $row['code'] == 'null' ){
					continue;
				}
				$row['sku_nhanh'] = trim($data[$j]['Q']);
				if(!$row['sku_nhanh'] || $row['sku_nhanh'] == 'null' ){
					continue;
				}
				$row['count'] = trim($data[$j]['S']);
				$row['shipping_unit_name'] = "Tiki";
				$row['tracking_code'] = trim($data[$j]['C']);
				if(!$row['tracking_code'] || $row['tracking_code'] == 'null' ){
					continue;
				}
				$upload_exel = $this->save_excel($row,$result_id);

				if(!$upload_exel){
					continue;
				}else{
					$count_ss++;
				}
			}
			return $count_ss;
		}

		function upload_excel_viettel($file_path,$result_id){
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
			$count_ss = 0;
			for($j=2;$j<=$heightRow;$j++){
				$row = array();
				$row['code'] = trim($data[$j]['B']);
				if(!$row['code'] || $row['code'] == 'null' ){
					continue;
				}
				$row['sku_nhanh'] = trim($data[$j]['O']);
				if(!$row['sku_nhanh'] || $row['sku_nhanh'] == 'null' ){
					continue;
				}
				$row['count'] = trim($data[$j]['P']);
				$row['shipping_unit_name'] = "Viettel Post";
				$upload_exel = $this->save_excel($row,$result_id);

				if(!$upload_exel){
					continue;
				}else{
					$count_ss++;
				}
			}
			return $count_ss;
		}

		function save_excel($row = array(),$result_id){
			if($result_id){
				$data = $this->get_record('id = '.$result_id,'fs_order_uploads');
			}

			if(empty($data)){
				return false;
			}

			$row['record_id'] = $result_id;

			if($row['sku_nhanh']){
				$arr_other = explode('-',$row['sku_nhanh']);
				
				$row['sku'] = $arr_other[0];
				$row['color'] = $arr_other[1];
				$row['size'] = $arr_other[2];

				$product_code = $row['sku'].'-'.$row['color'].'-'.$row['size'];
				$produt = $this->get_record('code = "'.$product_code.'"','fs_products');
				if(empty($produt)){
					return 0;
				}

				$row['product_id'] = $produt->id;
				$row['product_code'] = $produt->code;
				$row['product_price'] = $produt->price;
				$row['product_name'] = $produt->name;


				$row['shop_code'] = $data-> shop_code;
				$row['shop_code'] = $data-> shop_code;
				$row['shop_id'] = $data-> shop_id;
				$row['shop_name'] = $data-> shop_name;
				$row['date'] = $data-> date;
				$row['platform_id'] = $data-> platform_id;
				$row['warehouse_id'] = $data-> warehouse_id;
				$row['house_id'] = $data-> house_id;
				$row['created_time'] = date('Y-m-d H:i:s');
				$row['user_id'] = $_SESSION['ad_userid'];

				
				if($row['shipping_unit_name']){
					$check_shipping = $this->get_record('name = "'.$row['shipping_unit_name'].'"','fs_shipping_unit');
					if(!empty($check_shipping)){
						$row['shipping_unit_id'] = $check_shipping-> id;
					}else{
						$row2 = array();
						$row2['name'] = $row['shipping_unit_name'];
						$row2['published'] = 1;
						$add_shipping = $this ->_add($row2,'fs_shipping_unit');
						$row['shipping_unit_id'] = $add_shipping;
					}
				}
			}
			// printr($row);
			if($data-> platform_id == 1){ // check để tính toán số lượng cho sàn lazada
				$check_count = $this->get_record('lazada_sku = "'.$row['lazada_sku'].'" AND sku = "'.$row['sku'].'"','fs_order_uploads_detail');
				if(!empty($check_count)){
					$row3 = array();
					$row3['count'] = (int)$check_count-> count + 1;
					$row3['total_price'] = (int)$check_count-> total_price + (int)$produt->price;
					$update_id = $this ->_update($row3,'fs_order_uploads_detail','id = '. $check_count->id);
					if($update_id){
						$this->minus_quantity_product($row['warehouse_id'],$row['product_id'],1);
					}
					return $update_id;
				}else{
					$row['total_price'] = (int)$produt->price * (int)$row['count'];
					$add_id = $this->_add($row,'fs_order_uploads_detail');
					if($add_id){
						$this->minus_quantity_product($row['warehouse_id'],$row['product_id'],(int)$row['count']);
					}
					return $add_id;
				}
			}else{
				$row['total_price'] = (int)$produt->price * (int)$row['count'];
				$add_id = $this->_add($row,'fs_order_uploads_detail');
				if($add_id){
					$this->minus_quantity_product($row['warehouse_id'],$row['product_id'],(int)$row['count']);
				}
				return $add_id;
			}
		}


		//trừ số lượng của sản phẩm khi in thành công
		function minus_quantity_product($warehouse_id,$product_id,$count = 1){
			$data = $this->get_record('warehouses_id = ' . $warehouse_id . ' AND product_id = '. $product_id,'fs_warehouses_products');
			if(!empty($data)){
				$row = array();
				$row['amount'] = (int)$data->amount - (int)$count;
				$this->_update($row,'fs_warehouses_products','id = '.$data->id);
			}else{
				$row = array();
				$row['amount'] = -$count;
				$row['product_id'] = (int)$product_id;
				$row['warehouses_id'] = (int)$warehouse_id;
				$this->_add($row,'fs_warehouses_products');
			}
		}



		function save($row = array(), $use_mysql_real_escape_string = 1) {
			global $config;
			$users = $this -> get_record('id = ' . $_SESSION['ad_userid'],'fs_users');
			if($users-> group_id == 1 && $users-> money < $config['money_min']){
				Errors::_('Số tiền tạm ứng không đủ ' .format_money($config['money_min'],' đ','0 đ'). ' vui lòng liên hệ chúng tôi để nạp thêm.' );
				return false;
			}

			$id = FSInput::get('id');

			if($id){
				// không cho thay đổi nếu đơn này đã đươc IN
				$data = $this->get_record('id = '.$id,'fs_order_uploads');
				if($data-> is_print == 1){
					Errors::_('Đơn này đã được chuyển sang trạng thái in nên không thể thay đổi');
					return false;
				}
			}


			$fsFile = FSFactory::getClass('FsFiles');
			$cyear = date ( 'Y' );
			$cmonth = date ( 'm' );
			$cday = date ( 'd' );
			$path = PATH_BASE.'files/orders/'.$cyear.'/'.$cmonth.'/'.$cday.'/';
			$path = str_replace('/', DS,$path);
			// file pdf
	        $file_pdf = $_FILES["file_pdf"]["name"];
			if($file_pdf){
				$file_pdf_name = $fsFile -> upload_file("file_pdf", $path ,100000000, '_'.time());
				if(!$file_pdf_name)
					return false;
				$row['file_pdf'] = 'files/orders/'.$cyear.'/'.$cmonth.'/'.$cday.'/'.$file_pdf_name;
			}

			// file xlsx
	        $file_xlsx = $_FILES["file_xlsx"]["name"];
			if($file_xlsx){
				$file_xlsx_name = $fsFile -> upload_file("file_xlsx", $path ,100000000, '_'.time());
				if(!$file_xlsx_name)
					return false;
				$row['file_xlsx'] = 'files/orders/'.$cyear.'/'.$cmonth.'/'.$cday.'/'.$file_xlsx_name;
			}




			$date = FSInput::get('date');
			$row['date'] = date('Y-m-d',strtotime($date));
			$row['user_id'] = $_SESSION['ad_userid'];

			$shop_id = FSInput::get('shop_id');
			$platform_id = FSInput::get('platform_id');

			$house_id = FSInput::get('house_id');
			$warehouse_id = FSInput::get('warehouse_id');

			if(!$date || !$shop_id || !$platform_id || !$house_id || !$warehouse_id ){
				Errors::_('Bạn phải nhập đầy đủ thông tin.');
				return false;
			}

			if($shop_id){
				$shop = $this->get_record('id = '.$shop_id,'fs_shops');
				$row['shop_code'] = $shop->code;
				$row['shop_name'] = $shop->name;
			}


			$result_id = parent::save ($row);
			if($result_id && $file_xlsx && $file_xlsx_name){
				//lưu vào bảng tạm để làm thông số tạm giữ ở kho
				if($platform_id == 1){
					$add = $this->upload_excel_lazada($file_path,$item-> id);
				}elseif($platform_id == 2){
					$add = $this->upload_excel_shopee($file_path,$item-> id);
				}elseif($platform_id == 3){
					$add = $this->upload_excel_tiki($file_path,$item-> id);
				}elseif($platform_id == 4){
					$add = $this->upload_excel_viettel($file_path,$item-> id);
				}
				
			}
			

			return $result_id;
		}




		function prints($value)
		{
			$pdf = new PDFMerger;
			$ids = FSInput::get('id',array(),'array');
			if(!empty($ids))
			{
				global $db;
				$str_ids = implode(',',$ids);
				$list = $this->get_records('id IN ('.$str_ids.')','fs_order_uploads');
				$i = 0;
				$j = 1;
				$name_pdf = "";
				// $cyear = date ( 'Y' );
				// $cmonth = date ( 'm' );
				// $cday = date ( 'd' );
				
				
				foreach ($list as $item) {
					//tách file
					$file_path = PATH_BASE.$item-> file_xlsx;
					$file_path = str_replace('/', DS,$file_path);

					if($item-> platform_id == 1){
						$add = $this->upload_excel_lazada($file_path,$item-> id);
					}elseif($item-> platform_id == 2){
						$add = $this->upload_excel_shopee($file_path,$item-> id);
					}elseif($item-> platform_id == 3){
						$add = $this->upload_excel_tiki($file_path,$item-> id);
					}elseif($item-> platform_id == 4){
						$add = $this->upload_excel_viettel($file_path,$item-> id);
					}

					if($add){
						$row = array();
						$row['is_print'] = 1;
						$this->_update($row,'fs_order_uploads');
						$i++;
					}
					//ghép file pdf
					$file_path_pdf = PATH_BASE.$item-> file_pdf;
					$file_path_pdf = str_replace('/', DS,$file_path_pdf);

					$pdf->addPDF($file_path_pdf, 'all');

					if($j==1){
						$basename_1 = basename($item-> file_pdf);
						$path_pdf_merge_soft = str_replace($basename_1,'',$item-> file_pdf);
						$path_pdf_merge = PATH_BASE.$path_pdf_merge_soft;
						$path_pdf_merge = str_replace('/', DS,$path_pdf_merge);
						
					}

					if($j == count($list)){
						$name_pdf .= $item->id;
					}else{
						$name_pdf .= $item->id . '_';
					}
					$j++;
				}
				
				$pdf->merge('file',$path_pdf_merge.$name_pdf.'.pdf');

				//lưu lại lịch sử in
				$row2 = array();
				$row2['total_file'] = count($list);
				$row2['total_file_success'] = $i;
				$row2['created_time'] = date('Y-m-d H:i:s');
				$row2['action_username'] = $_SESSION ['ad_username'];
				$row2['action_userid'] = $_SESSION ['ad_userid'];
				$row2['file_pdf'] = $path_pdf_merge_soft.$name_pdf.'.pdf';
				$this->_add($row2,'fs_order_uploads_history_prints');
				return $i;
			}
			return 0;
		}
	}
	
?>