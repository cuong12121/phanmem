
<?php 
	TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
	//TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
	TemplateHelper::dt_edit_selectbox(FSText::_('Parent'),'parent_id',@$data -> parent_id,'',$categories,$field_value = 'id', $field_label='treename',$size = 1,0,1);
	//TemplateHelper::dt_edit_selectbox(FSText::_('Tên bảng'),'tablename',@$data -> tablename,'',$tables,$field_value = 'table_name', $field_label='table_name',$size = 1,0,1);
	TemplateHelper::dt_edit_image(FSText :: _('Ảnh'),'image',str_replace('/original/','/resized/',URL_ROOT.@$data->image),128,128,'Kích cỡ ảnh: 480x640');
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
	//TemplateHelper::dt_checkbox(FSText::_('Nofollow'),'nofollow',@$data -> nofollow,0,'',null,'Khi chọn CÓ thì google sẽ không index');
	
	//TemplateHelper::dt_edit_text(FSText :: _('Tóm tắt'),'summary',@$data -> summary,'',650,450,1);
	//TemplateHelper::dt_edit_text(FSText :: _('Mô tả'),'description',@$data -> description,'',650,450,1);

	?>
