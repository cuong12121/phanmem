<?php 
	class SellsModelsRetail extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 10;
			$this -> view = 'retail';
			$this -> table_name = 'fs_sells_retail';
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
					$where .= ' AND a.category_id like  "%' . $filter . '%" ';
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
	
		
		function save($row = array(),$use_mysql_real_escape_string = 0) {
			$id = FSInput::get ( 'id', 0, 'int' );

			

			$id = parent::save ( $row );
			if (! $id) {
				Errors::setError ( 'Not save' );
				return false;
			}
			return $id;
		}
	}
	
?>