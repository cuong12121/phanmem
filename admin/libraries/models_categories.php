<?php 
	class ModelsCategories extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			parent::__construct();
			$this -> limit = 50;
			$this -> view = 'categories';
			
//			$this -> table_items = 'fs_items';
//			$this -> table_name = 'fs_items_categories';
			$this -> check_alias = 1;
			$this -> call_update_sitemap = 0;
			
			// exception: key (field need change) => name ( key change follow this field)
//			$this -> field_except_when_duplicate = array(array('list_parents','id'),array('alias_wrapper','alias'));
		}
		
		function setQuery(){
			
			// ordering
			$ordering = "";
			$where = "  ";
			if(isset($_SESSION[$this -> prefix.'sort_field']))
			{
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				$ordering = '';
				if($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
			}
			if(isset($_SESSION[$this -> prefix.'filter'])){
				$filter = $_SESSION[$this -> prefix.'filter'];
				if($filter){
					$where .= ' AND b.id =  "'.$filter.'" ';
				}
			}
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND ( a.name LIKE '%".$keysearch."%'  )";
				}
			}
			
			$query = ' SELECT a.*
						  FROM 
						  	'.$this -> table_name.' AS a
						  	WHERE 1=1'.
						 $where.
						 $ordering. " ";
						
			return $query;
		}
		
		
		
		/*
		 * Save
		 */
		function save($row = array(),$use_mysql_real_escape_string = 0){
			$alias= FSInput::get('alias');
			$id= FSInput::get('id',0,'int');
			$fsstring = FSFactory::getClass('FSString','','../');
			$name = FSInput::get('name');
			if(!$alias){
				$row['alias'] = $fsstring -> stringStandart($name);
			} else {
				$row['alias'] = $fsstring -> stringStandart($alias);
			}
			/* Riêng cho sản phẩm có trường mở rộng và chỉ cho trường hợp sửa */
			$tablename = FSInput::get('tablename');
			if($tablename && $id){
				$old_record = $this ->get_record_by_id($id,$this -> table_name);
				if($tablename != $old_record -> tablename){
					 $this -> move_item_table($id,$old_record -> tablename ,$tablename);
				}
			}
			
			// parent
			$parent_id = FSInput::get('parent_id');
			if($id && ($id == $parent_id)){
				Errors::_('Parent can not itseft');
				return false;
			}
			if(@$parent_id)
			{
				$parent =  $this->get_record_by_id($parent_id,$this -> table_name);
				$parent_level = $parent -> level ?$parent -> level : 0; 
				$level = $parent_level + 1;
			} else {
				$level = 0;
			}
			$row['level'] = $level;
			$record_id =  parent::save($row);

			// echo $record_id;die;
			
			if($record_id){
				$this -> update_parent($record_id,$row['alias']);
				// update sitemap
//				$this -> update_sitemap($record_id,$this -> table_name,$this -> module);
			}
			return $record_id;
		}
		
		/*
		 * Chuyển bảng mở rộng
		 */
		function move_item_table($category_id,$old_table,$new_table){
			if(!$category_id || !$new_table)
				return;
			if($old_table == $new_table)
				return;
			$list = $this -> get_records('category_id = '.$category_id.'  ',$old_table);
			if(!$list)
				return;
			// remove old_table
			$this -> _remove('category_id = '.$category_id.'  ',$old_table);
			if($new_table == 'fs_products')
				return ;
				
			$fields_all_of_ext_table = $this->get_field_table ( $new_table, 1 );
			foreach($list as $item){
				$row = array();
				foreach ( $item as $field_name => $value ) {
					if ($field_name == 'id' || $field_name == 'tablename')
						continue;
					if (! isset ( $fields_all_of_ext_table [$field_name] ))
						continue;
//					if ($field_name == 'record_id')
//						continue;
					$row [$field_name] = $value;
				}
				$this->_add ( $row, $new_table );
			}
			
		}
		
			/*
		 * Update table table category And table table items
		 */
		function update_parent($cid,$alias){
			// echo $cid;die;
			$record =  $this->get_record_by_id($cid,$this -> table_name);
			if($record -> parent_id){
				$parent =  $this->get_record_by_id($record -> parent_id,$this -> table_name);
				$list_parents = ','.$cid.$parent -> list_parents ;
				$alias_wrapper = ','.$alias.$parent -> alias_wrapper ;
			} else {
				$list_parents = ','.$cid.',';
				$alias_wrapper = ','.$alias.',' ;
			}
			$row['list_parents'] = $list_parents;
			$row['alias_wrapper'] = $alias_wrapper;
			
			// update table items
			$id = FSInput::get('id',0,'int');
			if($id){
				$row2['category_id_wrapper'] = $list_parents;
				$row2['category_alias'] = $record -> alias;
				$row2['category_alias_wrapper'] =  $alias_wrapper;
				$row2['category_name'] =  $record -> name;
				$row2['category_published'] =  $record -> published;
				if(isset($record->tablename)){
					$row2['tablename'] =  $record->tablename;	
				}
				$this -> _update($row2,$this -> table_items,' category_id = '.$cid.' ');

				// update table categories : records have parent = this
				$this -> update_categories_children($cid,0,$list_parents,'',$alias_wrapper,$record -> level);
			}
			// change this record
			$rs =  $this -> record_update($row,$cid);
			// update sitemap
//			$this -> update_sitemap($cid,$this -> table_name,$this -> module);
			return $rs;
		}
			
		function update_categories_children($parent_id,$root_id,$list_parents,$root_alias,$alias_wrapper,$level){
			if(!$parent_id)
				return;
			$query = ' SELECT * FROM '.$this -> table_name.' 
						WHERE parent_id = '	.$parent_id;
			global $db;
			$db->query($query);
			$result = $db->getObjectList();	
			if(!count($result))
				return;
			foreach($result as $item){
				
				$row3['list_parents'] = ",".$item -> id.$list_parents;
				$row3['alias_wrapper'] = ",".$item -> alias.$alias_wrapper;
				$row3['level'] =  ($level + 1) ;
				if($this -> _update($row3,$this -> table_name,' id = '.$item -> id.' ')){
					// update sitemap
//					$this -> update_sitemap($item -> id,$this -> table_name,$this -> module);
					
					// update table items owner this category
					$row2['category_id_wrapper'] = $row3['list_parents'];
					$row2['category_alias_wrapper'] =  $row3['alias_wrapper'];
//					$row2['category_name'] =  $row3['name'];
					$this -> _update($row2,$this -> table_items,' category_id = '.$item -> id.' ');
					
					// đệ quy
//					$this -> update_categories_children($item -> id,$root_id,$row3['list_parents'],$root_alias,$row3['alias_wrapper'],$level);
				}
				$this -> update_categories_children($item -> id,$root_id,$row3['list_parents'],$root_alias,$row3['alias_wrapper'],$row3['level']);
			}
		}
		
		function check_remove(){
			$cids = FSInput::get('id',array(),'array');
			
			foreach ($cids as $cid)
			{
				if( $cid != 1)
				{
					$cids[] = $cid ;
				}
			}
			
			$num_record = 0;
			if(count($cids))
			{
				$str_cids = implode(',',$cids);
				global $db;
				
				$sql = " SELECT count(*) FROM  ".$this -> table_name." 
						WHERE id not IN ( $str_cids ) 
						AND parent_id IN ( $str_cids ) " ;
				$result = $db->getResult($sql);
				if($result)
					return false;
					
				$sql = " SELECT count(*) FROM  ".$this -> table_items." 
						WHERE category_id IN ( $str_cids ) 
						 " ;
				$result = $db->getResult($sql);
				if($result)
					return false;
			}
			return true;
		}
		function published($value)
		{
			$ids = FSInput::get('id',array(),'array');
			if(count($ids))
			{
				global $db;
				$str_ids = implode(',',$ids);
				$sql = " UPDATE ".$this -> table_items."
							SET category_published = $value
						WHERE category_id IN ( $str_ids ) " ;
				$result = $db->getResult($sql);
				
			}
			return parent::published($value);
		}
	}
	
?>