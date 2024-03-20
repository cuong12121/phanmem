<?php 
class WarehousesModelsBill_buy extends FSModels
{
	var $limit;
	var $prefix ;
	function __construct()
	{
		$this -> limit = 20;
		$this -> view = 'bill';
		// $this->table_category_name = 'fs_warehouses_categories';

		$this -> table_name = 'fs_warehouses_bill_buy';
		$this -> table_name_detail = 'fs_warehouses_bill_buy_detail';
			// config for save
		$this -> arr_img_paths = array(array('resized2',150,150,'cut_image'),array('resized',300,300,'cut_image'),array('large',400,400,'cut_image'),array('compress',1,1,'compress'));
		$this -> img_folder = 'images/warehouses';

		$this-> path_excel =  PATH_BASE.LINK_AMIN.DS.'import'.DS.'excel'.DS.'bill_buy'.DS;
		$this-> path_excel_name =  LINK_AMIN.'/import/excel/bill_buy/';

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
				$where .= ' AND a.type_import =  "' . $filter . '" ';
			}
		}

						// estore
		if (isset ( $_SESSION [$this->prefix . 'filter2'] )) {
			$filter = $_SESSION [$this->prefix . 'filter2'];
			if ($filter) {
				$where .= ' AND a.status =  "' . $filter . '" ';
			}
		}

								// estore
		if (isset ( $_SESSION [$this->prefix . 'filter3'] )) {
			$filter = $_SESSION [$this->prefix . 'filter3'];
			if ($filter) {
				$where .= ' AND a.status_buy =  "' . $filter . '" ';
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

	function save($row = array(), $use_mysql_real_escape_string = 0) {
		
		$id_old = FSInput::get ('id');
		// $status = FSInput::get ('status');

		if($id_old) {
			$check_data = $this-> get_record('id = '.$id_old,$this -> table_name,'*');
			$status_last = $check_data-> status;
		}

		$warehouses_id = FSInput::get ('warehouses_id'); 
		if($warehouses_id) {
			$warehouses = $this-> get_record('id = '.$warehouses_id,'fs_warehouses','id,name');
			$row['warehouses_name'] = $warehouses-> name;
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

		// die;

		if($id) {
			if(($id && !$id_old) || @$status_last == 1) { // tạo mới hoặc sửa phiếu tạm
				if($style_import == 1) {
				// danh sách sp trong bill nhập tay
					$this -> add_products_detail($id); 
				} elseif($style_import == 2 && @$excel) {
			// danh sách sp trong bill nhập excel
					$this -> add_products_detail_excel($id,$excel); 
				}
			}

			if($status == 4) {
			// $this -> add_products_warehouses($id); // cập nhật tồn kho khi hoàn thành
			}
		}

		return $id;
	}


	function add_products_warehouses($id) {

		$bill = $this-> get_record('id = '.$id,$this-> table_name,'*');
		$list_products = $this-> get_records('bill_id = '.$id,$this -> table_name_detail,'*');

		$warehouses = $this-> get_record('id = '.$bill-> warehouses_id,'fs_warehouses','*');

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

		if(!empty($list_products)) {
			foreach ($list_products as $product) {
				$check_exist = $this-> get_record('product_id = '.$product-> product_id.' AND warehouses_id = '.$bill-> warehouses_id,'fs_warehouses_products','*');
				if(!empty($check_exist)) {

					$row = array();
					$row['amount'] = $check_exist-> amount + $product-> amount;

					$this-> _update($row,'fs_warehouses_products','id = '.$check_exist-> id);
				} else {
					$row = array();
					$row['product_id'] = $product-> product_id;
					$row['warehouses_id'] = $bill-> warehouses_id;
					$row['warehouses_name'] = $warehouses-> name;
					$row['amount'] = $product-> amount;
					$this-> _add($row,'fs_warehouses_products');
				}
			}
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

			$this-> _add($row,$this -> table_name_detail);

			$total_product ++;
			$total_amount += $amount;
			$total_weight += $weight*$amount;
			$total_price += $price*$amount;

			if($typediscount == 1) {
				$total_discount += $discount;
			} else {
				$total_discount += $discount*$price*$amount/100;
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
				$data[$i - 2][$j] = $sheet->getCellByColumnAndRow($j, $i)->getValue();;
			}
		}

		$total_amount = 0;
		$total_product = 0;
		$total_price = 0;
		$total_price_after = 0;
		$total_weight = 0;
		$total_discount = 0;

		foreach ($data as $item) {
			$row = array();
			$row['bill_id'] = $id;
			$product = $this-> get_record('code = "'.$item[0].'"','fs_products');

			if(empty($product)) continue;

			$amount = $item[1];
			$link = $item[6];
			$price = $item[2];
			$typediscount = $item[3];
			$discount = $item[4];
			$weight = $item[5];

			$row['product_id'] = $product-> id;
			$row['amount'] = $amount;
			$row['link'] = $link;
			$row['price'] = $price;
			$row['typediscount'] = $typediscount;
			$row['discount'] = $discount;
			$row['weight'] = $weight;

			$this-> _add($row,$this -> table_name_detail);

			$total_product ++;
			$total_amount += $amount;
			$total_weight += $weight*$amount;
			$total_price += $price*$amount;

			if($typediscount == 1) {
				$total_discount += $discount;
			} else {
				$total_discount += $discount*$price*$amount/100;
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