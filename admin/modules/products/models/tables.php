<?php 
class ProductsModelsTables extends FSModels
{
	var $limit;
	var $page;
	function __construct()
	{
		$this -> limit = 30;
		$this -> type = 'products';
		$this -> table_name = 'fs_'.$this -> type.'_tables';
		$this -> table_filters = 'fs_'.$this -> type.'_filters';
		$table_extend = FSInput::get('tablename');
		if(!$table_extend)
			$this -> table_extend = '';
		else{
			$table_extend = strtolower($table_extend);
			if(strpos($table_extend, 'fs_'.$this->type.'_') !== false){
				$this -> table_extend = $table_extend;	
			}else{
				$this -> table_extend = 'fs_'.$this->type.'_'.$table_extend;
			}
		}
		parent::__construct();
	}

	/*********** DISPLAY LIST *********************/ 
	function setQuery()
	{
		$where = " ";
		if (isset ( $_SESSION [$this->prefix . 'keysearch'] )) {
			if ($_SESSION [$this->prefix . 'keysearch']) {
				$keysearch = $_SESSION [$this->prefix . 'keysearch'];
				$where .= " AND ( a.table_name LIKE '%" . $keysearch . "%')";
			}
		}
		$ordering = ' ORDER BY table_name ASC';
		$query = " 	  SELECT DISTINCT(a.table_name) 
		FROM ".$this -> table_name." AS a 
		WHERE 1=1 " . $where.$ordering ;
		return $query;
	}

		/*
		 * Show all table
		 */
		function get_data(){
			global $db;
			$query = $this->setQuery();
			$sql = $db->query_limit($query,$this->limit, $this->page );
			
			$list = $db->getObjectList();
			foreach ($list as $item) {
				$item->created_table = $db-> checkExistTable($item->table_name);
			}
			return $list;
		}
		/*********** end DISPLAY LIST *********************/ 
		
		/*************** CREATE TABLE ****************/
		function table_new()
		{
			global $db;
			$table_name = FSInput::get('table_name');
			$table_name = strtolower($table_name);
			$fsstring = FSFactory::getClass('FSString','','../');
			$table_name = $fsstring -> stringStandart($table_name);
			$table_name = str_replace('-', '_', $table_name);
			
			$table_extend = FSInput::get('tablename');
			if(!$table_extend)
				$this -> table_extend = '';
			else{
				$table_extend = strtolower($table_extend);
				if(strpos($table_extend, 'fs_'.$this->type.'_') !== false){
					$this -> table_extend = $table_extend;	
				}else{
					$this -> table_extend = 'fs_'.$this->type.'_'.$table_extend;
				}
			}
			
			// CHECK 
			// table name not valid
			if(!@$table_name)
			{
				Errors::setError("T&#234;n b&#7843;ng kh&#244;ng &#273;&#432;&#7907;c &#273;&#7875; r&#7895;ng");
				return false;
			}

			// tablename invalid
			if( !$this -> check_valid_name($table_name))
			{
				Errors::setError("T&#234;n b&#7843;ng ch&#432;a &#273;&#250;ng");
				return false;
			}
			$table_name = "fs_".$this -> type."_".$table_name;
			// tablename is exist
			if($db -> checkExistTable($table_name))
			{
				Errors::setError("T&#234;n b&#7843;ng &#273;&#227; &#273;&#432;&#7907;c d&#249;ng");
				return false;
			}
			// end CHECK 
			
			// check duplication
			if( !$this -> checkAlterTable())
			{
				return false;
			}

			$new_field_total = FSInput::get('new_field_total');
			if(!$new_field_total){
				Errors::setError("Bạn phải nhập ít nhất một trường",'error');
				return false;
			}
			
			// create table
			if(!$this -> createTable($table_name)){
				return;
			}

			// INSERT tablename witdh field id INTO fs_extends_table
			$fields_default = $this -> fields_default;

			foreach($fields_default as $field){
				$row = array();
				$row['table_name'] = $table_name ;
				$row['field_name'] = $field['name'] ;
				$row['field_type'] = $field['type'] ;
				$row['field_name_display'] = $field['show'] ;
				$row['is_default'] = 1 ;
				if(!$this -> _add($row,$this -> table_name));
				

				return;
			}	
			// save field in table
			if(!$this -> save_new_field($table_name))
				return;

			return $table_name;
		}
		
		/*
		 * check Fieledname and tablename
		 */
		function check_valid_name($name) {
			if(preg_match("/^[a-zA-Z0-9_]*$/",$name))
				return true;
			else
				return false;
		}
		
		/*************** end CREATE TABLE ****************/
		
		
		/*
		 * show field direct from exist table
		 */
		function getTableFields()
		{
			global $db;
			$tablename = FSInput::get('tablename');
			if(!$tablename)
				return;
			if($tablename == 'fs_'.$this -> type)
				return;
			$tablename = strtolower($tablename);
			if(strpos($tablename, 'fs_'.$this->type.'_') === false){
				$tablename = 'fs_'.$this->type.'_'.$tablename;
			}

			$query = " SELECT * 
			FROM ".$this -> table_name." 
			WHERE table_name =  '$tablename' 
			ORDER BY ordering, id";
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		
		/*
		 * get Field from table fs_produts_table
		 */
		function get_fields_of_table()
		{
			global $db;
			$tablename = FSInput::get('tablename');
			if($tablename == 'fs_'.$this -> type || !$tablename)
				return;
			$tablename = strtolower($tablename);
			if(strpos($tablename, 'fs_'.$this->type.'_') === false){
				$tablename = 'fs_'.$this->type.'_'.$tablename;
			}

			$query = " SELECT * 
			FROM ".$this -> table_name."
			WHERE table_name =  $tablename ";
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		/***************** OK ************/
		
		/*
		 * create table Products follow category ( level = 1)
		 */
		function createProductTbl($tbl_name)
		{
			global $db;
			$sql = " CREATE TABLE  IF NOT EXISTS `$tbl_name`
			(
			id int(11) NOT NULL auto_increment,

			PRIMARY KEY  (`id`)
		) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ";
		$db->query($sql);

	}

	/*************** EDIT TABLE ****************/
	function save_edit()
	{
		global $db;
		$tablename = FSInput::get('table_name');
		if($tablename == 'fs_'.$this -> type || !$tablename)
			return;
		$tablename = strtolower($tablename);
		$fsstring = FSFactory::getClass('FSString','','../');
		$tablename = $fsstring -> stringStandart($tablename);
		$tablename = str_replace('-', '_', $tablename);

		if(strpos($tablename, 'fs_'.$this->type.'_') === false){
			$tablename = 'fs_'.$this->type.'_'.$tablename;
		}

		if( !$this -> check_valid_name($tablename) || !$tablename)
		{
			Errors::setError('Can not change table type');
			return false;
		}

			// check duplication
		if( !$this -> checkAlterTable())
		{
			return false;
		}

		$table_name_begin = FSInput::get('table_name_begin');
//			$tablename = "fs_".$this -> type."_".$tablename;
		$table_name_begin = "fs_".$this -> type."_".$table_name_begin;

			// lấy ra danh sách trường của bảng cũ mà is_main = 1 để làm đối trọng so sánh
		$arr_field_begin_is_main = $this ->  get_extend_fields_is_main($table_name_begin);

			// rename tablename
		$this -> rename_table($tablename,$table_name_begin);

			// remove field 
		if(!$this->remove_exist_field($tablename))
		{
//				return false;
		}

			// save exist field
		if(!$this->save_exist_field($tablename)){
//				return false;
		}
//				
			// save new field	
		if(!$this->save_new_field($tablename)){
//				return false;
		}


			// sửa lại bộ lọc nếu thay đổi tên bản=================> HUY LÀM
			// sửa lại bộ lọc nếu thay đổi tên trường=================> HUY LÀM

//			$this -> remove_filter_value($tablename);
			// calculate filters:
//			$this -> caculate_filter(array($tablename))	;

			// Tính toán lại summary_auto
//			$this -> recal_summary_auto($tablename,$arr_field_begin_is_main);

		return $tablename;
	}

//		function remove_filter_value($tablename){
//			$this -> _remove('tablename = "'.$tablename.'"','fs_products_filters_values');
//		}

		/*
		 * Rename table
		 */
		function rename_table($tablename,$table_name_begin){
			if($table_name_begin == $tablename)
				return ;
			global $db;
			if( $db -> checkExistTable($tablename)){
				Errors::setError("Kh&#244;ng th&#7875; thay &#273;&#7893;i t&#234;n Table v&#236; t&#234;n table n&#224;y &#273;&#227; t&#7891;n t&#7841;i");
				return false;
			}
			// Rename table
			$sql_rename = " RENAME TABLE $table_name_begin TO $tablename ";
			$db->query($sql_rename);
			$rows = $db->affected_rows();
			
			// change in fs_pharmacology_tables
			$sql_change_table = " UPDATE  ".$this -> table_name."	 
			SET 
			table_name = '$tablename'
			WHERE table_name = '$table_name_begin' 
			";
			$db->query($sql_change_table);
			$rows = $db->affected_rows();
			if(!$rows)
			{
				Errors::setError("L&#7895;i khi update t&#234;n b&#7843;ng m&#7899;i");
				return false;
			}
			
			// change filters:
			$row['tablename'] = $tablename;
			$this -> _update($row, 'fs_'.$this -> type.'_filters','  tablename = "'.$table_name_begin.'"');
			$this -> _update($row, 'fs_'.$this -> type.'_filters_values','  tablename = "'.$table_name_begin.'"');
			$this -> _update($row, 'fs_products_categories','  tablename = "'.$table_name_begin.'"');
			$this -> _update($row, 'fs_products','  tablename = "'.$table_name_begin.'"');
			return true;
		}
		
		// Tính lại summary_auto cho bảng sản phẩm nếu ta thay đổi lại thuộc tính is_main của trường mở rộng
		function recal_summary_auto($tablename,$fields_begin){
			global $db;
			if(!$tablename)
				return;
			// danh sách trường mới có is_main = 1 	
			$fields_ext = $this->get_extend_fields_is_main ( $tablename );
			// ko có trường is_main mới nào
			if(!count($fields_ext)){
				if(count($fields_begin)){
					// xóa trắng vì mới không có mà cũ có
					$row['summary_auto'] =  null;
					$this -> _update($row, 'fs_products');
					$this -> _update($row, $tablename);
				}else{
					return;	
				}
			}

			// tính toán việc thay đổi trường is_main
			if(count($fields_ext) == count($fields_begin)){
				$arr_fields_begin = array();
				$arr_fields_ext = array();
				foreach($fields_ext as $item){
					$arr_fields_ext[] = $item -> field_name;
				}
				foreach($fields_begin as $item){
					$arr_fields_begin[] = $item -> field_name;
				}
				$compare = array_diff($arr_fields_ext,$arr_fields_begin);
				if(!count($compare))
					return false;
			}
			
			$records = $this-> get_all_record($tablename);
			foreach($records as $item){
				////////////
				$summary_auto = '';
				for($i = 0; $i < count ( $fields_ext ); $i ++) {
					$fname = strtolower ( $fields_ext [$i]->field_name );
					if (isset($item -> $fname )) {
						$ftype = $fields_ext [$i]->field_type;
						$display_name = $fields_ext [$i]->field_name_display;
						switch ($ftype) {
							case 'image' :
							break;
							case 'text' :
							$summary_auto .= '<div class="sum_item"><span class="sum_item_lb">' . $display_name . ': </span>' . $item -> $fname . '</div>';
							break;
							case 'foreign_multi' :
							$str_values = $item -> $fname;
							if (!  $str_values )
								break;
							$foreign_table_name = $fields_ext [$i]->foreign_tablename;
								// check exit extend_table
							if (! $db->checkExistTable ( $foreign_table_name ))
								break;
							$data_foreign = $this->get_records ( ' id IN (' . $str_values . ')', $foreign_table_name );
							if (! count ( $data_foreign ))
								break;
							$summary_auto .= '<div class="sum_item"><span class="sum_item_lb">' . $display_name . ': </span>';
							$s = 0;
							foreach ( $data_foreign as $foreign_item ) {
								if ($s > 0)
									$summary_auto .= ', ';
								$summary_auto .= $foreign_item->name;
								$s ++;
							}
							$summary_auto .= '</div>';
							break;
							case 'foreign_one' :
							$values = $item -> $fname;
							if (!  $values )
								break;

							$foreign_table_name = $fields_ext [$i]->foreign_tablename;								
								// check exit extend_table
							if (! $db->checkExistTable ( $foreign_table_name ))
								break;
							$data_foreign = $this->get_record ( ' id =  ' . $values . '', $foreign_table_name );
							if (! $data_foreign)
								break;
							$summary_auto .= '<div class="sum_item"><span class="sum_item_lb">' . $display_name . ': </span>' . $data_foreign->name;
							$summary_auto .= '</div>';
							break;
							case 'datetime' :
							$summary_auto .= '<div class="sum_item"><span class="sum_item_lb">' . $display_name . ': </span>' . $item -> $fname  . '</div>';
							break;
							default :
							$summary_auto .= '<div class="sum_item"><span class="sum_item_lb">' . $display_name . ': </span>' . $item -> $fname  . '</div>';
							break;

						}
					}
				}
				$row['summary_auto'] =  $summary_auto;
				$this -> _update($row, 'fs_products','id='.$item -> record_id);
				$this -> _update($row, $tablename,'id='.$item -> id);
			}
			return;
		}
		
		/*
		 * Lấy các trường is_main trong bảng mở rộng
		 */
		function get_extend_fields_is_main ( $tablename ){
			global $db;
			if ($tablename == 'fs_products' || $tablename == '')
				return;
			
			$query = " SELECT * 
			FROM fs_products_tables
			WHERE table_name =  '$tablename' 
			AND is_main  = 1 ";
			$sql = $db->query ( $query );
			$result = $db->getObjectList ();
			return $result;
		}
		
		/*
		 * created table
		 * 
		 */
		function  createTable($table_name){
			$fields_default = $this -> get_default_fields_in_extends();
			$arr_insert_table = array();
			$str_add = '';
			$str_add .= '`id` int(11) NOT NULL auto_increment,';
			$str_add .= '`record_id` int(11) ,';
			
			foreach($fields_default as $field){
				$name  = $field->field_name;
				$show  = $field->field_name_display;
				$ftype = $field->field_type; 
				if(!$name){
					continue;
				}
				if($name == 'id' || $name == 'record_id' || $name == 'tablename'){
					continue;
				}
				if($name == 'published'){
					$str_add .= '`published` tinyint(4),';
					continue;
				}
				switch ($ftype)
				{
					case 'int':
					$type = "INT(11)";
					break;
					case 'float':
					$type = "FLOAT(11)";
					break;
					case 'double':
					$type = "DOUBLE(11,0)";
					break;
					case 'varchar':
					$type = "VARCHAR(255)";
					break;
					case 'text':
					$type = "TEXT";
					break;
					case 'image':
					$type = "VARCHAR(255)";
					break;
					case 'datetime':
					$type = "DATETIME";
					break;
					default:
					$type = "VARCHAR(255)";
					break;
				}
				$str_add .= '`'.$name.'` '.$type.',';
			}
			
			global $db;
			$sql = " CREATE TABLE  IF NOT EXISTS `$table_name` 
			(".$str_add."										
			PRIMARY KEY  (`id`)
		) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ";
		$rs = $db->run_query($sql);
		if(!$rs)
			return false;
		return true;
	}

		/*
		 * Save new extend field
		 * 
		 */
		function save_new_field($table_name)
		{
			global $db;
			$cid = FSInput::get('cid');
			// NEW FIELD
			$new_field_total = FSInput::get('new_field_total');
			if($new_field_total)
			{
				$sql_add = "";
				$sql_insert_table = "";
				
				$arr_add = array();
				$arr_insert_table = array();
				for($i = 0 ; $i < $new_field_total ; $i ++ )
				{
					$new_fshow = FSInput::get('new_fshow_'.$i);

					$fsstring = FSFactory::getClass('FSString','','../');
					$new_fname = $fsstring -> stringStandart($new_fshow);
					$new_fname = str_replace('-','_',$new_fname);

					if($new_fname){
						$new_fname = $new_fname; // add prefix
						if($new_fname && $this -> check_valid_name($new_fname) )	
						{
							$new_ftype = FSInput::get('new_ftype_'.$i);
							switch ($new_ftype)
							{
								case 'int':
								$type = "INT(11)";
								break;
								case 'varchar':
								$type = "VARCHAR(255)";
								break;
								case 'text':
								$type = "TEXT";
								break;
								case 'image':
								$type = "VARCHAR(255)";
								break;
								case 'datetime':
								$type = "DATETIME";
								break;
								default:
								$type = "VARCHAR(255)";
								break;
							}
							$group_id = FSInput::get('new_group_id_'.$i);
							$new_fshow = FSInput::get('new_fshow_'.$i);
							$is_main = FSInput::get('new_is_main_'.$i);
							$is_filter = FSInput::get('new_is_filter_'.$i);
							$is_config = FSInput::get('new_is_config_'.$i);
							$is_price = FSInput::get('new_is_price_'.$i);
							$ordering = FSInput::get('new_ordering_'.$i);
							if($new_ftype == 'foreign_one' || $new_ftype == 'foreign_multi'){
								$foreign_id = FSInput::get('new_foreign_id_'.$i);
								$foreign = $this -> get_record_by_id($foreign_id,'fs_extends_groups');
								$foreign_name = $foreign -> name;	
								$foreign_tablename = $foreign -> table_name;
							}else{ 
								$foreign_id = '';
								$foreign_name = '';
								$foreign_tablename = '';
							}	
							$arr_insert_table[]  = 		"('$table_name','$new_fname','$new_ftype','$new_fshow','$foreign_id','$foreign_name','$foreign_tablename','$is_main','$is_filter','$is_config','$is_price','$group_id','$ordering')";
							$arr_add[] = "  ADD `$new_fname` $type ";
						}
					}
				}
				
				// alter tablename
				if(count($arr_add))
				{
					$sql_add = " ALTER TABLE  $table_name ";
					$sql_add .= implode(",", $arr_add);
					$rs = $db->query($sql_add);
//					if(!$rs)
//					{
//						Errors::setError("Kh&#244;ng alter &#273;&#432;&#7907;c table");
//						return false;
//					}
				}
				
				// insert into table ".$this -> table_name."
				if(count($arr_insert_table))
				{
					$sql_insert_table .= " INSERT INTO ".$this -> table_name." ";
					$sql_insert_table .= "		(table_name,field_name,field_type,field_name_display,foreign_id,foreign_name,foreign_tablename,is_main,is_filter,is_config,is_price,group_id,ordering) ";
					$sql_insert_table .= "		 VALUES "; 
					$sql_insert_table .= implode(",", $arr_insert_table);
					
//					echo $sql_insert_table;
//					die;
					
					$db->query($sql_insert_table);
					$rs = $db->insert();
					if(!$rs)
					{
						Errors::setError("Kh&#244;ng insert &#273;&#432;&#7907;c v&#224;o fs_pharmacology_tables");
						return false;
					}
				}
				
			}
			return true;
		}
		
		/*
		 * Remove field in table
		 */
		function remove_exist_field($tablename)
		{
			global $db;
			$field_remove = trim(FSInput::get('field_remove'));
			if($field_remove)
			{
				$array_field_remove = explode(",",$field_remove);
				if(count($array_field_remove ) > 0)
				{
					$sql_alter = " ALTER TABLE  $tablename ";
					
					$arr_sql_drop = array();
					$arr_fname_remove = array();
					for($i = 0 ; $i < count($array_field_remove) ; $i ++)
					{
						if($array_field_remove[$i])
						{
							$arr_sql_drop[] = " DROP `".$array_field_remove[$i]."`";// add prefix
							$arr_fname_remove[] = "'".$array_field_remove[$i]."'"; // add prefix
						} 
					}
					$sql_drop = implode(",",$arr_sql_drop)	;
					$sql_alter .= 	$sql_drop;
					
					// remove in ".$this -> table_name."
					$sql_remove = " DELETE FROM  ".$this -> table_name."
					WHERE table_name =  '$tablename' 
					AND field_name IN (".implode(",",$arr_fname_remove).") ";					
					// remove from database
					$db->query($sql_remove);
					$rows = $db->affected_rows();
					if(!$rows)
					{
						Errors::setError("L&#7895;i x&#7843;y ra khi remove trong table ".$this -> table_name."");
						return false;
					}
					
					
					// remove filter follow field
					$sql_remove = " DELETE FROM  fs_".$this -> type."_filters
					WHERE tablename =  '$tablename' 
					AND field_name IN (".implode(",",$arr_fname_remove).") ";					
					// remove from database
					$db->query($sql_remove);
					$rows = $db->affected_rows();
					if(!$rows){
//						Errors::setError("L&#7895;i x&#7843;y ra khi remove bộ lọc trong table fs_pharmacology_filters");
//						return false;
					}
					
					
					// alter
					$rs = $db->query($sql_alter);
					if(!$rs)
					{
						Errors::setError("L&#7895;i x&#7843;y ra khi alter nh&#7857;m remove c&#225;c field");
						return false;
					}
				}
			}
			return true;
		}
		/*
		 * Save exist extend field
		 */
		function save_exist_field($table_name)
		{
			global $db;
			
			// EXIST FIELD
			$field_extend_exist_total = FSInput::get('field_extend_exist_total');
			
			$sql_alter = "";
			$arr_sql_alter = array();
			
			for($i= 0 ; $i < $field_extend_exist_total ; $i++)
			{
				$sql_update = " UPDATE ".$this -> table_name."
				SET ";
				
				$fshow_exist = FSInput::get('fshow_exist_'.$i);
				$fshow_exist_begin = FSInput::get('fshow_exist_'.$i.'_begin');
				
//				$fname_exist = FSInput::get('fname_exist_'.$i);
				$fsstring = FSFactory::getClass('FSString','','../');
				$fname_exist = FSInput::get('fname_exist_'.$i);
				if(!$fname_exist)
					$fname_exist = $fshow_exist;
				$fname_exist = $fsstring -> stringStandart($fname_exist);
				$fname_exist = str_replace('-','_',$fname_exist);
				$fname_exist_begin = FSInput::get('fname_exist_'.$i."_begin");
				
				$ftype_exist = FSInput::get('ftype_exist_'.$i);
				$ftype_exist_begin = FSInput::get('ftype_exist_'.$i.'_begin');
				
				$group_id_exist = FSInput::get('group_id_exist_'.$i);
				$group_id_exist_begin = FSInput::get('group_id_exist_'.$i.'_begin');
				
//				$fshow_exist = FSInput::get('fshow_exist_'.$i);
//				$fshow_exist_begin = FSInput::get('fshow_exist_'.$i.'_begin');
				
				$is_main = FSInput::get('is_main_exist_'.$i);
				$is_main_begin = FSInput::get('is_main_'.$i.'_begin');
				
				$is_filter = FSInput::get('is_filter_exist_'.$i);
				$is_filter_begin = FSInput::get('is_filter_'.$i.'_begin');
				
				$is_config = FSInput::get('is_config_exist_'.$i);
				$is_config_begin = FSInput::get('is_config_'.$i.'_begin');

				$is_price = FSInput::get('is_price_exist_'.$i);
				$is_price_begin = FSInput::get('is_price_'.$i.'_begin');
				
				$foreign_id = FSInput::get('foreign_id_exist_'.$i);
				$foreign_id_begin = FSInput::get('foreign_id_'.$i.'_begin');
				
				$ordering = FSInput::get('ordering_exist_'.$i);
				$ordering_begin = FSInput::get('ordering_'.$i.'_begin');
				
				if($fname_exist)
				{
					
					if( ($fname_exist != $fname_exist_begin) || ($ftype_exist != $ftype_exist_begin) || ($is_main != $is_main_begin) || ($is_filter != $is_filter_begin)  || ($is_config != $is_config_begin)
						|| ($fshow_exist != $fshow_exist_begin) || ($group_id_exist != $group_id_exist_begin) || ($foreign_id != $foreign_id_begin)
						|| ($ordering != $ordering_begin)
					)
					{
						switch ($ftype_exist)
						{
							case 'int':
							$type = "INT(11)";
							break;
							case 'varchar':
							$type = "VARCHAR(255)";
							break;
							case 'text':
							$type = "TEXT";
							break;
							case 'datetime':
							$type = "DATETIME";
							break;
							case 'image':
							$type = "VARCHAR(255)";
							break;
							case 'foreign_one':
							$type = "VARCHAR(255)";
							break;
							case 'foreign_multi':
							$type = "VARCHAR(255)";
							break;
							default:
							$type = "VARCHAR(255)";
							break;
						}
						$arr_sql_alter[]  = " CHANGE `$fname_exist_begin`  `$fname_exist` $type ";
						
						// update
						$sql_update .= " 	field_name = '$fname_exist',
						field_name_display = '$fshow_exist', 
						field_type = '$ftype_exist',
						is_main = '$is_main',
						is_filter = '$is_filter',
						is_config = '$is_config',
						is_price = '$is_price',
						";
						// update foreign
						if($ftype_exist == 'foreign_multi' || $ftype_exist == 'foreign_one'){
							$foreign = $this -> get_record_by_id($foreign_id,'fs_extends_groups');
							$sql_update .= " foreign_id = '$foreign_id',
							foreign_name = '".$foreign -> name."',	
							foreign_tablename = '".$foreign -> table_name."',	
							";
						}
						
						$sql_update .= " group_id = '$group_id_exist',
						ordering = '$ordering'
						WHERE table_name = '$table_name'
						AND field_name = '$fname_exist_begin' ";
						$db->query($sql_update);
						$rows = $db->affected_rows();
						
						// update filter
						$sql_filter_update = " UPDATE fs_products_filters SET	field_name = '$fname_exist' WHERE tablename = '$table_name' AND field_name = '$fname_exist_begin'   ";
						$db->query($sql_filter_update);
						$rs = $db->affected_rows();
						
						$this -> change_extend_data_type($ftype_exist,$ftype_exist_begin,$fname_exist,$table_name);
					}
					else
					{
//						if($fshow_exist != $fshow_exist_begin)
//						{
//							$sql_update .= " 	
//											field_name_display = '$fshow_exist'											
//										WHERE table_name = '$table_name'
//										AND field_name = '$fname_exist_begin' ";
//							$db->query($sql_update);
//							$rows = $db->affected_rows();
//						}
					}
				}
			}
			if(count($arr_sql_alter))
			{
				$sql_alter = " ALTER TABLE  $table_name ";
				$sql_alter .= implode(",", $arr_sql_alter);
				$rs = $db->query($sql_alter);
				if(!$rs)
					return false;
			}
			return true;
			
			// END EXIST FIELD
		}
		
		function change_extend_data_type($ftype_exist,$ftype_exist_begin,$fname_exist,$table_name){
			if($ftype_exist == $ftype_exist_begin)
				return;
			if($ftype_exist == 'foreign_one'){
				if($ftype_exist_begin == 'foreign_multi'){
					$list = $this -> get_records($fname_exist .' LIKE "%,%" ',$table_name, 'id,'.$fname_exist);
					foreach($list as $item){
						// BỎ dấu "," đi, lấy con số đầu tiên. VD: ',4,7,9' => 4
						$str = $item -> $fname_exist;
						preg_match('#\,([0-9]*?)\,#is',$str,$new_item);
						if(isset($new_item[1])){
							$row = array();
							$row[$fname_exist] = $new_item[1];
							$this -> _update($row, $table_name,' id = '.$item -> id);
						}
					}
				}else{
					$row = array();
					$row[$fname_exist] = NULL;
					$this -> _update($row, $table_name);
				}
			}elseif($ftype_exist == 'foreign_multi'){
				if($ftype_exist_begin == 'foreign_one'){
					
					$sql = 'UPDATE '.$table_name.'
					SET '.$fname_exist.' = CONCAT(",", '.$fname_exist.', ",")
					WHERE '.$fname_exist.' <> "" AND '.$fname_exist.' IS NOT NULL ';
					global $db;
					$db->query($sql);
					$rows = $db->affected_rows();
					
				}else{
					$row = array();
					$row[$fname_exist] = NULL;
					$this -> _update($row, $table_name);
				}
			}else{
				if($ftype_exist_begin == 'foreign_one' || $ftype_exist_begin == 'foreign_multi' ){
					$row = array();
					$row[$fname_exist] = NULL;
					$this -> _update($row, $table_name);
				}else{
				}
			}
		}
		
		/*
		 * check Atler table
		 */
		function checkAlterTable()
		{
			$fields_default = $this -> get_default_fields_in_extends();
			$array_fields_default = array('id','record_id');
			foreach($fields_default as $field)
				$array_fields_default[]  = $field->field_name;


			// exist field                           
			$field_extend_exist_total = FSInput::get('field_extend_exist_total');
			for($i= 0 ; $i < $field_extend_exist_total ; $i++)
			{                                       
				$extend_fname_exist = FSInput::get('fname_exist_'.$i);
				$extend_fshow_exist = FSInput::get('fshow_exist_'.$i);
				if($extend_fname_exist)
				{
					if(in_array(strtolower(trim($extend_fname_exist)),$array_fields_default))
					{
						Errors::setError("Tr&#432;&#7901;ng b&#7883; tr&#249;ng v&#7899;i t&#234;n m&#7863;c &#273;&#7883;nh");
						return false;
					}
					$array_name[] = trim($extend_fname_exist);
				}

				if($extend_fshow_exist)
				{
					$array_show[] = trim($extend_fshow_exist);
				}
			}


			
			// new field
			$new_field_total = FSInput::get('new_field_total');
			if($new_field_total)
			{
				for($i = 0 ; $i < $new_field_total ; $i ++ )
				{
					$new_field_name = FSInput::get('new_fname_'.$i);
					$new_field_show = FSInput::get('new_fshow_'.$i);
					
					if($new_field_name)
					{
						if(in_array(strtolower(trim($new_field_name)),$array_fields_default))
						{
							Errors::setError("Tr&#432;&#7901;ng b&#7883; tr&#249;ng v&#7899;i t&#234;n m&#7863;c &#273;&#7883;nh");
							return false;
						}
						$array_name[] = trim($new_field_name);
					}

					
					
					if($new_field_show)
					{
						$array_show[] = trim($new_field_show);
					}	
				}
			}

			// printr($array_show);
			
			$length = count($array_name);
			$length_unique = count(array_unique($array_name));
			if($length_unique < $length)
			{
				Errors::setError("Có tên trường bị lặp");
				return false;
			}

			$length1 = count($array_show);
			$length_unique1 = count(array_unique($array_show));
			if($length_unique1 < $length1)
			{
				Errors::setError("Có tên hiển thị bị lặp");
				return false;
			}
			return true;
		}
		
		function remove(){

			$tablenames = FSInput::get('cid',array(),'array');


			// remove tabe EXTENTION
			// remove in 2 table:  PRODUCTS AND TABLE IMAGE
			if(count($tablenames))
			{
				// array table_names is changed. ( for calculate filter)
				$arr_table_name_changed = array();	
				
				global $db;
				$str_tablenames = ''; 
				for($i = 0; $i < count($tablenames) ; $i ++){

					// printr($tablenames[$i]);
					$count_data  = $this->get_records('',$tablenames[$i],'id');
					if(!empty($count_data)){
						$msg = "Bảng ".$tablenames[$i]." đã có dữ liệu nên không thể xóa.";
						$link ='index.php?module='.$this -> module.'&view='.$this -> view;
						setRedirect($link,FSText :: _($msg),'error');
					}
					if($i > 0)
						
						$str_tablenames .= ',';
					$str_tablenames .= "'".$tablenames[$i]."'";
	        			// calculate filter:
					$arr_table_name_changed[] = $tablenames[$i];
					


				}
				
				$sql = " DELETE FROM ".$this -> table_name."
				WHERE table_name IN ( $str_tablenames )  " ;
				// $db->query($sql);
				if(!$db->affected_rows($sql)){
					return false;
				}
				
				$sql_drop = " DROP TABLE  IF EXISTS  ".implode(",",$tablenames)." ";
				$db->query($sql_drop);
				$db->affected_rows();
				
				// remove filters:
				$this -> _remove(" tablename IN (".$str_tablenames.") ",'fs_'.$this -> type.'_filters') ;
				$this -> _remove(" tablename IN (".$str_tablenames.") ",'fs_'.$this -> type.'_filters_values') ;
				
				return true;
			}
			
			return false;
		}
		
		function get_group_field(){
			$query = " SELECT *
			FROM fs_".$this -> type."_fields_groups	 ";
			
			global $db;
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		/*
		 * Get table extend
		 */
		function get_foreign_data(){
			$query = " 	   SELECT *
			FROM fs_extends_groups AS a 
			";
			global $db;
			$db->query($query);
			$list = $db->getObjectList();
			return $list;
		}
		
		function get_default_fields_in_extends(){
			$where = ' type = "'.$this -> type.'"  ';
			return $this -> get_records($where, 'fs_tables');
		}
		
		/*
		 * duplicate table
		 */
		function duplicate(){
			$tablenames = FSInput::get('cid',array(),'array');
			if(!count($tablenames))
				return false;
			global $db;
			$str_tablenames = ''; 
			$rs = 0;
			for($i = 0; $i < count($tablenames) ; $i ++){
				$table_name = $tablenames[$i];
				$table_name_new = '';
				$j = 0;
				while(true)	{
					if(!$j){
						$table_name_new = $table_name.'_copy';
					} else { 
						$table_name_new = $table_name.'_copy'.$j;
					}
					$where = table_name.' = "'.$table_name_new.'" ';
					$check_exist = $this -> get_count($where,$this -> table_name);
					if(!$check_exist){
						break;
					}
					$j ++;
				}
				// create table
				if(!$this -> createTable($table_name_new))
					continue;
				$fields = $this -> get_records(' table_name ="'.$table_name.'"', $this -> table_name);	
				// add field not default and insert into table fs_TYPE_tables
				if(!$this -> duplicate_add_new_field($table_name_new,$fields))
					continue;

				$rs ++; 	
			}
			return $rs;
		}
		
	/*
		 * Save new extend field for task: DUPLICATE
		 * 
		 */
	function duplicate_add_new_field($table_name,$fields = array())
	{
		if(!count($fields))
			return;
		global $db;

		$sql_add = "";
		$sql_insert_table = "";

		$arr_add = array();
		$arr_insert_table = array();
		foreach($fields as $field){
			$new_fname = $field -> field_name;
			$new_ftype = $field -> field_type;
			$new_fshow = $field -> field_name_display;
			$group_id = $field -> group_id;
			$is_main = $field -> is_main;
			$is_filter = $field -> is_filter;
			$is_config = $field -> is_config;
			$is_compare = $field -> is_compare;
			$ordering = $field -> ordering;
			$foreign_id = $field -> foreign_id; 
			$foreign_name = $field -> foreign_name; 
			$foreign_tablename = $field -> foreign_tablename; 

			if(!$new_fname){
				continue;	
			}	
			switch ($new_ftype)
			{
				case 'int':
				$type = "INT(11)";
				break;
				case 'varchar':
				$type = "VARCHAR(255)";
				break;
				case 'text':
				$type = "TEXT";
				break;
				case 'image':
				$type = "VARCHAR(255)";
				break;
				case 'datetime':
				$type = "DATETIME";
				break;
				default:
				$type = "VARCHAR(255)";
				break;
			}
			$arr_insert_table[]  = 		"('$table_name','$new_fname','$new_ftype','$new_fshow','$foreign_id','$foreign_name','$foreign_tablename','$is_main','$is_filter','$is_config','$is_compare','$group_id','$ordering')";
			$arr_add[] = "  ADD `$new_fname` $type ";
		}

			// alter tablename
		if(count($arr_add))
		{
			$sql_add = " ALTER TABLE  $table_name ";
			$sql_add .= implode(",", $arr_add);

			$rs = $db->query($sql_add);
			if(!$rs)
			{
				Errors::setError("Kh&#244;ng alter &#273;&#432;&#7907;c table");
				return false;
			}
		}

			// insert into table ".$this -> table_name."
		if(count($arr_insert_table))
		{
			$sql_insert_table .= " INSERT INTO ".$this -> table_name." ";
			$sql_insert_table .= "		(table_name,field_name,field_type,field_name_display,foreign_id,foreign_name,foreign_tablename,is_main,is_filter,is_config,is_compare,group_id,ordering) ";
			$sql_insert_table .= "		 VALUES "; 
			$sql_insert_table .= implode(",", $arr_insert_table);

			$db->query($sql_insert_table);
			$rs = $db->insert();
			if(!$rs)
			{
				Errors::setError("Kh&#244;ng insert &#273;&#432;&#7907;c v&#224;o fs_pharmacology_tables");
				return false;
			}
		}

		return true;
	}
}

?>