<?php 
	$params = array (
		'suffix' => array(
					'name' => 'Hậu tố',
					'type' => 'text',
					'default' => '_banner'
					),
		'style' => array(
					'name'=>'Style',
					'type' => 'select',
					'value' => array('default' => 'Default','children_menu' => 'Menu cấp con')
			),
			'group' => array(
					'name'=>'Danh mục',
					'type' => 'select',
					'value' => get_categories(),
//					'attr' => array('multiple' => 'multiple'),
			),
	);
function get_categories(){
	global $db;
	$query = " SELECT group_name, id
						FROM fs_menus_groups
						ORDER By ordering, id
						";
	$db->query($query);
	$list = $db->getObjectList();
	if(!$list)
	     return;
	$arr_group = array();
    foreach($list as $item){
        $arr_group[$item -> id] = $item -> group_name;
    }
	return $arr_group;
}	
?>