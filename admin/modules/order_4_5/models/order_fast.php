<?php 
	class OrderModelsOrder_fast extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 40;
			$this -> view = 'order';
			$this -> table_name = 'fs_order';
			parent::__construct();
		}
		
		function get_data()
		{
			global $db;
			$query = $this->setQuery();
			if(!$query)
				return array();
				
			$sql = $db->query_limit($query,$this->limit,$this->page);
			$result = $db->getObjectList();
			
			return $result;
		}
		
		function setQuery(){
			
			$uid = FSInput::get('uid',0,'int');
			if(!$uid)
				return;
			
			// ordering
			$ordering = "";
			$where = "  ";
			
			// uid
			$where .= 'AND user_id = '.$uid;
			
			if(isset($_SESSION[$this -> prefix.'sort_field']))
			{
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				$ordering = '';
				if($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, id DESC ";
			}
			
			// from
			if(isset($_SESSION[$this -> prefix.'text0']))
			{
				$date_from = $_SESSION[$this -> prefix.'text0'];
				if($date_from){
					$date_from = strtotime($date_from);
					$date_new = date('Y-m-d H:i:s',$date_from);
					$where .= ' AND a.created_time >=  "'.$date_new.'" ';
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
					$where .= ' AND a.created_time <=  "'.$date_new.'" ';
				}
			}
			
			if(!$ordering)
				$ordering .= " ORDER BY id DESC ";
			
			
//			if(isset($_SESSION[$this -> prefix.'filter0'])){
//				$filter = $_SESSION[$this -> prefix.'filter0'];
//				if($filter){
//					$where .= ' AND b.id =  "'.$filter.'" ';
//				}
//			}
			
//			if(isset($_SESSION[$this -> prefix.'filter1'])){
//				$filter = $_SESSION[$this -> prefix.'filter1'];
//				if($filter){
//					$where .= ' AND a.user_id =  "'.$filter.'" ';
//				}
//			}
			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					$filter = (int)$filter - 1;
					$where .= ' AND a.status =  "'.$filter.'" ';
				}
			}
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					if(strpos($keysearch, 'DH') === 0){
						$keysearch_id = str_replace('DH','', $keysearch);
						$keysearch_id = (int)$keysearch_id;
					}
					$where .= " AND ( a.id LIKE '%".$keysearch."%' OR username LIKE  '%".$keysearch."%' OR sender_name LIKE  '%".$keysearch."%' 
								OR sender_email LIKE  '%".$keysearch."%' OR recipients_name LIKE  '%".$keysearch."%' OR recipients_email LIKE  '%".$keysearch."%' ";
					if(isset($keysearch_id))
						$where .= "	OR a.id LIKE '%".$keysearch_id."%' ";
						
					$where .= "	)"; 
				}
			}
			
			$query = " SELECT a.*
						  FROM fs_order AS a  
						   WHERE 1=1 
						   AND is_temporary = 0 "
						  .$where .$ordering;
						
			return $query;
		}
		function get_data_order(){
			$id = FSInput::get('id',0,'int');
			global $db;
			$query = "  SELECT a.*,b.name as product_name, b.alias as product_alias,b.category_alias
					FROM fs_order_items AS a
					INNER JOIN fs_products AS b on a.product_id = b.id
					WHERE
						a.order_id = $id
					";
			$db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		function getOrderById(){
			$id = FSInput::get('id',0,'int');
			global $db;
			$query = "  SELECT *
					FROM fs_order AS a
					WHERE
						id = $id
					";
			$db->query($query);
			$result = $db->getObject();
			return $result;
		}
		
//		function get_username(){
//			$id = FSInput::get('id',0,'int');
//			global $db;
//			$query = "  SELECT *
//					FROM fs_order AS a
//					WHERE
//						id = $id
//					";
//			$db->query($query);
//			$result = $db->getObject();
//			return $result;
//		}
//		
//		/*
//		 * get Cities
//		 */
//		function getCityNameById($city_id){
//			if(!$city_id)
//				return;
//			global $db;
//			$query = "SELECT name
//							FROM fs_cities 
//						WHERE id = $city_id
//						";
//			$db->query($query);
//			$rs = $db->getResult();
//			
//			return $rs;	
//		}
//		/*
//		 * get District
//		 */
//		function getDistrictById($district_id){
//			if(!$district_id)
//				return;
//			global $db;
//			$query = "SELECT name
//							FROM fs_districts
//						WHERE id = $district_id
//						";
//			$db->query($query);
//			$rs = $db->getResult();
//			
//			return $rs;	
//		}
		
		
		function cancel_order(){
			$cancel_people = $_SESSION['ad_username'];
			$id = FSInput::get('id',0,'int');
			$time = date("Y-m-d H:i:s");
			if(!$id)
				return;
			global $db;
			// get order_id to return
			$query = " SELECT * 
						FROM fs_order
						WHERE   
							id = $id 
							AND is_temporary = 0
					";	
			$db -> query($query);
			$order = $db -> getObject();
			
			$order_id = $order -> id;
			if(!$order_id)
				return false;
			if($order ->  status)
				return false;
				
				$row['status'] = 2;
				$row['edited_time'] = $time;
				$row['cancel_people'] = $cancel_people;
				$row['cancel_time'] = $time;
				$row['cancel_is_penalty'] = 1;
				$row['cancel_is_compensation'] = 1;
				$row['status_before_cancel'] = 0;
				$row['is_dispute'] = 0;
				$rs = $this -> _update($row, 'fs_order', ' id = '.$order -> id);
				return $rs;
			return;	
		}
		
		function finished_order(){
			$cancel_people = $_SESSION['ad_username'];
			$id = FSInput::get('id',0,'int');
			$time = date("Y-m-d H:i:s");
			if(!$id)
				return;
				
			global $db;
			// get order_id to return
			$query = " SELECT * 
						FROM fs_order
						WHERE   
							id = $id 
							AND is_temporary = 0
					";	
			$db -> query($query);
			$order = $db -> getObject();
			$order_id = $order -> id;
			if(!$order_id)
				return false;
			if($order ->  status >= 1)
				return false;
				
			if(!$order ->  status){	
				$row['status'] = 1;
				$row['edited_time'] = $time;
				$row['status_before_cancel'] = 0;
				$rs = $this -> _update($row, 'fs_order', ' id = '.$order -> id);
				return $rs;
			} 
			return;	
		}
		
		/*
		 * Repay the money after cancel order for guest
		 */
		function repay($money,$guest_username,$str_penaty = ''){
			// SAVE FS_MEMBERS
			// add money 
			global $db;
			if(!$guest_username)
				return false;
			$sql = "UPDATE fs_members SET `money` = money + ".$money." WHERE username = '".$guest_username."' ";
			// $db->query($sql);
			$rows = $db->affected_rows($sql);
			if(!$rows)
				return false;
				
			// SAVE HISTORY	
			$time = date("Y-m-d H:i:s");
			$row3['money'] = $money;
			$row3['type'] = 'deposit';
			$row3['username'] = $guest_username;
			$row3['created_time'] = $time;
			$row3['description'] = $str_penaty;
			$row3['service_name'] = 'Trả lại tiền';
			if(!$this -> _add($row3, 'fs_history'))
				return false;
		}
		
		
		function pay_penalty(){
			$cancel_people = $_SESSION['ad_username'];
			$id = FSInput::get('id',0,'int');
			$time = date("Y-m-d H:i:s");
			if(!$id)
				return;
				
			$row['edited_time'] = $time;
			$row['cancel_is_penalty'] = 1;
			$rs = $this -> _update($row, 'fs_order', ' id = '.$id. ' AND status = 6 ');
			return $rs;
		}
		function pay_compensation(){
			$cancel_people = $_SESSION['ad_username'];
			$id = FSInput::get('id',0,'int');
			$time = date("Y-m-d H:i:s");
			if(!$id)
				return;
				
			$row['edited_time'] = $time;
			$row['cancel_is_compensation'] = 1;
			$rs = $this -> _update($row, 'fs_order', ' id = '.$id. ' AND status = 6 ');
			return $rs;
		}
		
	}
?>
