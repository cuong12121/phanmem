<?php 
	class MainMenuBModelsMainMenu extends FSModels
	{
		function __construct()
		{
		}
		function getListSubmenuNew() {
			$query = "  SELECT * 
						FROM fs_news_categories
						WHERE published = 1 AND parent_id = 0";
					
			global $db;
			$db -> query($query);
			$result = $db->getObjectList();
			return $result;
		}
		function getListSubmenu() {

			$module = FSInput::get('module');

			$query = "  SELECT id,name,alias
						FROM fs_".$module."_categories 
						WHERE published = 1 AND parent_id = 0";
					
			global $db;
			$db -> query($query);
			$result = $db->getObjectList();
			return $result;
		}
		function getList($group){
			if(!$group)	
				return;
			global $db ;
			$fstable  = FSFactory:: getClass('fstable');
			$table_name = $fstable->_('fs_menus_items');
			$sql = " SELECT *
					FROM ".$table_name."
					WHERE published  = 1
						AND group_id = $group 
					ORDER BY ordering";
			$db->query($sql);
			$result =  $db->getObjectList();
			$tree_class  = FSFactory::getClass('tree','tree/');
			return $list = $tree_class -> indentRows($result,3);
		}
		function getListCat() {
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = "SELECT name,alias,id,level,parent_id as parent_id,alias, list_parents,tablename,image,icon,show_in_homepage,show_in_footer,level_menu
						  FROM ".$fs_table->_('fs_products_categories')." AS a
						  WHERE published = 1
						  ORDER BY ordering ASC, id DESC
						  
						 ";
		global $db;
		$db->query ( $query );
		$category_list = $db->getObjectList ();
		
		if (! $category_list)
			return;
		$tree_class = FSFactory::getClass ( 'tree', 'tree/' );
		return $list = $tree_class->indentRows ( $category_list, 3 );
	
		}
		function get_menu_parent($parent_id,$group_id){
			if(!$parent_id){
				return;
			}
			$query = "  SELECT * 
						FROM fs_menus_items
						WHERE published = 1 AND group_id = ".$group_id." AND parent_id =".$parent_id ." ORDER BY ordering ASC";
			global $db;
			$db -> query($query);
			$result = $db->getObjectList();
			return $result;
		}

		function active_sub($cid) {
			$module = FSInput::get('module');
			$id = FSInput::get('id');
			
			if(!$module || !$id || !$cid)
				return 0;	
			
			$query = "  SELECT id,category_id_wrapper 
						FROM fs_".$module."
						WHERE id = " .$id ." AND category_id_wrapper like '%,".$cid.",%'";				
			global $db;
			$db -> query($query);
			$result = $db->getObject();
			if(!empty($result)){
				return 1;
			}
			return 0;
		}
	}
?>