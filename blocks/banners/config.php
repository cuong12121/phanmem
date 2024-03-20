<?php 
	$params = array (
		'suffix' => array(
					'name' => 'Hậu tố',
					'type' => 'text',
					'default' => '_banner'
					),
		'id' => array(
					'name' => 'Id (dùng cho qcáo bên ngoài trang)',
					'type' => 'text',
					'default' => 'divAdLeft',
					'comment' => 'divAdLeft dùng cho bên trái, divAdRight cho bên phải'
					),
		'style' => array(
					'name'=>'Style',
					'type' => 'select',
					'value' => array('default' => 'Mặc định','wrapper'=>'Có viền bao','out'=> 'Quảng cáo trượt 2 bên','r_slide' => "Bên phải slideshow",'popup'=> 'Popup')
			),
		'load_lazy' => array(
					'name'=>'Load lazy',
					'type' => 'select',
					'value' => array('0' => 'Lazy','1'=>'Không lazy')
			),
		'category_id' => array(
					'name'=>'Nhóm banner',
					'type' => 'select',
					'value' => get_category(),
					'attr' => array('multiple' => 'multiple'),
			),
	);
	function get_category(){
		global $db;
			$query = " SELECT name, id 
						FROM fs_banners_categories 
						";
			$sql = $db->query($query);
			$result = $db->getObjectList();
			if(!$result)
			     return;
			$arr_group = array();
            foreach($result as $item){
            	$arr_group[$item -> id] = $item -> name;
            }
			return $arr_group;
	}
	
?>