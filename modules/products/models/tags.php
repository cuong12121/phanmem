
<?php 
	class ProductsModelsTags extends FSModels
	{

		function __construct() {
			parent::__construct ();
			global $module_config;
			$limit   = 15;
			$this->limit = $limit;
		}
		/* return query run
		 * get products list in category list.
		 * These categories is Children of category_current
		 */
	function getPagination($total) {
		FSFactory::include_class ( 'Pagination' );
		$pagination = new Pagination ( $this->limit, $total, $this->page );
		return $pagination;
	}
		function get_product_from_ids($str_product_ids){
			if(!$str_product_ids)
				return;
			$query = " SELECT *
					FROM fs_products
					WHERE id IN ($str_product_ids) ";
			$query;
			global $db;
			$db->query($query);
			$result = $db->getObjectList();
			return $result;
		}

		function set_query_body($data)
		{
			$where = " AND tag_group like '%,".$data->id. ",%' ";
			$fs_table = FSFactory::getClass('fstable');
			$sql  = "	
					FROM ".$fs_table -> getTable('fs_products')."
					WHERE published = 1 AND is_trash = 0 ".$where." 
                    ";
			return $sql;
		}

		function set_new_query_body()
		{
			$q = FSInput::get('q');
			if(!$q)
				return ;
			$q = str_replace('+', ' ',$q);
			// $q = mysql_real_escape_string($q);


			$fs_table = FSFactory::getClass('fstable');
			$where = "";
			
			$where .= " AND ( title like '%".$q."%' OR tags like '%".$q."%' ) ";
			$sql   = "	SELECT id,title,alias,category_alias,image  
						FROM ".$fs_table -> getTable('fs_news')."
						WHERE published =1 ".
						$where ;
			return $sql;
			
		}
		function get_list($query_body)
		{
			if(!$query_body)
				return;
			$query_ordering = $this -> set_query_order_by();
			$query = ' SELECT  id,name,alias,category_alias,category_id ,image,price,price_old,quantity,alias,discount,types,is_hot,is_new,style_types,type ' .$query_body;
			$query .= $query_ordering;
			global $db;
			$sql = $db->query_limit($query,$this->limit,$this->page);
			$result = $db->getObjectList();
			return $result;
		}

		function get_list_all($query_body)
		{
			if(!$query_body)
				return;
			$query_ordering = $this -> set_query_order_by();
			$query = ' SELECT id ' .$query_body;
			$query .= $query_ordering;
			global $db;
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}

		function get_list_next($query_body) {
			if(!$query_body)
				return;
			$query_ordering = $this -> set_query_order_by_news();
			$query = $query_body;
			$query .= $query_ordering;
			global $db;
			$sql = $db->query_limit($query,$this->limit,$this->page);
			$result = $db->getObjectList();
			return $result;
	}
	function get_list_ajax($query_body,$limit) {
		if (! $query_body)
			return;
		$query_ordering = $this->set_query_order_by ();
		$query_select = $this->set_query_select ();
		$query = $query_select;
		$query .= $query_body;
		$query .= $query_ordering;
		global $db;
		$pagecurrent = FSInput::get('pagecurrent',0,'int');
		$db->query_limit_export ( $query, $pagecurrent,$limit);
		$result = $db->getObjectList ();
		return $result;
	}
	function get_total_curent($query_body,$limit) {
		if (! $query_body)
			return;
		$query = " SELECT id";
		$query .= $query_body;
		global $db;
		$pagecurrent = FSInput::get('pagecurrent',0,'int');
		$db->query_limit_export ( $query, 0, $pagecurrent+ $this->limit);
		$result = $db->getObjectList ();
		return $result;
	}
		
		/*
		 * Insert order by into query select
		 */
		function set_query_order_by(){
			$order  = FSInput::get('order');
			 $query_ordering = '';
			if($order){
				switch ($order){
					case 'asc':
						$query_ordering='ORDER BY price '.$order;
						break;
					case 'desc':
						$query_ordering='ORDER BY price '.$order;
						break;
					case 'old':
						$query_ordering='ORDER BY status ASC';
						break;	
					case 'new':
						$query_ordering='ORDER BY status DESC';
						break;	
					case 'alpha':
						$query_ordering='ORDER BY name asc';
						break;	
					case 'promotion':
						$query_ordering='ORDER BY is_promotion asc';
						break;				
				}
			}else{
				$query_ordering='ORDER BY   ordering DESC';
			}
			
			return $query_ordering;
		}
		/*
		 * Insert order by into query select
		 */
		function set_query_order_by_news(){
			$order  = FSInput::get('order');
			 $query_ordering = '';
			if($order){
				switch ($order){
					case 'asc':
						$query_ordering='ORDER BY price '.$order;
						break;
					case 'desc':
						$query_ordering='ORDER BY price '.$order;
						break;
					case 'old':
						$query_ordering='ORDER BY status ASC';
						break;	
					case 'new':
						$query_ordering='ORDER BY status DESC';
						break;	
					case 'alpha':
						$query_ordering='ORDER BY name asc';
						break;	
					case 'promotion':
						$query_ordering='ORDER BY is_promotion asc';
						break;				
				}
			}else{
				$query_ordering='ORDER BY   created_time DESC, id DESC';
			}
			
			return $query_ordering;
		}
		function set_query_select(){
			$query = " SELECT * ";
			return $query;
		}
		
		/*
		 * get Category current
		 */
		function get_category(){
			$id = FSInput::get('id',0,'int');
			$where = 'published = 1 ';
			if($id){
				$where .= " AND id = '$id'  ";
			} else {
				$code = FSInput::get('ccode');
				if(!$code)
					return;
				$where .= " AND alias = '$code' ";
			}
			$fs_table = FSFactory::getClass('fstable');
			$result = $this -> get_record($where,$fs_table -> getTable('fs_products_categories'),'name,id,alias,parent_id,list_parents');
			return $result ;
		}
//		function get_list_parent($list_parents,$cat_id){
//			if(!$list_parents)
//				return;
//			$fs_table = FSFactory::getClass('fstable');
//			$query = 'SELECT name,id,alias,parent_id FROM '.$fs_table -> getTable('fs_products_categories').
//					' WHERE id IN (0'.$list_parents.'0) AND id <> '.$cat_id.'
//					ORDER BY POSITION(","+id+"," IN "0'.$list_parents.'0")';
//			global $db;
//			$db->query($query);
//			$list = $db->getObjectList();
//			return $list;
//		}
		
		function getTotal($query_body)
		{	
			if(!$query_body)
				return;
			global $db;
			$query = "SELECT count(*) ";
			$query .= $query_body;
			$db->query($query);
			$total = $db->getResult();
			return $total;
		}
		
	
		
		
   	function get_ajax_search($limit = 15){
      global $db;
      $where[1] = '';
      $where[2] = '';
      $where[3] = '';
      $where[4] = '';
      $query = FSInput::get('query', '');
      if(!$query)
      	return;
      
      $where[1] .= " AND name like  '%" . $query . "%'";			
			$where[2] .= " AND tags like  '%" . $query . "%'";

			$arr_tags = explode ( ' ', $query );
			$total_tags = count ( $arr_tags );
			if ($total_tags) {
				$where[3] .= ' AND (';
				$j = 0;
				for($i = 0; $i < $total_tags; $i ++) {
					$item = trim ( $arr_tags [$i] );
					if ($item) {
						if ($j > 0)
							$where[3] .= ' AND ';
							$where[3] .= " `name` like '%" . $item . "%'";
						$j ++;
					}
				}
				 $where[3] .= ' ) ';
			}

			if ($total_tags) {
				$where[4] .= ' AND (';
				$j = 0;
				for($i = 0; $i < $total_tags; $i ++) {
					$item = trim ( $arr_tags [$i] );
					if ($item) {
						if ($j > 0)
							$where[4] .= ' OR ';
							$where[4] .= " `name` like '%" . $item . "%'";
							$where[4] .= " OR `tags` like '%" . $item . "%'";
						$j ++;
					}
				}
				 $where[4] .= ' ) ';
			}

			$list = array();
			for($i = 1; $i < 5; $i ++)	{				
				$sql_where = $where[$i];
				
				  // $where .= " AND `name` like '%" .  $query . "%'";
         $query = '  SELECT *
                      FROM fs_products 
                      WHERE published = 1  '.$sql_where.' 
                      ORDER BY  ordering DESC
                      LIMIT 8
                      ';  
                      	
         $sql = $db->query($query);
					$result = $db->getObjectList();
					
					$list = array_merge($list,$result);					
			}
        
			
			return $this -> unique_array_objects($list);
    }

          function unique_array_objects($list){
    	
    	$arr_keys = array();
    	$rs = array();
    	foreach($list as $item){
    		if(!in_array($item -> id,$arr_keys)){
    			$rs[] = $item;
    			$arr_keys[] = $item->id;
    		}
    	}    	
    	return $rs;
    }
    
	
	function get_ajax_search_compare($ids,$table_name){
            global $db;
	    $where_c = '';
      $where[1] = '';
      $where[2] = '';
      $where[3] = '';
      $where[4] = '';
            $query = FSInput::get('query', '');
      if(!$query)
      	return;
      
      $where[1] .= " AND name like  '%" . $query . "%'";			
			$where[2] .= " AND tags like  '%" . $query . "%'";

			$arr_tags = explode ( ' ', $query );
			$total_tags = count ( $arr_tags );
			
				if ($total_tags) {
				$where[3] .= ' AND (';
				$j = 0;
				for($i = 0; $i < $total_tags; $i ++) {
					$item = trim ( $arr_tags [$i] );
					if ($item) {
						if ($j > 0)
							$where[3] .= ' AND ';
							$where[3] .= " `name` like '%" . $item . "%'";
						$j ++;
					}
				}
				 $where[3] .= ' ) ';
			}

			if ($total_tags) {
				$where[4] .= ' AND (';
				$j = 0;
				for($i = 0; $i < $total_tags; $i ++) {
					$item = trim ( $arr_tags [$i] );
					if ($item) {
						if ($j > 0)
							$where[4] .= ' OR ';
							$where[4] .= " `name` like '%" . $item . "%'";
							$where[4] .= " OR `tags` like '%" . $item . "%'";
						$j ++;
					}
				}
				 $where[4] .= ' ) ';
			}
			
		
			if($ids){
				 $where_c .= ' AND id NOT IN ('.$ids.') ';
			}
			if($table_name){
				$where_c .= ' AND tablename = "fs_products_'.$table_name.'" ';
			}

	$list = array();
			for($i = 1; $i < 5; $i ++)	{
			$sql_where = 	$where_c;			
				$sql_where .= $where[$i];
            // $where .= " AND `name` like '%" .  $query . "%'";
            $query = '  SELECT *
                        FROM fs_products 
                      WHERE published = 1  '.$sql_where.' 
                        
                        ORDER BY is_service ASC , ordering DESC
                        LIMIT 8
                        ';

            $sql = $db->query($query);
			$result = $db->getObjectList();
					$list = array_merge($list,$result);					
			}
			
			return $this -> unique_array_objects($list);
    }

    function get_types(){
		global $db;
			$query = "SELECT id,name
				 FROM fs_products_types
				 WHERE  published = 1

				 ORDER BY ordering
			";
		if(!$query)
			return;
		$sql = $db->query($query);
		$result = $db->getObjectListByKey('id');
		return $result;
	}
   
}
	
?>