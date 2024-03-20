<?php 
	class NewsModelsCategories extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'categories';
			
			$this -> table_news = 'fs_news';
			$this -> table_name = 'fs_news_categories';
			$this -> check_alias = 1;
			parent::__construct();
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
		 * select in category
		 */
		function get_categories_tree()
		{
			global $db;
			$query = $this->setQuery();
			$sql = $db->query($query);
			$result = $db->getObjectList();
			$tree  = FSFactory::getClass('tree','tree/');
			$list = $tree -> indentRows2($result);
			$limit = $this->limit;
			$page  = $this->page?$this->page:1;
			
			$start = $limit*($page-1);
			$end = $start + $limit;
			
			$list_new = array();
			$i = 0;
			foreach ($list as $row){
				if($i >= $start && $i < $end){
					$list_new[] = $row;
				}
				$i ++;
				if($i > $end)
					break;
			}
			return $list_new;
		}
		
		/*
		 * select in category by estore_id
		 */
		/*
		 * value: == 1 :hot
		 * value  == 0 :unhot
		 * published record
		 */
		function home($value)
		{
			$ids = FSInput::get('id',array(),'array');
			
			if(count($ids))
			{
				global $db;
				$str_ids = implode(',',$ids);
				$sql = " UPDATE ".$this -> table_name."
							SET show_in_homepage = $value
						WHERE id IN ( $str_ids ) " ;
				// $db->query($sql);
				$rows = $db->affected_rows($sql);
				return $rows;
			}
			return 0;
		}
		
		
		/*
		 * Save
		 */
		function save(){
			$alias= FSInput::get('alias');
			$fsstring = FSFactory::getClass('FSString','','../');
			$name = FSInput::get('name');
			if(!$alias){
				$row['alias'] = $fsstring -> stringStandart($name);
			} else {
				$row['alias'] = $fsstring -> stringStandart($alias);
			}
			
			// parent
			$parent_id = FSInput::get('parent_id');
			
			if(@$parent_id)
			{
				$parent =  $this->get_record_by_id($parent_id,'fs_news_categories');
				$parent_level = $parent -> level ?$parent -> level : 0; 
				$level = $parent_level + 1;
			} else {
				$level = 0;
			}
			$row['level'] = $level;
			$record_id =  parent::save($row);
			
			if($record_id){
				$this -> update_parent($record_id,$row['alias']);
			}
			return $record_id;
		}
		
			/*
		 * Update table fs_news_categories And table fs_news
		 */
		function update_parent($cid,$alias){
			$record =  $this->get_record_by_id($cid,'fs_news_categories');
			if($record -> parent_id){
				$parent =  $this->get_record_by_id($record -> parent_id,'fs_news_categories');
//				$root_id = $parent -> root_id ;
//				$root_alias = $parent -> root_alias ;
				$list_parents = ','.$cid.$parent -> list_parents ;
				$alias_wrapper = ','.$alias.$parent -> alias_wrapper ;
			} else {
//				$root_id = $cid;
//				$root_alias = $record -> alias ;
				$list_parents = ','.$cid.',';
				$alias_wrapper = ','.$alias.',' ;
			}
//			$row['root_id'] = $root_id;
//			$row['root_alias'] = $root_alias;
			$row['list_parents'] = $list_parents;
			$row['alias_wrapper'] = $alias_wrapper;
			
			// update fs_news
			$id = FSInput::get('id',0,'int');
			if($id){
				$row2['category_id_wrapper'] = $list_parents;
				$row2['category_alias'] = $record -> alias;
				$row2['category_alias_wrapper'] =  $alias_wrapper;
				$this -> _update($row2,'fs_news',' category_id = '.$cid.' ');
				
				// update fs_news_categories : records have parent = this
				$this -> update_categories_children($cid,0,$list_parents,'',$alias_wrapper);
			}
			// change this record
			return $this -> record_update($row,$cid);
		}
			
		function update_categories_children($parent_id,$root_id,$list_parents,$root_alias,$alias_wrapper){
			if(!$parent_id)
				return;
			$query = ' SELECT * FROM fs_news_categories 
						WHERE parent_id = '	.$parent_id;
			global $db;
			$db->query($query);
			$result = $db->getObjectList();	
			if(!count($result))
				return;
			foreach($result as $item){
//				$row3['root_id'] = $root_id;
				$row3['list_parents'] = ",".$item -> id.$list_parents;
//				$row3['root_alias'] = $root_alias;
				$row3['alias_wrapper'] = ",".$item -> alias.$alias_wrapper;
				if($this -> _update($row3,'fs_news_categories',' id = '.$item -> id.' ')){
					
					// update fs_news owner this category
					$row2['category_id_wrapper'] = $row3['list_parents'];
//					$row2['category_root_alias'] = $row3['root_alias'];
					$row2['category_alias_wrapper'] =  $row3['alias_wrapper'];
					$this -> _update($row2,'fs_news',' category_id = '.$item -> id.' ');
				}
				
			}
		}
		
		
		function remove(){
			if(!$this -> check_remove()){
				Errors::_(FSText::_('Can not remove category when it has child category or article'));
				return false;
			}
			return parent::remove();
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
				// $db->query($sql);
				$result = $db->getResult($sql);
				if($result)
					return false;
					
				$sql = " SELECT count(*) FROM  ".$this -> table_news." 
						WHERE category_id IN ( $str_cids ) 
						 " ;
				// $db->query($sql);
				$result = $db->getResult($sql);
				if($result)
					return false;
			}
			return true;
		}
	}
	
?>