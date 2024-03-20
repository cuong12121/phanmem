<?php 
	class ProductsModelsStatus extends FSModels
	{
		var $limit;
		var $page;
		function __construct()
		{
			$limit = 100;
			$page = FSInput::get('page');
			$this->limit = $limit;
			$this -> table_name = 'fs_products_status';
			$this -> img_folder = 'images/products/status/';
			$this -> arr_img_paths = array(array('resized',0,32,'resized_not_crop'));
			$this -> field_img = 'image';
			$this -> check_alias = 1;
			$this -> table_product = 'fs_products';
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
		
		function check_remove(){
			$cids = FSInput::get('id',array(),'array');
			if(!count($cids))
				return true;
			foreach ($cids as $cid){
				if($cid)
					$count = $this -> get_count(' id like "%,'.$cid.',%"');
				if($count)
					return false;
			}
			return true;
		}
	}
	
?>