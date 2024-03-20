<?php 
	class Products_categories_slideshowBModelsProducts_categories_slideshow
	{
		function __construct()
		{
		}
		
		function get_data($category_id,$limit = 10){	
			$where = "";
			if($category_id){
				$where .= " AND category_id = ".$category_id;
			}

			$fstable = FSFactory::getClass('fstable');
			$table_name  = $fstable->_('fs_products_categories_slideshow');						
			$query = "  SELECT id,name,image,url,summary
					FROM ".$table_name."
					WHERE published = 1 ".$where."
					ORDER BY ordering ";

			global $db;
			$db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
	}
	
?>