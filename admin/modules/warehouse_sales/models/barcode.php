<?php 
	class Warehouse_salesModelsBarcode extends FSModels
	{
		var $limit;
		var $page;
		function __construct()
		{
			$limit = 100;
			$page = FSInput::get('page');
			$this->limit = $limit;
			$this -> table_name = 'fs_order_uploads_detail';
		
			parent::__construct();
		}
		
		function setQuery()
		{
			// ordering
			$ordering = '';
			$where = " AND is_print = 1 ";

			$wrap_id_warehouses = $this->get_wrap_id_warehouses();
			$where .= ' AND warehouse_id IN ('.$wrap_id_warehouses.')';

			// from
			if(isset($_SESSION[$this -> prefix.'text0']))
			{
				$date_from = $_SESSION[$this -> prefix.'text0'];
				if($date_from){
					$date_from = strtotime($date_from);
					$date_new = date('Y-m-d',$date_from);
					$where .= ' AND a.date =  "'.$date_new.'" ';
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

			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					
					$where .= ' AND a.house_id =  "'.$filter.'" ';
				}
			}


			if(isset($_SESSION[$this -> prefix.'filter1'])){
				$filter = $_SESSION[$this -> prefix.'filter1'];
				if($filter){
					
					$where .= ' AND a.warehouse_id =  "'.$filter.'" ';
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter2'])){
				$filter = $_SESSION[$this -> prefix.'filter2'];
				if($filter){
					
					$where .= ' AND a.platform_id =  "'.$filter.'" ';
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter3'])){
				$filter = $_SESSION[$this -> prefix.'filter3'];
				if($filter){
					$where .= ' AND a.shipping_unit_id =  "'.$filter.'" ';
				}
			}

			if (isset ( $_SESSION [$this->prefix . 'filter4'] )) {
				$filter = $_SESSION [$this->prefix . 'filter4'];
				if ($filter) {
					if($filter == 1)
						$where .= ' AND a.is_shoot = 1';
					else 
						$where .= ' AND a.is_shoot <> 1';
				}
			}

			$where2 = $where;

			

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
			
			$str_key = FSInput::get('keysearch');
			if($str_key){
				if(isset($_SESSION[$this -> prefix.'keysearch'])){
					$ss = $_SESSION[$this -> prefix.'keysearch'].$str_key.',';
				}else{
					$ss = $str_key.',';
				}
				$ss = str_replace(',,',',',$ss);
				$_SESSION[$this -> prefix.'keysearch'] = $ss;
			}

			$users = $this -> get_record('id = ' . $_SESSION['ad_userid'],'fs_users');
			if($users->group_id == 1){
				$where .= " AND user_id = ".$_SESSION['ad_userid'];
			}

			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$arr_key = explode(',', $keysearch);
					$i = 0;
					foreach($arr_key as $key_it){
						if(!$key_it || empty($key_it) || $key_it == ''){
							continue;
						}
						if($i == 0){
							$where .= " AND tracking_code LIKE '%".$key_it."%' ";
						}else{
							$where .= " OR tracking_code LIKE '%".$key_it."%' " .$where2;
						}
						
						$where .= " OR code LIKE '%".$key_it."%' " .$where2;
						
						$i++;
					}
				}
			}

	
			$query = "SELECT * FROM ".$this -> table_name." AS a WHERE 1=1 " . $where. $ordering. " ";
			return $query;
		}

		function setQueryExportNhat()
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
					$where .= ' AND a.date =  "'.$date_new.'" ';
				}
			}
			
				// to
			// if(isset($_SESSION[$this -> prefix.'text1']))
			// {
			// 	$date_to = $_SESSION[$this -> prefix.'text1'];
			// 	if($date_to){
			// 		$date_to = $date_to . ' 23:59:59';
			// 		$date_to = strtotime($date_to);
			// 		$date_new = date('Y-m-d H:i:s',$date_to);
			// 		$where .= ' AND a.date <=  "'.$date_new.'" ';
			// 	}
			// }

			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					
					$where .= ' AND a.house_id =  "'.$filter.'" ';
				}
			}


			if(isset($_SESSION[$this -> prefix.'filter1'])){
				$filter = $_SESSION[$this -> prefix.'filter1'];
				if($filter){
					
					$where .= ' AND a.warehouse_id =  "'.$filter.'" ';
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter2'])){
				$filter = $_SESSION[$this -> prefix.'filter2'];
				if($filter){
					
					$where .= ' AND a.platform_id =  "'.$filter.'" ';
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter3'])){
				$filter = $_SESSION[$this -> prefix.'filter3'];
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
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
			}
			
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND tracking_code LIKE '%".$keysearch."%' OR shop_code LIKE '%".$keysearch."%' ";
				}
			}
			$users = $this -> get_record('id = ' . $_SESSION['ad_userid'],'fs_users');
			if($users->group_id == 1){
				$where .= " AND user_id = ".$_SESSION['ad_userid'];
			}
			$query = "SELECT * FROM ".$this -> table_name." AS a WHERE 1=1 AND is_shoot = 0 AND is_refund = 0 " . $where. $ordering. " ";
			return $query;
		}


		function setQueryExportTong()
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
					$where .= ' AND a.date =  "'.$date_new.'" ';
				}
			}else{
				echo "Bạn chưa chọn ngày.";
				die;
				return;
			}
			

			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					
					$where .= ' AND a.house_id =  "'.$filter.'" ';
				}
			}


			if(isset($_SESSION[$this -> prefix.'filter1'])){
				$filter = $_SESSION[$this -> prefix.'filter1'];
				if($filter){
					
					$where .= ' AND a.warehouse_id =  "'.$filter.'" ';
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter2'])){
				$filter = $_SESSION[$this -> prefix.'filter2'];
				if($filter){
					
					$where .= ' AND a.platform_id =  "'.$filter.'" ';
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter3'])){
				$filter = $_SESSION[$this -> prefix.'filter3'];
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
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
			}
			
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND tracking_code LIKE '%".$keysearch."%' OR shop_code LIKE '%".$keysearch."%' ";
				}
			}
			$users = $this -> get_record('id = ' . $_SESSION['ad_userid'],'fs_users');
			if($users->group_id == 1){
				$where .= " AND user_id = ".$_SESSION['ad_userid'];
			}
			$query = "SELECT id,SUM(count) as total,product_id,sku,product_name,`date` FROM ".$this -> table_name." AS a GROUP BY product_id HAVING 1=1 " . $where. $ordering. " ";
			return $query;
		}


		function get_excel_nhat($start = 0,$end = 0){
			global $db;
			$query = $this->setQueryExportNhat();
			if(!$query)
				return array();
			$sql = $db->query_limit_export($query,$start,$end);
			$result = $db->getObjectList();
			return $result;
		}


		function get_excel_tong($start = 0,$end = 0){
			global $db;
			$query = $this->setQueryExportTong();

			if(!$query)
				return array();
			$sql = $db->query_limit_export($query,$start,$end);
			$result = $db->getObjectList();
			return $result;
		}
	}
	
?>