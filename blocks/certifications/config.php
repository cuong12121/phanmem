<?php 
	$params = array (
		'suffix' => array(
					'name' => 'Hậu tố',
					'type' => 'text',
					'default' => '_certifications'
					),
		'style' => array(
					'name'=>'Style',
					'type' => 'select',
					'value' => array('default' => 'Mặc định')
		),
		'limit' => array(
			'name' => 'Giới hạn',
			'type' => 'text',
			'default' => '4'
		),
		'catid' => array(
	//					'name'=>'Chọn danh mục<br/><i>(Không dùng cho lọc danh mục tự động)</i>',
			'name'=>'Chọn danh mục',
			'type' => 'select',
			'value' => get_categories(),
	//					'attr' => array('multiple' => 'multiple'),
		),
	);

	function get_categories(){
		global $db;
		$query = " SELECT name, id
		FROM fs_certifications_categories
		";
		$db->query($query);
		$list = $db->getObjectList();
		$arr_group = array(''=>'Chọn danh mục');
		
		foreach($list as $item){
			$arr_group[$item -> id] = $item -> name;
		}
		return $arr_group;
	}


	
?>

