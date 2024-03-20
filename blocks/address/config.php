<?php 
	$params = array (
		'suffix' => array(
					'name' => 'Hậu tố',
					'type' => 'text',
					'default' => '_discount'
					),
		
		'style' => array(
					'name'=>'Style',
					'type' => 'select',
					'value' => array('default' => 'Mặc định','tab'=>'tab','list'=>'list')
			),
			
		
	);
	function get_discounts(){
		global $db;
			$query = " SELECT name, id
						FROM fs_discount 
						WHERE published = 1	
						";
			$db->query($query);
			$list = $db->getObjectList();
			if(!$list)
			     return;
			$arr_group = array();
            foreach($list as $item){
            	$arr_group[$item -> id] = $item -> name;
            }
			return $arr_group;
	}
?>