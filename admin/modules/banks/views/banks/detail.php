<?php
$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   

	$this -> dt_form_begin();
	
	
    TemplateHelper::dt_edit_text(FSText :: _('Tên'),'name',@$data -> name);
    TemplateHelper::dt_edit_text(FSText :: _('Code'),'code',@$data -> code);
    $array_card = array('master'=>'Master card','visa'=> 'Visa','jcb'=>'JCB')  ;
	TemplateHelper::dt_edit_selectbox(FSText::_('Loại thẻ'),'card_types_1',@$data -> card_types,0,$array_card,$field_value = 'id', $field_label='name',$size = 10,1);
	TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/resized/',URL_ROOT.@$data->image),90,20,'Kích cỡ ảnh: 90x20');
	TemplateHelper::dt_edit_text(FSText :: _('Lãi vay 3 tháng'),'interest_rate_3_month',@$data -> interest_rate_3_month);
	TemplateHelper::dt_edit_text(FSText :: _('Lãi vay 6 tháng'),'interest_rate_6_month',@$data -> interest_rate_6_month);
	TemplateHelper::dt_edit_text(FSText :: _('Lãi vay 9 tháng'),'interest_rate_9_month',@$data -> interest_rate_9_month);
	TemplateHelper::dt_edit_text(FSText :: _('Lãi vay 12 tháng'),'interest_rate_12_month',@$data -> interest_rate_12_month);
	TemplateHelper::dt_edit_text(FSText :: _('Lãi vay 24 tháng'),'interest_rate_24_month',@$data -> interest_rate_24_month);
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
	TemplateHelper::dt_edit_text(FSText :: _('Description'),'description',@$data -> description,'',100,5,0);
	$this -> dt_form_end(@$data);

?>