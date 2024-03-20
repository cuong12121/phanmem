<?php 
	class ProductsModelsManufactories
    {   
        function __construct()
		{
			$this -> table_name = FSTable::_('fs_manufactories');
		}
		function get_list(){
			$fs_table = FSFactory::getClass('fstable');
			$table_name = $fs_table -> getTable('fs_manufactories');
						
			$query = "  select * 
						from ".$table_name." 
						where published=1 
						ORDER BY ordering ASC,name ASC
						";
			global $db;
			$sql = $db->query($query);
			$list = $db->getObjectListByKey('id');
			return $list;
		}
		function get_list_hot(){
			$fs_table = FSFactory::getClass('fstable');
			$table_name = $fs_table -> getTable('fs_manufactories');
						
			$query = "  select * 
						from ".$table_name." 
						where published=1  AND  show_in_homepage = 1
						ORDER BY name ASC
						Limit 12
						";
			global $db;
			$sql = $db->query($query);
			$list = $db->getObjectList();
			return $list;
		}
	}
?>