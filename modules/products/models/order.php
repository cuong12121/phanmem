<?php 
	class ProductsModelsOrder extends FSModels{
		var $limit;
		var $page;
		function __construct()
		{
			$limit = 10;
			$page = FSInput::get('page');
			$this->limit = $limit;
			$this->page = $page;
		}
		
		function setQuery()
		{
			$username = $_SESSION['username'];
			$where = ' ';
			$status = FSInput::get('display');
			if($status!='')
			{
				$where .=  " AND status LIKE '%$status%' ";
			}
			$payment_method = FSInput::get('buy');
			if($payment_method!='')
			{
				$where .=  " AND payment_method LIKE '%$payment_method%' ";
			}
			
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
			
			
			$sql = "  SELECT a.* 
					FROM fs_order AS a
					WHERE 
					username = '$username'
					AND is_temporary = 0
					". $where ."
					ORDER BY id DESC
					";
			return $sql;
		}
		
		function getOrder()
		{
			global $db;
			$query = $this->setQuery();
			if(!$query)
				return array();
				
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
		function get_count_follow_status(){
			$username = $_SESSION['username'];
			global $db;
			$query = "  SELECT count(*) as count_items, status 
					FROM fs_order AS a
					WHERE 
					username = '$username'
					AND is_temporary = 0 
					GROUP BY status
					";
			$db->query($query);
			$result = $db->getObjectList();
			for($i = 0; $i < 7 ; $i ++ ){
				$count_status[$i] = 0;
				if(count($result)){
					foreach($result as $item){
						if($item -> status == $i ){
							$count_status[$i]  = $item -> count_items;
						}
					}
				}
			}
			return $count_status;
		}
		
		function getOrderById(){
			$username = $_SESSION['username'];
			$id = FSInput::get('id',0,'int');
			if(!$id)
				return;
			global $db;
			$query = "  SELECT *
					FROM fs_order AS a
					WHERE
						id = $id AND 
						username = '$username' 
					";
			$db->query($query);
			$result = $db->getObject();
			return $result;
		}
		
		function get_order_items($orderid){
			if(!$orderid)
				return;
//			$sim_number = $_SESSION['sim_number'];
			$id = FSInput::get('id',0,'int');
			global $db;
			$query = "  SELECT a.*
					FROM fs_order_items AS a
					WHERE
						a.order_id = $id
					";
			$db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		function get_products_from_ids($str_ids){
			if(!$str_ids)
				return;
			$query = "  SELECT name, category_alias,alias,id, image
					FROM fs_products 
					WHERE
						published = 1 
						AND id IN ($str_ids)
					";
			global $db;
			$db->query($query);
			$result = $db->getObjectListByKey('id');
			return $result;
		}
		function change_status(){
			$username = $_SESSION['username'];
			$id = FSInput::get('id',0,'int');
			$time = date("Y-m-d H:i:s");
			if(!$id)
				return;
			$query = "  UPDATE fs_order
						SET status = 3,
						edited_time = '$time'
						WHERE
							id = $id AND 
							username = '$username'
							AND status = 2 
					";
			global $db;
			$db->query($query);
			$result = $db->affected_rows();
			return $result;
		}
		
		function payment_for_order(){
			$username = $_SESSION['username'];
			$id = FSInput::get('id',0,'int');
			$time = date("Y-m-d H:i:s");
			if(!$id)
				return;
			global $db;
			// get order_id to return
			$query = " SELECT * 
						FROM fs_order
						WHERE  username = '$username'
							AND id = $id 
							AND is_temporary = 0
							AND status = 0 
					";	
			$db -> query($query);
			$order = $db -> getObject();
			$order_id = $order -> id;
			if(!$order_id)
				return false;
			
			if(!$this -> check_enough_money($order -> total_after_discount,$order -> username)){
				return false;
			}
			$this -> subtraction_money($order -> total_after_discount,$order -> username);
			$this -> save_into_history($order -> total_after_discount,$order -> username);
				
			$query = "  UPDATE fs_order
						SET status = 1,
						edited_time = '$time'
						WHERE
							id = $id AND 
							username = '$username'
							AND status = 0 
							AND is_temporary = 0
					";
			
			$db->query($query);
			$result = $db->affected_rows();
			return $result;
		}
		function recieved_order(){
			$username = $_SESSION['username'];
			$id = FSInput::get('id',0,'int');
			$time = date("Y-m-d H:i:s");
			if(!$id)
				return;
			global $db;
			
//			if(!$this -> check_enough_money($order -> total_after_discount,$order -> username)){
//				return false;
//			}
//			$this -> subtraction_money($order -> total_after_discount,$order -> username);
//			$this -> save_into_history($order -> total_after_discount,$order -> username);
				
			$query = "  UPDATE fs_order
						SET status = 4,
						edited_time = '$time'
						WHERE
							id = $id AND 
							username = '$username'
							AND status = 3 
							AND is_temporary = 0
					";
			$db->query($query);
			$result = $db->affected_rows();
			return $result;
		}
		function cancel_order(){
			$username = $_SESSION['username'];
			$id = FSInput::get('id',0,'int');
			$time = date("Y-m-d H:i:s");
			if(!$id)
				return;
			global $db;
			// get order_id to return
			$query = " SELECT * 
						FROM fs_order
						WHERE  username = '$username'
							AND id = $id 
							AND is_temporary = 0
					";	
			$db -> query($query);
			$order = $db -> getObject();
			$order_id = $order -> id;
			if(!$order_id)
				return false;
			if($order ->  status > 3)
				return false;
				
			if(!$order ->  status){	
				$row['status'] = 6;
				$row['edited_time'] = $time;
				$row['cancel_people'] = $username;
				$row['cancel_time'] = $time;
				$row['cancel_is_penalty'] = 1;
				$row['cancel_is_compensation'] = 1;
				$row['status_before_cancel'] = 0;
				$row['is_dispute'] = 0;
				
				$rs = $this -> _update($row, 'fs_order', ' WHERE id = '.$order -> id);
				return $rs;
			} else if($order ->  status == 1){
				$row['status'] = 6;
				$row['edited_time'] = $time;
				$row['cancel_people'] = $username;
				$row['cancel_time'] = $time;
				$row['cancel_is_penalty'] = 1;
				$row['cancel_is_compensation'] = 1;
				$row['status_before_cancel'] = 1;
				$row['is_dispute'] = 0;
				
				$str_penaty = "Trả lại tiền do bạn đã tự hủy đơn hàng <strong>DH".str_pad($order -> id, 8 , "0", STR_PAD_LEFT)."</strong>";
				$this -> repay($order -> total_after_discount,$str_penaty);
				$rs = $this -> _update($row, 'fs_order', ' WHERE id = '.$order -> id);
				return $rs;
			} else if($order ->  status == 2 || $order ->  status == 3){
				$diff_time = time_diff_to_hours($order -> received_time, time());
				
				$estore = $this -> getEstore($order -> estore_id);
				if($diff_time > 24){
					$money_penaty = $order -> total_after_discount * $estore -> penalty_guest_before_24h / 100;
					$money_compensation = $order -> total_after_discount * $estore -> compensation_estore_before_24h / 100;
				} else if($diff_time > 12){
					$money_penaty = $order -> total_after_discount * $estore -> penalty_guest_before_12h / 100;
					$money_compensation = $order -> total_after_discount * $estore -> compensation_estore_before_12h / 100;
				}else {
					$money_penaty = $order -> total_after_discount * $estore -> penalty_guest_after_12h / 100;
					$money_compensation = $order -> total_after_discount * $estore -> compensation_estore_after_12h / 100;
				}
				$str_penaty  = '';
				if($money_penaty){
					$str_penaty = 'Bạn đã bị trừ '.format_money($money_penaty).' do hủy đơn hàng (DH'.str_pad($order -> id, 8 , "0", STR_PAD_LEFT).') sau khi gian hàng đã xác nhận.';
				}
				$str_compensation = '';
				if($money_compensation){
					$str_compensation = 'Bạn đã được bồi thường '.format_money($money_compensation).' do khách hàng hủy đơn hàng (Mã đơn hàng: DH'.str_pad($order -> id, 8 , "0", STR_PAD_LEFT).')';
				}
				$money_repay = $order -> total_after_discount - $money_penaty;
				
				$row['status'] = 6;
				$row['edited_time'] = $time;
				$row['cancel_people'] = $username;
				$row['cancel_time'] = $time;
				$row['cancel_is_penalty'] = 1;
				$row['cancel_money_penalty'] = $money_penaty;
				$row['cancel_is_compensation'] = 1;
				$row['cancel_money_compensation'] = $money_compensation;
				$row['status_before_cancel'] = $order ->  status;
				$row['cancel_username_penalty'] = $order -> username;
				$row['cancel_username_compensation'] = $order -> estore_username ;
				$row['is_dispute'] = 1;
					
				if($money_repay)
					$this -> repay($money_repay,$str_penaty);
				if($money_compensation)
					$this -> compensation($order -> estore_username,$money_compensation,$str_compensation);
				$rs = $this -> _update($row, 'fs_order', ' WHERE id = '.$order -> id);
				return $rs;
			} 
			return;	
		}
		
		/*
		 * Repay the money after cancel order for guest
		 */
		function repay($money,$str_penaty = ''){
			// SAVE FS_MEMBERS
			// add money 
			$username = $_SESSION['username'];
			global $db;
			if(!$username)
				return false;
			$sql = "UPDATE fs_members SET `money` = money + ".$money." WHERE username = '".$username."' ";
			// $db->query($sql);
			$rows = $db->affected_rows($sql);
			if(!$rows)
				return false;
				
			// SAVE HISTORY	
			$time = date("Y-m-d H:i:s");
			$row3['money'] = $money;
			$row3['type'] = 'deposit';
			$row3['username'] = $username;
			$row3['created_time'] = $time;
			$row3['description'] = 'Trả lại do hủy đơn hàng. ';
			if($str_penaty){
				$row3['description'] = $str_penaty;
			}
			$row3['service_name'] = 'Trả lại tiền';
			if(!$this -> _add($row3, 'fs_history'))
				return false;
		}
		
		// compensation to estore 
		function compensation($estore_username,$money,$str_compensation){
			if(!$money || !$estore_username)
				return;
			global $db;
			$sql = "UPDATE fs_members SET `money` = money + ".$money." WHERE username = '".$estore_username."' ";
			// $db->query($sql);
			$rows = $db->affected_rows($sql);
			if(!$rows)
				return false;
				
			// SAVE HISTORY	
			$time = date("Y-m-d H:i:s");
			$row3['money'] = $money;
			$row3['type'] = 'deposit';
			$row3['username'] = $estore_username;
			$row3['created_time'] = $time;
			$row3['description'] = $str_compensation;
			$row3['service_name'] = 'Bồi thường do khách hàng hủy đơn hàng';
			if(!$this -> _add($row3, 'fs_history'))
				return false;
		}
		
		function check_enough_money($money_pr,$username){
			// check money	
			if(!$username)
				return false;
			$query = " SELECT count(*)
					FROM fs_members
					WHERE username = '$username'
					ANd money >= $money_pr ";
			global $db;
			$db->query($query);
			$result = $db->getResult();
			if(!$result){
				FSFactory::include_class('error');
				Errors:: setError("Tài khoản của bạn không đủ để thanh toán cho đơn hàng này. Bạn có thể nạp tiền để thanh toán sau.");
				return false;
			}
			return true;	
		} 
		function subtraction_money($money_pr,$username){
			// minus money
			global $db;
			if(!$username)
				return false;
			$sql = "UPDATE fs_members SET `money` = money - ".$money_pr." WHERE username = '".$username."' ";
			// $db->query($sql);
			$rows = $db->affected_rows($sql);
			if(!$rows)
				return false;
		}
		
		function save_into_history($money_pr,$username){
			if(!$username)
				return false;
			$time = date("Y-m-d H:i:s");
			$row3['money'] = $money_pr;
			$row3['type'] = 'buy';
			$row3['username'] = $username;
			$row3['created_time'] = $time;
			$row3['description'] = 'Đặt hàng';
			$row3['service_name'] = 'Đặt hàng';
			if(!$this -> _add($row3, 'fs_history'))
				return false;
		}
		
		function getEstore($eid){
			if(!$eid)
				return;

			$query = " SELECT *
					FROM fs_estores
					WHERE id = '$eid' ";
			global $db;
			$db->query($query);
			$result = $db->getObject();
			return $result;
		}
		/*
		 * get Cities
		 */
		function getCityNameById($city_id){
			if(!$city_id)
				return;
			global $db;
			$query = "SELECT name
							FROM fs_cities 
						WHERE id = $city_id
						";
			$db->query($query);
			$rs = $db->getResult();
			
			return $rs;	
		}
		/*
		 * get District
		 */
		function getDistrictById($district_id){
			if(!$district_id)
				return;
			global $db;
			$query = "SELECT name
							FROM fs_districts
						WHERE id = $district_id
						";
			$db->query($query);
			$rs = $db->getResult();
			
			return $rs;	
		}
		function get_order(){
			$username = $_SESSION['username'];
			$id = FSInput::get('order_code');
			$id = str_replace("DH", "", $id);
			if(!$id)
				return;
			global $db;
			$query = "  SELECT *
					FROM fs_order AS a
					WHERE
						id = $id AND 
						username = '$username' 
					";
			$db->query($query);
			$result = $db->getObject();
			return $result;
		}
		
	}
	
?>