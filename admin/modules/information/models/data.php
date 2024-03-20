<?php 
	class ExtendsModelsData extends FSModels
	{
		function __construct()
		{
			parent::__construct();
			$this -> limit = 50;
			$this -> view = 'news';
			
			$this -> table_name = 'fs_extends_items';
			$this -> table_group_name = 'fs_extends_groups';
			$this -> arr_img_paths = array(array('resized',180,108,'resize_image'),array('large',430,258,'resize_image'),array('small',80,80,'cut_image'));
			
			// config for save
			$cyear = date('Y');
			$cmonth = date('m');
			$cday = date('d');
			$this -> img_folder = 'images/extend/'.$cyear.'/'.$cmonth.'/'.$cday;
			$this -> check_alias = 0;
			$this -> field_img = 'image';
			
			
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
			
			// group
			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					$where .= ' AND a.group_id =  '.$filter.' ';
				}
			}	
			
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND a.name LIKE '%".$keysearch."%' ";
				}
			}
			
			$query = ' SELECT a.*, b.name as group_name
					  FROM 
					  	'.$this -> table_name.' AS a
					  	LEFT JOIN '.$this -> table_group_name.' AS b ON a.group_id = b.id
					  	WHERE 1=1 '.
					 $where.
					 $ordering. ' ';
			return $query;
		}
		
		
		
		/*
		 * select in category of home
		 */
		function get_groups()
		{
			global $db;
			$query = " SELECT a.*
						  FROM 
						  	".$this -> table_group_name." AS a
						  	ORDER BY ordering ";
			$sql = $db->query($query);
			$result = $db->getObjectList();
		
			return $result;
		}



	}
	
?>