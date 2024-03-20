<table cellspacing="1" class="admintable">
	<?php
	TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
	TemplateHelper::dt_edit_text(FSText :: _('Mã sản phẩm'),'code',@$data -> code);
	TemplateHelper::dt_edit_text(FSText :: _('Số lượng'),'amount',@$data -> amount);
	TemplateHelper::dt_edit_selectbox('Loại','type',@$data -> type,'',array('1'=>'Đổi','2'=>'Trả','3'=>'Bảo hành'),$field_value = '', $field_label='',$size = 1,0,0);
	TemplateHelper::dt_edit_text(FSText :: _('Lý do'),'note',@$data -> note,'',100,5,0);
	?>
</table>
