<?php 
	class ContactBModelsContact
	{
		function __construct()
		{
		}
        function get_address_list(){
			$query = "select * from fs_address WHERE published = 1 ORDER BY ordering ASC";
			global $db;
			$sql = $db->query($query);
			$list = $db->getObjectList();
			foreach($list as $key=>$item){
				 $query_image = "select image from fs_showroom_images where address_id=".$item->id;
				 $sql_img = $db->query($query_image);
				 $item->image = $db->getObjectList();
			}
			return $list;
		}
        function get_address_current(){
			$add_id=FSInput::get('id');
			$query = "select * from fs_address where id=".$add_id;
			global $db;
			$sql = $db->query($query);
			$object = $db->getObject();
			return $object;
		}
	}
	
?>