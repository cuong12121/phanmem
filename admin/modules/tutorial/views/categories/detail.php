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
	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
	TemplateHelper::dt_edit_selectbox(FSText::_('Parent'),'parent_id',@$data -> parent_id,0,$categories,$field_value = 'id', $field_label='treename',$size = 10,0,1);
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
//	TemplateHelper::dt_checkbox(FSText::_('Hiển thị tên category trong bài viết'),'display_title',@$data -> display_title,1);
	TemplateHelper::dt_checkbox(FSText::_('Hiển thị comment trong bài viết'),'display_comment',@$data -> display_comment,1);
	TemplateHelper::dt_checkbox(FSText::_('Hiển thị tags cho bài viết'),'display_tags',@$data -> display_tags,1);
	TemplateHelper::dt_checkbox(FSText::_('Hiển thị tin liên quan cho bài viết'),'display_related',@$data -> display_related,1);
	TemplateHelper::dt_checkbox(FSText::_('Hiển thị ngày tạo cho bài viết'),'display_created_time',@$data -> display_created_time,1);
	TemplateHelper::dt_checkbox(FSText::_('Hiển thị tóm tắt bài viết'),'display_summary',@$data -> display_summary,1);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
	TemplateHelper::dt_edit_text(FSText :: _('Mã schema'),'schema',@$data -> schema,'',60,6,0);
//	TemplateHelper::dt_edit_image(FSText :: _('Icon'),'icon',@$data -> icon);
	
	$this -> dt_form_end(@$data,1,1);
	
	?>

