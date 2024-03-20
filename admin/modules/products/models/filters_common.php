<?php 
	class ProductsModelsFilters_common extends FSModels
	{
		function __construct()
		{
			$calculators  = array(
//								array("1","h&#227;ng s&#7843;n xu&#7845;t"),
								2 => array("2","LIKE"),
								3 => array("3","Null"),
								4 => array("4","Not Null"),
								5 => array("5","=="),
								6 => array("6",">"),
								7 => array("7","<"),
								8 => array("8",">="),
								9 => array("9","<="),
								10 => array("10"," > value1 AND < value2"),
								11 => array("11"," > value1 AND <= value2"),
								12 => array("12"," >= value1 AND < value2"),
								13 => array("13"," >= value1 AND <= value2"),
								14 => array("14","FOREIGN_ONE"),
								15 => array("15","FOREIGN_MULTI")
							);
			$this -> type = 'products';				
			$this -> table_name = 'fs_'.$this -> type.'_filters';					
		}
		
		function getFieldList($type)
		{
			global $db;
			
			if(!$type){
				return ;
			}
			
			$query = " SELECT * FROM fs_tables
					WHERE type = '$type'
					AND field_name <> 'id' 
					AND is_filter = 1";
			$db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		
		function getFilters($module_type = 'products',$fieldname)
		{
			if(!$fieldname )
				return ;
			global $db;
			$query = " SELECT * FROM ".$this -> table_name."
					WHERE is_common = 1
					AND field_name = '$fieldname'
					AND tablename = 'fs_products'
					AND calculator <> 1 ";
			$db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		
		function get_filters_in_table(){
			global $db;
			$query = " SELECT * FROM ".$this -> table_name."
					WHERE is_common = 1
					AND tablename = 'fs_products'
					AND calculator <> 1 
					ORDER BY field_name, id";
			$db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		
		function get_count_field_by_filter_in_table(){
						global $db;
			$query = " SELECT field_name, count(*) as count_filter FROM ".$this -> table_name."
					WHERE is_common = 1
					AND calculator <> 1 
					GROUP BY field_name
					";
			$db->query($query);
			$result = $db->getObjectListByKey('field_name');
			return $result;
		}
		
		// save
		function save($row = array(), $use_mysql_real_escape_string = 1){
			
			$field_name = FSInput::get('field');

			// table show 
			$field_show = $this -> getTableShow($field_name);
			
			// field
			$field_current = $this  -> get_record(' type = "'.$this -> type.'" AND field_name = "'.$field_name.'"','fs_tables');
			// foreign:
			if(isset($field_current) && !empty($field_current) && ($field_current ->field_type == 'foreign_one' || $field_current ->field_type == 'foreign_multi')){
				// if(!$this -> save_filter_new($field_name,$field_show))
					
					
				// $this -> save_filter_edit($field_name);
					
				return $this -> save_foreign($field_current,$field_current ->field_type );				
			}else{
				
				
				if( !$this -> check_unique_alias($field_name) ){
					return false;
				}
				
				if( !$this -> save_filter_remove($field_name))
					return false;
					
				if(!$this -> save_filter_new($field_name,$field_show))
					return false;
					
				if( !$this -> save_filter_edit($field_name))
					return false;
			}
			// calculate filter:
			$this -> caculate_filter();
			return true;
		}
		
		/*
		 * Check unique for "alias"
		 */
		function check_unique_alias($field_name){
			$array_alias = array();
			// new filter
			$total = FSInput::get('filter_new_total');
			if($total){
				$arr_insert = array();
				for($i = 0 ; $i < $total ; $i ++ ){
					$alias = FSInput::get('alias_new_'.$i);
					if($alias)
						$array_alias[] = $alias;
				}
			}
			
			// exist filter
			$total = FSInput::get('filter_exist_total');
			for($i= 0 ; $i < $total ; $i++){
				$alias = FSInput::get('alias_exist_'.$i);
				if($alias)
					$array_alias[] = $alias;
			}
			$length = count($array_alias);
				
			// check unique in field			
			$array_alias = array_unique($array_alias);
			$length_unique = count($array_alias);
			if($length_unique < $length)
			{
				Errors::setError("Có sự trùng lặp tên hiệu");
				return false;
			}
			if($length > 0){
				$sql_or = '';
				$j = 0;
				foreach($array_alias as $item){
					if($j > 0)
						$sql_or .= ' OR ';
					$sql_or .= ' alias = "'.$item.'" ';
					$j ++; 
				}
				// check unique in table
				$query = 'SELECT count(*)
					FROM '.$this -> table_name.' 
					WHERE is_common = 1
					AND field_name != "'.$field_name.' " 
					AND ('.$sql_or.')
					';
				global $db;
				$sql = $db->query($query);
				$result = $db->getResult();
				if($result){
					Errors::setError("Có sự trùng lặp tên hiệu");
					return false;
				}
			}
			
			return true;
		}
		
		function save_filter_new($field_name,$field_show)
		{
			global $db;
			$fsstring = FSFactory::getClass('FSString','','../');
			// NEW FIELD
			$total = FSInput::get('filter_new_total');
			if($total)
			{
				$sql_insert = "";
				
				$arr_insert = array();
				for($i = 0 ; $i < $total ; $i ++ )
				{
					$filter_show = FSInput::get('filter_show_new_'.$i);
					$alias = FSInput::get('alias_new_'.$i);
					$alias = $fsstring -> stringStandart($alias);
					$calculator = FSInput::get('calculator_new_'.$i);
					$value = FSInput::get('value_new_'.$i);
					$published = FSInput::get('published_new_'.$i);
					$published = @$published ? 1: 0;
					
					if( $filter_show && $alias )	
					{
						$type = 'fs_'.$this -> type;
						$arr_insert[]  = 		"('$filter_show','$alias','$type','$field_name','$field_show','$calculator','$value','$published',1)";
					}
				}
				// insert into table fs_tables
				if(count($arr_insert))
				{
					$sql_insert .= " INSERT INTO ".$this -> table_name." ";
					$sql_insert .= "		(filter_show,alias,tablename,field_name,field_show,calculator,filter_value,published,is_common) ";
					$sql_insert .= "		 VALUES "; 
					$sql_insert .= implode(",", $arr_insert);
					
					$db->query($sql_insert);
					$rs = $db->insert();
					if(!$rs)
					{
						Errors::setError("Kh&#244;ng insert &#273;&#432;&#7907;c v&#224;o ".$this -> table_name."");
						return false;
					}
				}
				
			}
			return true;
		}
		
		/*
		 * Change field exist
		 */
		function save_filter_edit($field_name)
		{

			global $db;
			$fsstring = FSFactory::getClass('FSString','','../');	
			// EXIST FIELD
			$total = FSInput::get('filter_exist_total');
			
			$sql_alter = "";
			$arr_sql_alter = array();
			
			for($i= 0 ; $i < $total ; $i++)
			{
				$sql_update = " UPDATE ".$this -> table_name."
							SET ";
				
				$filter_show_exist = FSInput::get('filter_show_exist_'.$i);

				$filter_show_exist_begin = FSInput::get('filter_show_exist_'.$i."_begin");
				
				$alias_exist = FSInput::get('alias_exist_'.$i);
				$alias_exist_begin = FSInput::get('alias_exist_'.$i."_begin");
				
				$calculator_exist = FSInput::get('calculator_exist_'.$i);
				$calculator_exist_begin = FSInput::get('calculator_exist_'.$i.'_begin');
				
				$value_exist = FSInput::get('value_exist_'.$i);
				$value_exist_begin = FSInput::get('value_exist_'.$i.'_begin');

				
				
				$published_exist = FSInput::get('published_exist_'.$i);
				$published_exist_begin = FSInput::get('published_exist_'.$i.'_begin');
				$published_exist = $published_exist?1:0;
				$published_exist_begin = $published_exist_begin?1:0;
				
				// id
				$filterid_exist = FSInput::get('filterid_exist_'.$i); 

				
				
				if($filter_show_exist)
				{
					
					// if( ($filter_show_exist != $filter_show_exist_begin) || ($calculator_exist != $calculator_exist_begin) ||
					// 	($value_exist != $value_exist_begin) || ($published_exist != $published_exist_begin) ||  
					// 	($alias_exist != $alias_exist_begin)
					//    )
					// {
//						filter_show,tablename,field_name,field_show,calculator,filter_value,published
						$alias_exist = $fsstring -> stringStandart($alias_exist);
						// update
						$sql_update .= " 	filter_show = '$filter_show_exist',
											alias = '$alias_exist',
											ordering = '$ordering_exist',
											calculator = '$calculator_exist', 
											filter_value = '$value_exist',
											published = '$published_exist'
										WHERE tablename = '".'fs_'.$this -> type."'
										AND field_name = '$field_name' 
										AND id = $filterid_exist ";
						$db->query($sql_update);
						$rows = $db->affected_rows();
						if(!$rows)
						{
							Errors::setError($filter_show_exist. " kh&#244;ng l&#432;u &#273;&#432;&#7907;c");
						}
					// }
				}
			}
				
			return true;
			
			// END EXIST FIELD
		}
		function save_filter_remove($field_name)
		{

			global $db;
			$filter_exist_remove = trim(FSInput::get('filter_exist_remove'));
			if($filter_exist_remove)
			{
				$array_filter_remove = explode(",",$filter_exist_remove);
				if(count($array_filter_remove ) > 0)
				{
					$arr_filter_remove1 = array();
					for($i = 0 ; $i < count($array_filter_remove) ; $i ++)
					{
						if($array_filter_remove[$i])
						{
							$arr_filter_remove1[] = $array_filter_remove[$i];
						} 
					}
					
					$sql_remove = " DELETE FROM  ".$this -> table_name."
									 WHERE is_common = 1 
									 AND field_name  = '$field_name'
									 AND id IN (".implode(",",$arr_filter_remove1).") ";					
					// remove from database
					$db->query($sql_remove);
					$rows = $db->affected_rows();
					if(!$rows)
					{
						Errors::setError("L&#7895;i x&#7843;y ra khi remove trong table ".$this -> table_name."");
						return false;
					}
					
				}
			}
			return true;
		}
		
		/*
		 * get Table show
		 */
		function getTableShow($field_name)
		{
			$type = $this -> type;
			$query = " SELECT a.field_name_display
					 FROM fs_tables AS a
					WHERE 
						type	= '$type'
						AND field_name	= '$field_name'";
			global $db;
			$sql = $db->query($query);
			$result = $db->getResult();
			
			return $result;
		}
		
		
		function save_foreign($field_current,$filter_type = 'foreign_one'){

			$arr_foreign_id_select = FSInput::get('foreign_id',array(),'array');

			// printr($arr_foreign_id_select);
			
			$foreign = $this -> get_all_record($field_current -> foreign_tablename);
			if(!count($foreign))
				return false;
			$str_foreign_select = '';	
			$j = 0;
			
			foreach($foreign as $item){
				if(in_array($item -> id, $arr_foreign_id_select)){
					if($j > 0)
						$str_foreign_select .= ',';
					$str_foreign_select .= $item -> id;
					$ordering_exist = FSInput::get('ordering_exist_'.$item -> id);
					
					 $check_exist = $this  -> get_record(' tablename="fs_products" AND field_name = "'.$field_current -> field_name .'" AND filter_value = "'.$item -> id.'"',$this -> table_name);


					if(empty($check_exist)){
						// echo 111;
						// die;
						$row = array();
						$row['ordering'] = $ordering_exist;
						$row['filter_show'] = $item -> name;
						$row['tablename'] = 'fs_'.$this -> type;
						$row['field_name'] = $field_current -> field_name ;
						$row['field_show'] = $field_current -> field_name_display ;
						$row['alias'] = $field_current -> field_alias?$field_current -> field_alias.'-'.$item -> alias:$item -> alias;
						$row['calculator'] = $filter_type == 'foreign_one'?14:15 ;
						$row['filter_value'] = $item -> id;
						$row['published'] = 1;
						$row['is_common'] = 1;
						// printr($row);
						$this -> _add($row,$this -> table_name);
					}else{

						$row = array();
						$row['ordering'] = $ordering_exist;
						// $row['filter_show'] = $item -> name;
						// $row['tablename'] = 'fs_'.$this -> type;
						// $row['field_name'] = $field_current -> field_name ;
						// $row['field_show'] = $field_current -> field_name_display ;
						// $row['alias'] = $field_current -> field_alias?$field_current -> field_alias.'-'.$item -> alias:$item -> alias;
						// $row['calculator'] = $filter_type == 'foreign_one'?14:15 ;
						// $row['filter_value'] = $item -> id;
						// $row['published'] = 1;
						// $row['is_common'] = 1;
						

						$up_id = $this -> _update($row,$this -> table_name,'filter_value="' .$check_exist->filter_value.'"' );
						
					}
					$j ++;
				}
			}
			$sql_where = '';
			if($str_foreign_select)
				$sql_where = "AND filter_value NOT IN (".$str_foreign_select.")";
			$sql = " DELETE FROM ".$this -> table_name." 
						WHERE  is_common = 1 AND tablename = 'fs_products' AND field_name = '".$field_current -> field_name ."' ".$sql_where ;
			global $db;
			// $db->query($sql);
			$rows = $db->affected_rows($sql);
			if(!$rows)
				return true;
			return true;
		}
		
	}
	
?>