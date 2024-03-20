<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Danh sách thành viên đăng ký') );
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 
	$fitler_config['filter_count'] = 1;

	$filter_categories = array();
	$filter_categories['title'] = FSText::_('Chương trình'); 
	$filter_categories['list'] = @$discounts; 
	$filter_categories['field'] = 'name'; 
	
	$fitler_config['filter'][] = $filter_categories;																																																																																																																																																																																																																																																																																																																																																																																																																						

	//	CONFIG	
	$list_config = array();
	$list_config[] = array('title'=>'Email','field'=>'email','ordering'=> 1, 'type'=>'text','col_width' => '25%','arr_params'=>array('size'=> 30));
	$list_config[] = array('title'=>'Sex','field'=>'sex','ordering'=> 1, 'type'=>'text','col_width' => '25%','arr_params'=>array('size'=> 30,'function'=>'display_sex'));
	$list_config[] = array('title'=>'Giảm','field'=>'','type'=>'text','arr_params'=>array('function'=>'display_discount'));
	$list_config[] = array('title'=>'Mã giảm giá','field'=>'code','ordering'=> 1, 'type'=>'text','col_width' => '15%','arr_params'=>array('size'=> 10));
//	$list_config[] = array('title'=>'Ordering','field'=>'ordering','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>3));
	$list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published','col_width' => '7%');
	$list_config[] = array('title'=>'Ngày đăng kí','field'=>'created_time','ordering'=> 1, 'type'=>'datetime','col_width' => '10%');
	$list_config[] = array('title'=>'Ngày hết hạn','field'=>'expire_time','ordering'=> 1, 'type'=>'datetime','col_width' => '10%');
	$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text','col_width' => '5%');
	TemplateHelper::genarate_form_liting($this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>
