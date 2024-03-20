<?php 
	class DiscountBModelsDiscount
	{
		function __construct()
		{
		}
		
		function get_data($id){
			$where = "";
			if($id)
				$where = "AND id = ".$id."";
			$query = " SELECT *
					  FROM fs_discount
					  WHERE published = 1
					  ".$where." AND total < `limit`
					  ORDER BY id
					 ";
			global $db;
			$sql = $db->query($query);
			return  $db->getObject();
		}
	}
?>