<?php
/*
 * Tuan write
 */
	class UsersModelsMoney
	{
	function __construct()
		{
			$limit = 10;
			$page = FSInput::get('page',0,'int');
			$this->limit = $limit;
			$this->page = $page;
		}
		function getConfig($name)
		{
			global $db;
			$sql = " SELECT value FROM fs_config 
				WHERE name = '$name' ";
			// $db->query($sql);
			return $db->getResult($sql);
		}
		
		function setQuery(){
			global $econfig;

			$where = ' ';
			$date_from = FSInput::get('date_from');
			$date_from1 = date("Y/m/d 00:00:00", strtotime($date_from) );
			$date_to = FSInput::get('date_to');
			$date_to1 = date("Y/m/d 23:59:59", strtotime($date_to) );
			$service = FSInput::get('service');
			if($date_from)
			{
				$where .=  " AND created_time >= '$date_from1' ";
			}
			if($date_to)
			{
				$where .=  " AND created_time <= '$date_to1' ";
			}
			if($service)
			{
				$where .=  " AND service_name = '$service' ";
			}
				
			$type_select = FSInput::get('type');
			
			switch($type_select){
				case 'buy_history':
					$where .=  " AND type = 'buy' ";
					break;
				case 'deposit_history':
					$where .=  " AND type = 'deposit' ";
					break;
				default:
					beark;
			}
			
			$query = "   FROM fs_history
						  WHERE 1=1 ".$where;
			return $query;
		}
		function get_service_name($type){
			global $db;
			$sql = " SELECT distinct service_name FROM fs_history where type='$type'";
			// $db->query($sql);
			return $db->getObjectList($sql);
		}
		
		function getUsersList($query_body){
			if(!$query_body)
				return;
			global $db;
			
			$query = "SELECT id,created_time,money,service_name,description";
			$query .=  $query_body;
			$sql = $db->query_limit($query,$this->limit,$this->page);
			$result = $db->getObjectList();
			return $result;
		}
		
		function getTotal($query_body){
			if(!$query_body)
				return;
			global $db;
			$query = "SELECT count(*)";
			$query .=  $query_body;
			
			$sql = $db->query($query);
			$total = $db->getResult();
			return $total;
		}
		
		function getPagination($cid)
		{
			$total = $this->getTotal($cid);
			FSFactory::include_class('Pagination');
			$pagination = new Pagination($this->limit,$total,$this->page);
			return $pagination;
		}
	}
?>