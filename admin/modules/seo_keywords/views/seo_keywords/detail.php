<?php
$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   

$this -> dt_form_begin();
TemplateHelper::dt_edit_text(FSText :: _('Title'),'title',@$data -> title);
TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/small/',URL_ROOT.@$data->image),150,74,'Kích cỡ ảnh: 1260x620');
TemplateHelper::dt_edit_selectbox(FSText::_('Categories'),'category_id',@$data -> category_id,0,$categories,$field_value = 'id', $field_label='title',$size = 1,0);

TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
// TemplateHelper::dt_checkbox(FSText::_('Hiện trang chủ'),'show_in_home',@$data -> show_in_home,0);
TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
$this -> dt_form_end(@$data);

?>