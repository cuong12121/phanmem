<?php 
$params = array (
	'suffix' => array(
		'name' => 'Hậu tố',
		'type' => 'text',
		'default' => '_reasons'
	),
	'limit' => array(
		'name' => 'Giới hạn',
		'type' => 'text',
		'default' => '4'
	),
//		'identity' => array(
//					'name' => 'Đánh dấu id ( cho slideshow)',
//					'type' => 'text',
//					'default' => ''
//		
	// 'show_readmore' => array(
	// 	'name'=>'Hiện thị readmore',
	// 	'type' => 'is_check',
	// ),
	'catid' => array(
//					'name'=>'Chọn danh mục<br/><i>(Không dùng cho lọc danh mục tự động)</i>',
		'name'=>'Chọn danh mục',
		'type' => 'select',
		'value' => get_categories(),
//					'attr' => array('multiple' => 'multiple'),
	),

	// 'manuid' => array(
	// 	'name' => 'Hãng',
	// 	'type' => 'text'
	// ),
	// 'catproid' => array(
	// 	'name' => 'Danh mục sản phẩm',
	// 	'type' => 'text'
	// ),

	'style' => array(
		'name'=>'Style',
		'type' => 'select',
		'value' => array('full_cat' => 'Tất cả danh mục')
	),
	// 'summary' => array(
	// 	'name' => 'Mô tả',
	// 	'type' => 'text',
	// 	'default' => ''
	// ),

	// 'link' => array(
	// 	'name' => 'link',
	// 	'type' => 'text',
	// 	'default' => ''
	// ),
);
function get_categories(){
	global $db;
	$query = " SELECT name, id
	FROM fs_reasons_categories
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