<?php 
	class OnlinesupportModelsOnlinesupport extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$limit = FSInput::get('limit',20,'int');
			$this -> limit = $limit;
			$this -> view = 'onlinesupport';
			$this -> arr_img_paths = array(array('resized',44,44,'resized_not_crop'));
			$this -> table_name = 'fs_onlinesupport';
			$this -> img_folder = 'images/onlinesupport';
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
			
			$query = " SELECT a.*
						  FROM 
						  	".$this -> table_name." AS a
						  	WHERE 1=1 ".
						 $where.
						 $ordering. " ";
			return $query;
		}
		

	}
	
?>