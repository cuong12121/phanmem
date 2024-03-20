<?php 
	class NewsModelsQuicksearch
	{
		function __construct()
		{
			$limit = 12;
			$page = FSInput::get('page');
			$this->limit = $limit;
			$this->page = $page;
		}
		function setQuery()
		{
			$keyword = FSInput::get('keyword');
			if(!$keyword)
				return ;
			$where = "";
			$where .= " AND MATCH(title) AGAINST ('".$keyword."' IN BOOLEAN MODE ) ";
			$sql   = "SELECT id,title,summary,image
						FROM fs_contents
						WHERE 1=1 ".
						$where
						;
			return $sql;
			
		}
		function getTotal()
		{
			global $db;
			$query = $this->setQuery();
			$sql = $db->query($query);
			$total = $db->getTotal();
			return $total;
		}
		
		/*
		 * get News from keyword
		 */
		function getData()
		{
			global $db;
			$query = $this->setQuery();
			if(!$query)
				return array();
			$db->query_limit($query,$this->limit,$this->page);
			$result = $db->getObjectList();
			return $result;
			
		}
		
		function getPagination($total)
		{
			$pagination = new Pagination($this->limit,$total,$this->page);
			return $pagination;
		}
	}
	
?>