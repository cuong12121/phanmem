<?php 
	class UsersModelsMyself  extends FSModels {
		var $limit;
		var $page;
		function __construct()
		{
			$limit = FSInput::get('limit',20,'int');
			$page = FSInput::get('page');
			$this->limit = $limit;
			$this->page = $page;
		}
		
	
		/*
		 * Select User by Id
		 */
		function getUser()
		{
			if(!$_SESSION['ad_userid'])
				return;
			$query = ' SELECT *
						  FROM fs_users
						  WHERE id = '.$_SESSION['ad_userid'].' ';
			
			global $db;
			$sql = $db->query($query);
			$result = $db->getObject();
			return $result;
		}
		
		
		function save()
		{
			global $db;
			$row = array();
			$edit_pass = FSInput::get('edit_pass');
			if($edit_pass){
				$password = FSInput::get("password1");
				$row['password'] = md5($password);
			}
			$row['fname'] = FSInput::get('fname');
			$row['lname'] = FSInput::get('lname');
			$row['phone'] = FSInput::get('phone');
			$row['address'] = FSInput::get('address');
			$row['country']= FSInput::get('country');
			return $this -> _update($row,'fs_users',' id = '.$_SESSION['ad_userid']);
		}
		
	}
	
?>