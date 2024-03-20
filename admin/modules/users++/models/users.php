<?php
class UsersModelsUsers extends FSModels {
	var $limit;
	var $page;
	function __construct() {
		$limit = FSInput::get ( 'limit', 20, 'int' );
		$page = FSInput::get ( 'page' );
		$this->table_name = 'fs_users';
		$this->limit = $limit;
		$this->page = $page;
	}
	
	function getUserList() {
		global $db;
		$query = $this->setQuery ();
		$sql = $db->query_limit ( $query, $this->limit, $this->page );
		$result = $db->getObjectList ();
		
		return $result;
	}
	/*
		 * select group_id list contain this user
		 */
	function getUserGroupsByUser() {
		$cids = FSInput::get ( 'cid', array (), 'array' );
		$cid = $cids [0] ? $cids [0] : 0;
		global $db;
		$query = " SELECT groupid 
		FROM fs_users_groups 
		WHERE userid = $cid ";
		$sql = $db->query ( $query );
		$list = $db->getObjectList ();
		
		$arr_result = array ();
		if ($list)
			foreach ( $list as $item ) {
				$arr_result [] = $item->groupid;
			}
			return $arr_result;
		}
		
	/*
		 * select all group in table fs_group
		 */
	function getUserGroupsAll() {
		global $db;
		$query = " SELECT group_name, id 
		FROM fs_groups ";
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		
		return $result;
	}
	
	function setQuery() {
		// ordering
		$ordering = "";
		if (isset ( $_SESSION ['users_users_sort_field'] )) {
			$sort_field = $_SESSION ['users_users_sort_field'];
			$sort_direct = $_SESSION ['users_users_sort_direct'];
			$sort_direct = $sort_direct ? $sort_direct : 'asc';
			$ordering = '';
			if ($sort_field)
				$ordering .= " ORDER BY $sort_field $sort_direct ";
		}
		
		$where = ' WHERE 1=1 ';
		if (isset ( $_SESSION ['ss_usr_keysearch'] )) {
			if ($_SESSION ['ss_usr_keysearch']) {
				$keysearch = $_SESSION ['ss_usr_keysearch'];
				$where .= " AND username LIKE '%" . $keysearch . "%' ";
			}
		}
		
		if (isset ( $_SESSION ['ss_usr_group'] )) {
			if ($_SESSION ['ss_usr_group']) {
				$groupid = $_SESSION ['ss_usr_group'];
				global $db;
				$query_group = " SELECT userid 
				FROM fs_users_groups
				WHERE groupid = $groupid ";
				$db->query ( $query_group );
				$list_userid = $db->getObjectList ();
				$str_ids = '';
				for($i = 0; $i < count ( $list_userid ); $i ++) {
					if ($i > 0)
						$str_ids .= ',';
					$str_ids .= $list_userid [$i]->userid;
				}
				
				if ($str_ids)
					$where .= ' AND id IN (' . $str_ids . ') ';
			}
		}
		
		$query = " SELECT *
		FROM fs_users
		$where
		$ordering 
		";
		return $query;
	}
	
	function getTotal() {
		global $db;
		$query = $this->setQuery ();
		$sql = $db->query ( $query );
		$total = $db->getTotal ();
		return $total;
	}
	
	function getPagination() {
		$total = $this->getTotal ();
		$pagination = new Pagination ( $this->limit, $total, $this->page );
		return $pagination;
	}
	
	/*
		 * Select User by Id
		 */
	function getUserById() {
		$cids = FSInput::get ( 'cid', array (), 'array' );
		$cid = isset ( $cids [0] ) ? $cids [0] : 0;
		$query = " SELECT *
		FROM fs_users
		WHERE id = $cid ";
		
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObject ();
		return $result;
	}
	
	/*
		 * Save
		 */
	function save($row = array(), $use_mysql_real_escape_string = 1) {
		
	// check email and identify card
		$cid = $this->save_into_users ();
//		if ($cid)
//			if ($this->save_into_users_groups ( $cid ))
//				return $cid;
		
		return $cid;
		
	}

	
	
	/*
		 * check exits User
		 */
	function checkExistUser() {
		global $db;
		$email = FSInput::get ( 'email' );
		$username = FSInput::get ( 'username' );
		
	}
	
	function save_into_users() {
		global $db;
		$username = FSInput::get ( 'username' );
		$id = FSInput::get ( 'id' );

		if(!$username || empty($username)){
			if($id){
				setRedirect('index.php?module=users&view=users&task=edit&cid='.$id,FSText :: _('Tên đăng nhập không được để trống'),'error');
			}else{
				setRedirect('index.php?module=users&view=users&task=add',FSText :: _('Tên đăng nhập không được để trống'),'error');
			}
			
			return false;
		}

		if (!preg_match('/^(?=[a-z]{2})(?=.{4,26})(?=[^.]*\.?[^.]*$)(?=[^_]*_?[^_]*$)[\w.]+$/iD',
                $username))
		{
			if($id){
				setRedirect('index.php?module=users&view=users&task=edit&cid='.$id,FSText :: _('Tên đăng nhập viết liền không dấu'),'error');
			}else{
				setRedirect('index.php?module=users&view=users&task=add',FSText :: _('Tên đăng nhập viết liền không dấu'),'error');
			}
		 	return false;
		}
		




		
		$password = FSInput::get ( "password1" );
		$repass = FSInput::get ( "re-password1" );
		$fname = FSInput::get ( 'fname' );
		$lname = FSInput::get ( 'lname' );
		$lname = FSInput::get ( 'lname' );
		$email = FSInput::get ( 'email' );
		$phone = FSInput::get ( 'phone' );
		$address = FSInput::get ( 'address' );
		$country = FSInput::get ( 'country' );
		$published = FSInput::get ( 'published' );
		$ordering = FSInput::get ( 'ordering' );
		$time = gmdate ( 'Y-m-d H:i:s' );
		$id = FSInput::get ( 'id' );
		$group_id = FSInput::get ('group_id');
		
		if (@$id) {
			if($id == $_SESSION['ad_userid'] || $id == 9){
				$published = 1;
			}
			$edit_pass = FSInput::get ( 'edit_pass' );
			if ($edit_pass) {
				if (! $password || $password != $repass)
					return false;
				$password = fSencode(md5(md5($password)));
				$password = hash('sha256', $password);
				$sql_set = "password = '$password',";
			} else {
				$sql_set = "";
			}
			$sql = " UPDATE  fs_users SET 
			username = '$username'," . $sql_set . "fname  = '$fname',
			lname  = '$lname',
			email  = '$email',
			phone  = '$phone',
			address  = '$address',
			country = '$country',
			published  = '$published',
			ordering  = '$ordering',
			updated_time = '$time',
			group_id = '$group_id'
			WHERE id = 	$id 
			";
			$db->query ( $sql );
			$rows = $db->affected_rows ();
			
			if(isset($_SESSION['users']['users'])){
				unset($_SESSION['users']['users']);
			}
			return $id;
			
		} else {
			if (! $password || ($password != $repass))
				return false;
			$password = fSencode(md5(md5($password)));
			$password = hash('sha256', $password);
			$sql = " INSERT INTO fs_users
			(`username`,`password`,fname,lname,email,phone,address,country,published,ordering,updated_time,created_time,group_id)
			VALUES ('$username','$password','$fname','$lname','$email','$phone','$address','$country','$published','$ordering','$time','$time','$group_id')
			";
			$db->query ( $sql );
			$id = $db->insert ();
			if(isset($_SESSION['users']['users'])){
				unset($_SESSION['users']['users']);
			}
			return $id;
		}
		
	}
	
	/*
		 * Save into tble_users_groups
		 * @id: id of user
		 */
	function save_into_users_groups($id) {
		
		if ($id) {
			global $db;
			//	remove before save
			$sql = " DELETE FROM fs_users_groups
			WHERE userid = $id ";
			
			$db->query ( $sql );
			$rows = $db->affected_rows ();
			
			$group_ids = FSInput::get ( 'group_ids', array (), 'array' );
			if (@$group_ids) {
				foreach ( $group_ids as $groupid ) {
					
					// save
					$sql = " INSERT INTO fs_users_groups
					(`userid`,`groupid`)
					VALUES ('$id','$groupid')
					";
					
					$db->query ( $sql );
					
		//						$id = $db->insert();
				}
			}
			return $id;
		}
	}
	/*
		 * remove record
		 */
	function remove() {

		$module =$_GET['module'];
		$view= $_GET['view'];
		$permission = FSSecurity::check_permission($module, $view, 'remove');
		$cids = FSInput::get ( 'cid', array (), 'array' );
		
		if (count ( $cids )) {
			global $db;
			$str_cids = implode ( ',', $cids );
			$sql = " DELETE FROM fs_users
			WHERE id IN ( $str_cids ) ";
			$db->query ( $sql );
			$rows = $db->affected_rows ();
			return $rows;
		}
		return 0;
		
	}
	/*
		 * value: == 1 :published
		 * value  == 0 :unpublished
		 * published record
		 */
	function published($value) {
		$cids = FSInput::get ( 'cid', array (), 'array' );
		
		if (count ( $cids )) {
			global $db;
			$str_cids = implode ( ',', $cids );
			$sql = " UPDATE fs_users
			SET published = $value
			WHERE id IN ( $str_cids ) ";
			$db->query ( $sql );
			$rows = $db->affected_rows ();
			return $rows;
		}
		return 0;
		
	}
	
	function permission_save($cid = 0) {
		if(!$cid)
			return;
		$rs = $this -> permission_base_save($cid);	
		$rs1 = $this -> permission_other_save($cid);	
		return $rs;
	}
	function permission_other_save($cid = 0) {
		$row = array();
		
		// NEWS
		$area_select = FSInput::get ( 'area_news_categories_select' );
		$str_list = '';
		if (! $area_select || $area_select == 'none') {
			$str_list = 'none';
		} else if ($area_select == 'all') {
			$str_list = 'all';
		} else {
			$list = FSInput::get ( 'news_categories', array (), 'array' );
			$arr_list = implode ( ',', $list );
			if ($arr_list) {
				$str_list = ',' . $arr_list . ',';
			}
		}
		$row['news_categories'] = $str_list;
		
		// PRODUCTS
		$area_select = FSInput::get ( 'area_products_categories_select' );
		$str_list = '';
		if (! $area_select || $area_select == 'none') {
			$str_list = 'none';
		} else if ($area_select == 'all') {
			$str_list = 'all';
		} else {
			$list = FSInput::get ( 'products_categories', array (), 'array' );
			$arr_list = implode ( ',', $list );
			if ($arr_list) {
				$str_list = ',' . $arr_list . ',';
			}
		}
		$row['products_categories'] = $str_list;
		$this -> _update($row,'fs_users','id = '.$cid);
		
	}
	function permission_base_save($cid = 0) {
		$permission_arr = FSInput::get ( 'per_28', array (), 'array' );
		
		$modulelist = $this->get_records ( 'published = 1', 'fs_permission_tasks' );
		// array module_type list.
		global $db;
		foreach ( $modulelist as $m ) {
			
			$permission_arr = FSInput::get ( 'per_' . $m->id, array (), 'array' );


			// printr($permission_arr);

			
			$per = 0;
			if (count ( $permission_arr )) {
				for($i = 0; $i < count ( $permission_arr ); $i ++)
					$per = max ( $per, $permission_arr [$i] );
			}

			// echo $per;
			// die;

			$sql = ' SELECT id FROM fs_users_permission 
			WHERE user_id = ' . $cid . '
			AND task_id = ' . $m->id . ' ';
			$db->query ( $sql );
			$id = $db->getResult ();
			
			if (! $id) {
				$sql_insert = '  INSERT INTO fs_users_permission 
				(user_id,task_id,permission)
				VALUES ("' . $cid . '","' . $m->id . '","' . $per . '") ';
				$db->query ( $sql_insert );
				$id = $db->insert ();
				if (! $id)
					return 0;
			} else {
				$sql_update = " UPDATE  fs_users_permission
				SET permission = '$per'
				WHERE id = $id ";
				$db->query ( $sql_update );
				$rows = $db->affected_rows ();
			}
		}
		return true;
	}
	
	/*
		 * Select all list category of news
		 */
	function get_news_categories() {
		global $db;
		$result = $this->get_records ( '', 'fs_news_categories', '*', 'ordering, parent_id' );
		$tree = FSFactory::getClass ( 'tree', 'tree/' );
		$list = $tree->indentRows2 ( $result );
		
		return $list;
	}
	
	/*
		 * Select all list category of product
		 */
	function get_products_categories() {
		global $db;
		$result = $this->get_records ( '', 'fs_products_categories', '*', 'ordering, parent_id' );
		$tree = FSFactory::getClass ( 'tree', 'tree/' );
		$list = $tree->indentRows2 ( $result );
		
		return $list;
	}
/*
		 * check exist email .
		 */
	function check_exits_email()
	{
		global $db ;
		$email      =  FSInput::get("email");
		if(!$email){
			return false;
		}
		$sql = " SELECT count(*) 
		FROM fs_users 
		WHERE 
		email = '$email'
		";
		$db -> query($sql);
		$count = $db->getResult();
		
		return $count;
	}

	function check_exits_email_not_id($id)
	{
		if(!$id){
			return false;
		}
		global $db ;
		$email      =  FSInput::get("email");
		if(!$email){
			return false;
		}
		$sql = " SELECT count(*) 
		FROM fs_users 
		WHERE 
		email = '$email' AND id != '$id'
		";
		$db -> query($sql);
		$count = $db->getResult();
		
		return $count;
	}
		/*
		 * check exist username .
		 */
	function check_exits_username()
	{
		global $db ;
		$username      =  FSInput::get("username");
		if(!$username){
			return false;
		}
		$sql = " SELECT count(*) 
		FROM fs_users 
		WHERE 
		username = '$username'
		";
		$db -> query($sql);
		$count = $db->getResult();
		return $count;
	}

	function check_exits_username_not_id($id)
	{

		if(!$id){
			return false;
		}

		global $db ;
		$username      =  FSInput::get("username");
		if(!$username){
			return false;
		}
		$sql = " SELECT count(*)
		FROM fs_users 
		WHERE
		username = '$username' AND id != '$id'
		";
		
		$db -> query($sql);
		$count = $db->getResult();
		return $count;
	}

}

?>