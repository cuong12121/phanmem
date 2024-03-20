<?php
$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png');
$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   

	$this -> dt_form_begin();
	
	TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
	TemplateHelper::dt_edit_text(FSText :: _('Tên 2'),'name2',@$data -> name2);
//	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
	TemplateHelper::dt_edit_selectbox(FSText::_('Categories'),'category_id',@$data -> category_id,0,$categories,$field_value = 'id', $field_label='name',$size = 1,0);
	TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',URL_ROOT.str_replace('/original/','/slideshow_small/', @$data->image),'','');
	TemplateHelper::dt_edit_text(FSText :: _('Link 1'),'url',@$data -> url,'',80,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Tên Link 1'),'url_name',@$data -> url_name,'',80,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Link 2'),'url2',@$data -> url2,'',80,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Tên link 2'),'url_name2',@$data -> url_name2,'',80,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Summary'),'summary',@$data -> summary,'',100,9);
	TemplateHelper::dt_checkbox(FSText::_('Hiển thị text'),'is_text',@$data -> is_text,1);
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
	$this -> dt_form_end(@$data);

?>
		
