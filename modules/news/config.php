<?php 
//module_view_task
$config_module['news_news'] = array(
	// Các trường hỗ trợ cho lấy SEO TITLE
	'fields_seo_title' => 
		array('fields'=>	array('seo_title'=>'Seo Title','title'=>'Tên','category_name'=>'Tiêu đề danh mục'),
				'help'=> 'Cấu hình cho Seo Title. AND: có lấy trường này. OR: Nếu trước nó có rồi thì ko lấy tới nó nữa'
		),
	'fields_seo_keyword'=> 
		array('fields'=> array('seo_keyword'=>'Seo Keyword','title'=>'Tên','tags'=>'Tag '),
				'help'=> 'Cấu hình cho Seo Title. AND: có lấy trường này. OR: Nếu trước nó có rồi thì ko lấy tới nó nữa'
		),
	'fields_seo_description' => 
		array('fields'=> array('seo_description'=>'Seo Description','title'=>'Tên','summary'=>'Mô tả'),
			'help'=> 'Cấu hình cho thẻ Meta keywword. AND: có lấy trường này. OR: Nếu trước nó có rồi thì ko lấy tới nó nữa'
		),	
//	'cache' => 10  // giá trị mặc định giành cho cache. Nếu == 0 hoạc không tồn tại thì sẽ không được cache module này
);
$config_module['news_home'] = array(
	// Thông số này giúp cho các trang không nhập được  SEO như trang "trang chủ sp, trang chủ tin tức,...)
	'seo_special' => 1,
	'params' => array (	
		'limit' => array(
			'name' => 'Giới hạn',
			'type' => 'text',
			'default' => '6'
		)
	)
);

$config_module['news_cat'] = array(
	// Các trường hỗ trợ cho lấy SEO TITLE
	'fields_seo_title' => 
		array('fields'=>	array('seo_title'=>'Seo Title','name'=>'Tên danh mục'),
				'help'=> 'Cấu hình cho Seo Title. AND: có lấy trường này. OR: Nếu trước nó có rồi thì ko lấy tới nó nữa'
		),
	'fields_seo_keyword'=> 
		array('fields'=> array('seo_keyword'=>'Seo Keyword','name'=>'Tên danh mục'),
				'help'=> 'Cấu hình cho Seo Title. AND: có lấy trường này. OR: Nếu trước nó có rồi thì ko lấy tới nó nữa'
		),
	'fields_seo_description' => 
		array('fields'=> array('seo_description'=>'Seo Description','name'=>'Tên danh mục'),
			'help'=> 'Cấu hình cho thẻ Meta keywword. AND: có lấy trường này. OR: Nếu trước nó có rồi thì ko lấy tới nó nữa'
		),	
	'params' => array (	
		'limit' => array(
			'name' => 'Giới hạn',
			'type' => 'text',
			'default' => '6'
		),
//		'style' => array(
//					'name'=>'Style',
//					'type' => 'select',
//					'value' => array('default' => 'Mặc định','invico'=>'Invico')
//			),
	),
//	'cache' => 10  // giá trị mặc định giành cho cache. Nếu == 0 hoạc không tồn tại thì sẽ không được cache module này
);
//$config_module['news_gallery'] = array(
//	// Các trường hỗ trợ cho lấy SEO TITLE
//	'fields_seo_h1' => 
//		array('fields'=> array('title'=>'Tiêu đề'),
//		'help'=> 'Cấu hình cho thẻ H1. AND: có lấy trường này. OR: Nếu trước nó có rồi thì ko lấy tới nó nữa'
//	),	
//	'params' => array (	
//	),
//	'cache' => 10  // giá trị mặc định giành cho cache. Nếu == 0 hoạc không tồn tại thì sẽ không được cache module này
//);
//function get_types(){
//		global $db;
//			$query = " SELECT name, id
//						FROM fs_products_types 
//						";
//			$db->query($query);
//			$list = $db->getObjectList();
//			if(!$list)
//			     return;
//			$arr_group = array();
//            foreach($list as $item){
//            	$arr_group[$item -> id] = $item -> name;
//            }
//			return $arr_group;
//	}

/*
 * Hàm liệt kê danh sách cách phương thức resize ảnh
 */
function get_method_resized_image(){
	return array('cropImge' => 'Crop ảnh', // crop ảnh
				'cut_image' => 'Cắt ảnh', // chém ảnh cho vừa khít
				'resize_image' => 'Resize ảnh',// nguyên tỉ lệ, thêm khoảng trắng
				'resized_not_crop' => 'Resize không crop',// bóp méo ảnh
		);
}
?>