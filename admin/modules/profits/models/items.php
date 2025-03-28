<?php 
	class ProfitsModelsItems extends FSModels
	{
		var $limit;
		var $page;
		function __construct()
		{
			$limit = 20;
			$page = FSInput::get('page');
			$this->limit = $limit;
			$this -> table_name = 'fs_profits';
		
			parent::__construct();
		}
		
		function setQuery()
		{
			// ordering
			$ordering = '';
			$where = "  ";

			// from
			if(isset($_SESSION[$this -> prefix.'text0']))
			{
				$date_from = $_SESSION[$this -> prefix.'text0'];
				if($date_from){
					$date_from = strtotime($date_from);
					$date_new = date('Y-m-d',$date_from);
					$where .= ' AND a.date >=  "'.$date_new.'" ';
				}
			}
			
				// to
			if(isset($_SESSION[$this -> prefix.'text1']))
			{
				$date_to = $_SESSION[$this -> prefix.'text1'];
				if($date_to){
					$date_to = $date_to . ' 23:59:59';
					$date_to = strtotime($date_to);
					$date_new = date('Y-m-d H:i:s',$date_to);
					$where .= ' AND a.date <=  "'.$date_new.'" ';
				}
			}

			// if(isset($_SESSION[$this -> prefix.'filter0'])){
			// 	$filter = $_SESSION[$this -> prefix.'filter0'];
			// 	if($filter){
					
			// 		$where .= ' AND a.house_id =  "'.$filter.'" ';
			// 	}
			// }


			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					
					$where .= ' AND a.warehouse_id =  "'.$filter.'" ';
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter1'])){
				$filter = $_SESSION[$this -> prefix.'filter1'];
				if($filter){
					
					$where .= ' AND a.platform_id =  "'.$filter.'" ';
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter2'])){
				$filter = $_SESSION[$this -> prefix.'filter2'];
				if($filter){
					$where .= ' AND a.shipping_unit_id =  "'.$filter.'" ';
				}
			}

			

			if(isset($_SESSION[$this -> prefix.'sort_field']))
			{
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				$ordering = '';
				if($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, date DESC, id DESC ";
			}
			
			if(!$ordering)
				$ordering .= " ORDER BY date DESC , id DESC ";
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND shop_code = '".$keysearch."'";
				}
			}

			$wrap_id_warehouses = $this->get_wrap_id_warehouses();
			$where .= ' AND warehouse_id IN ('.$wrap_id_warehouses.')';

			if($_SESSION['ad_groupid'] == 1){
				$where .= ' AND list_user_id_manage_shop LIKE "%,'.$_SESSION['ad_userid'].',%"';
			}

			$query = "SELECT * FROM ".$this -> table_name." AS a WHERE 1=1 AND is_shoot = 1 "  . $where. $ordering. " ";
			return $query;
		}

		function get_data_statics()
		{
			global $db;
			$query = $this->setQuery();
			if(!$query)
				return array();
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}

		

	}
	
?>