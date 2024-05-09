<table cellspacing="1" class="admintable">
	<?php
	TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);

	?>
	<label for="parent">Kho cha</label>

	<select name="parent" id="parent" class="form-control">

	  	<option value="0">Kho Hà Nội</option>
	  	<option value="1">Kho Sài Gòn</option>
	  	
	</select>

	<?php
	// TemplateHelper::dt_edit_text(FSText :: _('Mô tả'),'summary',@$data -> summary,'',100,5,0);
	TemplateHelper::dt_checkbox(FSText ::_('Published'),'published',@$data -> published,1);
	?>
</table>
