<?php 
class WarehousesModelsBill extends FSModels
{
	var $limit;
	var $prefix ;
	function __construct()
	{
		$this -> limit = 20;
		$this -> view = 'bill';
		// $this->table_category_name = 'fs_warehouses_categories';

		$this -> table_name = 'fs_warehouses_bill';
		$this -> table_name_detail = 'fs_warehouses_bill_detail';
			// config for save
		$this -> arr_img_paths = array(array('resized2',150,150,'cut_image'),array('resized',300,300,'cut_image'),array('large',400,400,'cut_image'),array('compress',1,1,'compress'));
		$this -> img_folder = 'images/warehouses';

		$this-> path_excel =  PATH_BASE.LINK_AMIN.DS.'import'.DS.'excel'.DS.'bill'.DS;
		$this-> path_excel_name =  LINK_AMIN.'/import/excel/bill/';

		$this -> check_alias = 0;
		$this -> remove_field_img = 'file';
		parent::__construct();
	}

	function setQuery() {
		
		// ordering
		$ordering = "";
		$where = "  ";
		if (isset ( $_SESSION [$this->prefix . 'sort_field'] )) {
			$sort_field = $_SESSION [$this->prefix . 'sort_field'];
			$sort_direct = $_SESSION [$this->prefix . 'sort_direct'];
			$sort_direct = $sort_direct ? $sort_direct : 'asc';
			$ordering = '';
			if ($sort_field)
				$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
		}
		
		// estore
		if (isset ( $_SESSION [$this->prefix . 'filter0'] )) {
			$filter = $_SESSION [$this->prefix . 'filter0'];
			if ($filter) {
				$where .= ' AND a.warehouses_id =  "' . $filter . '" ';
			}
		}

				// estore
		if (isset ( $_SESSION [$this->prefix . 'filter1'] )) {
			$filter = $_SESSION [$this->prefix . 'filter1'];
			if ($filter) {
				$where .= ' AND a.type =  "' . $filter . '" ';
			}
		}

						// estore
		if (isset ( $_SESSION [$this->prefix . 'filter2'] )) {
			$filter = $_SESSION [$this->prefix . 'filter2'];
			if ($filter) {
				$where .= ' AND a.type_import =  "' . $filter . '" ';
			}
		}

								// estore
		if (isset ( $_SESSION [$this->prefix . 'filter3'] )) {
			$filter = $_SESSION [$this->prefix . 'filter3'];
			if ($filter) {
				$where .= ' AND a.status =  "' . $filter . '" ';
			}
		}

										// estore
		if (isset ( $_SESSION [$this->prefix . 'filter4'] )) {
			$filter = $_SESSION [$this->prefix . 'filter4'];
			if ($filter) {
				$where .= ' AND a.status2 =  "' . $filter . '" ';
			}
		}

					// from
		if(isset($_SESSION[$this -> prefix.'text0']))
		{
			$date_from = $_SESSION[$this -> prefix.'text0'];
			if($date_from){
				$date_from = strtotime($date_from);
				$date_new = date('Y-m-d H:i:s',$date_from);
				$where .= ' AND a.created_time >=  "'.$date_new.'" ';
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
				$where .= ' AND a.created_time <=  "'.$date_new.'" ';
			}
		}
		
		if (! $ordering)
			$ordering .= " ORDER BY created_time DESC , id DESC ";
		
		if (isset ( $_SESSION [$this->prefix . 'keysearch'] )) {
			if ($_SESSION [$this->prefix . 'keysearch']) {
				$keysearch = $_SESSION [$this->prefix . 'keysearch'];
				$where .= " AND ( id = '".$keysearch."'  OR a.name LIKE '%" . $keysearch . "%' )";
			}
		}
		
		$query = " SELECT a.*
		FROM 
		" . $this->table_name . " AS a
		WHERE 1=1 " . $where . $ordering . " ";
		return $query;
	}

	function save($row = array(), $use_mysql_real_escape_string = 1) {
		
		$id_old = FSInput::get ('id');
		// $status = FSInput::get ('status');

		// echo $id_old;

		if($id_old) {
			$check_data = $this-> get_record('id = '.$id_old,$this -> table_name,'*');
			$status_last = $check_data-> status;
			$list_products_old = $this-> get_records('bill_id = '.$id_old,$this -> table_name_detail,'*');

			// print_r($list_products_old);die;

			// $this -> remove_products_warehouses($check_data, $list_products_old); // Xóa tồn kho cũ
		}

		$warehouses_id = FSInput::get ('warehouses_id');
		if($warehouses_id) {
			$warehouses = $this-> get_record('id = '.$warehouses_id,'fs_warehouses','id,name');
			$row['warehouses_name'] = $warehouses-> name;
		}

		$to_warehouses_id = FSInput::get ('to_warehouses_id');
		if($to_warehouses_id) {
			$to_warehouses = $this-> get_record('id = '.$to_warehouses_id,'fs_warehouses','id,name');
			$row['to_warehouses_name'] = $to_warehouses-> name;
		}


		$supplier_id = FSInput::get ('supplier_id');

		if($supplier_id) {
			$supplier = $this-> get_record('id = '.$supplier_id,'fs_supplier','id,name');
			$row['supplier_name'] = $supplier-> name;
		}


		$status = FSInput::get ('status');
		$status2 = FSInput::get ('status2');
		$style_import = FSInput::get ('style_import');
		$file_excel = FSInput::get ('file_excel');

		if($style_import == 2) {
			$fsFile = FSFactory::getClass('FsFiles');
			$excel = $fsFile -> uploadExcel('file_excel', $this-> path_excel,200000000, '_'.time());
			$excel_arr = explode("/", $excel);
			$name_excel = $excel_arr[count($excel_arr) - 1];
		}



		if($style_import == 2 && @$excel) {
			$row['file'] = $this-> path_excel_name.$excel;
			$row['file_name'] = $name_excel;
			if(!empty($check_data)) {
				unlink($this-> path_excel.$check_data-> file);
			}
		}

		// echo $this-> path_excel_name.$excel;die;

		$id = parent::save ( $row );

		// echo $id;die;

		

		if($id) {
			$data_bill = $this->get_record('id = '.$id,'fs_warehouses_bill');
			$row3 = array();
			$row3['status'] = $status;
			$row3['warehouses_id'] = $data_bill-> warehouses_id;
			$row3['warehouses_name'] = $data_bill-> warehouses_name;
			$row3['created_time'] = $data_bill-> created_time;
			$row3['updated_time'] = $data_bill-> updated_time;
			$row3['to_warehouses_id'] = $data_bill-> to_warehouses_id;
			$row3['to_warehouses_name'] = $data_bill-> to_warehouses_name;
			$row3['type'] = $data_bill-> type;
			$row3['type_import'] = $data_bill-> type_import;
			$row3['supplier_id'] = $data_bill-> supplier_id;
			$row3['supplier_name'] = $data_bill-> supplier_name;
			$row3['note'] = $data_bill-> note;
			$row3['action_username'] = $data_bill-> action_username;
			$row3['action_userid'] = $data_bill-> action_userid;
			$row3['create_username'] = $data_bill-> create_username;
			$row3['style_import'] = $data_bill-> style_import;
			$this->_update($row3,'fs_warehouses_bill_detail','bill_id = '.$id);


			if($style_import == 1) {
				// danh sách sp trong bill nhập tay
				$this -> add_products_detail($id); 
			} elseif($style_import == 2 && @$excel) {
			// danh sách sp trong bill nhập excel
				$this -> add_products_detail_excel($id,$excel); 
			}
			// echo $status;die;

			if($status == 4) {
			$this -> add_products_warehouses($id); // cập nhật tồn kho mới

			}
	}

	return $id;
}

function add_products_warehouses($id) {

	$bill = $this-> get_record('id = '.$id,$this-> table_name,'*');
	// echo $bill -> id;
	$list_products = $this-> get_records('bill_id = '.$id,$this -> table_name_detail,'*');
	$warehouses = $this-> get_record('id = '.$bill-> warehouses_id,'fs_warehouses','*');

	// trừ tồn
	if($bill-> type == 1 || $bill-> type == 2) {
		if(!empty($list_products)){


			foreach ($list_products as $product) {
				$check_exist = $this-> get_record('product_id = '.$product-> product_id.' AND warehouses_id = '.$bill-> warehouses_id,'fs_warehouses_products','*');

				if(!empty($check_exist)) {
					$row = array();
					if($bill-> type == 1) {
						$row['amount'] = $check_exist-> amount + $product-> amount;
						
					}else{
						
						$row['amount'] = $check_exist-> amount - $product-> amount;
						if($check_exist-> amount_hold > $product-> amount){
							$row['amount_hold'] = $check_exist-> amount_hold - $product-> amount;
						}else{
							$row['amount_hold'] = 0;
						}
					}
					// echo $row['amount'];
					// die;
					$l = $this-> _update($row,'fs_warehouses_products','id = '.$check_exist-> id);
					
				} else {

					$row = array();
					$row['product_id'] = $product-> product_id;
					$row['warehouses_id'] = $bill-> warehouses_id;
					$row['warehouses_name'] = $warehouses-> name;

					if($bill-> type == 1) {
						$row['amount'] = $product-> amount;
					} elseif($bill-> type == 2) {
						$row['amount'] = 0 - $product-> amount;
					}
				
					$this-> _add($row,'fs_warehouses_products');
				}
			}
			$this->add_history_detail_bill($bill->id);
		}
	}

	if($bill-> type == 1) { 
		// cập nhật giá vốn
		if(!empty($list_products)) {
			foreach ($list_products as $product) {
				$p = $this-> get_record('id = '.$product-> product_id,'fs_products','*');
				$p_total_amount = $this-> get_record('product_id = '.$p-> id,'fs_warehouses_products','sum(amount) as p_total_amount') -> p_total_amount;

				if(!$p-> price_avg) {
					$p-> price_avg = $p-> price;
				}

				$price_bill = $product-> price;
				if($product-> typediscount == 1) {
					$price_bill = $price_bill - $product-> discount;
				} else {
					$price_bill = $price_bill * (1-$product-> discount/100);
				}

				// echo $price_bill; die;

				$price_avg_new = ($p-> price_avg * $p_total_amount + $product-> amount*$price_bill) / ($p_total_amount + $product-> amount);

				// echo $price_avg_new;die;

				$row_avg = array();
				$row_avg['price_avg_old'] = $p-> price_avg;
				$row_avg['price_avg'] = (int)$price_avg_new;

				// print_r($row_avg);die;

				$this-> _update($row_avg,'fs_products','id = '.$product-> product_id);
			}
		}
	}
}



function remove_products_warehouses($check_data, $list_products_old){

	$bill = $check_data;
	$list_products = $list_products_old;

	$warehouses = $this-> get_record('id = '.$bill-> warehouses_id,'fs_warehouses','*');

	if(!empty($list_products)) {
		foreach ($list_products as $product) {
			$check_exist = $this-> get_record('product_id = '.$product-> product_id.' AND warehouses_id = '.$bill-> warehouses_id,'fs_warehouses_products','*');
			if(!empty($check_exist)) {

				$row = array();

				if($bill-> type == 1) {
					$row['amount'] = $check_exist-> amount - $product-> amount;
				} else {
					$row['amount'] = $check_exist-> amount + $product-> amount;
				}
				$this-> _update($row,'fs_warehouses_products','id = '.$check_exist-> id);
			} else {
				$row = array();
				$row['product_id'] = $product-> product_id;
				$row['warehouses_id'] = $bill-> warehouses_id;
				$row['warehouses_name'] = $warehouses-> name;

				if($bill-> type == 1) {
					$row['amount'] = 0 - $product-> amount;
				} elseif($bill-> type == 2) {
					$row['amount'] = 0 + $product-> amount;
				}
				$this-> _add($row,'fs_warehouses_products');
			}
		}
	}
}


function add_history_detail_bill($bill_id){
	// cứ hoàn thành thì lưu lại lịch sử
	//lấy ra item
	$list_products = $this -> get_records('bill_id = '.$bill_id,$this -> table_name_detail,'DISTINCT product_id');
	foreach ($list_products as $product_id_item) {
		$list_detail = $this -> get_records('product_id = '.$product_id_item-> product_id.' AND bill_id = '.$bill_id,$this -> table_name_detail,'*','id ASC');
		$ton = -100000000;
		foreach($list_detail as $item_detail) {
			$row_10 = array();
			$row_10['bill_detail_id'] = $item_detail-> id;
			$row_10['bill_id'] = $item_detail-> bill_id;
			$row_10['created_time'] = $item_detail-> created_time;
			$row_10['product_id']   = $item_detail-> product_id;
			$row_10['product_code'] = $item_detail-> product_code;
			$row_10['product_name'] = $item_detail-> product_name;

			$row_10['warehouses_id'] = $item_detail-> warehouses_id;
			$row_10['warehouses_name'] = $item_detail-> warehouses_name;

			$row_10['type'] = $item_detail-> type;
			$row_10['amount'] = $item_detail-> amount;
			$row_10['price'] = $item_detail-> price;
			$row_10['tong_tien'] = $item_detail-> price * $item_detail-> amount;
			$row_10['note'] = $item_detail-> note;
			$row_10['status'] = $item_detail-> status;

			$row_10['time_add'] = date('Y-m-d H:i:s');

			//tồn thực tế hiện tại
			
			$amount_product = $this-> get_record('product_id = '.$item_detail-> product_id.' AND warehouses_id = '.$item_detail-> warehouses_id,'fs_warehouses_products','amount');


			if($item_detail-> type == 1){
				$row_10['type_action_name'] = "Phiếu nhập";
				if($ton == -100000000){
					// tính toán đã cộng bao nhiêu trc đó.
					$plus = 0;
					foreach($list_detail as $item_detail_plus){
						$plus += $item_detail_plus-> amount ;
					}

					$ton_luc_dau = $amount_product->amount - $plus;

					$ton = $ton_luc_dau + $item_detail-> amount;
				}else{
					$ton = $ton + $item_detail-> amount;
				}	

			}elseif($item_detail-> type == 2){
				
				$row_10['type_action_name'] = "Phiếu xuất";
				if($ton == -100000000){
					// tính toán đã trừ bao nhiêu trc đó.
					$minus = 0;
					foreach($list_detail as $item_detail_minus){
						$minus += $item_detail_minus-> amount ;
					}
					$ton_luc_dau = $amount_product->amount + $minus;
					$ton = $ton_luc_dau - $item_detail-> amount;
				}else{
					$ton = $ton - $item_detail-> amount;
				}
			}

			$row_10['ton'] = $ton;
			$rs_add = $this-> _add($row_10,'fs_warehouses_bill_detail_history',1);
			if($rs_add){
				$row_11 = array();
				$row_11['ton'] =  $row_10['ton'];
				$this-> _update($row_11,'fs_warehouses_bill_detail','id = '.$row_10['bill_detail_id']);
			}
		}
		//end lưu lịch sử
	}
}

function add_products_detail($id){

	$this-> _remove('bill_id ='.$id,$this -> table_name_detail);

	$arr = FSInput::get ( 'ajax_products', array (), 'array' );
	$total_amount = 0;
	$total_product = 0;
	$total_price = 0;
	$total_price_after = 0;
	$total_weight = 0;
	$total_discount = 0;

	$data_bill = $this->get_record('id = '.$id,$this-> table_name);

	foreach ($arr as $idp) {
		$row = array();
		$row['bill_id'] = $id;
		$row['product_id'] = $idp;
		$amount = FSInput::get('ajax_products_amount_'.$idp);
		$price = FSInput::get('ajax_products_price_'.$idp,0,'money');
		$typediscount = FSInput::get('ajax_products_typediscount_'.$idp);
		$discount = FSInput::get('ajax_products_discount_'.$idp,0,'money');
		$weight = FSInput::get('ajax_products_weight_'.$idp);
		$link = FSInput::get('ajax_products_link_'.$idp);

		$row['amount'] = $amount;
		$row['link'] = $link;
		$row['price'] = $price;
		$row['typediscount'] = $typediscount;
		$row['discount'] = $discount;
		$row['weight'] = $weight;


		$row['warehouses_id'] = $data_bill-> warehouses_id;
		$row['warehouses_name'] = $data_bill-> warehouses_name;
		$row['created_time'] = $data_bill-> created_time;
		$row['updated_time'] = $data_bill-> updated_time;
		$row['to_warehouses_id'] = $data_bill-> to_warehouses_id;
		$row['to_warehouses_name'] = $data_bill-> to_warehouses_name;
		$row['type'] = $data_bill-> type;
		$row['type_import'] = $data_bill-> type_import;
		$row['supplier_id'] = $data_bill-> supplier_id;
		$row['supplier_name'] = $data_bill-> supplier_name;
		$row['note'] = $data_bill-> note;
		$row['action_username'] = $data_bill-> action_username;
		$row['action_userid'] = $data_bill-> action_userid;
		$row['create_username'] = $data_bill-> create_username;
		$row['style_import'] = $data_bill-> style_import;
		$row['status'] = $data_bill-> status;
		$row['file'] = $data_bill-> file;
		$row['file_name'] = $data_bill-> file_name;

		$product = $this->get_record('id = '.$row['product_id'],'fs_products','code,name');
		if(!empty($product)){
			$row['product_code'] = $product-> code;
			$row['product_name'] = $product-> name;
		}
		

		$this-> _add($row,$this -> table_name_detail);

		$total_product ++;
		$total_amount += intval($amount);
		$total_weight += intval($weight)*intval($amount);
		$total_price += intval($price)*intval($amount);

		if($typediscount == 1) {
			$total_discount += intval($discount);
		} else {
			$total_discount += intval($discount)*intval($price)*intval($amount)/100;
		}

	}

	$total_price_after = $total_price - $total_discount;
	$row2 = array();

	$discount = FSInput::get('discount');
	$discount_type = FSInput::get('discount_type');
	$typevat = FSInput::get('typevat');
	$vat = FSInput::get('vat');

	if($discount_type == 1) {
		$discount = $discount;
	} else {
		$discount = $total_price_after*$discount/100;
	}

	if($typevat == 1) {
		$vat = $vat;
	} else {
		$vat = $total_price_after*$vat/100;
	}

	$row2['vat_bill'] = $vat;
	$row2['discount_bill'] = $discount;
	$row2['total_pay'] = $total_price_after - $discount + $vat;

	$row2['total_product'] = $total_product;
	$row2['total_amount'] = $total_amount;
	$row2['total_price'] = $total_price;
	$row2['total_discount'] = $total_discount;
	$row2['total_weight'] = $total_weight;
	$row2['total_price_after'] = $total_price_after;

	$this-> _update($row2,$this-> table_name,'id = '.$id);

}

function add_products_detail_excel($id,$excel){

	$this-> _remove('bill_id ='.$id,$this -> table_name_detail);

	if(!$excel) return;

	$fsstring = FSFactory::getClass('FSString','','../');
		// require_once 'Classes/PHPExcel.php';
	require_once("../libraries/excel/PHPExcel/Classes_new/PHPExcel.php");
		// echo $path.$excel;
		// die;
		//Đường dẫn file
	$file = $this-> path_excel.$excel;
		//Tiến hành xác thực file
	$objFile = PHPExcel_IOFactory::identify($file);
	$objData = PHPExcel_IOFactory::createReader($objFile);

		//Chỉ đọc dữ liệu
	$objData->setReadDataOnly(true);

		// Load dữ liệu sang dạng đối tượng
	$objPHPExcel = $objData->load($file);

		//Lấy ra số trang sử dụng phương thức getSheetCount();
		// Lấy Ra tên trang sử dụng getSheetNames();

		//Chọn trang cần truy xuất
	$sheet = $objPHPExcel->setActiveSheetIndex(0);

		//Lấy ra số dòng cuối cùng
	$Totalrow = $sheet->getHighestRow();
		//Lấy ra tên cột cuối cùng
	$LastColumn = $sheet->getHighestColumn();

		//Chuyển đổi tên cột đó về vị trí thứ, VD: C là 3,D là 4
	$TotalCol = PHPExcel_Cell::columnIndexFromString($LastColumn);

				//Tạo mảng chứa dữ liệu
	$data = array();

	

				//----Lặp dòng, Vì dòng đầu là tiêu đề cột nên chúng ta sẽ lặp giá trị từ dòng 2
	for ($i = 2; $i <= $Totalrow; $i++) {
		    //----Lặp cột
		for ($j = 0; $j < $TotalCol; $j++) {
		        // Tiến hành lấy giá trị của từng ô đổ vào mảng
			$data[$i - 2][$j] = $sheet->getCellByColumnAndRow($j, $i)->getCalculatedValue();
		}
	}

	$total_amount = 0;
	$total_product = 0;
	$total_price = 0;
	$total_price_after = 0;
	$total_weight = 0;
	$total_discount = 0;
	$data_bill = $this->get_record('id = '.$id,$this-> table_name);

	$link = FSRoute::_('index.php?module='.$this -> module.'&view='.$this -> view.'&task=edit&id='.$id);
	foreach ($data as $item) {
		$product = $this-> get_record('code = "'.$item[0].'"','fs_products');
		if(empty($product)){
			setRedirect($link,'Mã sản phẩm ' .$item[0]. ' không tồn tại, vui lòng kiểm tra lại !.','error');	
		}
	}



	foreach ($data as $item) {
		$row = array();
		$row['bill_id'] = $id;
		$product = $this-> get_record('code = "'.$item[0].'"','fs_products');
		if(empty($product)) continue;

		$amount = @$item[1];
		$link = @$item[6];
		$price = @$item[2];
		$typediscount = @$item[3];
		$discount = @$item[4];
		$weight = @$item[5];

		$row['product_id'] = $product-> id;
		$row['amount'] = $amount;
		$row['link'] = $link;
		$row['price'] = $price;
		$row['typediscount'] = $typediscount;
		$row['discount'] = $discount;
		$row['weight'] = $weight;


		$row['warehouses_id'] = $data_bill-> warehouses_id;
		$row['warehouses_name'] = $data_bill-> warehouses_name;
		$row['created_time'] = $data_bill-> created_time;
		$row['updated_time'] = $data_bill-> updated_time;
		$row['to_warehouses_id'] = $data_bill-> to_warehouses_id;
		$row['to_warehouses_name'] = $data_bill-> to_warehouses_name;
		$row['type'] = $data_bill-> type;
		$row['type_import'] = $data_bill-> type_import;
		$row['supplier_id'] = $data_bill-> supplier_id;
		$row['supplier_name'] = $data_bill-> supplier_name;
		$row['note'] = $data_bill-> note;
		$row['action_username'] = $data_bill-> action_username;
		$row['action_userid'] = $data_bill-> action_userid;
		$row['create_username'] = $data_bill-> create_username;
		$row['style_import'] = $data_bill-> style_import;
		$row['status'] = $data_bill-> status;
		$row['file'] = $data_bill-> file;
		$row['file_name'] = $data_bill-> file_name;

		$product = $this->get_record('id = '.$row['product_id'],'fs_products','code,name');
		if(!empty($product)){
			$row['product_code'] = $product-> code;
			$row['product_name'] = $product-> name;
		}

		$this-> _add($row,$this -> table_name_detail);

		$total_product ++;
		$total_amount += $amount;
		$total_weight += $weight*$amount;

		$prices = !empty($price)?intval($price)*intval($amount):0;
		$total_price += $prices;

		if($typediscount == 1) {
			$discountss = !empty($discount)?intval($discount):0;
			$total_discount += $discountss;
		} else {

			$discountss = !empty($price)&&!empty($amount)&&!empty($discount)?intval($discount)*intval($price)*intval($amount)/100:0;
			$total_discount += $discountss;
		}

			// code...
	}
	$total_price_after = $total_price - $total_discount;
	$row2 = array();

	$row2['total_product'] = $total_product;
	$row2['total_amount'] = $total_amount;
	$row2['total_price'] = $total_price;
	$row2['total_discount'] = $total_discount;
	$row2['total_weight'] = $total_weight;
	$row2['total_price_after'] = $total_price_after;

	$this-> _update($row2,$this-> table_name,'id = '.$id);

}

// function remove(){

// 	$cids = FSInput::get('id',array(),'array'); 

// 	foreach ($cids as $id) {
// 		$check_data = $this-> get_record('id = '.$id,$this -> table_name,'*');
// 			// $status_last = $check_data-> status;
// 		$list_products_old = $this-> get_records('bill_id = '.$id,$this -> table_name_detail,'*');
// 			// print_r($list_products_old);die;
// 			$this -> remove_products_warehouses($check_data, $list_products_old); // Xóa tồn kho cũ			
// 		}

// 		return parent::remove ();

// }


	function get_categories()
	{
		global $db;
		$query = " SELECT a.*
		FROM 
		fs_strengths_categories AS a
		ORDER BY ordering ";
		$sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
	}
	function get_data()
	{
		global $db;
		$query = $this->setQuery();
		if(!$query)
			return array();

		$sql = $db->query_limit($query,$this->limit,$this->page);
		$result = $db->getObjectList();

		return $result;
	}
	function get_categories_tree() {
		global $db;
		$query = " SELECT a.*
		FROM 
		" . $this->table_category_name . " AS a
		ORDER BY ordering ";
		$result = $db->getObjectList ( $query );
		$tree = FSFactory::getClass ( 'tree', 'tree/' );
		$list = $tree->indentRows2 ( $result );
		return $list;
	}
	function get_strengths_categories_tree() {
		global $db;
		$sql = " SELECT id, name, parent_id AS parent_id 
		FROM fs_strengths_categories
		ORDER BY ordering ASC ";
		$categories = $db->getObjectList ( $sql );
		$tree = FSFactory::getClass ( 'tree', 'tree/' );
		$rs = $tree->indentRows ( $categories, 1 );
		return $rs;
	}


	function get_categories_product_tree()
	{
		global $db;
		$query = " SELECT a.*
		FROM fs_products_categories AS a
		ORDER BY ordering ";
		$sql = $db->query($query);
		$result = $db->getObjectList();
		$tree  = FSFactory::getClass('tree','tree/');
		$list = $tree -> indentRows2($result);
		return $list;
	}
	function get_categories_filter() {
		global $db;
		$sql = " SELECT id, name, parent_id AS parent_id 
		FROM fs_products_categories WHERE parent_id = 0";
		$db->query ( $sql );
		$categories = $db->getObjectList();

			// $tree = FSFactory::getClass ( 'tree', 'tree/' );
			// $rs = $tree->indentRows ( $categories, 1 );
		return $categories;
	}



	function ajax_get_manufactory_related() {
			// $news_id = FSInput::get ( 'product_id', 0, 'int' );
			// $category_id = FSInput::get ( 'category_id', 0, 'int' );
		$keyword = FSInput::get ( 'keyword' );
		$where = ' WHERE published = 1 ';
			// if ($category_id) {
			// 	$where .= ' AND (category_id_wrapper LIKE "%,' . $category_id . ',%"	) ';
			// }
		$where .= " AND ( name LIKE '%" . $keyword . "%' OR alias LIKE '%" . $keyword . "%' )";

		$query_body = ' FROM '.FSTable_ad::_('fs_manufactories').' ' . $where;
		$ordering = " ORDER BY created_time DESC , id DESC ";
		$query = ' SELECT id,name ' . $query_body . $ordering . ' LIMIT 40 ';
		global $db;
		$result = $db->getObjectList ( $query );
		return $result;
	}




	function get_manufactory_related($manufactory_related) {
		if (! $manufactory_related)
			return;
		$query = " SELECT id, name 
		FROM ".FSTable_ad::_('fs_manufactories')."
		WHERE id IN (0" . $manufactory_related . "0) 
		ORDER BY POSITION(','+id+',' IN '0" . $manufactory_related . "0')
		";
		global $db;
		$result = $db->getObjectList ( $query );
		return $result;
	}



}

?>