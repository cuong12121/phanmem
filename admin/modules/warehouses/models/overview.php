<?php 
class WarehousesModelsOverview extends FSModels
{
	var $limit;
	var $prefix ;
	function __construct()
	{
		$this -> limit = 999999999;
		$this -> view = 'overview';
		$this->table_category_name = 'fs_order_uploads_detail';

		$this -> table_name = 'fs_order_uploads_detail';
			// config for save
		$this -> arr_img_paths = array(array('resized2',150,150,'cut_image'),array('resized',300,300,'cut_image'),array('large',400,400,'cut_image'),array('compress',1,1,'compress'));
		$this -> img_folder = 'images/overview';
		$this -> check_alias = 0;
		$this -> field_img = 'image';
		parent::__construct();
	}

	function get_list_month($filter_time){

		$where = " ";
		if (isset ( $_SESSION [$this->prefix . 'filter1'] )) {
			$filter = $_SESSION [$this->prefix . 'filter1'];
			if ($filter) {
				$where .= ' AND a.warehouse_id like  "%' . $filter . '%" ';
			}
		}

		$date_today = date('Y-m-d');
		$date_now = getdate();

		switch ($date_now['weekday']) {
			case 'Monday':
			$date_now['thu']=2;
			break;
			case 'Tuesday':
			$date_now['thu']=3;
			break;
			case 'Wednesday':
			$date_now['thu']=4;
			break;
			case 'Thursday':
			$date_now['thu']=5;
			break;
			case 'Friday':
			$date_now['thu']=6;
			break;
			case 'Saturday':
			$date_now['thu']=7;
			break;
			case 'Sunday':
			$date_now['thu']=8;
			break;
			default:
				# code...
			break;
		}

		$arr_time_start = array( 0 => $date_today , 1 => date('Y-m-d', strtotime('today - 1 days')) , 2 => date('Y-m-d', strtotime('today - '.($date_now['thu'] - 2).' days')) , 
			3 => date('Y-m-d', strtotime('today - '.($date_now['thu']-9).' days')), 4 => date('Y-m-01') , 5=> date("Y-m-d", strtotime("first day of previous month"))
		);

		$arr_time_end = array( 0 => $date_today , 1 => date('Y-m-d', strtotime('today - 1 days')) , 2 => date('Y-m-d', strtotime('today - '.($date_now['thu'] - 2 + 7).' days')) , 
			3 => date('Y-m-d', strtotime('today - '.($date_now['thu']-9+7).' days')), 4 => date('Y-m-t') , 5=> date("Y-m-d", strtotime("last day of previous month")),
		);

		$where .= ' AND a.created_time >= "'.$arr_time_start[$filter_time].' 00:00:00"';
		$where .= ' AND a.created_time <= "'.$arr_time_end[$filter_time].' 23:59:59"';
		
		$query = " SELECT a.* FROM 
		" . $this->table_name . " AS a
		WHERE 1=1 " . $where  . " ";
		// return $query;

		global $db;
		$sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
	}

	function get_list_products_warehouses(){
		$ordering = "";
		$where = "  ";

		// estore
		if (isset ( $_SESSION [$this->prefix . 'filter1'] )) {
			$filter = $_SESSION [$this->prefix . 'filter1'];
			if ($filter) {
				$where .= ' AND a.warehouses_id like  "%' . $filter . '%" ';
			}
		}

		$query = " SELECT a.*
		FROM fs_warehouses_products AS a
		WHERE 1=1 " . $where . " ";
		// return $query;

		global $db;
		$sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;


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
		if (isset ( $_SESSION [$this->prefix . 'filter1'] )) {
			$filter = $_SESSION [$this->prefix . 'filter1'];
			if ($filter) {
				$where .= ' AND a.warehouse_id like  "%' . $filter . '%" ';
			}
		}
		
		// if (! $ordering)
		// 	$ordering .= " ORDER BY created_time DESC , id DESC ";
		
		// if (isset ( $_SESSION [$this->prefix . 'keysearch'] )) {
		// 	if ($_SESSION [$this->prefix . 'keysearch']) {
		// 		$keysearch = $_SESSION [$this->prefix . 'keysearch'];
		// 		$where .= " AND a.name LIKE '%" . $keysearch . "%' ";
		// 	}
		// }

		$date_today = date('Y-m-d');
		// date('Y-m-d', strtotime('today - 30 days'));

				//echo '<pre>';
		$date_now = getdate();
		//print_r($date);

		switch ($date_now['weekday']) {
			case 'Monday':
			$date_now['thu']=2;
			break;
			case 'Tuesday':
			$date_now['thu']=3;
			break;
			case 'Wednesday':
			$date_now['thu']=4;
			break;
			case 'Thursday':
			$date_now['thu']=5;
			break;
			case 'Friday':
			$date_now['thu']=6;
			break;
			case 'Saturday':
			$date_now['thu']=7;
			break;
			case 'Sunday':
			$date_now['thu']=8;
			break;
			default:
				# code...
			break;
		}

		if (isset ( $_SESSION [$this->prefix . 'filter0'] )) {
			$filter_time = $_SESSION [$this->prefix . 'filter0'];
		} else {
			$filter_time = 0;
		}


		$arr_time_start = array( 0 => $date_today , 1 => date('Y-m-d', strtotime('today - 1 days')) , 2 => date('Y-m-d', strtotime('today - '.($date_now['thu'] - 2).' days')) , 
			3 => date('Y-m-d', strtotime('today - '.($date_now['thu']-9).' days')), 4 => date('Y-m-01') , 5=> date("Y-m-d", strtotime("first day of previous month"))
		);

		$arr_time_end = array( 0 => $date_today , 1 => date('Y-m-d', strtotime('today - 1 days')) , 2 => date('Y-m-d', strtotime('today - '.($date_now['thu'] - 2 + 7).' days')) , 
			3 => date('Y-m-d', strtotime('today - '.($date_now['thu']-9+7).' days')), 4 => date('Y-m-t') , 5=> date("Y-m-d", strtotime("last day of previous month")),
		);

		$where .= ' AND a.created_time >= "'.$arr_time_start[$filter_time].' 00:00:00"';
		$where .= ' AND a.created_time <= "'.$arr_time_end[$filter_time].' 23:59:59"';
		
		$query = " SELECT a.*
		FROM 
		" . $this->table_name . " AS a
		WHERE 1=1 " . $where . $ordering . " ";
		return $query;
	}
	

	function save($row = array(), $use_mysql_real_escape_string = 0) {
		$id = parent::save ( $row );
		$data_sync = array();
		$data_sync[] = array('field_check' => 'warehouses_id','tablenames' =>array('fs_warehouses_products', 'fs_warehouses_positions_products', 'fs_warehouses_positions_categories', 'fs_warehouses_positions','fs_warehouses_damaged_products_detail','fs_warehouses_damaged_products','fs_warehouses_check','fs_warehouses_bill_positions','fs_warehouses_bill','fs_warehouses_bill_buy') ,'field_sync' => array('warehouses_name' => 'name'));

		$this-> sync_data($data_change = array($id,$this -> table_name),$data_sync);

		return $id;
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