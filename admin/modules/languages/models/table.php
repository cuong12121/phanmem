<?php 
	class LanguagesModelsTable extends FSModels
	{
		var $limit;
		var $page;
		function __construct()
		{
			parent::__construct();
			$limit = 30;
//			$page = FSInput::get('page');
			$this->limit = $limit;
//			$this->page = $page;
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
		function get_language_by_id($id)
		{
			if(!$id){
				return;
			}
			global $db;
			
			$query = " SELECT a.*
						  FROM 
						  	fs_languages AS a
						  WHERE id = $id
						 ";
			$sql = $db->query($query);
			$result = $db->getObject();
			
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
		
		function setQuery($table,$language_not_default){
			global $db;
			$main_field = $table -> main_field_display;
			$table_name = $table -> table_name;
			$select  = '';
			$left_join = '';
			for($i = 0; $i < count($language_not_default); $i ++){
				$item = $language_not_default[$i] ;
				$table_name_language = $table_name.'_'.$item -> lang_sort;
				if($db -> checkExistTable($table_name_language)){
					$select .= ','.$table_name_language.'.'.$main_field . ' AS ' .$main_field.'_'.$item ->lang_sort;
					$left_join .= ' LEFT JOIN '.$table_name_language.' ON  '.$table_name.'.id = '.$table_name_language.'.id ';
				} else { 
					$select .= ",'' AS ".$main_field.'_'.$item ->lang_sort;
				}
			}
			$where = '';
			if($table -> where){
				$where .= ' AND '.$table -> where;
			}
			$query = " SELECT ".$table_name.".id,".$table_name.".".$main_field.$select.
					"	FROM  $table_name ".
					$left_join.
					" WHERE 1 = 1 ".$where.
					" ORDER BY ".$table_name.".id	"; 
			return $query;
		}
		
		/*
		 * Show all category of product
		 */
		function get_list($table,$language_not_default)
		{
			global $db;
			$query = $this->setQuery($table,$language_not_default);
			$sql = $db->query_limit($query,$this->limit,$this->page);
			$result = $db->getObjectList();
			
			return $result;
		}
		
		/*
		 * show total of categories
		 */
		function getTotal($table,$language_not_default)
		{
			global $db;
			$query = $this->setQuery($table,$language_not_default);
			$sql = $db->query($query);
			$total = $db->getTotal();
			return $total;
		}
		
		function getPagination($total)
		{
			$pagination = new Pagination($this->limit,$total,$this->page);
			return $pagination;
		}
		
		function get_field_table($table_name){
			global $db;
			$query = "SHOW COLUMNS FROM ".$table_name." ";
			$db->query($query);
			$fields_in_table = $db->getObjectList();
			return $fields_in_table;
		}
			
		function create_table($table_old,$table_new){
			global $db;
			if($db -> checkExistTable($table_new)){
				return true;
			}
			
//			$query = "SHOW COLUMNS FROM ".$table_old." ";
//			$db->query($query);
//			$fields_in_table = $db->getObjectList();
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
		
		/*
		 * store
		 */
		function save(){
			global $db;
			$id = FSInput::get('id',0,'int');	
			$record_id = FSInput::get('rid',0,'int');	
			
			$table_id = FSInput::get('table',0,'int');
			$table = $this -> getTable($table_id);	
			
			// danh sách các trường cần thay đổi trong cùng bảng( thay đổi đồng thời cùng lúc với save)
			$field_inner_change_simultaneously = $this -> get_field_inner_change($table,'field_inner_change_simultaneously');
			$fields_outer_change = $this -> get_field_outer_change($table);
			
			$fields_in_table = $this -> get_field_table($table -> table_name);
			
			$lang_sort = FSInput::get('lang_sort');	
			
			$data_old  = $this -> get_data($table -> table_name,$id);	
			$data_new  = $this -> get_data($table -> table_name . '_' . $lang_sort,$id);
			
			// update
			if($record_id){
				$str_update = '';
				for($i = 0; $i < count($fields_in_table); $i ++){
					$item = $fields_in_table[$i];
					$type = $item -> Type;
					$field  = $item -> Field;
					// các trường thay đổi theo mà ko phải nhập
					if(array_key_exists($field,$field_inner_change_simultaneously)){
//						$field_follow = $field_inner_change_simultaneously[$field]['field_from'];
						// writing....
					}
					if($field == 'images' || $field == 'image' || $field == 'picture' || $field == 'img'|| $field == 'pictures' ){
						$str_update .= "`".$field."` = '".$data_old -> $field."'";
					} else if(strpos($table -> field_synchronize, ','.$field.',') !== false){
						$str_update .= "`".$field."` = '".$data_old -> $field."'";
					} else if(strpos($table -> field_not_display, ','.$field.',') !== false){
						$str_update .= "`".$field."` = '".$data_old -> $field."'";
					} else {
						if(strpos($type,'text') !== false){
							$value = htmlspecialchars_decode(FSInput::get($field));
							$str_update .= "`".$field."` = '".$value."'";	
						} else if(strpos($type,'varchar') !== false){
							$value = FSInput::get($field);
							$str_update .= "`".$field."` = '".$value."'";	
						} else {
							$str_update .= "`".$field."` = '".$data_old -> $field."'";
						}
					} 
					if(($i+1) < count($fields_in_table) ){
						$str_update .= ',';
					}
				}
				
				$sql = ' UPDATE  '.$table -> table_name . '_' . $lang_sort . ' SET ';
				$sql .=  $str_update;
				$sql .=  ' WHERE rid = 	  '.$record_id.' ';
				// $db->query($sql);
				$rows = $db->affected_rows($sql);
				if($rows){
					if($fields_outer_change){
						// thay đổi bảng ngoài
						$this -> change_outer($table -> table_name,$fields_outer_change,$record_id,$lang_sort);
					}
				}
				return $rows;
			} else // insert 
			{  
				$str_fields = '';
				$str_values = '';
				for($i = 0; $i < count($fields_in_table); $i ++){
					$item = $fields_in_table[$i];
					$type = $item -> Type;
					$field  = $item -> Field;
					if($field == 'images' || $field == 'image' || $field == 'picture' || $field == 'img'|| $field == 'pictures' ){
						$str_fields .=  "`".$field."`";
						$str_values .=  "'".$data_old -> $field."'";
					} else {
						if(strpos($type,'text') !== false){
							$value = htmlspecialchars_decode(FSInput::get($field));
							$str_fields .=  "`".$field."`";
							$str_values .=  "'".$value."'";
						} else if(strpos($type,'varchar') !== false){
							$value = FSInput::get($field);
							$str_fields .=  "`".$field."`";
							$str_values .=  "'".$value."'";
						} else {
							$str_fields .=  "`".$field."`";
							$str_values .=  "'".$data_old -> $field."'";
						}
					} 
					if(($i+1) < count($fields_in_table) ){
						$str_fields .= ',';
						$str_values .= ',';
					}
				}
				
				$sql = ' INSERT INTO  '.$table -> table_name . '_' . $lang_sort . ' ';
				$sql .=  '('.$str_fields.") ";
				$sql .=  'VALUES ('.$str_values.") ";
				
				// $db->query($sql);
				$id = $db->insert($sql);
				return $id;
				
			}
		}
		
		/*
		 * Sinh ra mảng các trường cần thay đổi
		 */
		function get_field_inner_change($table, $field = 'field_inner_change_simultaneously'){
			$inner = $table -> $field;
			if(!$inner)
				return;
			$arr_fields_inner = explode(';', $inner);
			if(!count($arr_fields_inner)) 
				return;
			$rs = array();
			
			foreach($arr_fields_inner as $item){
				$item = trim($item);
				if(!$item || empty($item))
					continue;
				$arr_f = explode('=>', $item);
				$field_need_change = $arr_f[0];
				$arr_follow = explode('|', $arr_f[0]);
				$field_from = $arr_follow[0];
				if(isset($arr_follow[1]))
					$function_call = $arr_follow[1];
				else 
					$function_call = '';
				$follow = array('field_from' =>$field_from, 'function_call' => $function_call );
				$rs[$field_need_change] = 	$follow;
			}
			return $rs;
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
		
		/*
		 * **************** HÀM HỖ TRỢ DỊCH TỰ ĐỘNG **********************
		 */
		function translate_menu(){
			$field = FSInput::get('field');
			$table_name = FSInput::get('table_name');
			$record_id = FSInput::get('record_id',0,'int');
			if(!$field || !$table_name || !$record_id)
				return false;
			$data = $this -> get_record(' id= '.$record_id,$table_name);
			if(!$data)	
				return;
			$link = $data -> link;
			echo FSRoute::change_link_by_lang('en',$link);
			return;			
		}
	}
	
?>