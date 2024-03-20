<?php  
global $toolbar;
$toolbar->setTitle(FSText :: _('Bảo hành') );
$toolbar->addButton('duplicate',FSText :: _('Duplicate'),'','duplicate.png');
$toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');

	//	FILTER
$filter_config  = array();
$fitler_config['search'] = 0; 
$fitler_config['filter_count'] = 0;
$fitler_config['text_count'] = 3;

$text_imei = array();
$text_imei['title'] =  FSText::_('IMEI'); 

$text_phone = array();
$text_phone['title'] =  FSText::_('SĐT KH'); 

$text_info = array();
$text_info['title'] =  FSText::_('Name'); 

$fitler_config['text'][] = $text_imei;
$fitler_config['text'][] = $text_phone;
$fitler_config['text'][] = $text_info;



	//	CONFIG	
$list_config = array();
	// $list_config[] = array('title'=>'Title','field'=>'title','ordering'=> 1, 'type'=>'text','col_width' => '20%','arr_params'=>array('size'=> 30));
$list_config[] = array('title'=>'Name','field'=>'name','ordering'=> 1, 'type'=>'text','col_width' => '12%','arr_params'=>array('size'=> 30));
$list_config[] = array('title'=>'Phone','field'=>'phone','ordering'=> 1, 'type'=>'text','col_width' => '12%','arr_params'=>array('size'=> 30));
$list_config[] = array('title'=>'IMEI','field'=>'imei','ordering'=> 1, 'type'=>'text','col_width' => '12%','arr_params'=>array('size'=> 30));
$list_config[] = array('title'=>'Tên máy','field'=>'device_name','ordering'=> 1, 'type'=>'text','col_width' => '10%','arr_params'=>array('size'=> 30));

$list_config[] = array('title'=>'Bắt đầu bảo hành','field'=>'begin_time','ordering'=> 1, 'type'=>'date');
$list_config[] = array('title'=>'Hạn bảo hành','field'=>'end_time','ordering'=> 1, 'type'=>'date');
$list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
$list_config[] = array('title'=>'Edit','type'=>'edit');
$list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');

TemplateHelper::genarate_form_liting($this, $this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>
