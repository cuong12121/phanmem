<?php 
	class UsersModelsMoney extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$limit = FSInput::get('limit',20,'int');
			$page = FSInput::get('page');
			$this->limit = $limit;
			$this->page = $page;
			$this -> view = 'money';
			$this -> table_name = 'fs_members';
			parent::__construct(); 
		}
		
		function setQuery()
		{
			$ordering = '';
			if(isset($_SESSION[$this -> prefix.'sort_field']))
			{
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				$ordering = '';
				if($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
			}
			$query = " 	   SELECT * 
						  FROM fs_members AS a 
						 $ordering 
						 ";
			return $query;
		}
		
		
		function get_data()
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
		
		function get_detail(){
			$uid = FSInput::get('uid',0,'int');
			if(!$uid)
				return;
			$query = " 	   SELECT  money,username,id  FROM fs_members AS a
							WHERE id = $uid 
						 ";
			global $db;
			$db->query($query);
			return $db->getObject();
		}
		/* 
		 * Save
		 */
		function save(){
			$uid = FSInput::get('uid',0,'int');
			$username = FSInput::get('username');
			
			if(!$this -> check_save()){
				return false;
			}
			$time = date("Y-m-d H:i:s");
			$money = FSInput::get('deposit_money',0,'int');
			// save into history
			$row3['money']  = $money;
			$row3['type'] = 'deposit';
			$row3['username'] = $username;
			$row3['created_time'] = $time;
			$row3['description'] = 'Nạp tiền vào tài khoản';
			$row3['service_name'] = 'Nạp tiền vào tài khoản';
			parent::_add($row3, 'fs_history');
			
			// save into member
			global $db;
			$sql = "UPDATE fs_members SET `money` = money + ".$money." WHERE username = '".$username."' ";
			$db->query($sql);
			$rows = $db->affected_rows();
			if(!$rows)
				return false;
			return true;
		}
		function check_save(){
			$uid = FSInput::get('uid',0,'int');
			$username = FSInput::get('username');
			if(!$uid || !$username){
				Errors::_('Lỗi về username');
				return false;
			}
			$money = FSInput::get('deposit_money',0,'int');
			$re_money = FSInput::get('re_deposit_money',0,'int');
			if(!$money){
				Errors::_('Bạn phải nhập số tiền');
				return false;
			}
			
			if($money != $re_money){
				Errors::_('Số tiền nhập chưa khớp');
				return false;
			}
			return true;
		}
	}
	
?>