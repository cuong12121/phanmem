<?php
class UsersModelsProfile extends FSModels {
	var $limit;
	var $page;
	function __construct() {
		$limit = FSInput::get ( 'limit', 20, 'int' );
		$page = FSInput::get ( 'page' );
		$this->table_name = 'fs_users';
		$this->limit = $limit;
		$this->page = $page;
		$cyear = date ( 'Y' );
		$cmonth = date ( 'm' );
		$cday = date ( 'd' );
		$this->img_folder = 'images/users/' . $cyear . '/' . $cmonth . '/' . $cday;
		$this->field_img = 'image';
		$this -> arr_img_paths = array(array('resized',500,500,'cut_image'),array('small',150,150,'cut_image'));
		$this -> arr_img_people_id = array(array('compress',1,1,'compress'));
		parent::__construct ();
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
		$cids = FSInput::get ( 'id', array (), 'array' );
		$cid = isset ( $cids [0] ) ? $cids [0] : 0;
		$query = " SELECT *
		FROM fs_users
		WHERE id = $cid ";
		
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObject ();
		return $result;
	}
	

	function save($row = array(), $use_mysql_real_escape_string = 1) {
		global $db;
		$username = FSInput::get ( 'username' );
		$id = FSInput::get ( 'id' );
		$parent_id = FSInput::get ('parent_id');
		if(!$username || empty($username)){
			if($id){
				setRedirect(FSRoute::_('index.php?module=users&view=profile&task=edit&id='.$id),FSText :: _('Tên đăng nhập không được để trống'),'error');
			}else{
				setRedirect(FSRoute::_('index.php?module=users&view=profile&task=add'),FSText :: _('Tên đăng nhập không được để trống'),'error');
			}
			
			return false;
		}

		if (!preg_match('/^(?=[a-z]{2})(?=.{4,26})(?=[^.]*\.?[^.]*$)(?=[^_]*_?[^_]*$)[\w.]+$/iD',
                $username))
		{
			if($id){
				setRedirect(FSRoute::_('index.php?module=users&view=profile&task=edit&id='.$id),FSText :: _('Tên đăng nhập viết liền không dấu'),'error');
			}else{
				setRedirect(FSRoute::_('index.php?module=users&view=profile&task=add'),FSText :: _('Tên đăng nhập viết liền không dấu'),'error');
			}
		 	return false;
		}

		$password = FSInput::get ( "password1" );
		$repass = FSInput::get ( "re-password1" );
		$published = FSInput::get ( 'published' );

		if(@$id){
			if($id == $_SESSION['ad_userid'] || $id == 9){
				$published = 1;
			}
			$edit_pass = FSInput::get ( 'edit_pass' );
			if ($edit_pass) {
				if (! $password || $password != $repass)
					return false;
				$password = fSencode(md5(md5($password)));
				$password = hash('sha256', $password);
			}

			$row['published'] = $published;
			if($password){
				$row['password'] = $password;
			}
		}else{
			if (! $password || ($password != $repass))
				return false;
			$password = fSencode(md5(md5($password)));
			$password = hash('sha256', $password);
			$row['password'] = $password;
		}
		$birthday = FSInput::get('birthday');
		$row['birthday'] = date('Y-m-d',strtotime($birthday));


		$day_in = FSInput::get('day_in');
		$row['day_in'] = date('Y-m-d',strtotime($day_in));

		$day_in_main = FSInput::get('day_in_main');
		$row['day_in_main'] = date('Y-m-d',strtotime($day_in_main));

		$image_t_peopel_id = $_FILES["image_t_peopel_id"]["name"];
		if($image_t_peopel_id){
			$image_t_peopel_id_ul = $this->upload_image('image_t_peopel_id','_'.time(),200000000,$this -> arr_img_paths_banner);
			if($image_t_peopel_id_ul){
				$row['image_t_peopel_id'] = $image_t_peopel_id_ul;
			}
		}

		$image_s_peopel_id = $_FILES["image_s_peopel_id"]["name"];
		if($image_s_peopel_id){
			$image_s_peopel_id_ul = $this->upload_image('image_s_peopel_id','_'.time(),200000000,$this -> arr_img_paths_banner);
			if($image_s_peopel_id_ul){
				$row['image_s_peopel_id'] = $image_s_peopel_id_ul;
			}
		}

		$other_receives = FSInput::get('other_receives',array(),'array');
		if(!empty($other_receives)){
			$other_receives_str = implode(',',$other_receives);
			$row['receives'] = ','.$other_receives_str.',';

		}else{
			$row['receives'] = '';
		}


		$other_quits_job = FSInput::get('other_quits_job',array(),'array');
		if(!empty($other_quits_job)){
			$other_quits_job_str = implode(',',$other_quits_job);
			$row['quits_job'] = ','.$other_quits_job_str.',';

		}else{
			$row['quits_job'] = '';
		}

		$wrap_id_warehouses = FSInput::get ( 'wrap_id_warehouses', array (), 'array' );
		$str_wrap_id_warehouses = implode ( ',', $wrap_id_warehouses );
		if ($str_wrap_id_warehouses) {
			$str_wrap_id_warehouses = ',' . $str_wrap_id_warehouses . ',';
		}
		$row ['wrap_id_warehouses'] = $str_wrap_id_warehouses;



		// shops
		$record_shops_relate = FSInput::get ( 'shops_record_related', array (), 'array' );
		$row['shop_id'] = '';
		$row['level'] = 0;
		if($parent_id){ // có cha
			$row['shop_id'] = '';
			$row['level'] = 1;
			if (!empty( $record_shops_relate )){
				//check xem shop này đã có tài khoản nào quản lý hay chưa
				foreach ($record_shops_relate as $shop_id) {
					if($id){
						$user_manage_shop =  $this->get_record('id <> '.$id.' AND id <> '.$parent_id.' AND shop_id LIKE "%,'.$shop_id.',%"','fs_users');
						
					}else{
						$user_manage_shop =  $this->get_record('id <> '.$parent_id.' AND shop_id LIKE "%,'.$shop_id.',%"','fs_users');
						
					}
					
					if(!empty($user_manage_shop)){
						$name_shop =  $this->get_record('id ='.$shop_id,'fs_shops','name');
						if($id){
							setRedirect(FSRoute::_('index.php?module=users&view=profile&task=edit&id='.$id),'Shop "'.$name_shop->name.'" đã có tài khoản: "' .$user_manage_shop->username. '" quản lý, vui lòng check lại.','error');
						}else{
							setRedirect(FSRoute::_('index.php?module=users&view=profile'),'Shop "'.$name_shop->name.'" đã có tài khoản: "' .$user_manage_shop->username. '" quản lý, vui lòng check lại.','error');
						}
					}
				}
				$record_shops_relate = array_unique ( $record_shops_relate );
				$row ['shop_id'] = ',' . implode ( ',', $record_shops_relate ) . ',';
			}
		}else{
			if (!empty( $record_shops_relate )){
			//check xem shop này đã có tài khoản nào quản lý hay chưa
			foreach ($record_shops_relate as $shop_id) {
				if($id){
					$user_manage_shop =  $this->get_record('id <> '.$id.' AND shop_id LIKE "%,'.$shop_id.',%"','fs_users');

				}else{
					$user_manage_shop =  $this->get_record('shop_id LIKE "%,'.$shop_id.',%"','fs_users');
				}


				
				
				if(!empty($user_manage_shop)){

					
					$name_shop =  $this->get_record('id ='.$shop_id,'fs_shops','name');
					if($id){
						if($user_manage_shop -> parent_id != $id){
							setRedirect(FSRoute::_('index.php?module=users&view=profile&task=edit&id='.$id),'Shop "'.$name_shop->name.'" đã có tài khoản: "' .$user_manage_shop->username. '" quản lý, vui lòng check lại.','error');
						}
						
					}else{
						setRedirect(FSRoute::_('index.php?module=users&view=profile'),'Shop "'.$name_shop->name.'" đã có tài khoản: "' .$user_manage_shop->username. '" quản lý, vui lòng check lại.','error');
					}
				}
			}

			$record_shops_relate = array_unique ( $record_shops_relate );
			$row ['shop_id'] = ',' . implode ( ',', $record_shops_relate ) . ',';
		}
		}

		
		
		$result_id = parent::save ( $row );
		if(isset($_SESSION['users']['users'])){
			unset($_SESSION['users']['users']);
		}

		//hợp đồng
		if (! $this->remove_contracts( $result_id )) {		
		}
		if (! $this->save_exist_contracts( $result_id)) {
		}
		if (! $this->save_new_contracts( $result_id )) {
		}
		
		if (! $this->save_insurance( $result_id )) {
		}
		return $result_id;
	}

	function save_insurance($user_id){
		$row = array ();
		$row ['so_so_bhxh']  = FSInput::get ('so_so_bhxh');
		$row ['so_so_bhyt']  = FSInput::get ('so_so_bhyt');
		$row ['ma_tinh_cap']  = FSInput::get ('ma_tinh_cap');
		$row ['dang_ky_kham_chua_benh']  = FSInput::get ('dang_ky_kham_chua_benh');
		$row ['trang_thai_so']  = FSInput::get ('trang_thai_so');
		$row ['phap_nhan']  = FSInput::get ('phap_nhan');

		$ns_hoan_thien_hs = FSInput::get('ns_hoan_thien_hs');
		$row ['ns_hoan_thien_hs']  = date('Y-m-d',strtotime($ns_hoan_thien_hs));

		$nv_hoan_thien_hs = FSInput::get('nv_hoan_thien_hs');
		$row ['nv_hoan_thien_hs']  = date('Y-m-d',strtotime($nv_hoan_thien_hs));

		$ngay_nhan_the_bhyt = FSInput::get('ngay_nhan_the_bhyt');
		$row ['ngay_nhan_the_bhyt']  = date('Y-m-d',strtotime($ngay_nhan_the_bhyt));

		$ngay_tra_the_bhyt = FSInput::get('ngay_tra_the_bhyt');
		$row ['ngay_tra_the_bhyt']  = date('Y-m-d',strtotime($ngay_tra_the_bhyt));

		$ngay_nhan_so_bh_tu_nld = FSInput::get ('ngay_nhan_so_bh_tu_nld');
		$row ['ngay_nhan_so_bh_tu_nld']  = date('Y-m-d',strtotime($ngay_nhan_so_bh_tu_nld));

		$nv_hoan_thien_hs_bg = FSInput::get ('nv_hoan_thien_hs_bg');
		$row ['nv_hoan_thien_hs_bg']  = date('Y-m-d',strtotime($nv_hoan_thien_hs_bg));

		$ngay_nhan_so_bh_chot = FSInput::get ('ngay_nhan_so_bh_chot');
		$row ['ngay_nhan_so_bh_chot']  = date('Y-m-d',strtotime($ngay_nhan_so_bh_chot));

		$ngay_tra_so_cho_nld = FSInput::get ('ngay_tra_so_cho_nld');
		$row ['ngay_tra_so_cho_nld']  = date('Y-m-d',strtotime($ngay_tra_so_cho_nld));
		$row ['user_id'] = $user_id;
		// printr($row);
		$check_user = $this->get_record('user_id = ' . $user_id,'fs_users_insurance');
		if(empty($check_user )){
			$row ['created_time'] = date('Y-m-d');
			$rs = $this->_add ( $row, 'fs_users_insurance', 1 );
		}else{
			$row ['updated_time'] = date('Y-m-d');
			$rs = $this->_update ( $row, 'fs_users_insurance', 'user_id = ' . $user_id);
		}
		return $rs;
	}

	function save_new_contracts($user_id) {
		global $db;
		for($i = 0; $i < 20; $i ++) {
			$row = array ();
			$row ['name'] = FSInput::get ( 'new_contract_name_' . $i );
			if (! $row ['name']) {
				continue;
			}
			$row ['user_id'] = $user_id;
			$row ['signature'] = FSInput::get ( 'new_contract_signature_' . $i );

			$date_signature = FSInput::get ( 'new_contract_date_signature_' . $i );
			$row ['date_signature'] = date('Y-m-d',strtotime($date_signature));


			$date_start = FSInput::get ( 'new_contract_date_start_' . $i );
			$row ['date_start'] = date('Y-m-d',strtotime($date_start));

			$date_end = FSInput::get ( 'new_contract_date_end_' . $i );
			$row ['date_end'] = date('Y-m-d',strtotime($date_end));


			// file downlaod
	        $file_upload = $_FILES["new_contract_file_".$i]["name"];
			if($file_upload){
				$path_original = '../images/users/file_hop_dong/';
				$fsFile = FSFactory::getClass('FsFiles');
				$file_upload_name = $fsFile -> upload_file("new_contract_file_".$i, $path_original ,100000000, '_'.time());
				if(!$file_upload_name)
					return false;
				$row['file'] = 'images/users/file_hop_dong/'.$file_upload_name;
			}

			$row ['created_time'] = date('Y-m-d');
			$rs = $this->_add ( $row, 'fs_users_contracts', 1 );
		}
		return true;
	}


	function save_exist_contracts($id) {
		global $db;
		$total = FSInput::get ( 'contract_exist_total' );

		$rs = 0;
		for ($i = 0; $i < $total; $i++) {
			$id_exist = FSInput::get('exist_contract_id_'.$i);

			if($id_exist){
				$row = array();
				$row ['name'] = FSInput::get('exist_contract_name_'.$i);
				$row ['signature'] = FSInput::get ('exist_contract_signature_' . $i);

				$date_signature = FSInput::get ('exist_contract_date_signature_' . $i );
				$row ['date_signature'] = date('Y-m-d',strtotime($date_signature));

				$date_start = FSInput::get ( 'exist_contract_date_start_' . $i );
				$row ['date_start'] = date('Y-m-d',strtotime($date_start));

				$date_end = FSInput::get ( 'exist_contract_date_end_' . $i );
				$row ['date_end'] = date('Y-m-d',strtotime($date_end));
				$row ['updated_time'] = date('Y-m-d');
				
				$file_upload = $_FILES["exist_contract_file_".$i]["name"];
				if($file_upload){
					$path_original = '../images/users/file_hop_dong/';
					$fsFile = FSFactory::getClass('FsFiles');
					$file_upload_name = $fsFile -> upload_file("exist_contract_file_".$i, $path_original ,100000000, '_'.time());
					if(!$file_upload_name)
						return false;
					$row['file'] = 'images/users/file_hop_dong/'.$file_upload_name;
				}


				$u = $this->_update($row, 'fs_users_contracts', ' id=' . $id_exist);
				if ($u)
					$rs ++;
			}		
		}
		return $rs;
	}

	function remove_contracts($record_id) {
		if (! $record_id)
			return true;
		$other_days_remove = FSInput::get('other_contracts',array(),'array');
		$str_other_days = implode(',',$other_days_remove);
		if ($str_other_days) {
			global $db;
			$sql = " DELETE FROM fs_users_contracts
			WHERE user_id = $record_id AND id IN ($str_other_days)";
			$db->query ( $sql );
			$rows = $db->affected_rows ();
			return $rows;
		}
		return true;
	}



	function checkExistUser() {
		global $db;
		$email = FSInput::get ( 'email' );
		$username = FSInput::get ( 'username' );
		
	}
	
	
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
		$cids = FSInput::get ( 'id', array (), 'array' );
		
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

	function ajax_get_shops_related() {
		$where = ' WHERE 1 = 1';
		$where2 ="";
		
	   // cuong:tắt phần người nào tạo shop thì mới được thêm shop vào tk của mình 
// 		$parent_id = FSInput::get ('parent_id');
    
// 		if($parent_id){
// 			$user_parent = $this->get_record('id = '.$parent_id,'fs_users');

// 			if(!empty($user_parent) && $user_parent-> shop_id && $user_parent-> shop_id != ''){
// 				$where .= ' AND id IN ('.substr($user_parent-> shop_id, 1,-1).')';
// 				$where2 = ' AND id IN ('.substr($user_parent-> shop_id, 1,-1).')';
// 			}
// 		}
        // check là admin mới được thêm shop vào tài khoản của user
        $is_admin = $_SESSION['ad_username']==='admin'?'1':'0';
        $result ='';
        if($is_admin==='1'){
            $keyword = FSInput::get ( 'keyword' );
           
    		$where .= " AND ( name LIKE '%" . $keyword . "%') OR ( code LIKE '%" . $keyword . "%') " .$where2;
    		
    		$query_body = ' FROM '.FSTable_ad::_('fs_shops').' ' . $where;
    		$ordering = " ORDER BY id DESC ";
    		$query = ' SELECT id,name ' . $query_body . $ordering . ' LIMIT 10000000000 ';
    		global $db;
    		$result = $db->getObjectList ( $query );
    		
    		return $result;
        }
	
		return $result;
	}

	function get_shops_related($shop_id) {
		if (! $shop_id)
			return;
		$query = " SELECT id, name 
					FROM ".FSTable_ad::_('fs_shops')."
					WHERE id IN (0" . $shop_id . "0) 
					 ORDER BY POSITION(','+id+',' IN '0" . $shop_id . "0')
					";
		global $db;
		$result = $db->getObjectList ( $query );
		return $result;
	}

}

?>