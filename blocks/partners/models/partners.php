<?php 
	class PartnersBModelsPartners
	{
		function __construct()
		{
		}
		
		function get_data($limit){

			$where=" ";
			$query = "  SELECT id,name,image,url
					FROM fs_partners
					WHERE published =1 ".$where."
					 ORDER BY ordering
					 LIMIT $limit  
					 ";
			global $db;
			$db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
	}
	
?>