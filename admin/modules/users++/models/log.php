<?php 
	class UsersModelsLog
	{
		function __construct()
		{
		}
		
		function login()
		{
			global $db;
			$password = md5(FSInput::get('password'));
			$username = FSInput::get('username');
			$sql = " SELECT username, email, id as userid 
					FROM fs_users
					WHERE username = '$username'
						AND password = '$password'
						 ";
			$db->query($sql);
			$user = $db->getObject();
			
			if(!$user)
			{
				return false;
			}
			
			$sql_group  = " SELECT a.group_id 
							FROM fs_users_groups AS a
							INNER JOIN fs_groups AS b ON a.group_id = b.id 
							WHERE a.userid = $user->id
								AND b.published = 1 ";
			$db->query($sql_group);
			$grs = $db->getObjectList();
			
			
			if(!$grs)
				return false;
				
			// convert groupid list: from array to string 
			$arr_grs = array();
			foreach ($grs as $gr) {
				$arr_grs[]  = $gr->group_id;
			}	
			$str_grs = implode(",",$arr_grs);

			$_SESSION['ad_logged'] = 1;
			$_SESSION['ad_username'] = $user->username;
	//		$_SESSION['email'] = $user->email;
			$_SESSION['ad_userid'] = $user->userid;
	//		$_SESSION['grs'] = $user->$str_grs;
			
			return true;
		}
		
		function logout()
		{
			session_start();	
			if(isset($_SESSION['ad_logged']) )	
				unset($_SESSION['ad_logged'])	;
				
			if (isset( $_SESSION['ad_username'] ))	 
				unset( $_SESSION['ad_username'] ) ;
				
	//		if ( isset( $_SESSION['email']))	
	//			unset ( $_SESSION['email']);
				
			if ( isset( $_SESSION['ad_userid']))	 
				unset ( $_SESSION['ad_userid']);
				 
		//	if ( isset( $_SESSION['grs']))	
		//		unset ( $_SESSION['grs']);
		}
			
		/*
		 * Add infor when user login
		 */
		function changeUserInfor()
		{
			
		}
				 
	}
	
?>