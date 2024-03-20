<?php
$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   

$this -> dt_form_begin();
TemplateHelper::dt_edit_text(FSText :: _('Title'),'title',@$data -> title);
TemplateHelper::dt_edit_text(FSText :: _('Họ tên'),'name',@$data -> name);
TemplateHelper::dt_edit_text(FSText :: _('Thông tin khác'),'more_info',@$data -> more_info);
TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/resized/',URL_ROOT.@$data->image),50,50,'Kích cỡ ảnh: 76x76');
TemplateHelper::dt_edit_image(FSText :: _('Image video'),'image_video',str_replace('/original/','/large/',URL_ROOT.@$data->image_video),360,196,'Kích cỡ ảnh: 360x196');
//TemplateHelper::dt_edit_image(FSText :: _('Image video'),'image_video',str_replace('/original/','/large/',URL_ROOT.@$data->image_video),50,50);
TemplateHelper::dt_edit_text(FSText :: _('Link video'),'file_flash',@$data -> file_flash);
// TemplateHelper::dt_edit_image(FSText :: _('Image_video'),'image',str_replace('/original/','/resized/',URL_ROOT.@$data->image),50,50,'Kích cỡ ảnh: 76x76');
//	TemplateHelper::dt_edit_selectbox(FSText::_('City'),'city_id',@$data -> city_id,0,$cities,$field_value = 'id', $field_label='name',$size = 10,0);

TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
TemplateHelper::dt_edit_text(FSText :: _('Description'),'description',@$data -> description,'',100,5,0);
$this -> dt_form_end(@$data);

?>