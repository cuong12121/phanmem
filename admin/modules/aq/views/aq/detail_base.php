<table cellspacing="1" class="admintable">
<?php 
	
	TemplateHelper::dt_edit_text(FSText :: _('Tiêu đề'),'title',@$data -> title);
	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
	TemplateHelper::dt_edit_selectbox(FSText::_('Categories'),'category_id',@$data -> category_id,0,$categories,$field_value = 'id', $field_label='treename',$size = 1,0);
	// TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',URL_ROOT.@$data->image,150,100);

	TemplateHelper::dt_checkbox(FSText::_('Phổ biến'),'is_common',@$data -> is_common,1);
//	TemplateHelper::dt_checkbox(FSText::_('Tin nhanh'),'news_fast',@$data -> news_fast,1);
//	TemplateHelper::dt_checkbox(FSText::_('Tin tiêu điểm'),'news_focus',@$data -> news_focus,1);
//	TemplateHelper::dt_checkbox(FSText::_('Tin slideshow'),'news_slide',@$data -> news_slide,1);

	TemplateHelper::dt_edit_selectbox(FSText::_('Danh mục sản phẩm'),'products_category_id',@$data -> products_category_id,0,$products_categories,$field_value = 'id', $field_label='name',$size = 1,1,1);

	TemplateHelper::dt_edit_text(FSText :: _('Người hỏi'),'asker',@$data -> asker,'',60,1);
	TemplateHelper::dt_edit_text(FSText :: _('Email'),'email',@$data -> email,'',60,1);
  TemplateHelper::dt_edit_text(FSText :: _('PHone'),'phone',@$data -> phone,'',60,1);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	TemplateHelper::dt_edit_text(FSText :: _('Câu hỏi'),'question',@$data -> question,'',100,9);
	TemplateHelper::dt_edit_text(FSText :: _('Trả lời'),'content',@$data -> content,'',650,450,1);
	//TemplateHelper::dt_edit_text(FSText :: _('Tags'),'tags',@$data -> tags,'',100,4);

?>
</table>
