<!-- HEAD -->
	<?php 
	
	$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('cancel',FSText :: _('Cancel'),'','cancel.png'); 
    
    $this -> dt_form_begin(1,4,$title.' '.FSText::_('Group'));
    
    TemplateHelper::dt_edit_text(FSText :: _('Name'),'group_name',@$data -> group_name);
    TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1); 
    TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
    
    $this -> dt_form_end(@$data,1,0);
?>


