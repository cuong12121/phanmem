<?php 
	class ProductsModelsWarehouse extends FSModels
	{
		var $limit;
		var $page;
		function __construct()
		{
			$limit = 100;
			$page = FSInput::get('page');
			$this->limit = $limit;
			$this -> table_name = 'fs_warehouse';
			$this -> arr_img_paths = array(array('resized',370,247,'cut_image'),array('small',127,72,'cut_image'),array('large',600,315,'cut_image'));
			$cyear = date ( 'Y' );
			$cmonth = date ( 'm' );
			$cday = date ( 'd' );
			$this->img_folder = 'images/cities/' . $cyear . '/' . $cmonth . '/' . $cday;
			$this->check_alias = 0;
			$this->field_img = 'image';
			$this -> check_alias = 1;
			parent::__construct();
		}
		
		function setQuery()
		{
			// ordering
			$ordering = '';
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
					$where .= " AND name LIKE '%".$keysearch."%' ";
				}
			}
			$query = " 	   SELECT * 
						
						  FROM ".$this -> table_name." 
						  	WHERE 1=1 ".
						 $where.
						 $ordering. " ";
			return $query;
		}


		function save($row = array(), $use_mysql_real_escape_string = 1){
			$row['edited_time'] = date('Y-m-d H:i:s');
			$row['user_edit_id'] = $_SESSION['ad_userid'];
			$row['user_edit_name'] = $_SESSION['ad_username'];
			$latitude = FSInput::get('latitude');
			$longitude = FSInput::get('longitude');
			if(!$latitude || !$longitude){
				return false;
			}
			$record_id =  parent::save($row);
			if($record_id){
				$row2 = array();
				$row2['latitude_warehouse'] = $latitude;
				$row2['longitude_warehouse'] = $longitude;
				$rsyn = $this->_update($row2,'fs_cities','warehouse_id = '.$record_id);
			}
			return $record_id;
		}
		
		
	}
	
?>