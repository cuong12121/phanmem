<?php
$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   

$this -> dt_form_begin();
TemplateHelper::dt_edit_text(FSText :: _('Name'),'title',@$data -> title);
TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias);
TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/resized/',URL_ROOT.@$data->image),100,60,'Kích cỡ ảnh: 600px x 387px');
TemplateHelper::dt_edit_text(FSText :: _('Loại'),'type_name',@$data -> type_name);
TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
//TemplateHelper::dt_edit_text(FSText :: _('Description'),'description',@$data -> description,'',100,5,0);
$this -> dt_form_end(@$data);

?>