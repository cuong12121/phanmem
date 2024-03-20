<?php 
	class StrengthsBModelsStrengths
	{
		function __construct()
		{
		}
	
		function get_list($category_id, $limit){
			
			global $db;
			$where = "";
			if($category_id){
				$where = ' AND category_id = '.$category_id;
			}
			$query = " SELECT *
						  FROM fs_strengths
						 WHERE  published = 1 ".$where."
						 ORDER BY  ordering ASC 
						 LIMIT ".$limit ." 
						 ";
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}

		function get_list2($category_id, $limit,$manuid,$catproid){
			
			global $db;
			$where = "";
			if($category_id){
				$where .= ' AND category_id = '.$category_id;
			}
			if($manuid){
				$where .= ' AND manufactory_related LIKE "%,'.$manuid.',%"';
			}

			if($catproid){
				$where .= ' AND category_id_wrapper LIKE "%,'.$catproid.',%"';
			}

		
			$query = " SELECT *
						  FROM fs_strengths
						 WHERE  published = 1 ".$where."
						 ORDER BY  ordering ASC 
						 LIMIT ".$limit ." 
						 ";
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}

		function get_cat($category_id){
			global $db;
			$where = "";
			if($category_id){
				$where = ' AND id = '.$category_id;
			}
			$query = " SELECT *
						  FROM fs_strengths_categories
						 WHERE  published = 1 ".$where."
						 ORDER BY  ordering ASC 
						 ";
			$sql = $db->query($query);
			$result = $db->getObject();
			return $result;
		}	
		
		
	}

?>