<?php 
//module_view_task
$config_module['products_product'] = array(
	// Các trường hỗ trợ cho lấy SEO TITLE
	'fields_seo_title' => 
		array('fields'=>	array('seo_title'=>'Seo Title','name'=>'Tên sản phẩm','category_name'=>'Tiêu đề danh mục'),
				'help'=> 'Cấu hình cho Seo Title. AND: có lấy trường này. OR: Nếu trước nó có rồi thì ko lấy tới nó nữa'
		),
	'fields_seo_keyword'=> 
		array('fields'=> array('seo_keyword'=>'Seo Keyword','name'=>'Tên sản phẩm','tags'=>'Tag sản phẩm'),
				'help'=> 'Cấu hình cho Seo Title. AND: có lấy trường này. OR: Nếu trước nó có rồi thì ko lấy tới nó nữa'
		),
	'fields_seo_description' => 
		array('fields'=> array('seo_description'=>'Seo Description','name'=>'Tên sản phẩm','summary'=>'Mô tả'),
			'help'=> 'Cấu hình cho thẻ Meta keywword. AND: có lấy trường này. OR: Nếu trước nó có rồi thì ko lấy tới nó nữa'
		),	
	'params' => array (	
			'image_large_size' => array(
							'name' => 'Resize ảnh => Ảnh lớn: Kích thước',
							'type' => 'text',
							'default' => '360x360',
							'help'=> 'Đây là ảnh lớn nằm ở trang chi tiết sản phẩm. Nhập dạng: <strong>rộng x cao</strong>',
							),
				'image_large_method' => array(
							'name' => 'Resize ảnh => Ảnh lớn: Phương thức resize ảnh',
							'type' => 'select',
							'default' => 'cut_image',
							'value' => get_method_resized_image(),
							'help'=> 'Phương thức lấy ảnh nhỏ hơn từ ảnh gốc:<br/> 
									<strong> - Crop</strong>: Giữ nguyên tỉ lệ ảnh<br/>
									<strong> - Cắt ảnh</strong>: Cắt ảnh cho vừa vào tỉ lệ mới, có thể ảnh gốc sẽ bị khuyết một vài chỗ<br/>
									<strong> - Resize</strong>: Ảnh mới có thay đổi, nhưng không bị biến dạng ảnh, thêm màu trắng hoặc trong suốt vào chỗ khuyết<br/>
									<strong> - Resize không crop</strong>: Bóp méo ảnh cũ để đạt được kích thước mới<br/>
									',
							),
				'sepa1' => array(
							'type' => 'sepa',
							),			
				'image_resized_size' => array(
							'name' => 'Resize ảnh => Ảnh nhỏ: Kích thước',
							'type' => 'text',
							'default' => '130x130',
							'help'=> 'Đây là ảnh đại diện thường nằm ở trang danh sách sản phẩm. Nhập dạng: <strong>rộng x cao</strong>',
							),
				'image_resized_method' => array(
							'name' => 'Resize ảnh => Ảnh nhỏ: Phương thức resize ảnh',
							'type' => 'select',
							'default' => 'cut_image',
							'value' => get_method_resized_image(),
							'help'=> 'Phương thức lấy ảnh nhỏ hơn từ ảnh gốc:<br/> 
									<strong> - Crop</strong>: Giữ nguyên tỉ lệ ảnh<br/>
									<strong> - Cắt ảnh</strong>: Cắt ảnh cho vừa vào tỉ lệ mới, có thể ảnh gốc sẽ bị khuyết một vài chỗ<br/>
									<strong> - Resize</strong>: Ảnh mới có thay đổi, nhưng không bị biến dạng ảnh, thêm màu trắng hoặc trong suốt vào chỗ khuyết<br/>
									<strong> - Resize không crop</strong>: Bóp méo ảnh cũ để đạt được kích thước mới<br/>
									',
							),
				'sepa2' => array(
							'type' => 'sepa',
							),				
				'image_small_size' => array(
							'name' => 'Resize ảnh => Ảnh nhỏ trong slileshow: Kích thước',
							'type' => 'text',
							'default' => '70x70',
							'help'=> 'Đây là ảnh nhỏ trong slideshow. Nhập dạng: <strong>rộng x cao</strong>',
							),
				'image_small_method' => array(
							'name' => 'Resize ảnh => Ảnh nhỏ trong slileshow: Phương thức resize ảnh',
							'type' => 'select',
							'default' => 'cut_image',
							'value' => get_method_resized_image(),
							'help'=> 'Phương thức lấy ảnh nhỏ hơn từ ảnh gốc:<br/> 
									<strong> - Crop</strong>: Giữ nguyên tỉ lệ ảnh<br/>
									<strong> - Cắt ảnh</strong>: Cắt ảnh cho vừa vào tỉ lệ mới, có thể ảnh gốc sẽ bị khuyết một vài chỗ<br/>
									<strong> - Resize</strong>: Ảnh mới có thay đổi, nhưng không bị biến dạng ảnh, thêm màu trắng hoặc trong suốt vào chỗ khuyết<br/>
									<strong> - Resize không crop</strong>: Bóp méo ảnh cũ để đạt được kích thước mới<br/>
									',
							),
				'sepa3' => array(
							'type' => 'sepa',
							),				
				'use_manufactory' => array(
							'name' => 'Sử dụng hãng sản xuất',
							'type' => 'is_check',
							'default' => '1'
						),
				'use_model' => array(
							'name' => 'Sử dụng dòng sản phẩm',
							'type' => 'is_check',
							'default' => '1',
							'help'=> 'Dòng sản phẩm chỉ được sử dụng khi có sử dụng <strong>Hãng sản xuất</strong>. Đây là các dòng sản phẩm riêng biệt do các hãng sản xuất tạo ra',
						),
	),

);
$config_module['products_home'] = array(
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

$config_module['products_cat'] = array(
	// Các trường hỗ trợ cho lấy SEO TITLE
	'fields_seo_title' => 
		array('fields'=>	array('seo_title_filter'=>'Seo Title Filter','seo_title'=>'Seo Title','name'=>'Tên danh mục'),
				'help'=> 'Cấu hình cho Seo Title. AND: có lấy trường này. OR: Nếu trước nó có rồi thì ko lấy tới nó nữa'
		),
	'fields_seo_keyword'=> 
		array('fields'=> array('seo_keyword_filter'=>'Seo Keyword Filter','seo_keyword'=>'Seo Keyword','name'=>'Tên danh mục'),
				'help'=> 'Cấu hình cho Seo Title. AND: có lấy trường này. OR: Nếu trước nó có rồi thì ko lấy tới nó nữa'
		),
	'fields_seo_description' => 
		array('fields'=> array('seo_description_filter'=>'Seo Description Filter','seo_description'=>'Seo Description','name'=>'Tên danh mục'),
			'help'=> 'Cấu hình cho thẻ Meta keywword. AND: có lấy trường này. OR: Nếu trước nó có rồi thì ko lấy tới nó nữa'
		),	
	'params' => array (	
		'limit' => array(
			'name' => 'Giới hạn',
			'type' => 'text',
			'default' => '6'
		),

	),
);


$config_module['products_manufactory'] = array(
	// Các trường hỗ trợ cho lấy SEO TITLE
	'fields_seo_title' => 
		array('fields'=>	array('seo_title_filter'=>'Seo Title Filter','seo_title'=>'Seo Title','name'=>'Tên danh mục'),
				'help'=> 'Cấu hình cho Seo Title. AND: có lấy trường này. OR: Nếu trước nó có rồi thì ko lấy tới nó nữa'
		),
	'fields_seo_keyword'=> 
		array('fields'=> array('seo_keyword_filter'=>'Seo Keyword Filter','seo_keyword'=>'Seo Keyword','name'=>'Tên danh mục'),
				'help'=> 'Cấu hình cho Seo Title. AND: có lấy trường này. OR: Nếu trước nó có rồi thì ko lấy tới nó nữa'
		),
	'fields_seo_description' => 
		array('fields'=> array('seo_description_filter'=>'Seo Description Filter','seo_description'=>'Seo Description','name'=>'Tên danh mục'),
			'help'=> 'Cấu hình cho thẻ Meta keywword. AND: có lấy trường này. OR: Nếu trước nó có rồi thì ko lấy tới nó nữa'
		),	
	'params' => array (	
		'limit' => array(
			'name' => 'Giới hạn',
			'type' => 'text',
			'default' => '6'
		),

	),
);


$config_module['products_manufactories'] = array(
	// Thông số này giúp cho các trang không nhập được  SEO như trang "trang chủ sp, trang chủ tin tức,...)
	'seo_special' => 1
	// 'params' => array (	
	// 	'limit' => array(
	// 		'name' => 'Giới hạn',
	// 		'type' => 'text',
	// 		'default' => '6'
	// 	)
	// )
);

$config_module['products_hotdeal'] = array(
	// Thông số này giúp cho các trang không nhập được  SEO như trang "trang chủ sp, trang chủ tin tức,...)
	'seo_special' => 1
	// 'params' => array (	
	// 	'limit' => array(
	// 		'name' => 'Giới hạn',
	// 		'type' => 'text',
	// 		'default' => '6'
	// 	)
	// )
);

$config_module['products_sell'] = array(
	// Thông số này giúp cho các trang không nhập được  SEO như trang "trang chủ sp, trang chủ tin tức,...)
	'seo_special' => 1,
	'params' => array (	
		'limit' => array(
			'name' => 'Giới hạn',
			'type' => 'text',
			'default' => '20'
		)
	)
);


$config_module['products_combo'] = array(
	'seo_special' => 1,
	'params' => array (	
		'limit' => array(
			'name' => 'Giới hạn',
			'type' => 'text',
			'default' => '20'
		)
	)
);


$config_module['products_tags'] = array(
	// Các trường hỗ trợ cho lấy SEO TITLE
	'fields_seo_title' => 
		array('fields'=>	array('seo_title'=>'Seo Title'),
				'help'=> 'Cấu hình cho Seo Title. AND: có lấy trường này. OR: Nếu trước nó có rồi thì ko lấy tới nó nữa'
		),
	'fields_seo_keyword'=> 
		array('fields'=> array('seo_keyword'=>'Seo Keyword'),
				'help'=> 'Cấu hình cho Seo Title. AND: có lấy trường này. OR: Nếu trước nó có rồi thì ko lấy tới nó nữa'
		),
	'fields_seo_description' => 
		array('fields'=> array('seo_description'=>'Seo Description'),
			'help'=> 'Cấu hình cho thẻ Meta keywword. AND: có lấy trường này. OR: Nếu trước nó có rồi thì ko lấy tới nó nữa'
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