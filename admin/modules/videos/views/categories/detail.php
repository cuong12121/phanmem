<!-- HEAD -->
	<?php 
	
	$title = @$data ? FSText::_('Edit'): FSText::_('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('apply',FSText::_('Apply'),'','apply.png'); 
	$toolbar->addButton('save',FSText::_('Save'),'','save.png'); 
	$toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');   
	
	$this -> dt_form_begin();
	
	TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
//	TemplateHelper::dt_edit_text(FSText :: _('Chiều rộng ảnh lớn'),'width',@$data -> width,0,'20');
//	TemplateHelper::dt_edit_text(FSText :: _('Chiều cao ảnh lớn'),'height',@$data -> height,0,'20');
//	TemplateHelper::dt_edit_text(FSText :: _('Chiều rộng ảnh thumnail'),'width_small',@$data -> width_small,0,'20');
//	TemplateHelper::dt_edit_text(FSText :: _('Chiều cao ảnh thumnail'),'height_small',@$data -> height_small,0,'20');
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,0,'20');
	TemplateHelper::dt_sepa();
	TemplateHelper::dt_edit_text(FSText :: _('SEO title'),'seo_title',@$data -> seo_title,'',100,1);
	TemplateHelper::dt_edit_text(FSText :: _('SEO meta keyword'),'seo_keyword',@$data -> seo_keyword,'',100,1);
	TemplateHelper::dt_edit_text(FSText :: _('SEO meta description'),'seo_description',@$data -> seo_description,'',100,9);
//	
	$this -> dt_form_end(@$data,1,0);
	
	?>