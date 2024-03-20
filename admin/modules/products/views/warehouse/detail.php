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
	TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
	TemplateHelper::dt_edit_text(FSText :: _('Latitude'),'latitude',@$data -> latitude);
	TemplateHelper::dt_edit_text(FSText :: _('Longitude'),'longitude',@$data -> longitude);
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
	$this -> dt_form_end(@$data);
	?>
<!-- END HEAD-->
