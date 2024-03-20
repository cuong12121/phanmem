<?php
/*
 * Tuan write
 */
	class UsersModelsHistory extends FSModels
	{
	function __construct()
		{
			$limit = FSInput::get('limit',20,'int');
			$page = FSInput::get('page',0,'int');
			$this->limit = $limit;
			$this->page = $page;
			parent::__construct(); 
		}
		
		function setQuery(){
			global $econfig;

			$where = ' ';
				
			$type_select = FSInput::get('type');
			
			switch($type_select){
				case 'buy':
					$where .=  " AND type = 'buy' ";
					break;
				case 'deposit':
					$where .=  " AND type = 'deposit' ";
					break;
				default:
					break;
			}
			
			// ordering
			$ordering = "";
			if(isset($_SESSION[$this -> prefix.'sort_field']))
			{
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				if($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
				if($sort_field == 'money'){
					$ordering = " ORDER BY ABS($sort_field) $sort_direct, created_time DESC, id DESC ";
				}
			}
			if($_SESSION[$this -> prefix.'service'])
			{
				$service = $_SESSION[$this -> prefix.'service'];
				$where .= "AND service_name = '$service'";
			}
			 $query = "  SELECT * FROM fs_history WHERE 1=1 ".$where.$ordering;
			return $query;
		}
		function get_service_name($type){
			global $db;
			$sql = " SELECT distinct service_name FROM fs_history where type='$type'";
			$db->query($sql);
			return $db->getObjectList();
		}
		
		
		function get_list()
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
		
		function getPagination(){
			$total = $this->getTotal();			
			$pagination = new Pagination($this->limit,$total,$this->page);
			return $pagination;
		}
		
	}
?>