<?php 
	class StrengthsModelsCategories extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'categories';
			$this -> table_news = FSTable_ad::_('fs_strengths');
			$this -> table_name = FSTable_ad::_('fs_strengths_categories');
			$this -> arr_img_paths = array(array('resized',420,300,'cut_image'),array('compress',1,1,'compress'));
			$this -> img_folder = 'images/strengths';
			// $this -> check_alias = 0;
			$this -> field_img = 'image';
            
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
//		
//		/*
//		 * select in category
//		 */
//		function get_categories_tree()
//		{
//			global $db;
//			$query = $this->setQuery();
//			$sql = $db->query($query);
//			$result = $db->getObjectList();
//			$tree  = FSFactory::getClass('tree','tree/');
//			$list = $tree -> indentRows2($result);
//			$limit = $this->limit;
//			$page  = $this->page?$this->page:1;
//			
//			$start = $limit*($page-1);
//			$end = $start + $limit;
//			
//			$list_new = array();
//			$i = 0;
//			foreach ($list as $row){
//				if($i >= $start && $i < $end){
//					$list_new[] = $row;
//				}
//				$i ++;
//				if($i > $end)
//					break;
//			}
//			return $list_new;
//		}
//		
//		/*
//		 * select in category by estore_id
//		 */
//		/*
//		 * value: == 1 :hot
//		 * value  == 0 :unhot
//		 * published record
//		 */
//		function home($value)
//		{
//			$ids = FSInput::get('id',array(),'array');
//			
//			if(count($ids))
//			{
//				global $db;
//				$str_ids = implode(',',$ids);
//				$sql = " UPDATE ".$this -> table_name."
//							SET show_in_homepage = $value
//						WHERE id IN ( $str_ids ) " ;
//				$db->query($sql);
//				$rows = $db->affected_rows();
//				return $rows;
//			}
//			return 0;
//		}
//		
//		
//		/*
//		 * Save
//		 */
//		function save($row = array(),$use_mysql_real_escape_string = 0){
//			$name = FSInput::get('name');
//			if(!$name){
//				Errors::_(FSText::_('Name is not empty'));
//				return false;
//			}
//			$id = FSInput::get('id',0,'int');
//			$icon = $_FILES["icon"]["name"];
//			if($icon){
//				
//				// remove old if exists record and img
//				
//				$path_original =  PATH_IMG_NEWS.'categories'.DS.'icons'.DS.'original'.DS;
//				$path_resize =  PATH_IMG_NEWS.'categories'.DS.'icons'.DS.'resized'.DS;
//				
//				if($id){
//					$img_paths = array();
//					$img_paths[] = $path_original;
//					$img_paths[] = $path_resize;
//					$this -> remove_image($id,$img_paths);
//				}
//				$fsFile = FSFactory::getClass('FsFiles');
//				// upload
//				$icon = $fsFile -> uploadImage("icon", $path_original ,2000000, '_'.time());
//				if(!$icon){
//					Errors::_(FSText::_('Can not upload image'));
//					return false;
//				}
//					
//				// rezise to standart : 34x27
//				$width = 34;
//				$height = 27;
//				if(!$fsFile ->resized_not_crop($path_original.$icon, $path_resize.$icon,$width, $height))
//				{
//					Errors::_(FSText::_('Can not resize image'));
//					return false;
//				}
//				$row['icon'] = 	$icon;
//			}
//				
//			$alias= FSInput::get('alias');
//			$fsstring = FSFactory::getClass('FSString','','../');
//			if(!$alias){
//				$row['alias'] = $fsstring -> stringStandart($name);
//			} else {
//				$row['alias'] = $fsstring -> stringStandart($alias);
//			}
//			
//			// change in table fs_news
//			if($id)
//				$this -> change_table_child($row['alias'],'category_alias',' WHERE category_id = '.$id,'fs_news');
//			return parent::save($row);
//		}
//		
//		
//		function remove(){
//			if(!$this -> check_remove()){
//				Errors::_(FSText::_('Can not remove category when it has child category or article'));
//				return false;
//			}
//			return parent::remove();
//		}
//		
//		function check_remove(){
//			$cids = FSInput::get('id',array(),'array');
//			foreach ($cids as $cid)
//			{
//				if( $cid != 1)
//				{
//					$cids[] = $cid ;
//				}
//			}
//			
//			$num_record = 0;
//			if(count($cids))
//			{
//				$str_cids = implode(',',$cids);
//				global $db;
//				
//				$sql = " SELECT count(*) FROM  ".$this -> table_name." 
//						WHERE id not IN ( $str_cids ) 
//						AND parent_id IN ( $str_cids ) " ;
//				$db->query($sql);
//				$result = $db->getResult();
//				if($result)
//					return false;
//					
//				$sql = " SELECT count(*) FROM  ".$this -> table_news." 
//						WHERE category_id IN ( $str_cids ) 
//						 " ;
//				$db->query($sql);
//				$result = $db->getResult();
//				if($result)
//					return false;
//			}
//			return true;
//		}
	}
	
?>