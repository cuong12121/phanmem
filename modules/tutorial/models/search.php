
<?php 
	class NewsModelsSearch
	{
		var $limit;
		var $page;
		function __construct()
		{
			$limit = 12;
			$page = FSInput::get('page');
			$this->limit = $limit;
			$this->page = $page;
		}
		
		
		/* return query run
		 * get products list in category list.
		 * These categories is Children of category_current
		 */
		function get_product_from_ids($str_product_ids){
			if(!$str_product_ids)
				return;
			$query = " SELECT *
					FROM fs_news
					WHERE id IN ($str_product_ids) ";
			$query;
			global $db;
			$db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		function set_query_body()
		{
			global $db;
			$keyword = FSInput::get('keyword');
			if(!$keyword)
				return ;
			$keyword = str_replace('-', ' ',$keyword);
			$keyword = $db -> escape_string($keyword);
			$fs_table = FSFactory::getClass('fstable');
			$where = "";
			$where .= " AND (title like '%".$keyword."%' OR tags like '%".$keyword."%' ) ";
			$sql   = "	 FROM ".$fs_table -> getTable('fs_news')."
						WHERE published =1 AND is_trash = 0 ".
						$where ;
			return $sql;
			
		}
		function get_list($query_body)
		{
			if(!$query_body)
				return;
			$query_ordering = $this -> set_query_order_by();
			$query_select = $this -> set_query_select();
			$query = $query_select;
			$query .= $query_body;
			$query .= $query_ordering;
			$query;
			global $db;
			
			$db->query_limit($query,$this->limit,$this->page);
			$result = $db->getObjectList();
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
				$query_ordering='ORDER BY title DESC, id DESC';
			}
			
			return $query_ordering;
		}
		function set_query_select(){
			$query = " SELECT * ";
			return $query;
		}
		
		
		
		
		function getTotal($query_body)
		{
			global $db;
			$query = "SELECT count(*) ";
			$query .= $query_body;
			$db->query($query);
			$total = $db->getResult();
			return $total;
		}
		
		function getPagination($total)
		{
			FSFactory::include_class('Pagination');
			$pagination = new Pagination($this->limit,$total,$this->page);
			return $pagination;
		}
		function get_breadcrumb(){
			$array_breadcrumb = array();
			$array_breadcrumb[0] = array();
			$array_breadcrumb[0][] = array('name'=>'Tìm kiếm','link'=>'','selected'=>1);
			
			return $array_breadcrumb;
		}
	}
	
?>