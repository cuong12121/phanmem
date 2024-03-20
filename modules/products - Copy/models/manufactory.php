<?php
class ProductsModelsManufactory extends FSModels {
	function __construct() {
		parent::__construct ();
		global $module_config;
		FSFactory::include_class('parameters');
		$current_parameters = new Parameters(@$module_config->params);
		$limit   = $current_parameters->getParams('limit'); 
		$limit = $limit ? $limit: 24;
		$this->limit = $limit;	
	}
	
	function set_query_body_normal($id) {
		if (! $id)
			return;
		$where = "";
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = " FROM " . $fs_table->getTable ( 'fs_products' ) . " AS a
						  WHERE manufactory = " . $id . "
						  	AND published = 1 AND is_trash = 0
						  	" . $where . "";
		return $query;
	}

	
	function get_list($query_body) {
		if (! $query_body)
			return;
		$query_ordering = $this->set_query_order_by (  );
		$query_select = $this->set_query_select ( );
		$query = $query_select;
		$query .= $query_body;
		$query .= $query_ordering;
		global $db;
		$db->query_limit ( $query, $this->limit, $this->page );
		$result = $db->getObjectList ();
		return $result;
	}
	/*
		 * $table_type: 1: fs_products
		 * $table_type: 0: fs_products_...(detail)
		 */
	function set_query_body($manu) {
		return $this->set_query_body_normal ($manu->id);
	}
	
	
	/*
		 * Insert order by into query select
		 */
	function set_query_order_by() {
		$order = FSInput::get ( 'order' );
		$query_ordering = '';
		if ($order) {
			switch ($order) {
				case 'asc' : //tăng
					$query_ordering='ORDER BY ABS(price) ASC ';
					break;
				case 'desc' : //giảm
					$query_ordering='ORDER BY ABS(price) DESC';
					break;
				case 'san-pham-cu' :
					$query_ordering = 'ORDER BY created_time ASC, id DESC';
					break;
				case 'san-pham-moi' :
					$query_ordering = 'ORDER BY created_time DESC, id DESC';
					break;
				case 'alpha' :
					$query_ordering = 'ORDER BY name asc';
					break;
				case 'promotion' :
					$query_ordering = 'ORDER BY discount DESC';
					break;
			}
		} else {
			$query_ordering = 'ORDER BY  ordering ASC,created_time DESC';
		}
		return $query_ordering;
	}
	
	/*
		 * Insert select into query select
		 * 1: fs_products
		 */
	function set_query_select() {
		
		$query = " SELECT * ";
		
		return $query;
	}
	
	/*
		 * get Category current
		 */
	function get_manufactory() {
		$id = FSInput::get ( 'id', 0, 'int' );
		$where = 'published = 1 ';
		if ($id) {
			$where .= " AND id = '$id'  ";
		} else {
			$code = FSInput::get ( 'code' );
			if (! $code)
				return;
			$where .= " AND alias = '$code' ";
		}
		$fs_table = FSFactory::getClass ( 'fstable' );
		$result = $this->get_record ( $where, $fs_table->getTable ( 'fs_manufactories' ), '*' );
		return $result;
	}


	
	function getTotal($query_body) {
		global $db;
		$query = "SELECT count(*) ";
		$query .= $query_body;
		$db->query ( $query );
		$total = $db->getResult ();
		return $total;
	}
	function getPagination($total) {
		FSFactory::include_class ( 'Pagination' );
		$pagination = new Pagination ( $this->limit, $total, $this->page );
		return $pagination;
	}
	function get_types(){
		global $db;
			$query = "SELECT id,name
				 FROM fs_products_types
				 WHERE  published = 1

				 ORDER BY ordering
			";
		if(!$query)
			return;
		$sql = $db->query($query);
		$result = $db->getObjectListByKey('id');
		return $result;
	}
	
}

?>