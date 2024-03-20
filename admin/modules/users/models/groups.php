<?php 
	class UsersModelsGroups extends FSModels
	{
		var $limit;
		var $page;
		function __construct()
		{
			$limit = FSInput::get('limit',20,'int');
			$page = FSInput::get('page');
			$this->limit = $limit;
			$this->page = $page;
			$this -> view = 'groups';
			$this -> table_name = 'fs_users_groups';
		}
		
		function save($row = array(), $use_mysql_real_escape_string = 1)
		{
			$arr_task = FSInput::get('check_task',array(),'array');
			// printr($arr_task);
			if(!empty($arr_task)){
				$str_task = implode(',',$arr_task);
				$str_task = ','.$str_task.',';
				$row['str_task'] = $str_task;
			}else{
				$row['str_task'] = '';
			}
			$result_id = parent::save ($row);
			return $result_id;
		}
		 
	}
	
?>