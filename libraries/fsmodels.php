<?php
class FSModels {
	var $limit;
	var $page;
	function __construct() {
		$page = FSInput::get ( 'page', 0, 'int' );
		$limit = FSInput::get ( 'limit', 10, 'int' );
		$this->page = $page;
		$this->limit = $limit;
	}
	
	function _update($row, $table_name, $where = '', $use_mysql_real_escape_string = 1) {
		$total = count ( $row );
		if (! $total || ! $table_name)
			return;
		global $db;
		$sql = 'UPDATE ' . $table_name . ' SET ';
		$i = 0;
		foreach ( $row as $key => $value ) {
			if ($use_mysql_real_escape_string)
				$sql .= "`" . $key . "` = '" . $db->escape_string ( $value ) . "'";
			else
				$sql .= "`" . $key . "` = '" . $value . "'";
			if ($i < $total - 1)
				$sql .= ',';
			$i ++;
		}
		if ($where)
			$where = ' WHERE ' . $where;
		$sql .= $where;
		global $db;
		$db->query ( $sql );
		$rows = $db->affected_rows ();
		return $rows;
	}
	
	function _add($row, $table_name, $use_mysql_real_escape_string = 0) {
		if (! $table_name)
			return false;
		global $db;
		$str_fields = array ();
		$str_values = array ();
		
		if (! count ( $row ))
			return;
		foreach ( $row as $field => $value ) {
			$str_fields [] = "`" . $field . "`";
			if ($use_mysql_real_escape_string) {
				$value = $db->escape_string ( $value );
			} else {
				$value = htmlspecialchars_decode ( $value );
			}
			
			//			$value = htmlspecialchars($value);
			//			$value = mysql_real_escape_string($value);
			$str_values [] = "'" . $value . "'";
		}
		
		$str_fields = implode ( ',', $str_fields );
		$str_values = implode ( ',', $str_values );
		
		$sql = ' INSERT INTO  ' . $table_name;
		$sql .= '(' . $str_fields . ") ";
		$sql .= 'VALUES (' . $str_values . ") ";
		$id = $db->insert ( $sql );
		//echo $sql;
		//die();
		return $id;
	
	}
	/*
		 * Value need remove
		 */
	function _remove($where = '', $table_name = '') {
		$sql_where = '';
		if ($where)
			$sql_where .= ' WHERE ' . $where;
		if (! $table_name)
			$table_name = $this->table_name;
		$sql = " DELETE FROM " . $table_name . $sql_where;
		global $db;
		$db->query ( $sql );
		$rows = $db->affected_rows ();
		return $rows;
	}
	
	/*
		 * Remove img
		 */
	// remove image of id IN str_id
	function remove_image($where, $path_arr = array(), $field = 'image', $table_name = '') {
		if (! $where)
			return;
		if (! $table_name)
			return false;
		$sql = " SELECT " . $field . "
					 FROM " . $table_name . "
					 WHERE  " . $where;
		global $db;
		$db->query ( $sql );
		$list = $db->getObjectList ();
		
		for($i = 0; $i < count ( $list ); $i ++) {
			$image = $list [$i]->$field;
			$p = PATH_BASE . str_replace ( '/', DS, $image );
			if (! @unlink ( $p )) {
			}
			if ($image)
				for($j = 0; $j < count ( $path_arr ); $j ++) {
					$p = str_replace ( '/original/', '/' . $path_arr [$j] [0] . '/', $image );
					$p = PATH_BASE . str_replace ( '/', DS, $p );
					if (! @unlink ( $p )) {
						//						$fserrors = FSFactory::getClass('Errors');
					//						$fserrors -> _('Not remove image'.$path_arr[$j].$image);
					//						return false;
					}
				}
		}
		return true;
	}
	
	/*
	 * Get wrapper of list id
	 * ex: get parent_ids from fs_category where id IN ()
	 * return string of wrapper
	 */
	function _get_wrapper($tablename, $field_wrapper, $where_value, $where_field = 'id', $where_type = 'IN') {
		if (! $tablename || ! $field_wrapper || ! $where_value)
			return;
		$sql = ' SELECT  ' . $field_wrapper;
		$sql .= ' FROM ' . $tablename;
		if ($where_type == 'IN') {
			$sql .= ' WHERE  ' . $where_field . ' IN (' . $where_value . ') ';
		} else {
			$sql .= ' WHERE  ' . $where_field . $where_type . $where_value;
		}
		global $db;
		$db->query ( $sql );
		$list = $db->getObjectlist ();
		
		$str_wrapper = '';
		for($i = 0; $i < count ( $list ); $i ++) {
			$item = $list [$i];
			if ($item->$field_wrapper) {
				if ($str_wrapper)
					$str_wrapper .= ',';
				$str_wrapper .= $item->$field_wrapper;
			}
		}
		if (! $str_wrapper)
			return;
		$arr_wrapper = explode ( ',', $str_wrapper );
		$arr_wrapper = array_unique ( $arr_wrapper );
		return implode ( $arr_wrapper, ',' );
	}
	
	function get_estore() {
		$estore_id = $_SESSION ['estore_id'];
		if (! $estore_id)
			return;
		
		global $db;
		$sql = " SELECT id,category_ids,estore_name,estore_url,category_ids_wrapper,product_categories_wrapper, city_id, district_id,destination_ids,username,etemplate
				FROM fs_estores
				WHERE `id`  = '$estore_id' 
				";
		$db->query ( $sql );
		return $db->getObject ();
	
	}
	
	/*
	 * get Destination
	 * default: Hoan kiem, Ha Noi
	 */
	function get_destination($district_id = '1478') {
		if (! $district_id)
			return false;
		global $db;
		$sql = " SELECT id, name FROM fs_destination
				WHERE district_id = $district_id ";
		$db->query ( $sql );
		return $db->getObjectList ();
	}
	function alert_error($msg) {
		echo "<script type='text/javascript'>alert('" . $msg . "'); </script>";
	}
	function get_estore_by_ids($str_estore_id) {
		if (! $str_estore_id)
			return;
		global $db;
		$sql = " SELECT id,estore_name,username,estore_url FROM fs_estores
				WHERE id IN (" . $str_estore_id . ") 
				AND published = 1";
		$db->query ( $sql );
		return $list = $db->getObjectListByKey ( 'id' );
	}
	function get_estore_by_id($estore_id) {
		if (! $estore_id)
			return;
		global $db;
		$sql = " SELECT id,estore_name,username,estore_url FROM fs_estores
				WHERE id = (" . $estore_id . ") 
				AND published = 1";
		$db->query ( $sql );
		return $list = $db->getObject ();
	}
	
	/*
	 * get record by rid
	 */
	function get_record_by_id($id, $table_name = '', $select = '*') {
		if (! $id)
			return;
		if (! $table_name)
			$table_name = $this->table_name;
		$query = " SELECT " . $select . "
					  FROM " . $table_name . "
					  WHERE id = $id ";
					  // die;
		
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObject ();
		return $result;
	}
	/*
	 * Return result
	 */
	function get_result($where = '', $table_name = '', $field = 'id') {
		if (! $where)
			return;
		if (! $table_name)
			$table_name = $this->table_name;
		$select = " SELECT " . $field . " ";
		$query = $select . "  FROM " . $table_name . "
					  WHERE " . $where;
		
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getResult ();
		return $result;
	}
	function get_field_by_id($id, $field, $table_name = '') {
		if (! $id)
			return;
		if (! $table_name)
			$table_name = $this->table_name;
		$query = " SELECT $field
						  FROM " . $table_name . "
						  WHERE id = $id ";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getResult ();
		return $result;
	}
	/*
	 * select count(...) thỏa mãn điều kiện
	 */
	function get_count($where = '', $table_name = '', $select = '*') {
		if (! $where)
			return;
		if (! $table_name)
			$table_name = $this->table_name;
		$query = ' SELECT count(' . $select . ')
					  FROM ' . $table_name . '
					  WHERE ' . $where;
		
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getResult ();
		return $result;
	}
	/*
	 * get record by rid
	 */
	function get_record($where = '', $table_name = '', $select = '*') {
		if (! $where)
			return;
		if (! $table_name)
			$table_name = $this->table_name;
		$query = " SELECT " . $select . "
					  FROM " . $table_name . "
					  WHERE " . $where;
					 
		
		global $db;
		$db->query ( $query );
		$result = $db->getObject ();
		return $result;
	}
	/*
	 * get records
	 */
	function get_records($where = '', $table_name = '', $select = '*', $ordering = '', $limit = '', $field_key = '') {
		$sql_where = " ";
		if ($where) {
			$sql_where .= ' WHERE ' . $where;
		}
		if (! $table_name)
			$table_name = $this->table_name;
		$query = " SELECT " . $select . "
					  FROM " . $table_name . $sql_where;
		
		if ($ordering)
			$query .= ' ORDER BY ' . $ordering;
		if ($limit)
			$query .= ' LIMIT ' . $limit;



		
		$query;
		global $db;
		$sql = $db->query ( $query );
		if (! $field_key)
			$result = $db->getObjectList ();
		else
			$result = $db->getObjectListByKey ( $field_key );
		return $result;
	}
	
	/*
	 * save into table
	 */
	function _save($row = array(), $table_name = '', $use_mysql_real_escape_string = 0) {
		$id = FSInput::get ( 'id', 0, 'int' );
		if (! $id)
			return $this->_add ( $row, $table_name, $use_mysql_real_escape_string );
		else
			return $this->_update ( $row, $table_name, ' WHERE id = ' . $id, $use_mysql_real_escape_string );
	}
	
	function get_countries() {
		global $db;
		$sql = " SELECT id, name FROM fs_countries
				WHERE published = 1
				ORDER BY `ordering`
				";
		$db->query ( $sql );
		return $db->getObjectListByKey ('id');
	}
	
	/*
	 * get list District
	 * default: Ha Noi
	 */
	function get_districts($city_id) {
		if (! $city_id)
			return;
		global $db;
		$sql = " SELECT id, name FROM fs_districts
				WHERE city_id = $city_id 
				AND published = 1
				ORDER BY `ordering`
				";
		$db->query ( $sql );
		return $db->getObjectList ();
	}
	function get_cities($country_id = 66) {
		global $db;
		$sql = " SELECT id, name FROM fs_cities 
				WHERE country_id = $country_id 
				AND published = 1
				ORDER BY `ordering`";
		$db->query ( $sql );
		return $db->getObjectListByKey ('id');
	}
	function get_communes($district_id = 66) {
		global $db;
		$sql = " SELECT id, name FROM fs_commune
				WHERE district_id = $district_id 
				AND published = 1
				ORDER BY `ordering`";
		$db->query ( $sql );
		return $db->getObjectList ();
	}
	function get_sitemap($level = 0) {
		$where = '';
		if ($level)
			$where .= ' AND level < "' . $level . '" ';
		global $db;
		$sql = " SELECT name,alias, level, parent_id,module, record_id as id,id as sitemap_id
				FROM fs_sitemap
				WHERE published  = 1
				" . $where . "
				ORDER BY module,ordering";
		$db->query ( $sql );
		$list = $db->getObjectList ();
		if (! $list)
			return;
		$tree_class = FSFactory::getClass ( 'tree', 'tree/' );
		
		// call views
		$arr_sitemap = array ();
		foreach ( $list as $item ) {
			if (! isset ( $arr_sitemap [$item->module] ))
				$arr_sitemap [$item->module] = array ();
			$arr_sitemap [$item->module] [] = $item;
		}
		if (! count ( $arr_sitemap ))
			return;
		foreach ( $arr_sitemap as $key => $items ) {
			$arr_sitemap [$key] = $tree_class->indentRows ( $items );
		}
		return $arr_sitemap;
	}
	function check_exist($value, $id = '', $field = 'alias', $table_name = '') {
		if (! $value)
			return true;
		if (! $table_name)
			$table_name = $this->table_name;
		$query = " SELECT count(*)
					  FROM " . $table_name . " 
					WHERE 
						$field = '" . $value . "' ";
		if ($id)
			$query .= ' AND id <> ' . $id . ' ';
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getResult ();
		return $result;
	}
	/*
	 * Chèn từ khóa vào nội dung ( bài viết hoặc sản phẩm)
	 */
	function insert_keyword_to_content($content) {
		$content = htmlspecialchars_decode($content);
		$arr_keyword_name = $this -> get_records('published = 1','fs_keywords','name,link');
		if(count($arr_keyword_name)){
				foreach($arr_keyword_name as $item){
					preg_match('#<a[^>]*>((^((?!</a>).)*$)*?)'.$item ->name.'(((^((?!<a>).)*$))*?)</a>#is',$content,$rs);
					if(count($rs))
						continue;
					$link = $item->link ? FSRoute::_($item -> link): FSRoute::_('index.php?module=products&view=search&keyword='.str_replace(' ','+',trim($item -> name)));
					$content  = str_replace($item -> name,'<a href="'.$link.'" >'.$item -> name.'</a>',$content);
				}
		}
		return $content;
	}
	
/*
		 * get Max value of Ordering field in table fs_categories
		 */
		function getMaxOrdering()
		{
			$query = " SELECT Max(a.ordering)
					 FROM ".$this -> table_name." AS a
					";
			global $db;
			$sql = $db->query($query);
			$result = $db->getResult();
			if(!$result)
				return 1;
			return ($result + 1);
		}
}	
