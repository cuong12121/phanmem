<?php 
$params = array (
	'suffix' => array(
		'name' => 'Hậu tố',
		'type' => 'text',
		'default' => '_products'
	),

	'limit' => array(
		'name' => 'Giới hạn',
		'type' => 'text',
		'default' => '10'
	),
	'type' => array(
		'name'=>'Lấy theo',
		'type' => 'select',
		'value' => array('newest'=> 'Mới nhất','is_hotdeal'=>'Hotdeal','sale'=>'Bán nhiều nhất','viewest'=>'Xem nhiều nhất','random' => 'Ngẫu nhiên','hot'=>'Sản phẩm hot','same_author'=>'Cùng người đăng','discount'=>"Khuyến mại"),
//					'attr' => array('multiple' => 'multiple'),
	),	
		// 'filter_category_auto' => array(
		// 		'name'=>'Lọc tự động theo category</i>',
		// 		'type' => 'is_check',
		// ),

	'style' => array(
		'name'=>'Style',
		'type' => 'select',
		'value' => array('row_2'=>'2 cột','slideshow_hot' => "Slideshow hotdeal")
	),
	'catid' => array(
		'name'=>'Chọn danh mục',
		'type' => 'select',
		'value' => get_categories(),
	),
	
	'link' => array(
		'name' => 'Xem tất cả',
		'type' => 'text',
		'default' => ''
	),

);
function get_categories(){
	global $db;
	$query = " SELECT name, id
	FROM fs_products_categories
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