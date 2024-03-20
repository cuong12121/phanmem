<!-- HEAD -->
<?php 

    $title = @$data ? FSText::_('Edit'): FSText::_('Add'); 
    global $toolbar;
    $toolbar->setTitle($title);
    $toolbar->addButton('apply',FSText::_('Apply'),'','apply.png'); 
    $toolbar->addButton('save',FSText::_('Save'),'','save.png'); 
    $toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');  

 
    $this -> dt_form_begin(1,4,$title.' '.FSText::_('Danh mục'));
    
    TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
    TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1); 
    TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
    TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/resized/',URL_ROOT.@$data->image),50,50);
    TemplateHelper::dt_edit_text(FSText :: _('Link xem thêm'),'link',@$data -> link);
    TemplateHelper::dt_edit_text(FSText :: _('Mô tả'),'des',@$data -> des,'',650,450,1);

    
    $this -> dt_form_end(@$data,1,0);
?>

