<?php 
class WarehousesModelsMovingaverage extends FSModels
{
	var $limit;
	var $prefix ;
	function __construct()
	{
		$this -> limit = 9999;
		$this -> view = 'movingaverage';
		// $this->table_category_name = 'fs_warehouses_categories';

		$this -> table_name = 'fs_products';
		$this -> table_name_detail = 'fs_warehouses_check_detail';
			// config for save
		$this -> arr_img_paths = array(array('resized2',150,150,'cut_image'),array('resized',300,300,'cut_image'),array('large',400,400,'cut_image'),array('compress',1,1,'compress'));
		$this -> img_folder = 'images/warehouses';

		$this-> path_excel =  PATH_BASE.LINK_AMIN.DS.'import'.DS.'excel'.DS.'check'.DS;
		$this-> path_excel_name =  LINK_AMIN.'/import/excel/check/';

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
			if ($sort_field) {
				// $ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
			}
		}

	

												// estore
		if (isset ( $_SESSION [$this->prefix . 'filter0'] )) {
			$filter = $_SESSION [$this->prefix . 'filter0'];
			if ($filter) {
				$where .= ' AND d.warehouse_id =  "' . $filter . '" ';
			}
		}

														// estore
		if (isset ( $_SESSION [$this->prefix . 'filter2'] )) {
			$filter = $_SESSION [$this->prefix . 'filter2'];
			if ($filter) {
				$where .= ' AND a.category_id =  "' . $filter . '" ';
			}
		}
		
		//from
		if(isset($_SESSION[$this -> prefix.'text0']))
		{
			$date_from = $_SESSION[$this -> prefix.'text0'];
			if($date_from){
				$date_from = strtotime($date_from);
				$date_new = date('Y-m-d H:i:s',$date_from);
				$where .= ' AND d.created_time >=  "'.$date_new.'" ';
			}
		}
		
	//	to
		if(isset($_SESSION[$this -> prefix.'text1']))
		{
			$date_to = $_SESSION[$this -> prefix.'text1'];
			if($date_to){
				$date_to = $date_to . ' 23:59:59';
				$date_to = strtotime($date_to);
				$date_new = date('Y-m-d H:i:s',$date_to);
				$where .= ' AND d.created_time <=  "'.$date_new.'" ';
			}
		}
		
		if (! $ordering)
			$ordering .= " ORDER BY d.created_time DESC , a.id DESC ";
		
		if (isset ( $_SESSION [$this->prefix . 'keysearch'] )) {
			if ($_SESSION [$this->prefix . 'keysearch']) {
				$keysearch = $_SESSION [$this->prefix . 'keysearch'];
				$where .= " AND ( a.id = '".$keysearch."'  OR a.name LIKE '%" . $keysearch . "%' OR a.code LIKE '%" . $keysearch . "%' )";
			}
		}

		if ((@$_SESSION[$this -> prefix.'text0'] && @$_SESSION[$this -> prefix.'text1'])) {

		} else {
			$where .= ' AND 1 = 2';
		}
		
		$query = " SELECT a.*, sum(d.count) as total,d.warehouse_id FROM 
		" . $this->table_name . " AS a 
		INNER JOIN fs_order_uploads_detail as d 
		ON a.id = d.product_id 
		WHERE 1=1 AND d.is_print = 1 AND d.is_refund = 0 AND is_seeding = 0 " . $where .' GROUP BY a.id '. $ordering . " ";
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


		$status = FSInput::get ('status');
		$style_import = FSInput::get ('style_import');

		// $file_excel = FSInput::get ('file_excel');

		// if($file_excel) {
		if($style_import == 2){
			$fsFile = FSFactory::getClass('FsFiles');
			$excel = $fsFile -> uploadExcel('file_excel', $this-> path_excel,200000000, '_'.time());
			$excel_arr = explode("/", $excel);
			$name_excel = $excel_arr[count($excel_arr) - 1];
		}

		// }

		if($style_import == 2 && @$name_excel) {
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
		if(($id && !$id_old) || @$status_last == 1) { // tạo mới hoặc sửa phiếu tạm
			if($style_import == 1) {
				// danh sách sp trong bill nhập tay
				$this -> add_products_detail($id); 
			} elseif($style_import == 2 && @$excel) {
			// danh sách sp trong bill nhập excel
				$this -> add_products_detail_excel($id,$warehouses_id,$excel); 
			}
		}

		if($status == 4) {
			if($id_old) {
				$this -> add_products_warehouses($id_old); // cập nhật tồn kho khi hoàn thành
			} else {
				$this -> add_products_warehouses($id); // cập nhật tồn kho khi hoàn thành
			}
			
		}
	}

	return $id;
}


function add_products_warehouses($id) {


	$bill = $this-> get_record('id = '.$id,$this -> table_name,'*');

	$list_products = $this-> get_records('bill_id = '.$id,$this -> table_name_detail,'*');

	$warehouses = $this-> get_record('id = '.$bill-> warehouses_id,'fs_warehouses','*');

	if(!empty($list_products)) {

		foreach ($list_products as $product) {
			$check_exist = $this-> get_record('product_id = '.$product-> product_id.' AND warehouses_id = '.$bill-> warehouses_id,'fs_warehouses_products','*');
			if(!empty($check_exist)) {

				$row = array();

				$row['amount'] = $check_exist-> amount_deliver + $product-> reality;

				$this-> _update($row,'fs_warehouses_products','id = '.$check_exist-> id);
			} else {
				$row = array();
				$row['product_id'] = $product-> product_id;
				$row['warehouses_id'] = $bill-> warehouses_id;
				$row['warehouses_name'] = $warehouses-> name;

				$row['amount'] = $product-> reality;

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

	foreach ($arr as $idp) {
		$row = array();
		$row['bill_id'] = $id;
		$row['product_id'] = $idp;

		$reality = FSInput::get('ajax_products_reality_'.$idp);
		$price = FSInput::get('ajax_products_price_'.$idp);
		$note = FSInput::get('ajax_products_note_'.$idp);
		$amount = FSInput::get('ajax_products_amount_'.$idp,0,'money');
		$amount_deliver = FSInput::get('ajax_products_amount_deliver_'.$idp);

		$row['reality'] = $reality;
		$row['price'] = $price;
		$row['note'] = $note;
		$row['amount'] = $amount;
		$row['amount_deliver'] = $amount_deliver;

		$total_product ++;
		$total_amount += $reality;

		$this-> _add($row,$this -> table_name_detail);

	}

	$row2 = array();

	$row2['total_product'] = $total_product;
	$row2['total_amount'] = $total_amount;

	$this-> _update($row2,$this -> table_name,'id = '.$id);

}

function add_products_detail_excel($id,$warehouses_id,$excel){

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

	foreach ($data as $item) {
		$row = array();
		$row['bill_id'] = $id;

		if(!$item[0]) {
			break;
		}

		$product = $this-> get_record('code = "'.$item[0].'"','fs_products','*');

		if(empty($product)) continue;

		$product_amount = $this-> get_record('product_id = "'.$product-> id.'" AND warehouses_id = '.$warehouses_id,'fs_warehouses_products','*');

		$reality = $item[1];
		$note = $item[2];

		$row['product_id'] = $product-> id;
		$row['price'] = $product-> price;
		$row['amount'] = @$product_amount-> amount;
		$row['amount_deliver'] = @$product_amount-> amount_deliver;
		$row['amount_hold'] = @$product_amount-> amount_hold;
		$row['reality'] = $reality;
		$row['note'] = $note;

		$this-> _add($row,$this -> table_name_detail);

		$total_product ++;
		$total_amount += $reality;

			// code...
	}

	$row2 = array();

	$row2['total_product'] = $total_product;
	$row2['total_amount'] = $total_amount;

	$this-> _update($row2,$this -> table_name,'id = '.$id);

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