<?php 
	class ProductsModelsHistory extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'history';
			$this -> table_name = 'fs_products_history';
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
			
			$record_id = FSInput::get('record_id',0,'int');			
			
			if(!$ordering)
				$ordering .= " ORDER BY  id DESC ";
			
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND a.title LIKE '%".$keysearch."%' ";
				}
			}
			
			$query = " SELECT a.*
						  FROM 
						  	fs_products_history AS a
						  	WHERE record_id = ".$record_id.
						 $where.
						 $ordering. " ";
			return $query;
		}
		
		function get_data_older($id,$record_id){
			if(!$id || !$record_id)
				return;
			$table_name = $this -> table_name;
			$query = " SELECT *
						  FROM ".$table_name."
						  WHERE id < $id AND record_id = ".$record_id." 
						  ORDER BY id ASC ";
			
			global $db;
			$sql = $db->query($query);
			$result = $db->getObject();
			return $result;
		}		
		
	}
	
?>