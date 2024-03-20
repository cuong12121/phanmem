
<?php 
    $title = @$data ? FSText::_('Edit'): FSText::_('Add'); 
    global $toolbar;
    $toolbar->setTitle($title);
    $toolbar->addButton('apply',FSText::_('Apply'),'','apply.png'); 
    $toolbar->addButton('save',FSText::_('Save'),'','save.png'); 
    $toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');  


    $this -> dt_form_begin(1,4,$title.' '.FSText::_('Bán hàng ra kho'));
    TemplateHelper::dt_edit_text(FSText :: _('sku'),'sku',@$data -> sku,'',60,1,0);
    TemplateHelper::dt_edit_text(FSText :: _('color'),'color',@$data -> color,'',60,1,0);
    TemplateHelper::dt_edit_text(FSText :: _('size'),'size',@$data -> size,'',60,1,0);
    $this -> dt_form_end(@$data,1,0);
?>

