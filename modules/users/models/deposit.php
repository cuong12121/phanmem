<?php
/*
 * Tuan write
 */
	class UsersModelsDeposit
	{
		function getConfig($name)
		{
			global $db;
			$sql = " SELECT value FROM fs_config 
				WHERE name = '$name' ";
			// $db->query($sql);
			return $db->getResult($sql);
		}
	}
?>