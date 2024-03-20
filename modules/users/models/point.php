<?php
/*
 * Tuan write
 */
	class UsersModelsPoint
	{
		function __construct()
		{
			$limit = 10;
			$page = FSInput::get('page',0,'int');
			$this->limit = $limit;
			$this->page = $page;
		}
		function get_member(){
			$user_id = $_SESSION['user_id'];
			global $db;
			$sql = " SELECT point,money,level FROM fs_members
				WHERE id = '$user_id' ";
			// $db->query($sql);
			return $db->getObject($sql);
		}
		function get_level(){
			$sql = " SELECT * FROM fs_members_level ";
			global $db ;
			$db->query($sql);
			return $db->getObjectListByKey('level');
		}
	}
?>