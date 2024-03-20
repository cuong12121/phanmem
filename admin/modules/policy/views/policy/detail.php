<?php
// printr($_SESSION);
$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   

$this -> dt_form_begin();

TemplateHelper::dt_edit_text(FSText :: _('Title'),'title',@$data -> title);    
	//TemplateHelper::dt_edit_text(FSText :: _('Title2'),'title2',@$data -> title2);  
TemplateHelper::dt_edit_text(FSText :: _('Icon (SVG)'),'icon',@$data -> icon);
    //TemplateHelper::dt_edit_text(FSText :: _('Cat'),'category_id',@$data -> category_id);
//	TemplateHelper::dt_edit_selectbox(FSText::_('City'),'city_id',@$data -> city_id,0,$cities,$field_value = 'id', $field_label='name',$size = 10,0);
TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/resized/',URL_ROOT.@$data->image),50,50,'Kích cỡ ảnh: 340x270');
TemplateHelper::dt_edit_selectbox(FSText::_('Categories'),'category_id',@$data -> category_id,0,$categories,$field_value = 'id', $field_label='name',$size = 1,0);
TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
TemplateHelper::dt_edit_text(FSText :: _('Link'),'link',@$data -> link);  
TemplateHelper::dt_edit_text(FSText :: _('Mô tả'),'summary',@$data -> summary,'',100,5,0);
TemplateHelper::dt_edit_text(FSText :: _('Mô tả ( khi lật)'),'summary_hover',@$data -> summary_hover,'',500,50,1);
$this -> dt_form_end(@$data);

?>