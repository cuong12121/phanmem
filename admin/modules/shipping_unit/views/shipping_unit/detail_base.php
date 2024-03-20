<?php 
    TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
    TemplateHelper::dt_edit_text(FSText :: _('Phí ship'),'price',@$data -> price,'',20,1,0);


    TemplateHelper::dt_edit_text(FSText :: _('Số ngày dự kiến'),'days',@$data -> days,'',20,1,0);
    TemplateHelper::dt_checkbox(FSText::_('Mặc định'),'is_default',@$data -> is_default,0);
    //TemplateHelper::dt_edit_text(FSText :: _('Chủ tài khoản'),'account_name',@$data -> account_name);
    // TemplateHelper::dt_edit_image(FSText:: _('Image'),'image',URL_ROOT.@$data->image,'',''); 
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
?>
