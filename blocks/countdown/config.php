<?php 
	$params = array (
		'suffix' => array(
					'name' => 'Hậu tố',
					'type' => 'text',
					'default' => '_product_list'
					),
		'limit' => array(
					'name' => 'Giới hạn',
					'type' => 'text',
					'default' => '6'
					),		
		'type' => array(
					'name'=>'Lấy theo',
					'type' => 'select',
					'value' => array('selling'=>'Bán chạy','in_cat'=>'Cùng danh mục','promotion'=>'Khuyến mại','hot'=>'Sản phẩm hot','relate'=>'SP liên quan với tin tức'),
//					'attr' => array('multiple' => 'multiple'),
			),			
		'style' => array(
					'name'=>'Style',
					'type' => 'select',
					'value' => array('default' => 'Mặc định','vertical'=>'Chiều dọc','slide'=>'Slide')
			)

	);
?>