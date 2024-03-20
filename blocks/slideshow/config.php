<?php 
	$params = array (
		'suffix' => array(
					'name' => 'Hậu tố',
					'type' => 'text',
					'default' => '_slideshow'
					),
		'style' => array(
					'name'=>'Style',
					'type' => 'select',
					'value' => array('jellyfish' => 'Default')
			),
			'category_id' => array(
					'name'=>'Danh mục',
					'type' => 'select',
					'value' => get_categories(),
//					'attr' => array('multiple' => 'multiple'),
			),
	);
function get_categories(){
	global $db;
	$query = " SELECT name, id
						FROM fs_slideshow_categories
						ORDER By ordering, id
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