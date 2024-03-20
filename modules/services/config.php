<?php 
//module_view_task
$config_module['contents_content'] = array(
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
		)	
);

$config_module['contents_cat'] = array(
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