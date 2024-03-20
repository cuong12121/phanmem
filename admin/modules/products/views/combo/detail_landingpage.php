<table cellspacing="1" class="admintable">
<?php 

	
	TemplateHelper::dt_edit_text(FSText :: _('Landingpage template'),'landingpage',@$data -> landingpage,'',60,1,0,FSText::_("Làm theo mẫu là 'default'"));

	
	TemplateHelper::dt_edit_image(FSText :: _('Ảnh đại diện bên trái'),'landingpage_image_left',URL_ROOT.@$data->landingpage_image_left,300);


	TemplateHelper::dt_edit_image(FSText :: _('Ảnh quảng cáo bên phải'),'landingpage_image_right',URL_ROOT.@$data->landingpage_image_right,300);

	TemplateHelper::dt_edit_text(FSText :: _('Nội dung landingpage'),'landingpage_content',@$data -> landingpage_content,'',650,450,1);


	TemplateHelper::dt_edit_text(FSText :: _('Mẫu landingpage (copy sang nội dung)'),'landingpage_template',@$landingpage_template -> content,'',650,450,1);
?>
</table>
