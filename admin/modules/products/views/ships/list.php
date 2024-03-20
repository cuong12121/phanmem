<?php  
	global $toolbar;
	$toolbar->setTitle(FSText::_('Cấu hình vận chuyển') );
	// $toolbar->addButton('add',FSText::_('Th&#234;m m&#7899;i'),'','add.png'); 
	$toolbar->addButton('edit',FSText::_('S&#7917;a'),FSText::_('B&#7841;n ch&#432;a ch&#7885;n b&#7843;n ghi n&#224;o !'),'edit.png'); 
	$toolbar->addButton('remove',FSText::_('X&#243;a'),FSText::_('B&#7841;n ch&#432;a ch&#7885;n b&#7843;n ghi n&#224;o !'),'remove.png'); 
	// $toolbar->addButton('published',FSText::_('K&#237;ch ho&#7841;t'),FSText::_('B&#7841;n ch&#432;a ch&#7885;n b&#7843;n ghi n&#224;o !'),'published.png');
	// $toolbar->addButton('unpublished',FSText::_('Ng&#7915;ng k&#237;ch ho&#7841;t'),FSText::_('B&#7841;n ch&#432;a ch&#7885;n b&#7843;n ghi n&#224;o !'),'unpublished.png');
	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 

	//	CONFIG	
	$list_config = array();
	$list_config[] = array('title'=>'Loại xe','field'=>'name','ordering'=> 1, 'type'=>'text','col_width' => '10%','align'=>'left');
	$list_config[] = array('title'=>'Trọng lượng từ(kg)','field'=>'kilogam_min','ordering'=> 1, 'type'=>'text','col_width' => '10%','align'=>'left');
	$list_config[] = array('title'=>'Trọng lượng đến(kg)','field'=>'kilogam_max','ordering'=> 1, 'type'=>'text','col_width' => '10%','align'=>'left');
	$list_config[] = array('title'=>'Giá 31-100 km','field'=>'money_type_1','ordering'=> 1, 'type'=>'text','col_width' => '10%','align'=>'left');
	$list_config[] = array('title'=>'Giá > 100km','field'=>'money_type_2','ordering'=> 1, 'type'=>'text','col_width' => '10%','align'=>'left');
	$list_config[] = array('title'=>'Người sửa','field'=>'user_edit_name','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Thời gian sửa','field'=>'edited_time','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Edit','type'=>'edit');
	// $list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
	$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this,$this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>

