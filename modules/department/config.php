<?php 

$config_module['department_department'] = array(
	'seo_special' => 1,
	'params' => array (	
		'limit' => array(
			'name' => 'Giới hạn',
			'type' => 'text',
			'default' => '6'
		)
	)
);

function get_method_resized_image(){
	return array('cropImge' => 'Crop ảnh', // crop ảnh
				'cut_image' => 'Cắt ảnh', // chém ảnh cho vừa khít
				'resize_image' => 'Resize ảnh',// nguyên tỉ lệ, thêm khoảng trắng
				'resized_not_crop' => 'Resize không crop',// bóp méo ảnh
		);
}
?>