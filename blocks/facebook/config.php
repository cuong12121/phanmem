<?php 
	$params = array (
		'suffix' => array(
					'name' => 'Hậu tố',
					'type' => 'text',
					'default' => '_facebook'
					),
		
		'fanpage' => array(
					'name'=>'Fanpage',
					'type' => 'text',
					'value' => '',

			),			
		'fanpage_name' => array(
					'name'=>'Tên Fanpage',
					'type' => 'text',
					'value' => '',

			),	
		'width' => array(
					'name'=>'Width',
					'type' => 'text',
					'default' => '280',

			),	
			'height' => array(
					'name'=>'Height',
					'type' => 'text',
					'default' => '300',

			),	
			'style' => array(
					'name'=>'Style',
					'type' => 'select',
					'value' => array('default' => 'Mặc định')
					
			),

	);
	
?>