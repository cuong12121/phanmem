<?php 
	class FacebookBModelsFacebook
	{
		function __construct()
		{
		}
		
		function get_data(){							
			$query = "  SELECT id,name,image,more_info,model,price,link
					FROM fs_slideshow
					WHERE published = 1
					ORDER BY ordering ";
			global $db;
			$db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
	}
	
?>