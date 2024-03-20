<?php 
//module_view_task
$config_module['albums_home'] = array(
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

?>