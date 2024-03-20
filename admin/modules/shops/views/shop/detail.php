<!-- HEAD -->
<?php 

    $title = @$data ? FSText::_('Edit'): FSText::_('Add'); 
    global $toolbar;
    $toolbar->setTitle($title);
    $toolbar->addButton('apply',FSText::_('Apply'),'','apply.png'); 
    $toolbar->addButton('save',FSText::_('Save'),'','save.png'); 
    $toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');  

 
    $this -> dt_form_begin(1,4,$title.' '.FSText::_('Shop'));
    
    TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
    TemplateHelper::dt_edit_text(FSText :: _('Code'),'code',@$data -> code);
    TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1); 

    $this -> dt_form_end(@$data,1,0);
?>

