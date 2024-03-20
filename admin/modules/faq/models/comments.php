<?php 
	class RecommendationsModelsComments extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'recommendations';
			$this -> table_name = 'fs_recommendations_comments';
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
			
			// id content
			if(isset($_SESSION[$this -> prefix.'text0']))
			{
				$record_id = $_SESSION[$this -> prefix.'text0'];
				$record_id = intval($record_id);
				if($record_id){
					$where .= ' AND d.id =  "'.$record_id.'" ';
				}
			}
			
			// categories
			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					$where .= ' AND (d.category_id_wrapper like  "%,'.$filter.',%")';
				}
			}
			
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND a.comment LIKE '%".$keysearch."%' ";
				}
			}
			
			$query = " SELECT a.*, d.title
						  FROM 
						   fs_recommendations_comments AS a
						  INNER JOIN fs_recommendations  AS d  ON a.record_id = d.id
						  WHERE 1=1 ".
						 $where.
						 $ordering. " ";
			return $query;
		}
		
		
	}
	
?>
