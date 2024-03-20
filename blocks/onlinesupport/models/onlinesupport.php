<?php 
	class OnlinesupportBModelsOnlinesupport
	{
		function __construct()
		{
		}
		function getList(){
			global $db ;
			$limit = 5;
			$sql = " SELECT id, name as display_name, yahoo,skype,email,hotline,image
					FROM fs_onlinesupport
					WHERE published  = 1 
					ORDER BY ordering
					LIMIT $limit ";
			$db->query($sql);
			return $db->getObjectList();
		}
		
	}
	
?>