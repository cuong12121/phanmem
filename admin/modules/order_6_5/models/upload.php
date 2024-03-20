<?php
	include 'PDFMerger-tcpdf/PDFMerger.php';
	use PDFMerger\PDFMerger;
	include 'fpdf/fpdf.php';
   	include 'fpdi/src/autoload.php';
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

		function upload_excel_shopee($file_path,$result_id,$shop_code){
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
			

		
			if(!$result_id){
				$link = FSRoute::_('index.php?module=order&view=upload&task=add');
			}else{
				$link = FSRoute::_('index.php?module=order&view=upload&task=edit&id='.$result_id);
			}
			

			//chạy vòng đầu để check lỗi trước
			for($j=2;$j<=$heightRow;$j++){
				$row = array();
				$row['code'] = trim($data[$j]['A']);
				if(!$row['code'] || $row['code'] == 'null' ){
					$this->remove_xml($result_id,$file_path);
					$msg = 'Không được để trống Mã đơn hàng(cột A) dòng '.$j;
					setRedirect($link,$msg,'error');
				}
				$row['sku_nhanh'] = trim($data[$j]['S']);
				if(!$row['sku_nhanh'] || $row['sku_nhanh'] == 'null' ){
					$this->remove_xml($result_id,$file_path);
					$msg = 'Không được để trống SKU phân loại(cột S) dòng '.$j;
					setRedirect($link,$msg,'error');
				}
				$row['count'] = trim($data[$j]['Z']);
				if(!$row['count'] || $row['count'] == 'null' ){
					$this->remove_xml($result_id,$file_path);
					$msg = 'Không được để trống Số lượng(cột Z) dòng '.$j;
					setRedirect($link,$msg,'error');
				}
				$row['shipping_unit_name'] = trim($data[$j]['G']);
				if(!$row['shipping_unit_name'] || $row['shipping_unit_name'] == 'null' ){
					$this->remove_xml($result_id,$file_path);
					$msg = 'Không được để trống Đơn vị vận chuyển(cột G) dòng '.$j;
					setRedirect($link,$msg,'error');
				}

				$row['tracking_code'] = trim($data[$j]['F']);
				if(!$row['tracking_code'] || $row['tracking_code'] == 'null' ){
					$this->remove_xml($result_id,$file_path);
					$msg = 'Không được để trống Mã vận đơn(cột F) dòng '.$j;
					setRedirect($link,$msg,'error');
				}

				$arr_other = explode('-',$row['sku_nhanh']);
				$row['sku'] = $arr_other[0];
				
				$row['color'] = $arr_other[1];
				$row['size'] = $arr_other[2];
				$row['shop_code'] = $arr_other[3];
				$product_code = $row['sku'].'-'.$row['color'].'-'.$row['size'];
				$produt = $this->get_record('code = "'.$product_code.'"','fs_products');
				if(empty($produt)){
					$this->remove_xml($result_id,$file_path);
					$msg = 'Không tìm thấy sản phẩm có sku '.$product_code.' trong kho.';
					setRedirect($link,$msg,'error');
				}

				if($shop_code !== $row['shop_code']){
					$this->remove_xml($result_id,$file_path);
					$msg = 'Mã shop không đúng (cột S) dòng '.$j;
					setRedirect($link,$msg,'error');
				}
			}


			$count_ss = 0;
			for($j=2;$j<=$heightRow;$j++){
				$row = array();
				$row['code'] = trim($data[$j]['A']);
				$row['sku_nhanh'] = trim($data[$j]['S']);
				$row['count'] = trim($data[$j]['Z']);
				$row['shipping_unit_name'] = trim($data[$j]['G']);
				$row['tracking_code'] = trim($data[$j]['F']);
				$upload_exel = $this->save_excel($row,$result_id);
				if(!$upload_exel){
					continue;
				}else{
					$count_ss++;
				}
			}
			return $count_ss;
		}


		function remove_xml($id,$file_path){
			$row = array();
			$row['file_xlsx'] = "";
			$this->_update($row,'fs_order_uploads','id ='.$id);
			unset($file_path);

			// xóa hết các item của file cũ đi
			$this->delete_item_update_amount_hold($id);

		}




		function remove(){
			global $db;
			// check remove
			if(method_exists($this,'check_remove')){
				if(!$this -> check_remove()){
					Errors::_(FSText::_('Can not remove these records because have data are related'));
					return false;
				}
			}
			$cids = FSInput::get('id',array(),'array'); 
			
			if(!count($cids))
				return false;
			$str_cids = implode(',',$cids);
			
			$i = 0;
			foreach ($cids as $id) {
				$data = $this->get_record('id = ' . $id,$this -> table_name);
				if(!empty($data) && $data-> is_print != 1){
					$sql = " DELETE FROM ".$this -> table_name." WHERE id = " . $id;
					$row = $db->affected_rows($sql);
					if($row){
						// xóa hết các item của file cũ đi
						$this->delete_item_update_amount_hold($id);
						$i++;
					}
				}
			}
			return $i;
		}


		function upload_excel_lazada($file_path,$result_id,$shop_code){
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

			if(!$result_id){
				$link = FSRoute::_('index.php?module=order&view=upload&task=add');
			}else{
				$link = FSRoute::_('index.php?module=order&view=upload&task=edit&id='.$result_id);
			}

			//chạy vòng đầu để check lỗi trước
			for($j=2;$j<=$heightRow;$j++){
				$row = array();
				$row['code'] = trim($data[$j]['A']);
				if(!$row['code'] || $row['code'] == 'null' ){
					$this->remove_xml($result_id,$file_path);
					$msg = 'Không được để trống Mã đơn hàng(cột A) dòng '.$j;
					setRedirect($link,$msg,'error');
				}
				$row['sku_nhanh'] = trim($data[$j]['F']);
				if(!$row['sku_nhanh'] || $row['sku_nhanh'] == 'null' ){
					$this->remove_xml($result_id,$file_path);
					$msg = 'Không được để trống SKU phân loại(cột F) dòng '.$j;
					setRedirect($link,$msg,'error');
				}
				
				$row['shipping_unit_name'] = trim($data[$j]['BC']);
				if(!$row['shipping_unit_name'] || $row['shipping_unit_name'] == 'null' ){
					$this->remove_xml($result_id,$file_path);
					$msg = 'Không được để trống Đơn vị vận chuyển(cột BC) dòng '.$j;
					setRedirect($link,$msg,'error');
				}

				$row['tracking_code'] = trim($data[$j]['BG']);
				if(!$row['tracking_code'] || $row['tracking_code'] == 'null' ){
					$this->remove_xml($result_id,$file_path);
					$msg = 'Không được để trống Mã vận đơn(cột BG) dòng '.$j;
					setRedirect($link,$msg,'error');
				}

				$row['lazada_sku'] = trim($data[$j]['G']);
				if(!$row['lazada_sku'] || $row['lazada_sku'] == 'null' ){
					$this->remove_xml($result_id,$file_path);
					$msg = 'Không được để trống Mã vận đơn(cột G) dòng '.$j;
					setRedirect($link,$msg,'error');
				}

				

				$arr_other = explode('-',$row['sku_nhanh']);
				$row['sku'] = $arr_other[0];
	

				$row['color'] = $arr_other[1];
				$row['size'] = $arr_other[2];
				$row['shop_code'] = $arr_other[3];
				$product_code = $row['sku'].'-'.$row['color'].'-'.$row['size'];
				$produt = $this->get_record('code = "'.$product_code.'"','fs_products');
				if(empty($produt)){
					$this->remove_xml($result_id,$file_path);
					$msg = 'Không tìm thấy sản phẩm có sku '.$product_code.' trong kho.';
					setRedirect($link,$msg,'error');
				}

				if($shop_code !== $row['shop_code']){
					$this->remove_xml($result_id,$file_path);
					$msg = 'Mã shop không đúng (cột S) dòng '.$j;
					setRedirect($link,$msg,'error');
				}
			}


			$count_ss = 0;
			for($j=2;$j<=$heightRow;$j++){
				$row = array();
				$row['code'] = trim($data[$j]['A']);
				$row['sku_nhanh'] = trim($data[$j]['F']);
				$row['count'] = 1;
				$row['shipping_unit_name'] = trim($data[$j]['BC']);
				$row['lazada_sku'] = trim($data[$j]['G']);
				$row['tracking_code'] = trim($data[$j]['BG']);

				$upload_exel = $this->save_excel($row,$result_id);

				if(!$upload_exel){
					continue;
				}else{
					$count_ss++;
				}
			}
			return $count_ss;
		}

		function upload_excel_tiki($file_path,$result_id,$shop_code){
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

			if(!$result_id){
				$link = FSRoute::_('index.php?module=order&view=upload&task=add');
			}else{
				$link = FSRoute::_('index.php?module=order&view=upload&task=edit&id='.$result_id);
			}

			//chạy vòng đầu để check lỗi trước
			for($j=2;$j<=$heightRow;$j++){
				$row = array();

				$row['code'] = trim($data[$j]['O']);
				if(!$row['code'] || $row['code'] == 'null' ){
					$this->remove_xml($result_id,$file_path);
					$msg = 'Không được để trống Mã đơn hàng(cột O) dòng '.$j;
					setRedirect($link,$msg,'error');
				}

				$row['sku_nhanh'] = trim($data[$j]['Q']);
				if(!$row['sku_nhanh'] || $row['sku_nhanh'] == 'null' ){
					$this->remove_xml($result_id,$file_path);
					$msg = 'Không được để trống SKU phân loại(cột Q) dòng '.$j;
					setRedirect($link,$msg,'error');
				}

				$row['count'] = trim($data[$j]['S']);
				if(!$row['count'] || $row['count'] == 'null' ){
					$this->remove_xml($result_id,$file_path);
					$msg = 'Không được để trống Số lượng(cột S) dòng '.$j;
					setRedirect($link,$msg,'error');
				}
			
				$row['tracking_code'] = trim($data[$j]['C']);
				if(!$row['tracking_code'] || $row['tracking_code'] == 'null' ){
					$this->remove_xml($result_id,$file_path);
					$msg = 'Không được để trống Mã vận đơn(cột C) dòng '.$j;
					setRedirect($link,$msg,'error');
				}

				$arr_other = explode('-',$row['sku_nhanh']);
				$row['sku'] = $arr_other[0];
				
				$row['color'] = $arr_other[1];
				$row['size'] = $arr_other[2];
				$row['shop_code'] = $arr_other[3];
				$product_code = $row['sku'].'-'.$row['color'].'-'.$row['size'];
				$produt = $this->get_record('code = "'.$product_code.'"','fs_products');

				if(empty($produt)){
					$this->remove_xml($result_id,$file_path);
					$msg = 'Không tìm thấy sản phẩm có sku '.$product_code.' trong kho.';
					setRedirect($link,$msg,'error');
				}
				
				$shop_code."==".$row['shop_code'];
				if($shop_code !== $row['shop_code']){
					$this->remove_xml($result_id,$file_path);
					$msg = 'Mã shop không đúng (cột Q) dòng '.$j;
					setRedirect($link,$msg,'error');
				}
				// die;
			}


			$count_ss = 0;
			for($j=2;$j<=$heightRow;$j++){
				$row = array();
				$row['code'] = trim($data[$j]['O']);
				$row['sku_nhanh'] = trim($data[$j]['Q']);
				$row['count'] = trim($data[$j]['S']);
				$row['shipping_unit_name'] = "Tiki";
				$row['tracking_code'] = trim($data[$j]['C']);
				
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
				$sku_fisrt = str_split($row['sku'], 3);
				$sku_last = str_split($row['sku'], 4);
				$row['sku_fisrt'] = $sku_fisrt[0];
				$row['sku_last'] = $sku_fisrt[1];
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
					$row3['count'] = (float)$check_count-> count + 1;
					$row3['total_price'] = (float)$check_count-> total_price + (float)$produt->price;
					$update_id = $this ->_update($row3,'fs_order_uploads_detail','id = '. $check_count->id);
					if($update_id){
						$this->plus_quantity_product($row['warehouse_id'],$row['product_id'],1);
					}
					return $update_id;
				}else{
					
					$row['total_price'] = (float)$produt->price * (float)$row['count'];
					$add_id = $this->_add($row,'fs_order_uploads_detail');
					if($add_id){
						$this->plus_quantity_product($row['warehouse_id'],$row['product_id'],(float)$row['count']);
					}
					return $add_id;
				}
			}else{
				$row['total_price'] = (float)$produt->price * (float)$row['count'];
				$add_id = $this->_add($row,'fs_order_uploads_detail');
				if($add_id){
					$this->plus_quantity_product($row['warehouse_id'],$row['product_id'],(float)$row['count']);
				}
				return $add_id;
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
				$link = FSRoute::_('index.php?module=order&view=upload&task=edit&id='.$id);
				// không cho thay đổi nếu đơn này đã đươc IN
				$data = $this->get_record('id = '.$id,'fs_order_uploads');
				if($data-> is_print == 1){
					$msg = 'Đơn này đã được chuyển sang trạng thái in nên không thể thay đổi các thông tin.';
					setRedirect($link,$msg,'error');
					return false;
				}
			}else{
				$link = FSRoute::_('index.php?module=order&view=upload&task=add');
			}


			$fsFile = FSFactory::getClass('FsFiles');
			$cyear = date ( 'Y' );
			$cmonth = date ( 'm' );
			$cday = date ( 'd' );
			$path = PATH_BASE.'files/orders/'.$cyear.'/'.$cmonth.'/'.$cday.'/';
			$path = str_replace('/', DS,$path);

			// file pdf
	      	$file_pdf = $_FILES["file_pdf"]["name"];
	      	
	      	// var_dump($file_pdf);
			if(!empty($file_pdf[0])){
				$file_pdf_name = $fsFile -> upload_file_multiple("file_pdf", $path ,100000000, '_'.time());
				if(!$file_pdf_name){
					return false;
				}
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
				$msg = 'Bạn phải nhập đầy đủ thông tin.';
				setRedirect($link,$msg,'error');
				return false;
			}

			if($shop_id){
				$shop = $this->get_record('id = '.$shop_id,'fs_shops');
				$row['shop_code'] = $shop->code;
				$row['shop_name'] = $shop->name;
			}


			$result_id = parent::save ($row);

			if($result_id && $file_xlsx && $file_xlsx_name){

				// xóa hết các item của file cũ đi
				$this->delete_item_update_amount_hold($result_id);


				$file_path = PATH_BASE.$row['file_xlsx'];
				$file_path = str_replace('/', DS,$file_path);
				//lưu vào lấy thông số tạm giữ ở kho
				if($platform_id == 1){
					$add = $this->upload_excel_lazada($file_path,$result_id,$shop->code);
				}elseif($platform_id == 2){
					$add = $this->upload_excel_shopee($file_path,$result_id,$shop->code);
				}elseif($platform_id == 3){
					$add = $this->upload_excel_tiki($file_path,$result_id,$shop->code);
				}elseif($platform_id == 4){
					$add = $this->upload_excel_viettel($file_path,$result_id,$shop->code);
				}

			}
			return $result_id;
		}

		//xóa các item đồng thời update lại tạm giữ ở kho
		function delete_item_update_amount_hold($id){
			//kiểm tra xem có item không
			$list = $this->get_records('record_id = '.$id,'fs_order_uploads_detail');
			if(!empty($list)){
				$sql = " DELETE FROM fs_order_uploads_detail 
				WHERE record_id = ".$id;
				global $db;
				$rows = $db->affected_rows($sql);
				if($rows){
					foreach($list as $item){
						$get_amount = $this->get_record('warehouses_id = '.$item->warehouse_id . ' AND product_id = ' .$item->product_id,'fs_warehouses_products');
						if(!empty($get_amount)){
							$row = array();
							$row['amount_hold'] = (float)$get_amount-> amount_hold - (float)$item-> count;
							$this->_update($row,'fs_warehouses_products','id = '.$get_amount-> id);
						}
					}
				}
			}
		}

		//tăng số lượng tạm giữ lên
		function plus_quantity_product($warehouse_id,$product_id,$count = 1){
			$data = $this->get_record('warehouses_id = ' . $warehouse_id . ' AND product_id = '. $product_id,'fs_warehouses_products');
			if(!empty($data)){
				$row = array();
				$row['amount_hold'] = (float)$data->amount_hold + (float)$count;
				$this->_update($row,'fs_warehouses_products','id = '.$data->id);
			}else{
				$row = array();
				$row['amount_hold'] = $count;
				$row['product_id'] = (float)$product_id;
				$row['warehouses_id'] = (float)$warehouse_id;
				$this->_add($row,'fs_warehouses_products');
			}
		}

		function split_page_pdf($file_path_pdf,$id){
			
			global $db;
			if(!$file_path_pdf){
				return false;
			}
			$i=0;
			$arr_name = explode(',',$file_path_pdf);
			if(!empty($arr_name)){
				foreach($arr_name as $name_item) {
					$base_name = basename($name_item);
					if($i == 0){
						$path = str_replace($base_name,'',$name_item);
					}
					$file_path_pdf_item = PATH_BASE.$path.$base_name;
			        $pdf_check = new \setasign\Fpdi\Fpdi();
			        $count_page = $pdf_check->setSourceFile($file_path_pdf_item);
			      	for ($k = 1; $k <= $count_page; $k++) {
			            $file_path_pdf_item = PATH_BASE.$path.$base_name;
			            $pdf = new \setasign\Fpdi\Fpdi();
			            $pageCount = $pdf->setSourceFile($file_path_pdf_item);
			            $pageFrom = $k;
			            $pageTo   = $k;
			            $existCounter = 0;
			            for ($i = $pageFrom; $i <= $pageTo; $i++) 
			            {   
			                $tpl  = $pdf->importPage($i);
			                $pdf->getTemplateSize($tpl);
			                $pdf->addPage();

			                $pdf->useTemplate($tpl,['adjustPa geSize' => true]);
			                $existCounter++;    
			            }
			            $split_filename = PATH_BASE.$path.basename($file_path_pdf_item, '.pdf').'_page'.$k.'.pdf';
			            $pdf->Output($split_filename, "F");

			            $row = array(); // lưu từng page lại
			            $row['file_pdf'] = $path.basename($file_path_pdf_item,'.pdf').'_page'.$k.'.pdf';
			            $row['record_id'] = $id;

			            $check_add_item_page_id = $this->get_record('file_pdf = "'.$row['file_pdf'].'" AND record_id = '.$id,'fs_order_uploads_page_pdf');
			            if(!empty($check_add_item_page_id)){
			            	$this->_update($row,'fs_order_uploads_page_pdf','id = '.$check_add_item_page_id->id);
			            	$add_item_page_id = $check_add_item_page_id->id;
			            }else{
			            	$add_item_page_id = $this->_add($row,'fs_order_uploads_page_pdf');
			            }
			            

			            if($add_item_page_id){
			            	//xử lý tách lấy nội dung của page
			            	$this->pdf_to_html($add_item_page_id,$row['file_pdf'],$path);
			            }

			        }
					$i++;
				}
			}
			return $i;
		}

		function pdf_to_html($id,$file_pdf,$path){
			//chú ý ko đc xóa file pdftohtml.exe ở thư mục ngoài cùng cạnh index.php trong admin
			$source_pdf = PATH_BASE.$file_pdf;
			$source_pdf = str_replace('/', DS,$source_pdf);
			$output_folder = PATH_BASE.$path;
			$output_folder = str_replace('/', DS,$output_folder);
			// echo $output_folder.basename($file_pdf);
			// die;

		    if (!file_exists($output_folder)) { mkdir($output_folder, 0777, true);}
			$a = passthru("pdftohtml $source_pdf $output_folder".basename($file_pdf),$b);
			$name_html = str_replace('.pdf','.pdfs.html',basename($file_pdf));
			//đọc file để lấy text update
			$myfile = fopen($output_folder.$name_html, "r") or die("Unable to open file!");

			$text = fread($myfile,filesize($output_folder.basename($file_pdf)));
			$text = utf8_encode($text);
			$text = strip_tags($text);
			$text = trim($text);
			$row = array();
			$row['content'] = $text;
			// echo  utf8_encode($text);
			$this->_update($row,'fs_order_uploads_page_pdf','id ='.$id);
			fclose($myfile);
			// var_dump($a);
			// die;
		}
		
		function prints($value)
		{

			global $db;
			
			
			$ids = FSInput::get('id',array(),'array');
			
			if(!empty($ids))
			{
				$str_ids = implode(',',$ids);
				$list = $this->get_records('id IN ('.$str_ids.')','fs_order_uploads');
				
			
				foreach ($list as $item){
					// xứ lý chém page nhỏ của mỗi file
					$count_split = $this->split_page_pdf($item-> file_pdf,$item-> id);

					//xử lí tìm nội dung pdf có tracking_code là gì
					$list_detail = $this->get_records('record_id = '.$item->id,'fs_order_uploads_detail','DISTINCT tracking_code','sku_fisrt ASC,ABS(sku_fisrt),color ASC,ABS(color),size ASC,ABS(size)');
					// printr($list_detail);
					
					if(!empty($list_detail)){
						//$stt = 0;
						foreach ($list_detail as $it_detail) {
							$check_tracking_code = $this->get_record('content like "%'.$it_detail-> tracking_code.'%" AND record_id = '.$item->id,'fs_order_uploads_page_pdf');
							if(!empty($check_tracking_code)){
								$row_3 = array();
								$row_3['tracking_code'] = $it_detail-> tracking_code;
								// $row_3['ordering'] = $stt;
								$this->_update($row_3,'fs_order_uploads_page_pdf','id = '.$check_tracking_code-> id);
								//$stt++;
							}
							
						}
					}
				}

				
				//tìm số thứ tự in
				$list_detail_soft = $this->get_records('record_id IN ('.$str_ids.')','fs_order_uploads_detail','DISTINCT tracking_code','sku_fisrt ASC,ABS(sku_fisrt),color ASC,ABS(color),size ASC,ABS(size)');

				$stt = 0;
				foreach ($list_detail_soft as $it_detail_soft){
					$row_4 = array();
					$row_4['ordering'] = $stt;
					$this->_update($row_4,'fs_order_uploads_page_pdf','tracking_code = "'.$it_detail_soft-> tracking_code.'"');
				}

				//ghép file pdf


				$i = 0;
				$j = 1;
				$name_pdf = "";
				$get_list_page_pdf = $this->get_records('record_id IN ('.$str_ids.')','fs_order_uploads_page_pdf','id,file_pdf,record_id','ordering ASC');

				$pdf = new PDFMerger;

				foreach ($get_list_page_pdf as $item_page_pdf){
					$file_path_pdf = PATH_BASE.$item_page_pdf-> file_pdf;
					$file_path_pdf = str_replace('/', DS,$file_path_pdf);

					$pdf->addPDF($file_path_pdf, 'all');
					if($j==1){
						$basename_1 = basename($item_page_pdf-> file_pdf);
						$path_pdf_merge_soft = str_replace($basename_1,'',$item_page_pdf-> file_pdf);
						$path_pdf_merge = PATH_BASE.$path_pdf_merge_soft;
						$path_pdf_merge = str_replace('/', DS,$path_pdf_merge);
					}

					// if($j == count($list)){
					// 	$name_pdf .= $item_page_pdf->id;
					// }else{
						$name_pdf .= $item_page_pdf->id . '_';
					//}
					$j++;

					$row = array();
					$row['is_print'] = 1;
					$row_update = $this->_update($row,'fs_order_uploads','id = ' . $item_page_pdf-> record_id);
					if($row_update){
						$this->_update($row,'fs_order_uploads_detail','record_id = ' . $item_page_pdf-> record_id);
					}
					$i++;
				}

				$name_pdf = substr($name_pdf,0,-1);
				
				$pdf->merge('file',$path_pdf_merge.$name_pdf.'.pdf');

				//lưu lại lịch sử in
				$row2 = array();
				$row2['total_file'] = count($get_list_page_pdf);
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