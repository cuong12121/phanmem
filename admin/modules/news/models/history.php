<?php 
	class NewsModelsHistory extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'history';
			$this -> table_name = 'fs_news_history';
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
			
			$news_id = FSInput::get('news_id',0,'int');			
			
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
						  	fs_news_history AS a
						  	WHERE news_id = ".$news_id.
						 $where.
						 $ordering. " ";
			return $query;
		}
		
		function get_data_older($id,$news_id){
			if(!$id || !$news_id)
				return;
			$table_name = $this -> table_name;
			$query = " SELECT *
						  FROM ".$table_name."
						  WHERE id < $id AND news_id = ".$news_id." 
						  ORDER BY id ASC ";
			
			global $db;
			$sql = $db->query($query);
			$result = $db->getObject();
			return $result;
		}		
		
	}
	
?>