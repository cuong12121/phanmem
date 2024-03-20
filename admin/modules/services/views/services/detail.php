<?php
$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   

	$this -> dt_form_begin();
	
	TemplateHelper::dt_edit_text(FSText :: _('Title'),'title',@$data -> title);
	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
	// TemplateHelper::dt_edit_text(FSText :: _('Tên xét nghiệm'),'name',@$data -> name);
	// TemplateHelper::dt_edit_text(FSText :: _('Đối tượng xét nghiệm'),'objects',@$data -> objects);
	TemplateHelper::dt_edit_text(FSText :: _('Giá cao nhất'),'maxPrice',@$data -> maxPrice);
	TemplateHelper::dt_edit_text(FSText :: _('Giá thấp nhất'),'minPrice',@$data -> minPrice);
	TemplateHelper::dt_edit_selectbox(FSText::_('Categories'),'category_id',@$data -> category_id,0,$categories,$field_value = 'id', $field_label='treename',$size = 1,0);
	TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',URL_ROOT.str_replace('/original/','/resized/',@$data->image));
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	TemplateHelper::dt_checkbox(FSText::_('Show in homepage'),'show_in_homepage',@$data -> show_in_homepage,0);
//	TemplateHelper::dt_checkbox(FSText::_('Tin nhanh'),'news_fast',@$data -> news_fast,1);
//	TemplateHelper::dt_checkbox(FSText::_('Tin tiêu điểm'),'news_focus',@$data -> news_focus,1);
//	TemplateHelper::dt_checkbox(FSText::_('Tin slideshow'),'news_slide',@$data -> news_slide,1);

	
	TemplateHelper::dt_edit_text(FSText :: _('Icon SVG(show home mới cần)'),'icon',@$data -> icon);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
	TemplateHelper::dt_edit_text(FSText :: _('Summary'),'summary',@$data -> summary,'',100,9,1);
	// TemplateHelper::dt_edit_text(FSText :: _('Hướng dẫn'),'tutorial',@$data -> tutorial,'',100,9,1);
	TemplateHelper::dt_edit_text(FSText :: _('Content'),'content',@$data -> content,'',650,450,1);
//	TemplateHelper::dt_edit_text(FSText :: _('Tags'),'tags',@$data -> tags,'',100,4);
	$this -> dt_form_end(@$data,1,1);

?>
