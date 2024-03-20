<?php 
	class NewsModelsHot
	{
		function __construct()
		{
			$limit = 2;
			$page = FSInput::get('page');
			$this->limit = $limit;
			$this->page = $page;
			$db = new Mysql_DB();
		}
		function setQuery()
		{
			$query = "  SELECT id, title,image, summary
					  FROM fs_news
					  WHERE published = 1
					  AND is_hot = 1
					  AND published = 1
					ORDER BY hot_ordering DESC ";
			return $query;
		}
		function getNewsList()
		{
			global $db;
			$query = $this->setQuery();
			$sql = $db->query_limit($query,$this->limit,$this->page);
			$result = $db->getObjectList();
			
			return $result;
		}
		
		function getTotal()
		{
			global $db;
			$query = $this->setQuery();
			$sql = $db->query($query);
			$total = $db->getTotal();
			return $total;
		}
		
		function getPagination()
		{
			$total = $this->getTotal();
			FSFactory::include_class('Pagination');
			$pagination = new Pagination($this->limit,$total,$this->page);
			return $pagination;
		}
	}
	
?>