<table cellspacing="1" class="admintable">
	<?php
	TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
	// TemplateHelper::dt_edit_text(FSText :: _('Mô tả'),'summary',@$data -> summary,'',100,5,0);
	TemplateHelper::dt_checkbox(FSText ::_('Published'),'published',@$data -> published,1);
	?>
</table>
