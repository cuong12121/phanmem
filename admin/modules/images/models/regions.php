<?php 
	class ImagesModelsRegions extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 10;
			$this -> view = 'regions';
			$this -> table_name = 'fs_images_regions';
			parent::__construct();
		}
		
		function get_data()
		{
			global $db;
			$query = $this->setQuery();
			if(!$query)
				return array();
				
			$sql = $db->query_limit($query,$this->limit,$this->page);
			$result = $db->getObjectList();
			
			return $result;
		}
		
//		function setQuery(){
//			
//			// ordering
//			$ordering = "";
//			if(isset($_SESSION[$this -> prefix.'sort_field']))
//			{
//				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
//				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
//				$sort_direct = $sort_direct?$sort_direct:'asc';
//				$ordering = '';
//				if($sort_field)
//					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
//					
//			}
//			if(!$ordering)
//				$ordering .= " ORDER BY created_time DESC , id DESC ";
//			
//			$where = "  ";
//			
//			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
//			{
//				if($_SESSION[$this -> prefix.'keysearch'] )
//				{
//					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
//					$where .= " AND name LIKE '%".$keysearch."%' ";
//				}
//			}
//			
//			$query = " SELECT a.*
//						  FROM 
//						  	fs_departments AS a
//						  	WHERE 1=1".
//						 $where.
//						 $ordering. " ";
//						
//			return $query;
//		}
		
		function save(){
			$name = FSInput::get('name');
			if(!$name)
				return false;
			$alias= FSInput::get('alias');
			$fsstring = FSFactory::getClass('FSString','','../');
			if(!$alias){
				$row['alias'] = $fsstring -> stringStandart($name);
			} else {
				$row['alias'] = $fsstring -> stringStandart($alias);
			}
			return parent::save($row);
		}
		
	}
	
?>