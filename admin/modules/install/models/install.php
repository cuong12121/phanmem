<?php 
	class InstallModelsInstall extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 10;
			$this -> view = 'install';
			$this -> table_name = 'fs_install';
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
		
		function setQuery(){
			
			// ordering
			$ordering = "";
			if(isset($_SESSION[$this -> prefix.'sort_field']))
			{
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				$ordering = '';
				if($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
					
			}
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			$where = "  ";
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND name LIKE '%".$keysearch."%' ";
				}
			}
			
			$query = " SELECT a.*,b.name as service_name
						  FROM 
						  	fs_install AS a
						  	LEFT JOIN fs_services AS b ON a.service_id = b.id
						  	WHERE 1=1".
						 $where.
						 $ordering. " ";
						
			return $query;
		}
		
		function save(){
			$subject = FSInput::get('subject');
			if(!$subject)
				return false;
			$row['map'] = htmlspecialchars_decode(FSInput::get('map'));
			$row['link_map'] = htmlspecialchars_decode(FSInput::get('link_map'));
			$row['description'] = htmlspecialchars_decode(FSInput::get('description'));
			$alias= FSInput::get('alias');
			$fsstring = FSFactory::getClass('FSString','','../');
			return parent::save($row);
		}
		
	}
	
?>