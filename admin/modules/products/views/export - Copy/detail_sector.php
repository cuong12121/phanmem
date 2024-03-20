<table cellspacing="1" class="admintable">
<?php 
	TemplateHelper::dt_edit_text(FSText :: _('Hà nội'),'ha_hoi',@$data -> ha_hoi);
	TemplateHelper::dt_edit_text(FSText :: _('Tp.Hồ Chí Minh'),'ho_chi_minh',@$data -> ho_chi_minh);
	TemplateHelper::dt_edit_text(FSText :: _('Đà nẵng'),'da_nang',@$data -> da_nang);
?>
</table>

