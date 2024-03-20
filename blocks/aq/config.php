<?php 
	$params = array (
		'suffix' => array(
					'name' => 'Hậu tố',
					'type' => 'text',
					'default' => '_news_list'
					),
		'limit' => array(
					'name' => 'Giới hạn',
					'type' => 'text',
					'default' => '6'
					),
		'type' => array(
					'name'=>'Lấy theo',
					'type' => 'select',
					'value' => array('newest'=> 'Mới nhất'),
//					'attr' => array('multiple' => 'multiple'),
			),
		'summary' => array(
				'name' => 'Mô tả',
				'type' => 'textarea',
				'default' => ''
				),		
		'style' => array(
					'name'=>'Style',
					'type' => 'select',
					'value' => array('default' => 'Mặc định','col1' => '1 cột','form_question' => 'Gửi câu hỏi')
			)

	);
?>