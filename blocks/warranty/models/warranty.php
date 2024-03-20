<?php 
	class WarrantyBModelsWarranty
	{
		function __construct()
		{
		}
		function getList($code){

			global $db ;
			$limit = 10;
			$sql = " SELECT *
					FROM fs_warrantys
					WHERE phone = ".$code." or code = ".$code."
					ORDER BY ordering
					LIMIT $limit ";
			$db->query($sql);
			$list =  $db->getObjectList();
			return $list;
		}
		function ajax_check_code()
		{
			global $db ;
			$code      =  FSInput::get("code");
			if(!$code){
				return false;
			}
			$sql = " SELECT count(*) 
			FROM fs_warrantys 
			WHERE 
			code = '$code'
			";
			$db -> query($sql);
			$count = $db->getResult();
			if($count){
				return false;
			}
			return true;
		}
		
	}
	
?>