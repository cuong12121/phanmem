<?php
	// models 
	class UsersControllersUsers   extends Controllers 
	{
		var $module;
		var $gid;
		function __construct()
		{
//			$module = 'users';
//			$this->module = $module ;
			parent::__construct(); 
			$this->gid = FSInput::get('gid');
		}
		function display()
		{
			$sort_field  = FSInput::get('sort_field');
			$sort_direct = FSInput::get('sort_direct');
			$sort_direct = $sort_direct?$sort_direct:'asc';
			
			if(@$sort_field)
			{
				$_SESSION['userlist_sort_field']  =  $sort_field  ;
				$_SESSION['userlist_sort_direct']  = $sort_direct ;
			}

			if(isset($_SESSION['users']['users'])){
				unset($_SESSION['users']['users']);
			}
			
			$keysearch = FSInput::get('keysearch');
			if(isset($_POST['keysearch']))
			{
				$_SESSION['ss_usr_keysearch']  =  $_POST['keysearch']  ;
			}
//			$select_cat = FSInput::get('select_cat');
			
			if(	isset($_POST['select_group']))
			{
				$_SESSION['ss_usr_group']  =  $_POST['select_group'] ;
			}
			
			// call models
			$model = new UsersModelsUsers();

	//		$all_groups = $model->getUserGroupsAll();
			
			$list = $model->getUserList();
			$pagination = $model->getPagination();
			

			// call views
			
			include 'modules/'.$this->module.'/views/users/list.php';
		}
		
		
		function add()
		{
			$permission = FSSecurity::check_permission($this -> module, $this -> view, 'add');
	        if (!$permission){
	            echo FSText::_("Bạn không có quyền thực hiện chức năng này");
	            return;
	        }
			$model = new UsersModelsUsers();
	//		$groups_all = $model->getUserGroupsAll();
			include 'modules/'.$this->module.'/views/users/detail.php';
		}

		function edit()
		{
			$permission = FSSecurity::check_permission($this -> module, $this -> view, 'edit');
	        if (!$permission){
	            echo FSText::_("Bạn không có quyền thực hiện chức năng này");
	            return;
	        }
			$id = FSInput::get("cid");
			if($id==9){
				setRedirect('index.php?module=users&view=users',$rows.' '.FSText :: _('Không được sửa user này'),'error');
			}
			
			$model = new UsersModelsUsers();
			$data = $model->getUserById();
	//		$groups_all = $model->getUserGroupsAll();
	//		$groups_contain_user = $model->getUserGroupsByUser();
			include 'modules/'.$this->module.'/views/users/detail.php';
		}

		function remove()
		{
			$permission = FSSecurity::check_permission($this -> module, $this -> view, 'remove');
	        if (!$permission){
	            echo FSText::_("Bạn không có quyền thực hiện chức năng này");
	            return;
	        }

			$model = new UsersModelsUsers();
			$cids = FSInput::get ( 'cid', array (), 'array' );
			foreach ($cids as $id) {
				if($id == 9){
					setRedirect('index.php?module=users&view=users',FSText :: _('Không được xóa tài khoản admin'),'error');	
	            	return false;
				}
			}

			$rows = $model->remove();
			if($rows)
			{
				setRedirect('index.php?module=users&view=users',$rows.' '.FSText :: _('record was deleted'));	
			}
			else
			{
				setRedirect('index.php?module=users&view=users',FSText :: _('Not delete'),'error');	
			}
		}
		function published()
		{
			$model = new UsersModelsUsers();
			$rows = $model->published(1);
			if($rows)
			{
				setRedirect('index.php?module=users&view=users',$rows.' '.FSText :: _('record was published'));	
			}
			else
			{
				setRedirect('index.php?module=users&view=users',FSText :: _('Error when published record'),'error');	
			}
		}
		function unpublished()
		{
			$model = new UsersModelsUsers();
			$rows = $model->published(0);
			if($rows)
			{
				setRedirect('index.php?module=users&view=users',$rows.' '.FSText :: _('record was unpublished'));	
			}
			else
			{
				setRedirect('index.php?module=users&view=users',FSText :: _('Error when unpublished record'),'error');	
			}
		}
		function apply()
		{
			$this->save_new_session_user();
			$model = new UsersModelsUsers();
			
			$id = FSInput::get('id');
			if(!$id){
				if($model->check_exits_email()){
					setRedirect('index.php?module=users&view=users&task=add',FSText :: _('Email này đã có người sử dụng'),'error');	
				}
				if($model->check_exits_username()){
					setRedirect('index.php?module=users&view=users&task=add',FSText :: _('Username này đã có người sử dụng'),'error');	
				}
			}
			// check password and repass
			$password = FSInput::get("password1");
			$repass = FSInput::get("re-password1");
			if($id)
			{

				if($model->check_exits_email_not_id($id)){
					setRedirect('index.php?module=users&view=users&task=edit&cid='.$id,FSText :: _('Email này đã có người sử dụng'),'error');	
				}

				if($model->check_exits_username_not_id($id)){
					setRedirect('index.php?module=users&view=users&task=edit&cid='.$id,FSText :: _('Username này đã có người sử dụng'),'error');	
				}
				
				$edit_pass = FSInput::get('edit_pass');

				if($edit_pass){
					if(!$password || ($password != $repass))
					{
						setRedirect('index.php?module=users&view=users&task=edit&cid='.$id,FSText :: _('Bạn phải nhập mật khẩu và hai mật khẩu phải trùng nhau'),'error');
					}
				}

			}else
			{
				if(!$password || ($password != $repass))
				{
					setRedirect('index.php?module=users&view=users&task=add',FSText :: _('Bạn phải nhập mật khẩu và hai mật khẩu phải trùng nhau'),'error');
				}	
			}
			// call Models to save
			$cid = $model->save();
			
			if($cid)
			{
				setRedirect("index.php?module=users&view=users&task=edit&cid=$cid",FSText :: _('Saved'));	
			}
			else
			{
				setRedirect('index.php?module=users&view=users&task=add',FSText :: _('Not save'),'error');	
			}
			
		}
		function save()
		{
			$this->save_new_session_user();
			$model = new UsersModelsUsers();

			$id = FSInput::get('id');

			if(!$id){
				
				if($model->check_exits_email()){
					setRedirect('index.php?module=users&view=users&task=add',FSText :: _('Email này đã có người sử dụng'),'error');	
				}
				if($model->check_exits_username()){
					setRedirect('index.php?module=users&view=users&task=add',FSText :: _('Username này đã có người sử dụng'),'error');	
				}
			}else{
				if($model->check_exits_email_not_id($id)){
					setRedirect('index.php?module=users&view=users&task=edit&cid='.$id,FSText :: _('Email này đã có người sử dụng'),'error');	
				}
				
				if($model->check_exits_username_not_id($id)){
					setRedirect('index.php?module=users&view=users&task=edit&cid='.$id,FSText :: _('Username này đã có người sử dụng'),'error');	
				}


			}
			
			// check password and repass
			$password = FSInput::get("password1");
			$repass = FSInput::get("re-password1");
			$edit_pass = FSInput::get('edit_pass');
				
			

			if($id)
			{

				if($edit_pass){
					if(!$password || ($password != $repass))
					{
						setRedirect('index.php?module=users&view=users&task=edit&cid='.$id,FSText :: _('Bạn phải nhập mật khẩu và hai mật khẩu phải trùng nhau'),'error');

					}
					
				}
				

			}
			else
			{
				
				if(!$password || ($password != $repass))
					setRedirect('index.php?module=users&view=users&task=add',FSText :: _('Bạn phải nhập mật khẩu và hai mật khẩu phải trùng nhau'),'error');	
			}
			
			// call Models to save
			$cid = $model->save();
			
			if($cid)
			{
				setRedirect('index.php?module=users&view=users&cid='.$cid,FSText :: _('Saved'));	
			}
			else
			{
				setRedirect('index.php?module=users&view=users',FSText :: _('Not save'),'error');	
			}
			
		}

		function save_new_session_user(){
			$username = FSInput::get ( 'username' );
			$email = FSInput::get ( 'email' );
			$ordering = FSInput::get ( 'ordering' );
			$fname = FSInput::get ( 'fname' );
			$lname = FSInput::get ( 'lname' );
			$phone = FSInput::get ( 'phone' );
			$address = FSInput::get ( 'address' );
			$country = FSInput::get ( 'country' );

			$_SESSION['users']['users']['username'] = $username;
			$_SESSION['users']['users']['email'] = $email;
			$_SESSION['users']['users']['ordering'] = $ordering;
			$_SESSION['users']['users']['fname'] = $fname;
			$_SESSION['users']['users']['lname'] = $lname;
			$_SESSION['users']['users']['phone'] = $phone;
			$_SESSION['users']['users']['address'] = $address;
			$_SESSION['users']['users']['country'] = $country;	

			
		}
		
		function cancel()
		{
			setRedirect('index.php?module=users&view=users');	
		}
		
		/*********************************** CREATE LINK *********************************/

		function linked()
		{
			$model = new UsersModelsUsers();
			$linked_list = $model->getCreateLink();
			$parent_list = $model->getParentLink();
			
			$cid = FSInput::get('cid');
			if($cid)
			{
				$linked = $model -> getLinkedById($cid);
			}
			include 'modules/'.$this->module.'/views/users/linked.php';
			
		}
		/*********************************** end CREATE LINK *********************************/

		
		/*********************************** PERMISSION *********************************/

	function permission_save() {
		$model = new UsersModelsUsers();

		$id = FSInput::get('id',0,'int');
		$link = "index.php?module=users&view=users&task=permission&cid=".$id."" ;
		$rs = $model->permission_save ($id);
		
		// if not save
		if ($rs) {
			setRedirect ( $link, 'Đã lưu thành công' );
		} else {
			setRedirect ( $link, 'Bạn chưa lưu thành công', 'error' );
		}
	}
	
	function permission_apply() {
		$model = new UsersModelsUsers();

		$id = FSInput::get('id',0,'int');
		$link =  'index.php?module=users&view=users&task=permission&cid='.$id ;
		$rs = $model->permission_save ($id);
		// if not save
		if ($rs) {
			setRedirect ( $link, 'Đã lưu thành công' );
		} else {
			setRedirect ( $link, 'Bạn chưa lưu thành công', 'error' );
		}
	}
	
	function permission(){
		$id = FSInput::get('cid');
		if(!$id || $id == 1 || $id==9){
			echo "Không được quyền sửa user này";
			return;
		}
		$model = $this -> model;
		$list_task = $model -> get_records('published = 1','fs_permission_tasks','*','ordering ASC, id ASC');
		$arr_task = array();
		foreach($list_task as $item){
			if(!isset($arr_task[$item -> module][$item -> view]))
				$arr_task[$item -> module][$item -> view] = array();
			$arr_task[$item -> module][$item -> view] = $item;	
		}
		
		// other
		$news_categories = $model->get_news_categories ();
		$products_categories = $model->get_products_categories ();
		
		$data = $model -> get_record_by_id($id,'fs_users');
		$list_permission = $model -> get_records(' user_id = '.$data -> id,'fs_users_permission','*','','','task_id');
		include 'modules/' . $this->module . '/views/' . $this->view . '/permission.php';
	}
		
	/*********************************** end PERMISSION *********************************/

	function ajax_check_name()
	{	
		$model  = $this -> model;
		$name = FSInput::get('name');
		$data_id = FSInput::get('id_user',0,'int');
		$result = $model->get_result('username="'.$name.'" AND id != ' .  $data_id);
		if($result){
			echo 1;
		}else{
			echo 0;
		}
		return;
	}

	function ajax_check_email()
	{	
		$model  = $this -> model;
		$email = FSInput::get('email');
		$data_id = FSInput::get('id_user',0,'int');
		$result = $model->get_result('email="'.$email.'" AND id != ' .  $data_id);
		if($result){
			echo 1;
		}else{
			echo 0;
		}
		return;
	}		 
}
	
?>