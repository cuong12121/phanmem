<?php 
	class LeftMenuBModelsLeftMenu
	{
		function __construct()
		{
		}
		
		function getList($group,$order_to_tree = 1){
			/*
			 * Gá»�i tá»« fsglobal Ä‘á»ƒ há»— trá»£ memcache 
			 */
			$global_class = FSFactory::getClass('FsGlobal');
			$list = $global_class -> get_menu_by_group($group);
			
			if(!$list)	
				return;
//			global $db ;
//			$sql = " SELECT id,link, name, level, parent_id as parent_id, target
//					FROM fs_menus_items
//					WHERE published  = 1
//						AND group_id = $group 
//					ORDER BY ordering";
//			$db->query($sql);
//			$result =  $db->getObjectList();
				
			if($order_to_tree){
				$tree_class  = FSFactory::getClass('tree','tree/');
				return $list = $tree_class -> indentRows($list,3);
			} else {
				return $list;
			}
		}
	}
?>