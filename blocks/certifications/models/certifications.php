<?php 
	class CertificationsBModelsCertifications
	{
		function __construct()
		{
		}
		
		function get_list($category_id,$limit){
			global $db;
			$where = "";
			if($category_id){
				$where .= ' AND category_id = '.$category_id;
			}

			$fstable = FSFactory::getClass('fstable');
			$table_name  = $fstable->_('fs_certifications');
			$query = " SELECT *
						 FROM ".$table_name."
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
						  FROM fs_certifications_categories
						 WHERE  published = 1 ".$where."
						 ORDER BY  ordering ASC 
						 ";
			$sql = $db->query($query);
			$result = $db->getObject();
			return $result;
		}
	}
	
?>