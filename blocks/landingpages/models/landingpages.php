<?php 
class LandingpagesBModelsLandingpages
{
	function get_content(){
		$limit = 1;
		$where = '';
		$query = " SELECT * 
		FROM fs_landingpages_content 
		WHERE  published = 1 ".$where."
		ORDER BY  ordering ASC 
		LIMIT ".$limit ." 
		";
		global $db;
		$db->query($query);
		$list = $db->getObjectList();
		return $list;
	}

	function get_images($intro_id){
		$where = " AND record_id=".$intro_id;
		$query = " SELECT * 
		FROM fs_landingpages_images
		WHERE '1=1'".$where."
		ORDER BY id ASC";
		global $db;
		$db->query($query);
		$list = $db->getObjectList();
		return $list;
	}
		function get_list( $limit){
			
			global $db;
			$where = "";
			
			$query = " SELECT *
						  FROM fs_landingpages
						 WHERE  published = 1 ".$where."
						 ORDER BY  ordering ASC 
						 LIMIT ".$limit ." 
						 ";
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}


}
?>