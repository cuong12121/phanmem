<?php
$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png');
$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   

	$this -> dt_form_begin();
	
	TemplateHelper::dt_edit_text(FSText :: _('Redirect From'),'redirect_from',@$data -> redirect_from,'',80,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Redirect To'),'redirect_to',@$data -> redirect_to,'',80,1,0);
	$this -> dt_form_end(@$data);

?>
		
