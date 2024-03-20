<?php
	function view_permission($controle,$id) {
		$link = FSRoute::_("index.php?module=users&view=profile&task=permission&id=".$id);
		return '<a href="'.$link .'"><img border="0" src="'.URL_ADMIN.'templates/default/images/user.png" alt="Phân quyền"></a>';
	}

	class UsersControllersProfile extends Controllers 
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
			$model = new UsersModelsProfile();
			$groups = $model -> get_records('1=1','fs_users_groups');
	//		$all_groups = $model->getUserGroupsAll();
			
			$list = $model->getUserList();
			$pagination = $model->getPagination();
			

			// call views
			
			include 'modules/'.$this->module.'/views/profile/list.php';
		}
		
		
		function add()
		{
			$permission = FSSecurity::check_permission($this -> module, $this -> view, 'add');
	        if (!$permission){
	            echo FSText::_("Bạn không có quyền thực hiện chức năng này");
	            return;
	        }
			$model = $this -> model;
			
			$receives = $model-> get_records('published = 1','fs_users_receives');
			$quits_job = $model-> get_records('published = 1','fs_users_quits_job');
		
			$groups = $model -> get_records('1=1','fs_users_groups');
			include 'modules/'.$this->module.'/views/profile/detail.php';
		}

		function edit()
		{
			$model = $this -> model;
			$permission = FSSecurity::check_permission($this -> module, $this -> view, 'edit');
	        if (!$permission){
	            echo FSText::_("Bạn không có quyền thực hiện chức năng này");
	            return;
	        }
			$id = FSInput::get("id");
			// if($id==9){
			// 	setRedirect(FSRoute::_('index.php?module=users&view=profile'),$rows.' '.FSText :: _('Không được sửa user này'),'error');
			// }
			
			$data = $model->getUserById();
			$insurance = $model->get_record('user_id = '.$id,'fs_users_insurance');
			$contracts = $model->get_records('user_id = '.$id,'fs_users_contracts');
			$receives = $model-> get_records('published = 1','fs_users_receives');
			$quits_job = $model-> get_records('published = 1','fs_users_quits_job');
			$shops_related = $model -> get_shops_related($data -> shop_id);
			$groups = $model -> get_records('1=1','fs_users_groups');
			include 'modules/'.$this->module.'/views/profile/detail.php';
		}

		function remove()
		{
			$permission = FSSecurity::check_permission($this -> module, $this -> view, 'remove');
	        if (!$permission){
	            echo FSText::_("Bạn không có quyền thực hiện chức năng này");
	            return;
	        }

			$model = $this -> model;
			$cids = FSInput::get ( 'id', array (), 'array' );
			foreach ($cids as $id) {
				if($id == 9){
					setRedirect(FSRoute::_('index.php?module=users&view=profile'),FSText :: _('Không được xóa tài khoản admin'),'error');	
	            	return false;
				}
			}

			$rows = $model->remove();
			if($rows)
			{
				setRedirect(FSRoute::_('index.php?module=users&view=profile'),$rows.' '.FSText :: _('record was deleted'));	
			}
			else
			{
				setRedirect(FSRoute::_('index.php?module=users&view=profile'),FSText :: _('Not delete'),'error');	
			}
		}
		function published()
		{
			$model = $this -> model;
			$rows = $model->published(1);
			if($rows)
			{
				setRedirect(FSRoute::_('index.php?module=users&view=profile'),$rows.' '.FSText :: _('record was published'));	
			}
			else
			{
				setRedirect(FSRoute::_('index.php?module=users&view=profile'),FSText :: _('Error when published record'),'error');	
			}
		}
		function unpublished()
		{
			$model = $this -> model;
			$rows = $model->published(0);
			if($rows)
			{
				setRedirect(FSRoute::_('index.php?module=users&view=profile'),$rows.' '.FSText :: _('record was unpublished'));	
			}
			else
			{
				setRedirect(FSRoute::_('index.php?module=users&view=profile'),FSText :: _('Error when unpublished record'),'error');	
			}
		}
		function apply()
		{
			$this->save_new_session_user();
			$model = $this -> model;
			
			$id = FSInput::get('id');
			if(!$id){
				if($model->check_exits_email()){
					setRedirect(FSRoute::_('index.php?module=users&view=profile&task=add'),FSText :: _('Email này đã có người sử dụng'),'error');	
				}
				if($model->check_exits_username()){
					setRedirect(FSRoute::_('index.php?module=users&view=profile&task=add'),FSText :: _('Username này đã có người sử dụng'),'error');	
				}
			}
			// check password and repass
			$password = FSInput::get("password1");
			$repass = FSInput::get("re-password1");
			if($id)
			{

				// if($model->check_exits_email_not_id($id)){
				// 	setRedirect('index.php?module=users&view=profile&task=edit&cid='.$id,FSText :: _('Email này đã có người sử dụng'),'error');	
				// }

				if($model->check_exits_username_not_id($id)){
					setRedirect(FSRoute::_('index.php?module=users&view=profile&task=edit&id='.$id),FSText :: _('Username này đã có người sử dụng'),'error');	
				}
				
				$edit_pass = FSInput::get('edit_pass');

				if($edit_pass){
					if(!$password || ($password != $repass))
					{
						setRedirect(FSRoute::_('index.php?module=users&view=profile&task=edit&id='.$id),FSText :: _('Bạn phải nhập mật khẩu và hai mật khẩu phải trùng nhau'),'error');
					}
				}

			}else
			{
				if(!$password || ($password != $repass))
				{
					setRedirect(FSRoute::_('index.php?module=users&view=profile&task=add'),FSText :: _('Bạn phải nhập mật khẩu và hai mật khẩu phải trùng nhau'),'error');
				}	
			}
			// call Models to save
			$cid = $model->save();
			
			if($cid)
			{
				setRedirect(FSRoute::_("index.php?module=users&view=profile&task=edit&id=".$cid),FSText :: _('Saved'));	
			}
			else
			{
				setRedirect(FSRoute::_('index.php?module=users&view=profile&task=add'),FSText :: _('Not save'),'error');	
			}
			
		}
		function save()
		{
			$this->save_new_session_user();
			$model = $this -> model;

			$id = FSInput::get('id');

			if(!$id){
				
				// if($model->check_exits_email()){
				// 	setRedirect('index.php?module=users&view=profile&task=add',FSText :: _('Email này đã có người sử dụng'),'error');	
				// }
				if($model->check_exits_username()){
					setRedirect(FSRoute::_('index.php?module=users&view=profile&task=add'),FSText :: _('Username này đã có người sử dụng'),'error');	
				}
			}else{
				// if($model->check_exits_email_not_id($id)){
				// 	setRedirect('index.php?module=users&view=profile&task=edit&cid='.$id,FSText :: _('Email này đã có người sử dụng'),'error');	
				// }
				
				if($model->check_exits_username_not_id($id)){
					setRedirect(FSRoute::_('index.php?module=users&view=profile&task=edit&id='.$id),FSText :: _('Username này đã có người sử dụng'),'error');	
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
						setRedirect(FSRoute::_('index.php?module=users&view=profile&task=edit&id='.$id),FSText :: _('Bạn phải nhập mật khẩu và hai mật khẩu phải trùng nhau'),'error');

					}
					
				}
				

			}
			else
			{
				
				if(!$password || ($password != $repass))
					setRedirect(FSRoute::_('index.php?module=users&view=profile&task=add'),FSText :: _('Bạn phải nhập mật khẩu và hai mật khẩu phải trùng nhau'),'error');	
			}
			
			// call Models to save
			$cid = $model->save();
			
			if($cid)
			{
				setRedirect(FSRoute::_('index.php?module=users&view=profile&id='.$cid),FSText :: _('Saved'));	
			}
			else
			{
				setRedirect(FSRoute::_('index.php?module=users&view=profile'),FSText :: _('Not save'),'error');	
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
			setRedirect(FSRoute::_('index.php?module=users&view=profile'));	
		}
		
		/*********************************** CREATE LINK *********************************/

		function linked()
		{
			$model = $this -> model;
			$linked_list = $model->getCreateLink();
			$parent_list = $model->getParentLink();
			
			$cid = FSInput::get('cid');
			if($cid)
			{
				$linked = $model -> getLinkedById($cid);
			}
			include 'modules/'.$this->module.'/views/profile/linked.php';
			
		}
		/*********************************** end CREATE LINK *********************************/

		
		/*********************************** PERMISSION *********************************/

	function permission_save() {
		$model = $this -> model;

		$id = FSInput::get('id',0,'int');
		$link = FSRoute::_("index.php?module=users&view=profile&task=permission&cid=".$id) ;
		$rs = $model->permission_save ($id);
		
		// if not save
		if ($rs) {
			setRedirect ( $link, 'Đã lưu thành công' );
		} else {
			setRedirect ( $link, 'Bạn chưa lưu thành công', 'error' );
		}
	}
	
	function permission_apply() {
		$model = $this -> model;

		$id = FSInput::get('id',0,'int');
		$link =  'index.php?module=users&view=profile&task=permission&cid='.$id ;
		$rs = $model->permission_save ($id);
		// if not save
		if ($rs) {
			setRedirect ( FSRoute::_($link), 'Đã lưu thành công' );
		} else {
			setRedirect ( FSRoute::_($link), 'Bạn chưa lưu thành công', 'error' );
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

	function ajax_get_shops_related(){
		$model = $this -> model;
		$data = $model->ajax_get_shops_related();
		$html = $this -> shops_genarate_related($data);
		echo $html;
		return;
	}
	
	function shops_genarate_related($data){
		$str_exist = FSInput::get('str_exist');
		$html = '';
			$html .= '<div class="shops_related">';
			foreach ($data as $item){
				if($str_exist && strpos(','.$str_exist.',', ','.$item->id.',') !== false ){
					$html .= '<div class="red shops_related_item  shops_related_item_'.$item -> id.'" onclick="javascript: set_shops_related('.$item->id.')" style="display:none" >';	
					$html .= $item -> name;				
					$html .= '</div>';					
				}else{
					$html .= '<div class="shops_related_item  shops_related_item_'.$item -> id.'" onclick="javascript: set_shops_related('.$item->id.')">';	
					$html .= $item -> name;				
					$html .= '</div>';	
				}
			}
			$html .= '</div>';
			return $html;
	}	 
}
	
?>