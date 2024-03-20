<?php 
	class  ShopsModelsRecharges extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 100;
			$this -> view = 'recharges';
			$this -> table_name = 'fs_shops_recharges';
			parent::__construct();
		}

		function setQuery() {
		
			// ordering
			$ordering = "";
			$where = "  ";
			if (isset ( $_SESSION [$this->prefix . 'sort_field'] )) {
				$sort_field = $_SESSION [$this->prefix . 'sort_field'];
				$sort_direct = $_SESSION [$this->prefix . 'sort_direct'];
				$sort_direct = $sort_direct ? $sort_direct : 'asc';
				$ordering = '';
				if ($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
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
			
		
			
			if (! $ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			if (isset ( $_SESSION [$this->prefix . 'keysearch'] )) {
				if ($_SESSION [$this->prefix . 'keysearch']) {
					$keysearch = $_SESSION [$this->prefix . 'keysearch'];
					$where .= " AND a.user_name LIKE '%" . $keysearch . "%'";
				}
			}
		
		$query = " SELECT a.*
						  FROM 
						  	" . $this->table_name . " AS a
						  	WHERE 1=1 " . $where . $ordering . " ";
		return $query;
	}
	
		
	
	function save($row = array(),$use_mysql_real_escape_string = 0) {
		$id = FSInput::get ('id');
		$user_id = FSInput::get ('user_id');
		$money = FSInput::get ('money');
		if(!$user_id || !$money){
			Errors::_('Bạn phải nhập số tiền và chọn tài khoản shop');
			return false;
		}
		$user = $this->get_record('id = '.$user_id,'fs_users');
		$row['user_name'] = $user-> username;

		//cộng trừ tiền cho user
		if(!$id){
			$row2 = array();
			$row2['money'] = $user->money + $money;
			$this->_update($row2,'fs_users','id = '.$user_id);
		}

		$result = parent::save ( $row );
		if($result){
			$row['record_id'] = $id;
			$row['created_time'] = date('Y-m-d H:i:s');
			$row['money'] = FSInput::get ('money');
			$row['user_id'] = $user_id;
			$row['summary'] = FSInput::get ('summary');
			$row['action_username'] = $_SESSION['ad_username'];
			$row['action_userid'] = $_SESSION['ad_userid'];
			$this->_add($row,'fs_shops_recharges_history');
		}

	
		return $result;
	}
}
?>