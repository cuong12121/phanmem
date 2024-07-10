<?php
class FSSecurity
{
	function __construct(){
		
	}

	static function check_permission_groups($module,$view,$task){

		// $module = FSInput::get('module');
		// $view =  FSInput::get('view');
		// $task =  FSInput::get('task');
		// echo $task;

		if($module == 'built' || $task == 'ajax_products_search_keyword' ||  $task == 'ajax_show_info_product' || $task == 'print' || $task == 'revoke' || $task == 'ajax_reverse' || $module == 'users' && $view == 'messages' && $task == 'display') {
			return true;
		}

		if(!$view){
			$view =  FSInput::get('view',$module);
		}

		if(!$task || $task=='back'){
			$task = 'display';
		}

		$module = strtolower($module);
		$view = strtolower($view);
		$task = strtolower($task);
		if($module == 'home' || $task == 'cancel' || $_SESSION['ad_groupid'] == 4 || $_SESSION['ad_userid'] == 9 || $_SESSION['ad_userid'] == 6 || $task == 'logout' ||  $task == 'ajax_set_ss_search_multipe' ||  $task == 'ajax_unset_ss' ||  $task == 'ajax_get_product_name'){
			return true;
		}
		if(!isset($_SESSION['ad_userid']) || !isset($_SESSION['ad_groupid'])){
			return false;
		}

	
		if($task == 'save' || $task== 'apply' || $task =='hot' || $task == 'unhot'  ||  $task =='home' || $task == 'unhome'|| $task== 'save_new' || $task== 'duplicate' ||  $task== 'save_all' || $task== 'permission_save'|| $task== 'permission_apply' || $task == 'published' ){
			$task = 'edit';
		}


		global $db;
		$sql = 'SELECT id FROM fs_permission_tasks WHERE module = "'.$module.'" AND `view` = "'.$view.'" AND _task = "'.$task.'"' ;
		$task_db = $db->getObject($sql);

		if(empty($task_db)){
			return false;
		}

		


		$sql2 = 'SELECT * FROM fs_users_groups WHERE id = '.$_SESSION['ad_groupid'];
		$group_data = $db->getObject($sql2);
		// printr($group_data);


		$pos = strpos($group_data-> str_task,','.$task_db->id.',');

		if($pos !== false){
		    return true;
		}else{
			return false;
		}
		
	}

	static function check_permission_status_warehouses(){
		if(!isset($_SESSION['ad_userid']) || !isset($_SESSION['ad_groupid'])){
			return false;
		}
		if($_SESSION['ad_userid'] == 9) {
			return true;
		}

		global $db;
		$sql2 = 'SELECT * FROM fs_users_groups WHERE id = '.$_SESSION['ad_groupid'];
		$group_data = $db->getObject($sql2);

		$pos = strpos($group_data-> str_task,','.'125'.',');
		if($pos !== false){
			return true;
		}else{
			return false;
		}

	}

	static function  check_permission($module,$view='',$task=''){
		return true;
		if(!$module)
			$module = FSInput::get('module');
			
		if(!$view)
			$view =  FSInput::get('view',$module);
		if(!$task)
			$task = 'display';
		$module = strtolower($module);
		$view = strtolower($view);
		$task = strtolower($task);
		if($module == 'users' && $view == 'log' && $task == 'logout' )
			return true;
			
		if(!isset($_SESSION['ad_userid']))
			return false;

		global $db;
		// get task_id
	
		$sql = 'SELECT id,`trigger` FROM fs_permission_tasks WHERE module = "'.$module.'" AND `view` = "'.$view.'"' ;
		$task_db = $db->getObject($sql);
		if(!$task_db)
			return true;

			// trigger	
			
		
		$user_id = $_SESSION['ad_userid'];
        
        $sql_permission_user = ' SELECT user_id FROM fs_users_permission WHERE user_id = "'.$user_id.'" ' ;
        $permission_user = $db->getObjectList($sql_permission_user);
        if(!count($permission_user)){
        	if($user_id == 9){
        		return true;
        	}
			return false;
        }
		
		$sql_permission = ' SELECT permission FROM fs_users_permission WHERE user_id = "'.$user_id.'" AND task_id IN ('.$task_db -> id.') ' ;
		$permission = $db->getResult($sql_permission);

		// echo 

		// not set: return true
		if(!$permission)
			return false;

			
		// view	
			

			if($module = "order" && $view = "order"){
				if(($task == 'display' || $task =='detail' || $task == 'permission' || $task == 'edit' ) && (float)$permission < 3)
					return false;

				if(($task == 'save' || $task =='add'  || $task== 'apply' || $task =='hot' || $task == 'unhot'  ||  $task =='home' || $task == 'unhome'|| $task== 'save_new' || $task== 'duplicate' ||  $task== 'save_all' || $task== 'permission_save'|| $task== 'permission_apply' || $task == 'published' || $task == 'change_satus_order'  ) && (float)$permission < 5){
					return false;
				}
			}else{
				if(($task == 'display' || $task =='detail' || $task == 'permission' ) && (float)$permission < 3)
					return false;

				if(($task == 'save' || $task =='add' || $task == 'edit' || $task== 'apply' || $task =='hot' || $task == 'unhot'  ||  $task =='home' || $task == 'unhome'|| $task== 'save_new' || $task== 'duplicate' ||  $task== 'save_all' || $task== 'permission_save'|| $task== 'permission_apply' || $task == 'published' ) && (float)$permission < 5){
					return false;
				}
			}

			if(($task == 'published' || $task == 'unpublished' ) && (float)$permission < 6){
				return false;
			}

			if(($task == 'remove' || $task =='delete' || $task == 'del' ) && (float)$permission < 7)
				return false;
			return true;
	}

	static function  check_permission_other($module,$view='',$task=''){
		
		if(!$module)
			$module = FSInput::get('module');
			
		if(!$view)
			$view =  FSInput::get('view',$module);
		if(!$task)
			$task = 'display';
		$module = strtolower($module);
		$view = strtolower($view);
		$task = strtolower($task);
		if($module == 'users' && $view == 'log' && $task == 'logout' )
			return true;
			
		if(!isset($_SESSION['ad_userid']))
			return false;

		global $db;
		// get task_id
	
		$sql = 'SELECT id,`trigger` FROM fs_permission_tasks WHERE module = "'.$module.'" AND `view` = "'.$view.'"' ;
		$task_db = $db->getObject($sql);
		if(!$task_db)
			return true;

			// trigger	
			
		
		$user_id = $_SESSION['ad_userid'];
       
        $sql_permission_user = ' SELECT user_id FROM fs_users_permission WHERE user_id = "'.$user_id.'" ' ;
        $permission_user = $db->getObjectList($sql_permission_user);

        if(!count($permission_user)){
        	if($user_id == 9){
        		return true;
        	}
			return false;
        }


		
		$sql_permission = ' SELECT permission FROM fs_users_permission WHERE user_id = "'.$user_id.'" AND task_id IN ('.$task_db -> id.') ' ;
		$permission = $db->getResult($sql_permission);




		// not set: return true
		if(!$permission)
			return false;

			$arr_per = explode('.', @$permission);
			$permission = $arr_per[1];
			// echo $permission;
			// die;

		// view	
			if(($task == 'display' || $task =='detail'  || $task == 'permission' ) && (float)$permission < 3)
				return false;

			if(($task == 'save' || $task =='add' || $task == 'edit' || $task== 'apply' || $task =='hot' || $task == 'unhot'  ||  $task =='home' || $task == 'unhome'|| $task== 'save_new' || $task== 'duplicate' ||  $task== 'save_all' || $task== 'permission_save'|| $task== 'permission_apply' || $task == 'published' ) && (float)$permission < 5){
				return false;
			}

			if(($task == 'published' || $task == 'unpublished' ) && (float)$permission < 6){
				return false;
			}

			

			if(($task == 'remove' || $task =='delete' || $task == 'del' ) && (float)$permission < 7)
				return false;
			return true;
	}

	static function save_history($module,$view='',$task=''){
	
		if(!$module)
			$module = FSInput::get('module');
			
		if(!$view)
			$view =  FSInput::get('view',$module);
		if(!$task)
			$task = 'display';
		$module = strtolower($module);
		$view = strtolower($view);
		$task = strtolower($task);
		if($module == 'users' && $view == 'log' && $task == 'logout' )
			return true;

		if($task == 'display' || $task=='edit' || $task == 'add' || $task== 'cancel' || $task == 'select_categories'){
			return;
		}

		if(!isset($_SESSION['ad_userid']))
			return false;

		$row = array();

		$ids = FSInput::get('id',array(),'array');
		// if(empty($ids)){
		// 	$ids = FSInput::get('cid',array(),'array');
		// }
		
		if(count($ids)){
			$row['ids_action']  = implode(',',$ids);				
		}
		
	
		$row['module'] = $module;
		$row['view'] = $view;
		$row['task'] = $task;
		$row['module'] = $module;

		$row['user_id'] = $_SESSION['ad_userid'];
		$row['username'] = $_SESSION['ad_username'];
		$row['ipaddress'] = $_SERVER['REMOTE_ADDR'];
		
		$time = date('Y-m-d H:i:s');	
		$row['created_time'] = $time;
		
		
		FSSecurity :: _add($row,'fs_admin_history');
	}


	static	function _add($row,$table_name,$use_mysql_real_escape_string = 0){
			if(!$table_name)
				return false;
			global $db;	
			$str_fields = array();
			$str_values = array();
			
			if(!count($row))
				return;
			foreach($row as $field => $value){
				if($use_mysql_real_escape_string){
					$value = $db -> escape_string($value);	
				
				}
				$str_fields[] =   "`".$field."`";
				$str_values[]  =   "'".$value."'";
			}
			
			$str_fields = implode(',',$str_fields);
			$str_values = implode(',',$str_values);
			
			global $db;
			
			$sql = ' INSERT INTO  '.$table_name ;
			$sql .=  '('.$str_fields.') ';
			$sql .=  'VALUES ('.$str_values.') ';
			
			$id = $db->insert($sql);
			return $id;
		}
		
	

}