<?php 
	class AddressBModelsAddress extends FSModels
	{
		function __construct()
		{
		}
		
		function get_list(){
			$where = "";
			$query = " SELECT *
					  FROM fs_address
					  WHERE published = 1
					  ".$where." 
					  ORDER BY ordering ASC
					 ";
			global $db;
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		
		function get_regions(){
			return $this -> get_records('published  = 1','fs_address_regions','id,name',' ordering ASC, id ASC ');
		}
	}
?>