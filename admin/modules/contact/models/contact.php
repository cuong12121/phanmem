<?php 
	class ContactModelsContact extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 10;
			$this -> view = 'contact';
            $this -> table_name = FSTable_ad::_('fs_contact');
			parent::__construct();
		}
		
		function setQuery1(){
			
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
			
			$query = " SELECT a.*
						  FROM 
						  	fs_departments AS a
						  	WHERE 1=1".
						 $where.
						 $ordering. " ";
						
			return $query;
		}
		
		function save($row = array(), $use_mysql_real_escape_string = 1){
			$department_id = FSInput::get('department_id');
			if($department_id){
				$department = $this->get_record('id =' . $department_id,'fs_contact_department');
				$row['department_name'] = $department ->name;
			}

			// if(!$name)
			// 	return false;
			// $row['map'] = htmlspecialchars_decode(FSInput::get('map'));
			// $row['link_map'] = htmlspecialchars_decode(FSInput::get('link_map'));
			// $row['description'] = htmlspecialchars_decode(FSInput::get('description'));
			// $alias= FSInput::get('alias');
			// $fsstring = FSFactory::getClass('FSString','','../');
			// if(!$alias){
			// 	$row['alias'] = $fsstring -> stringStandart($name);
			// } else {
			// 	$row['alias'] = $fsstring -> stringStandart($alias);
			// }
			return parent::save($row);
		}
		
	}
	
?>