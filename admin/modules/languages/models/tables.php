<?php 
	class LanguagesModelsTables  extends FSModels
	{
		function getTables()
		{
			global $db;
			$query = $this->setQuery();
			if(!$query)
				return array();
				
			$sql = $db->query($query);
			$result = $db->getObjectList();
			
			return $result;
		}
		function get_languages(){
			global $db;
			$query = " SELECT *
						  FROM 
						  	fs_languages AS a
						  	WHERE is_default <> 1
						 ";
			$sql = $db->query($query);
			$result = $db->getObjectList();
			
			return $result;
		}
		
		function setQuery()
		{
			
			$query = " SELECT a.*
						  FROM 
						  	fs_languages_tables AS a
						  	WHERE published = 1
						  	ORDER BY ordering ASC, name ASC
						 ";
						
			return $query;
		}
		
		function getTable($id)
		{
			if(!$id){
				return;
			}
			global $db;
			
			$query = " SELECT a.*
						  FROM 
						  	fs_languages_tables AS a
						  WHERE id = $id
						 ";
			$sql = $db->query($query);
			$result = $db->getObject();
			
			return $result;
		}
		
		function synchronize(){
			$table_id = FSInput::get('id',0,'int');
			$copy = FSInput::get('copy',0,'int');
			$lang_sort = FSInput::get('syn_lang');
			if(!$table_id || !$lang_sort)
				return;
			$table = $this ->getTable($table_id);	
			$table_name = $table -> table_name;			
			
			$this -> synchronize_table($table_name, $table_name.'_'.$lang_sort );
			$this -> remove_data_excess($table_name, $table_name.'_'.$lang_sort );
			$this -> synchronize_data($table_name, $table_name.'_'.$lang_sort ,$copy,$lang_sort);
			
			return true;
		}
		
		/*
		 * Copy data
		 * Only for language default
		 * copy from fs_data to fs_data_lang
		 */
		function copy(){
			$table_id = FSInput::get('id',0,'int');
			$lang_sort = FSInput::get('lang');
			if(!$table_id || !$lang_sort)
				return;
			$table = $this ->getTable($table_id);	
			$table_name = $table -> table_name;			
			
			$this -> synchronize_table($table_name, $table_name.'_'.$lang_sort );
			$this -> remove_data_excess($table_name, $table_name.'_'.$lang_sort );
			$this -> copy_data($table_name, $table_name.'_'.$lang_sort);
			
			return true;
		}
		
		function synchronize_table($table_old,$table_new){
			global $db;
			if(!$db -> checkExistTable($table_new)){
				$this -> create_table($table_old,$table_new);	
				return true;
			} else {
				$this -> change_table($table_old,$table_new);
				return true;	
			}
		}
		function synchronize_data($table_name_old, $table_name_new ,$copy = 1,$lang_sort){
			$data_old = $this -> get_all_data($table_name_old);
			$fields_in_table = $this -> get_field_table($table_name_old);
			$table_config = $this -> get_record('table_name = "'.$table_name_old.'"','fs_languages_tables');
			global $db; 
			for($i = 0; $i < count($data_old); $i ++){
				$item = $data_old[$i];
				$record_new = $this -> get_data($table_name_new,$item -> id);
				// update
				if(@$record_new -> id){
					$str_update = array();
					for($j = 0; $j < count($fields_in_table); $j ++){
						
						// create sql update
						
						$field = $fields_in_table[$j];
						$type = $field -> Type;
						$field_name  = $field -> Field;
						
						if(strpos($table_config -> field_synchronize, ','.$field_name.',') !== false){
							$str_update[] = "`".$field_name."` = '".$item -> $field_name."'";
						}else if($field_name == 'images' || $field_name == 'image' || $field_name == 'picture' || $field_name == 'img'|| $field_name == 'pictures' ){
							$str_update[] = "`".$field_name."` = '".$item -> $field_name."'";
						} else if(strpos($type,'text') !== false || strpos($type,'varchar') !== false){
							continue	;
						}else {
							$str_update[] = "`".$field_name."` = '".$item -> $field_name."'";
						}
					}
					$str_update = implode(',',$str_update);
					
					$sql = ' UPDATE  '.$table_name_new .  ' SET ';
					$sql .=  $str_update;
					$sql .=  ' WHERE rid = 	  '.$record_new -> rid.' ';
					// $db->query($sql);
					$rows = $db->affected_rows($sql);
					if($rows){
						// update các bảng cần đồng bộ khác ( VD: fs_news from fs_news_categories)
						if($table_config -> field_outer_change){
							$fields_outer_change = $this -> get_field_outer_change($table_config);
							$this -> change_outer($table_name_old,$fields_outer_change,$record_new -> rid,$lang_sort);
						}						
					}

				} 
				else { // insert
					$str_fields = array();
					$str_values = array();
					for($j = 0; $j < count($fields_in_table); $j ++){
						$field = $fields_in_table[$j];
						$type = $field -> Type;
						$field_name  = $field -> Field;
						if($field_name == 'images' || $field_name == 'image' || $field_name == 'picture' || $field_name == 'img'|| $field_name == 'pictures' ){
							$str_fields[] =  "`".$field_name."`";
							$str_values[] =  "'".$item -> $field_name."'";
						} else {
							if(strpos($type,'text') !== false){
								if($copy){
									$str_fields[] =  "`".$field_name."`";
									$str_values[] =  "'".$item -> $field_name."'";
								}
							} else if(strpos($type,'varchar') !== false){
								if($copy){
									$str_fields[] =  "`".$field_name."`";
									$str_values[] =  "'".$item -> $field_name."'";
								}
							} else {
								$str_fields[] =  "`".$field_name."`";
								$str_values[] =  "'".$item -> $field_name."'";
							}
						} 
					}
					$str_fields = implode(',',$str_fields);
					$str_values = implode(',',$str_values);
					
					$sql = ' INSERT INTO  '.$table_name_new . ' ';
					$sql .=  '('.$str_fields.") ";
					$sql .=  'VALUES ('.$str_values.") ";
					
					
					//$db->query($sql);
					$id = $db->insert($sql);
				}
			}
		}
		
		/*
		 * Copy data
		 */
		function copy_data($table_name_old, $table_name_new){
			$data_old = $this -> get_all_data($table_name_old);
			$fields_in_table = $this -> get_field_table($table_name_old);
			global $db; 
			for($i = 0; $i < count($data_old); $i ++){
				$item = $data_old[$i];
				$record_new = $this -> get_data($table_name_new,$item -> id);
				// update
				if(@$record_new -> id){
					$str_update = array();
					for($j = 0; $j < count($fields_in_table); $j ++){
						
						// create sql update
						
						$field = $fields_in_table[$j];
						$type = $field -> Type;
						$field_name  = $field -> Field;
//						if($field_name == 'images' || $field_name == 'image' || $field_name == 'picture' || $field_name == 'img'|| $field_name == 'pictures' ){
//							$str_update[] = "`".$field_name."` = '".$item -> $field_name."'";
//						} else {
							if(strpos($type,'text') !== false ){
								$str_update[] = "`".$field_name."` = '".$item -> $field_name."'";	
							} else {
								$str_update[] = "`".$field_name."` = '".$item -> $field_name."'";
							}
//						} 
						// end create sql update
					}
					$str_update = implode(',',$str_update);
					
					$sql = ' UPDATE  '.$table_name_new .  ' SET ';
					$sql .=  $str_update;
					$sql .=  ' WHERE rid = 	  '.$record_new -> rid.' ';
					//$db->query($sql);
					$rows = $db->affected_rows($sql;
					
				} 
				else { // insert
					$str_fields = array();
					$str_values = array();
					for($j = 0; $j < count($fields_in_table); $j ++){
						$field = $fields_in_table[$j];
						$type = $field -> Type;
						$field_name  = $field -> Field;
//						if($field_name == 'images' || $field_name == 'image' || $field_name == 'picture' || $field_name == 'img'|| $field_name == 'pictures' ){
//							$str_fields[] =  "`".$field_name."`";
//							$str_values[] =  "'".$item -> $field_name."'";
//						} else {
							if(strpos($type,'text') !== false){
//								if($copy){
									$str_fields[] =  "`".$field_name."`";
									$str_values[] =  "'".$item -> $field_name."'";
//								}
							} else {
								$str_fields[] =  "`".$field_name."`";
								$str_values[] =  "'".$item -> $field_name."'";
							}
							
//							else if(strpos($type,'varchar') !== false){
//								if($copy){
//									$str_fields[] =  "`".$field_name."`";
//									$str_values[] =  "'".$item -> $field_name."'";
//								}
//							} else {
//								$str_fields[] =  "`".$field_name."`";
//								$str_values[] =  "'".$item -> $field_name."'";
//							}
//						} 
					}
					$str_fields = implode(',',$str_fields);
					$str_values = implode(',',$str_values);
					
					$sql = ' INSERT INTO  '.$table_name_new . ' ';
					$sql .=  '('.$str_fields.") ";
					$sql .=  'VALUES ('.$str_values.") ";
					
					
					//$db->query($sql);
					$id = $db->insert($sql);
				}
			}
		}
		
		/*
		 * Remove data excess from table_name_new
		 */
		function remove_data_excess($table_name_old, $table_name_new){
			$query = " SELECT id
						  FROM 
						  	".$table_name_old ." 
						  	
						 ";
			global $db;
			$sql = $db->query($query);
			$list = $db->getObjectList();
			$str_ids  = '';
			for($i = 0; $i < count($list) ;$i ++ ){
				if($i > 0)
					$str_ids .= ','; 
				$str_ids .= $list[$i]->id;
			}
			if(!$str_ids)	
				return;
			$sql = " DELETE FROM ".$table_name_new."
						WHERE id NOT IN ( $str_ids ) " ;	
			//$db->query($sql);
			$rows = $db->affected_rows($sql);
			return $rows;
		}
		
		function get_all_data($table_name){
			if(!$table_name)
				return;
			global $db;
			$query = " SELECT a.*
						  FROM 
						  	".$table_name ." AS a
						 ";
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		
		function get_data($table_name,$id){
			if(!$id || !$table_name){
				return;
			}
			global $db;
			if(!$db -> checkExistTable($table_name))
				return ;
			
			$query = " SELECT a.*
						  FROM 
						  	".$table_name ." AS a
						  WHERE id = $id
						 ";
			$sql = $db->query($query);
			$result = $db->getObject();
			return $result;
		}

		function create_table($table_old,$table_new){
			global $db;
			
			$fields_in_table = $this -> get_field_table($table_old);
			
			$sql_create = " CREATE TABLE `".$table_new."` (
  								`rid` int(11) NOT NULL auto_increment, ";
			for($i = 0; $i < count($fields_in_table); $i ++ ){
				$item = $fields_in_table[$i];
				$sql_create .= ' `'.$item -> Field.'` ' . $item -> Type ;
				if($item -> Null == 'YES'){
					$sql_create .= ' default NULL,';
				} else {
					$sql_create .= ' NOT NULL,';
				}
			}
			
			$sql_create .= " PRIMARY KEY  (`rid`)
								) ENGINE=MyISAM  DEFAULT CHARSET=utf8; ";
			$rs = $db->query($sql_create);
			if(!$rs)
				return false;
			return true;
		}
		
		/*
		 * Change table old and new
		 * add field new for new table
		 * change type for  field
		 */
		function change_table($table_old,$table_new){
			global $db;
			
			$fields_in_table_old = $this -> get_field_table($table_old);
			$fields_in_table_new = $this -> get_field_table($table_new);
			
			$str_alter = array();
			
			// remove
			for($i = 0; $i < count($fields_in_table_new); $i ++){
				$item_new = $fields_in_table_new[$i];
				if($item_new  -> Field == 'rid' || $item_new  -> Field == 'id')
					continue;
				$exist = 0;
				for($j = 0; $j < count($fields_in_table_old); $j ++){
					$item_old = $fields_in_table_old[$j];
					if($item_new -> Field == $item_old -> Field){
						$exist ++;
						break;
					}
				}
				if(!$exist  ){
					$str_alter[] = " DROP `".$item_new -> Field."`";
				}
			}
			
			
			// add and change
			for($i = 0; $i < count($fields_in_table_old); $i ++){
				$item_old = $fields_in_table_old[$i];
				$exist = 0;
				for($j = 0; $j < count($fields_in_table_new); $j ++){
					$item_new = $fields_in_table_new[$j];
					if($item_old -> Field== $item_new -> Field){
						if($item_old -> Type != $item_new -> Type){
							$str_alter[] = 'CHANGE '.$item_new -> Field.' '.$item_new -> Field.' '.$item_old -> Type;
						}
						$exist ++	;
						break;
					}
				}
				if(!$exist){
					$str_alter[] = "  ADD `".$item_old -> Field."` ".$item_old -> Type ." ";
				}
			}
			
			
			if(count($str_alter))
			{
				$sql_alter = " ALTER TABLE  ".$table_new ." ";
				$sql_alter .= implode(",", $str_alter);
				
				$rs = $db->query($sql_alter);
				if(!$rs)
					return false;
			}
			return true;
			
		}
		
		function get_field_table($table_name){
			global $db;
			$query = "SHOW COLUMNS FROM ".$table_name." ";
			$db->query($query);
			$fields_in_table = $db->getObjectList();
			return $fields_in_table;
		}
		
		/*
		 * Sinh ra mảng các trường cần thay đổi ở bảng ngoài (synchronize)
		 */
		function get_field_outer_change($table, $field = 'field_outer_change'){
			$outer = $table -> $field;
			if(!$outer)
				return;
			$arr_fields_outer = explode(';', $outer);
			if(!count($arr_fields_outer)) 
				return;
			$rs = array();
			foreach($arr_fields_outer as $item){
				$item = trim($item);
				if(!$item || empty($item))
					continue;
				$arr_f = explode('=>', $item);
				$field_outer_change = $arr_f[0];
				$arr_follow = explode('|', $arr_f[1]);
				$field_inner_from = $arr_follow[0];
				$table_outer = $arr_follow[1];
				$function_call = $arr_follow[2];
				$field_compare_inner = $arr_follow[3];// trường so sánh inner lấy ra để làm mệnh đề where
				$field_compare_outer = $arr_follow[4];// trường so sánh outer  lấy ra để làm mệnh đề where
				$follow = array('field_inner_from' =>$field_inner_from,'table_outer' => $table_outer ,'function_call' => $function_call,'field_compare_inner' => $field_compare_inner,'field_compare_outer' => $field_compare_outer  );
				$rs[$field_outer_change] = 	$follow;
			}
			return $rs;
		}
		/*
		 * Thay đổi các bảng bên ngoài
		 */
		function change_outer($table_inner,$fields_outer_change,$record_id,$lang_sort){
			$record = $this -> get_record('rid = '.$record_id,$table_inner.'_'.$lang_sort);
			foreach($fields_outer_change as $field_outer_change => $item){
				$table_outer = $item['table_outer'];
				$field_inner_from = $item['field_inner_from'];
				$function_call = trim($item['function_call']);
				$field_compare_inner = $item['field_compare_inner'];
				$field_compare_outer = $item['field_compare_outer'];
				if($function_call){
					// writing...
				}else{
					$row = array();
					$row[$field_outer_change] = $record -> $field_inner_from;
					$this -> _update($row,$table_outer.'_'.$lang_sort,' '.$field_compare_outer.' = "'.$record -> $field_compare_inner.'"');
				}
			}
		}
	}
	
?>