<?php
class ProductsModelsFilters extends FSModels {
	function __construct() {
		$calculators = array (//								array("1","h&#227;ng s&#7843;n xu&#7845;t"),
		2 => array ("2", "LIKE" ), 3 => array ("3", "Null" ), 4 => array ("4", "Not Null" ), 5 => array ("5", "==" ), 6 => array ("6", ">" ), 7 => array ("7", "<" ), 8 => array ("8", ">=" ), 9 => array ("9", "<=" ), 10 => array ("10", " > value1 AND < value2" ), 11 => array ("11", " > value1 AND <= value2" ), 12 => array ("12", " >= value1 AND < value2" ), 13 => array ("13", " >= value1 AND <= value2" ), 14 => array ("14", "FOREIGN_ONE" ), 15 => array ("15", "FOREIGN_MULTI" ) );
		$this->type = 'products';
		$this->table_name = 'fs_' . $this->type . '_filters';
		$this->table_field = 'fs_' . $this->type . '_tables';
	}
	
	function getFieldList($table_name) {
		global $db;
		
		if (! $table_name) {
			return;
		}
		
		$query = " SELECT * FROM " . $this->table_field . "
					WHERE table_name = '$table_name'
					AND field_name <> 'id' ";
		$db->query ( $query );
		$result = $db->getObjectList ();
		// printr($result);
		return $result;
	}
	function getFieldListCommon($type) {
		global $db;
		
		if (! $type) {
			return;
		}
		
		$query = " SELECT * FROM fs_tables
					WHERE type = '$type'
					AND field_name <> 'id' 
					AND is_filter = 1";
		$db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}
	
	function getFilters($table_name, $fieldname) {
		if (! $table_name || ! $fieldname) {
			return;
		}
		// echo $fieldname;
		global $db;
		$query = " SELECT * FROM " . $this->table_name . "
					WHERE tablename = '$table_name' 
					AND field_name = '$fieldname' 
					AND calculator <> 1 ";
		$db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}
	
	/*
		 * Lấy ra trường hiện tại
		 * 1: có trong trường mở rộng đc định nghĩa bởi ng dung
		 * 2: có trong trường common do hệ thống định nghĩa
		 */
	function get_field_current($field, $table_name) {
		if (! $field)
			return;
		if ($table_name)
			$field_current = $this->get_record ( ' table_name = "' . $table_name . '" AND field_name = "' . $field . '"', 'fs_' . $this->type . '_tables', '*,0 AS is_common' );
		if (! @$field_current) {
			$field_current = $this->get_record ( ' type = "' . $this->type . '" AND field_name = "' . $field . '"', 'fs_tables', '*,1 AS is_common' );
		
		//				$field_current -> is_common = 1;
		} else {
			//				$field_current -> is_common = 0;
		}
		return $field_current;
	}
	
	function get_filters_in_table($table_name) {
		if (! $table_name) {
			return;
		}
		global $db;
		$query = " SELECT * FROM " . $this->table_name . "
					WHERE tablename = '$table_name'
					AND calculator <> 1 
					ORDER BY field_name, id";
		$db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}
	
	function get_count_field_by_filter_in_table($table_name) {
		if (! $table_name) {
			return;
		}
		global $db;
		$query = " SELECT field_name, count(*) as count_filter FROM " . $this->table_name . "
					WHERE tablename = '$table_name'
					AND calculator <> 1 
					GROUP BY field_name
					";
		$db->query ( $query );
		$result = $db->getObjectListByKey ( 'field_name' );
		return $result;
	}
	
	/*
		 * filter menufacture ?
		 */
	function getFiltersManufactory($table_name) {
		if (! $table_name) {
			return;
		}
		global $db;
		$query = " SELECT * FROM " . $this->table_name . "
					WHERE tablename = '$table_name'
					AND calculator = 1 ";
		$db->query ( $query );
		$result = $db->getObject ();
		return $result;
	}
	
	// save
	function save2($table_name) {
		if (! $table_name) {
			return;
		}
		if(strpos($table_name, 'fs_'.$this->type.'_') === false){
			$table_name = 'fs_'.$this->type.'_'.$table_name;
		}
		$field_name = FSInput::get ( 'field' );
		// table show 
		$field_show = $this->getTableShow ( $table_name, $field_name );
		
		// field
		$field_current = $this->get_field_current ( $field_name, $table_name );
		// foreign:
		if (isset ( $field_current ) && ! empty ( $field_current ) && ($field_current->field_type == 'foreign_one' || $field_current->field_type == 'foreign_multi')) {
			if ($field_current->is_common) {
				$rs = $this->save_foreign ( $table_name, $field_current, $field_current->field_type , 1 );
			} else {
				$rs = $this->save_foreign ( $table_name, $field_current, $field_current->field_type , 0 );
			}
		} else {
			if (! $this->check_unique_alias ( $table_name, $field_name )) {
				return false;
			}
			if (! $this->save_filter_remove ( $table_name, $field_name ))
				return false;
			
			if (! $this->save_filter_new ( $table_name, $field_name, $field_show, $field_current ))
				return false;
			
			if (! $this->save_filter_edit ( $table_name, $field_name, $field_current ))
				return false;
		}
		$this -> save_field_ordering($table_name, $field_name);
		// calculate filter
		//			$this -> caculate_filter(array($table_name));
		return true;
	}
	
	/*
		 * Check unique for "alias"
		 */
	function check_unique_alias($table_name, $field_name) {
		$array_alias = array ();
		// new filter
		$total = FSInput::get ( 'filter_new_total' );
		if ($total) {
			$arr_insert = array ();
			for($i = 0; $i < $total; $i ++) {
				$alias = FSInput::get ( 'alias_new_' . $i );
				if ($alias)
					$array_alias [] = $alias;
			}
		}
		
		// exist filter
		$total = FSInput::get ( 'filter_exist_total' );
		for($i = 0; $i < $total; $i ++) {
			$alias = FSInput::get ( 'alias_exist_' . $i );
			if ($alias)
				$array_alias [] = $alias;
		}
		$length = count ( $array_alias );
		
		// check unique in field			
		$array_alias = array_unique ( $array_alias );
		$length_unique = count ( $array_alias );
		if ($length_unique < $length) {
			Errors::setError ( "Có sự trùng lặp tên hiệu" );
			return false;
		}
		if ($length > 0) {
			$sql_or = '';
			$j = 0;
			foreach ( $array_alias as $item ) {
				if ($j > 0)
					$sql_or .= ' OR ';
				$sql_or .= ' alias = "' . $item . '" ';
				$j ++;
			}
			// check unique in table
			$query = 'SELECT count(*)
					FROM ' . $this->table_name . ' 
					WHERE tablename = "' . $table_name . '" 
					AND field_name != "' . $field_name . ' " 
					AND (' . $sql_or . ')
					';
			global $db;
			$sql = $db->query ( $query );
			$result = $db->getResult ();
			if ($result) {
				Errors::setError ( "Có sự trùng lặp tên hiệu" );
				return false;
			}
		}
		
		return true;
	}
	
	function save_filter_new($table_name, $field_name, $field_show, $field_current) {
		global $db;
		$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
		// NEW FIELD
		$total = FSInput::get ( 'filter_new_total' );
		if ($total) {
			$sql_insert = "";
			
			$arr_insert = array ();
			for($i = 0; $i < $total; $i ++) {
				$filter_show = FSInput::get ( 'filter_show_new_' . $i );
				$alias = FSInput::get ( 'alias_new_' . $i );
				$alias = $fsstring->stringStandart ( $alias );
				$calculator = FSInput::get ( 'calculator_new_' . $i );
				$value = FSInput::get ( 'value_new_' . $i );
				$seo_title = FSInput::get ( 'seo_title_new_' . $i );
				$seo_meta_key = FSInput::get ( 'seo_meta_key_new_' . $i );
				$seo_meta_des = FSInput::get ( 'seo_meta_des_new_' . $i );
				$field_ordering = FSInput::get ( 'field_ordering',$field_current->ordering,'int' );
				$ordering = FSInput::get ( 'ordering_new_' . $i, 0, 'int' );
				$is_home = FSInput::get ( 'is_home_new_' . $i );
				$is_home = @$is_home ? 1 : 0;
				$published = FSInput::get ( 'published_new_' . $i );
				$published = @$published ? 1 : 0;
				$is_seo = FSInput::get ( 'is_seo_new_' . $i );
				$is_seo = @$is_seo ? 1 : 0;
				$is_common = $field_current->is_common;
				
				if ($filter_show && $alias) {
					$arr_insert [] = "('$filter_show','$alias','$table_name','$field_name','$field_show','$calculator','$value','$seo_title','$seo_meta_key','$seo_meta_des',$field_ordering,$ordering,$published,$is_home,$is_common,$is_seo)";
				}
			}
			// insert into table fs_products_tables
			if (count ( $arr_insert )) {
				$sql_insert .= " INSERT INTO " . $this->table_name . " ";
				$sql_insert .= "		(filter_show,alias,tablename,field_name,field_show,calculator,filter_value,seo_title,seo_meta_key,seo_meta_des,field_ordering,ordering,published,is_common,is_home,is_seo) ";
				$sql_insert .= "		 VALUES ";
				$sql_insert .= implode ( ",", $arr_insert );
				
				$db->query ( $sql_insert );
				$rs = $db->insert ();
				if (! $rs) {
					Errors::setError ( "Kh&#244;ng insert &#273;&#432;&#7907;c v&#224;o " . $this->table_name . "" );
					return false;
				}
			}
		
		}
		return true;
	}
	
	/*
		 * Change field exist
		 */
	function save_filter_edit($tablename, $field_name, $field_current) {
		global $db;
		$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
		// EXIST FIELD
		$total = FSInput::get ( 'filter_exist_total' );
		
		$sql_alter = "";
		$arr_sql_alter = array ();
		
		for($i = 0; $i < $total; $i ++) {
			$sql_update = " UPDATE " . $this->table_name . "
							SET ";
			
			$filter_show_exist = FSInput::get ( 'filter_show_exist_' . $i );
			$filter_show_exist_begin = FSInput::get ( 'filter_show_exist_' . $i . "_begin" );
			
			$alias_exist = FSInput::get ( 'alias_exist_' . $i );
			$alias_exist_begin = FSInput::get ( 'alias_exist_' . $i . "_begin" );
			
			$calculator_exist = FSInput::get ( 'calculator_exist_' . $i );
			$calculator_exist_begin = FSInput::get ( 'calculator_exist_' . $i . '_begin' );
			
			$value_exist = FSInput::get ( 'value_exist_' . $i );
			$value_exist_begin = FSInput::get ( 'value_exist_' . $i . '_begin' );
			
			$seo_title_exist = FSInput::get ( 'seo_title_exist_' . $i );
			$seo_title_exist_begin = FSInput::get ( 'seo_title_exist_' . $i . '_begin' );
			
			$seo_meta_key_exist = FSInput::get ( 'seo_meta_key_exist_' . $i );
			$seo_meta_key_exist_begin = FSInput::get ( 'seo_meta_key_exist_' . $i . '_begin' );
			
			$seo_meta_des_exist = FSInput::get ( 'seo_meta_des_exist_' . $i );
			$seo_meta_des_exist_begin = FSInput::get ( 'seo_meta_des_exist_' . $i . '_begin' );

			$description_exist = $_POST['description_exist_' . $i];
			$description_exist_begin = $_POST['description_exist_' . $i . '_begin' ];
			
//			$field_ordering_exist = FSInput::get ( 'field_ordering_exist_' . $i, $field_current->ordering, 'int' );
//			$field_ordering_exist_begin = FSInput::get ( 'field_ordering_exist_' . $i . '_begin', $field_current->ordering, 'int' );
			
			$ordering_exist = FSInput::get ( 'ordering_exist_' . $i, $field_current->ordering, 'int' );
			$ordering_exist_begin = FSInput::get ( 'ordering_exist_' . $i . '_begin', $field_current->ordering, 'int' );
			
			$published_exist = FSInput::get ( 'published_exist_' . $i );
			$published_exist_begin = FSInput::get ( 'published_exist_' . $i . '_begin' );
			$published_exist = $published_exist ? 1 : 0;
			$published_exist_begin = $published_exist_begin ? 1 : 0;

			$is_seo_exist = FSInput::get ( 'is_seo_exist_' . $i );
			$is_seo_exist_begin = FSInput::get ( 'is_seo_exist_' . $i . '_begin' );
			$is_seo_exist = $is_seo_exist ? 1 : 0;
			$is_seo_exist_begin = $is_seo_exist_begin ? 1 : 0;
			
			// id
			$filterid_exist = FSInput::get ( 'filterid_exist_' . $i );
			
			if ($filter_show_exist) {
				
				if (($filter_show_exist != $filter_show_exist_begin) || ($calculator_exist != $calculator_exist_begin) || ($value_exist != $value_exist_begin) || ($published_exist != $published_exist_begin) || ($alias_exist != $alias_exist_begin) || ($seo_title_exist != $seo_title_exist_begin) || ($seo_meta_key_exist != $seo_meta_key_exist_begin) || ($seo_meta_des_exist != $seo_meta_des_exist_begin) || ($description_exist != $description_exist_begin) || ($ordering_exist != $ordering_exist_begin) 
					|| ($is_seo_exist != $is_seo_exist_begin)
				 ) {
					//						filter_show,tablename,field_name,field_show,calculator,filter_value,published
					$alias_exist = $fsstring->stringStandart ( $alias_exist );
					// update
					$sql_update .= " 	filter_show = '$filter_show_exist',
											alias = '$alias_exist',
											calculator = '$calculator_exist', 
											filter_value = '$value_exist',
											seo_title = '$seo_title_exist',
											seo_meta_key = '$seo_meta_key_exist',
											seo_meta_des = '$seo_meta_des_exist',
											description = '$description_exist',

											ordering = '$ordering_exist',
											published = '$published_exist',
											is_home = '$is_home_exist',
											is_seo = '$is_seo_exist',
											is_common = '" . $field_current->is_common . "'
										WHERE tablename = '$tablename'
										AND field_name = '$field_name' 
										AND id = $filterid_exist ";
					$db->query ( $sql_update );
					$rows = $db->affected_rows ();
					if (! $rows) {
						Errors::setError ( $filter_show_exist . " kh&#244;ng l&#432;u &#273;&#432;&#7907;c" );
					}
				}
			}
		}
		
		return true;
	
		// END EXIST FIELD
	}
	function save_filter_remove($tablename, $field_name) {
		global $db;
		$filter_exist_remove = trim ( FSInput::get ( 'filter_exist_remove' ) );
		if ($filter_exist_remove) {
			$array_filter_remove = explode ( ",", $filter_exist_remove );
			if (count ( $array_filter_remove ) > 0) {
				$arr_filter_remove1 = array ();
				for($i = 0; $i < count ( $array_filter_remove ); $i ++) {
					if ($array_filter_remove [$i]) {
						$arr_filter_remove1 [] = $array_filter_remove [$i];
					}
				}
				
				$sql_remove = " DELETE FROM  " . $this->table_name . "
									 WHERE tablename =  '$tablename' 
									 AND field_name  = '$field_name'
									 AND id IN (" . implode ( ",", $arr_filter_remove1 ) . ") ";
				// remove from database
				$db->query ( $sql_remove );
				$rows = $db->affected_rows ();
				if (! $rows) {
					Errors::setError ( "L&#7895;i x&#7843;y ra khi remove trong table " . $this->table_name . "" );
					return false;
				}
			
			}
		}
		return true;
	}
	
	/*
		 * get Table show
		 */
	function getTableShow($tablename, $field_name) {
		if (! $field_name)
			return;
		$field_name_display = '';
		if ($tablename)
			$field_name_display = $this->get_result ( ' table_name	= "' . $tablename . '" AND field_name	= "' . $field_name . '"', 'fs_' . $this->type . '_tables', 'field_name_display' );
		if (! $field_name_display)
			$field_name_display = $this->get_result ( ' type	= "' . $this->type . '" AND field_name	= "' . $field_name . '"', 'fs_tables', 'field_name_display' );
		
		return $field_name_display;
	}
	
	/*
		 * save Filter for Manufactory
		 */
	function save_manufactory($tablename) {
		if (! $tablename)
			return false;
		$filter_manufactory = FSInput::get ( 'filter_manufactory' );
		$filter_manufactory_begin = FSInput::get ( 'filter_manufactory_begin' );
		$filter_manufactory_published = FSInput::get ( 'filter_manufactory_published' );
		$filter_manufactory_published = $filter_manufactory_published ? 1 : 0;
		global $db;
		if ($filter_manufactory_begin) {
			if (! $filter_manufactory) {
				$sql = " DELETE FROM  " . $this->table_name . "
									 WHERE tablename =  '$tablename' 
									 AND calculator = 1 ";
				$db->query ( $sql );
				$rows = $db->affected_rows ();
				if (! $rows) {
					return false;
				}
			} else {
				$sql = " UPDATE " . $this->table_name . " SET
								published = '$filter_manufactory_published'
										WHERE tablename = '$tablename'
										AND calculator = 1 ";
				$db->query ( $sql );
				$rows = $db->affected_rows ();
			}
		} else {
			if ($filter_manufactory) {
				$sql = " INSERT INTO " . $this->table_name . "
							(tablename,calculator,published)
							VALUES ('$tablename','1','$filter_manufactory_published') ";
				$db->query ( $sql );
				$id = $db->insert ();
				if (! $id) {
					return false;
				}
			}
		}
		
		return true;
	}
	function save_foreign($table_name, $field_current, $filter_type = 'foreign_one',$is_common = 0) {
		
		if($is_common){
			$foreign = $this->get_records ( 'published = 1', $field_current->foreign_tablename );
		}else{
			$foreign = $this->get_records ( 'group_id = ' . $field_current->foreign_id . '', 'fs_extends_items', '*', ' ordering ,id ' );
		}
	
		if (! count ( $foreign ))
			return false;
		$str_foreign_select = '';
		$j = 0;
		foreach ( $foreign as $item ) {
			$checked =  FSInput::get('published_'.$item -> id);
			if(!$checked)
				continue;
				
			$row = array ();
			$row ['filter_show'] = FSInput::get('filter_show_'.$item->id);
			$row ['tablename'] = $table_name;
			$row ['field_name'] = $field_current->field_name;
			$row ['field_show'] = $field_current->field_name_display;
			$row ['alias'] =      FSInput::get('alias_'.$item->id);
			$row ['calculator'] = $filter_type == 'foreign_one' ? 14 : 15;
			$row ['filter_value'] = $item->id;
			$row ['seo_title'] = 	FSInput::get('seo_title_'.$item->id);
			$row ['seo_meta_key'] = FSInput::get('seo_meta_key_'.$item->id);
			$row ['seo_meta_des'] = FSInput::get('seo_meta_des_'.$item->id);
			$row ['description'] = $_POST['description_'.$item->id];

			$row ['description_cat'] = $_POST['description_cat_'.$item->id];

			$row ['published'] = 1;
			$row ['is_seo'] =  FSInput::get('is_seo_'.$item -> id);
			
			$row ['is_home'] = FSInput::get('is_home_'.$item->id);
			$row ['ordering'] = FSInput::get('ordering_'.$item->id);
			$row ['field_ordering'] = FSInput::get('field_ordering');
			$row ['is_common'] = $field_current->is_common;
				
			$id_exist = $this->get_result( ' tablename = "' . $table_name . '" AND field_name = "' . $field_current->field_name . '" AND filter_value = "' . $item->id . '"', $this->table_name,'id' );
			if (! $id_exist) {
				$rs = $this->_add ( $row, $this->table_name,1 );
				if ($str_foreign_select)
					$str_foreign_select .= ',';
				$str_foreign_select .= $rs;
			}else{
				$rs = $this->_update( $row, $this->table_name, ' id = '.$id_exist,1 );
				if ($str_foreign_select)
					$str_foreign_select .= ',';
				$str_foreign_select .= $id_exist;
			}
			$j ++;
		}
//		echo $str_foreign_select;
//		die;
		$sql_where = '';
		if ($str_foreign_select)
			$sql_where = "AND id NOT IN (" . $str_foreign_select . ")";
		$sql = " DELETE FROM " . $this->table_name . " 
						WHERE  tablename = '" . $table_name . "' AND field_name = '" . $field_current->field_name . "' " . $sql_where;
		global $db;
		$db->query ( $sql );
		$rows = $db->affected_rows ();
		if (! $rows)
			return false;
		return true;
	
	}
	
	function save_field_ordering($table_name, $field_name){
		$row = array();
		$row['field_ordering'] = FSInput::get('field_ordering');
		$this -> _update($row,  $this->table_name, ' tablename = "' . $table_name . '" AND field_name = "' . $field_name . '" ' );
	}
}

?>