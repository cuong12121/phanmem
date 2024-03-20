<?php 
    TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
    TemplateHelper::dt_edit_text(FSText :: _('Chi nhánh'),'branch',@$data -> branch);
    TemplateHelper::dt_edit_text(FSText :: _('Số tài khoản'),'account',@$data -> account);
    TemplateHelper::dt_edit_text(FSText :: _('Chủ tài khoản'),'account_name',@$data -> account_name);
    // TemplateHelper::dt_edit_image(FSText:: _('Image'),'image',URL_ROOT.@$data->image,'',''); 
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
?>
