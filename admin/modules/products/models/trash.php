<?php
class ProductsModelsTrash extends FSModels {
	var $limit;
	var $prefix;
	var $image_watermark;
	function __construct() {
		$limit = FSInput::get('limit',20,'int');
		$this -> limit = $limit;
		$this->view = 'products';
		$this->type = 'products';
		$this->table_name = 'fs_products';
		$this->use_table_extend = 1;
		$this->table_category = 'fs_' . $this->type . '_categories';
		$this->table_types = 'fs_' . $this->type . '_types';
		parent::__construct ();
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
		// from
		if(isset($_SESSION[$this -> prefix.'text0']))
		{
			$date_from = $_SESSION[$this -> prefix.'text0'];
			if($date_from){
				$date_from = strtotime($date_from);
				$date_new = date('Y-m-d H:i:s',$date_from);
				$where .= ' AND a.edited_time >=  "'.$date_new.'" ';
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
				$where .= ' AND a.edited_time <=  "'.$date_new.'" ';
			}
		}
		if (isset ( $_SESSION [$this->prefix . 'filter0'] )) {
			$filter = $_SESSION [$this->prefix . 'filter0'];
			if ($filter) {
				$where .= ' AND a.category_id_wrapper like   "%,' . $filter . '%," ';
			}
		}
		// Lọc ảnh
		if (isset ( $_SESSION [$this->prefix . 'filter1'] )) {
			$filter = $_SESSION [$this->prefix . 'filter1'];
			if ($filter) {
				if($filter == 1)
					$where .= ' AND a.image is not NULL AND a.image != " "';
				else 
					$where .= 'AND (a.image is NULL OR a.image = " " )';
			}
		}
		// lọc loại sản phẩm
		if (isset ( $_SESSION [$this->prefix . 'filter2'] )) {
			$filter = $_SESSION [$this->prefix . 'filter2'];
			if ($filter) {
				$where .= ' AND a.types like   "%,' . $filter . '%," ';
			}
		}
		
		// Trang chủ
		if (isset ( $_SESSION [$this->prefix . 'filter3'] )) {
			$filter = $_SESSION [$this->prefix . 'filter3'];
			if ($filter) {
				if($filter == 1)
					$where .= ' AND a.show_in_home = 1';
				else 
					$where .= ' AND a.show_in_home = 0';
			}
		}
		
		// SP nổi bật
		if (isset ( $_SESSION [$this->prefix . 'filter4'] )) {
			$filter = $_SESSION [$this->prefix . 'filter4'];
			if ($filter) {
				if($filter == 1)
					$where .= ' AND a.is_hot = 1';
				else 
					$where .= ' AND a.is_hot = 0';
			}
		}
		//Kích hoạt
		if (isset ( $_SESSION [$this->prefix . 'filter5'] )) {
			$filter = $_SESSION [$this->prefix . 'filter5'];
			if ($filter) {
				if($filter == 1)
					$where .= ' AND a.published = 1';
				else 
					$where .= ' AND a.published = 0';
			}
		}

		if (! $ordering)
			$ordering .= " ORDER BY edited_time DESC , id DESC ";
		
		if (isset ( $_SESSION [$this->prefix . 'keysearch'] )) {
			if ($_SESSION [$this->prefix . 'keysearch']) {
				$keysearch = $_SESSION [$this->prefix . 'keysearch'];
				$where .= " AND ( a.name LIKE '%" . $keysearch . "%' OR a.alias LIKE '%" . $keysearch . "%' OR a.id = '".$keysearch."' OR a.code LIKE '%" . $keysearch . "%')";
			}
		}
		
		 $query = " SELECT a.*
						  FROM 
						  	" . $this->table_name . " AS a
						  	WHERE 1=1 AND is_trash = 1  " . $where . $ordering . " ";
		return $query;
	}

	/*
		 * select in category
		 */
	function get_categories_tree() {
		global $db;
		$where ='';
		if (isset ( $_SESSION [$this->prefix . 'category_keysearch'] )) {
			if ($_SESSION [$this->prefix . 'category_keysearch']) {
				$keysearch = $_SESSION [$this->prefix . 'category_keysearch'];
				$where .= " AND ( name LIKE '%" . $keysearch . "%' OR alias LIKE '%" . $keysearch . "%' OR id = '".$keysearch."')";
			}
		}
		$sql = " SELECT id, name, parent_id AS parent_id  ,level
				FROM " . $this->table_category."
				WHERE 1=1 " . $where;
		$db->query ( $sql );
		$categories = $db->getObjectList ();
		
		$tree  = FSFactory::getClass('tree','tree/');
		$list = $tree -> indentRows2($categories);
		return $list;
	}
		/*
		 * value: == 1 :trash
		 * value  == 0 :no trash
		 * restore record
		 */
		function restore_data($value)
		{
			$ids = FSInput::get('id',array(),'array');
			if(count($ids))
			{
				global $db;
				$str_ids = implode(',',$ids);
				$sql = " UPDATE ".$this -> table_name."
							SET is_trash = $value
						WHERE id IN ( $str_ids ) " ;
				$db->query($sql);
				$rows = $db->affected_rows();
				return $rows;
			}
			// 	update sitemap
			if($this -> call_update_sitemap){
				$this -> call_update_sitemap();
			}
			return 0;
		}
		
}
?>