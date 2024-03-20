<?php 
	class ManufactoriesBModelsManufactories
	{
		function __construct()
		{
		}
		
		function get_data($limit){

		
			$query = "SELECT *
						FROM fs_manufactories
						WHERE published =1 and show_in_homepage= 1
						ORDER BY ordering ASC LIMIT ". $limit
					;
			global $db;
			$db->query($query);
			$result = $db->getObjectList();
			return $result;
		}

		function get_data_luxury($limit){

			$query = "SELECT *
						FROM fs_manufactories
						WHERE published =1 and is_luxury = 1
						ORDER BY ordering DESC LIMIT " .$limit
					;
			global $db;
			$db->query($query);
			$result = $db->getObjectList();
			return $result;
		}

		
	}
	
?>