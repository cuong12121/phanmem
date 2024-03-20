
<?php 
	class News_filterBModelsNews_filter
	{
		function __construct()
		{
		  $this->table_name = FSTable::_('fs_news_categories');
		} 
		
		function get_product_category($id = 0)
		{
			global $db;
			$where = '';
			if($id)
				$where .= ' WHERE AND published = 1 AND parent_id = '.$id;
			else   
				$where .= ' WHERE level = 0 AND published = 1';
			$query = "SELECT * FROM ".$this->table_name." ".$where. " ORDER BY ordering ASC";
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}         
		function get_product_category_leve1()
		{
			global $db;
			
			$query = "SELECT * FROM ".$this->table_name." WHERE level = 1 AND published = 1 ORDER BY ordering ASC";
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}      
		
		function get_product_category_leve2()
		{
			global $db;
			
			$query = "SELECT * FROM ".$this->table_name." WHERE level = 2 AND published = 1 ORDER BY ordering ASC";
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}    

	}
	
?>