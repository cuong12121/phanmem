<?php 
class WarehousesModelsPositions extends FSModels
{
	var $limit;
	var $prefix ;
	function __construct()
	{
		$this -> limit = 20;
		$this -> view = 'positions';
		$this -> table_category_name = 'fs_warehouses_positions_categories';

		$this -> table_name = 'fs_warehouses_positions';
			// config for save
		$this -> arr_img_paths = array(array('resized2',150,150,'cut_image'),array('resized',300,300,'cut_image'),array('large',400,400,'cut_image'),array('compress',1,1,'compress'));
		$this -> img_folder = 'images/positions';
		$this -> check_alias = 0;
		$this -> field_img = 'image';
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
		
		if (! $ordering)
			$ordering .= " ORDER BY created_time DESC , id DESC ";
		
		if (isset ( $_SESSION [$this->prefix . 'keysearch'] )) {
			if ($_SESSION [$this->prefix . 'keysearch']) {
				$keysearch = $_SESSION [$this->prefix . 'keysearch'];
				$where .= " AND a.name LIKE '%" . $keysearch . "%' ";
			}
		}
		
		$query = " SELECT a.*
		FROM 
		" . $this->table_name . " AS a
		WHERE 1=1 " . $where . $ordering . " ";
		return $query;
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