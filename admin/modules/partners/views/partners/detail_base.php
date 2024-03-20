<table cellspacing="1" class="admintable">
<?php 

	TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
	// TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',URL_ROOT.str_replace('/original/','/resized/', @$data->image),'','');
	TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/resized/',URL_ROOT.@$data->image),164,80,'Kích cỡ ảnh: 164x80 px');
	//TemplateHelper::dt_edit_text(FSText :: _('Địa chỉ'),'adress',@$data -> adress);
	//TemplateHelper::dt_edit_text(FSText :: _('Lĩnh vực'),'field',@$data -> field);	
	//TemplateHelper::dt_edit_text(FSText :: _('Url'),'url',@$data -> url,'',80,1,0);
	//	TemplateHelper::dt_edit_selectbox(FSText::_('Categories'),'category_id',@$data -> category_id,0,$categories,$field_value = 'id', $field_label='name',$size = 1,0);
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	// TemplateHelper::dt_checkbox(FSText::_('Nổi bật'),'is_hot',@$data -> is_hot,1);
	//TemplateHelper::dt_edit_text(FSText :: _('Summary'),'summary',@$data -> summary,'',100,9);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
?>
</table>


