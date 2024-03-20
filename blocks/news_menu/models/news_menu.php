<?php 
	class News_menuBModelsNews_menu
	{
		function __construct()
		{
		}
		function getList(){
	
			$query = " SELECT name,alias,id,level,parent_id as parent_id,alias, list_parents
						  FROM fs_news_categories AS a
						  WHERE published = 1
						  ORDER BY ordering ASC, id ASC
						 ";
			global $db;
			$db->query($query);
			$category_list = $db->getObjectList();
			
			if(!$category_list)
				return;
			$tree_class  = FSFactory::getClass('tree','tree/');
			return $list = $tree_class -> indentRows($category_list,3);
		}
	}
?>