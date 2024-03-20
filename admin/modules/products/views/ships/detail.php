<?php 
?>
<!-- HEAD -->
	<?php 
	
	$title = @$data ? FSText :: _('Sửa'): FSText :: _('Thêm'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('apply',FSText::_('Apply'),'','apply.png'); 
	$toolbar->addButton('save',FSText::_('Save'),'','save.png'); 
	$toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');   
	
	$this -> dt_form_begin();
	TemplateHelper::dt_edit_text(FSText :: _('Loại xe'),'name',@$data -> name);
	TemplateHelper::dt_edit_text(FSText :: _('Trọng lượng từ(kg)'),'kilogam_min',@$data -> kilogam_min);
	TemplateHelper::dt_edit_text(FSText :: _('Trọng lượng đến(kg)'),'kilogam_max',@$data -> kilogam_max);
	TemplateHelper::dt_edit_text(FSText :: _('Giá 31-100 km'),'money_type_1',@$data -> money_type_1);
	TemplateHelper::dt_edit_text(FSText :: _('Giá > 100km'),'money_type_2',@$data -> money_type_2);
	$this -> dt_form_end(@$data);
	?>
<!-- END HEAD-->
