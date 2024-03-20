<!-- HEAD -->
<?php 

    $title = @$data ? FSText::_('Edit'): FSText::_('Add'); 
    global $toolbar;
    $toolbar->setTitle($title);
    $toolbar->addButton('apply',FSText::_('Apply'),'','apply.png'); 
    $toolbar->addButton('save',FSText::_('Save'),'','save.png'); 
    $toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');  

 
    //$this -> dt_form_begin(1,4,$title.' '.FSText::_('Danh mục'));
    $this -> dt_form_begin();
    
    TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
    TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias);

    //TemplateHelper::dt_edit_text(FSText :: _('Name 2'),'name2',@$data -> name2);
    TemplateHelper::dt_edit_selectbox(FSText::_('Parent'),'parent_id',@$data -> parent_id,0,$categories,$field_value = 'id', $field_label='treename',$size = 10,0,1);

    TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/resized/',URL_ROOT.@$data->image),150,150,'');

    TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1); 
    // TemplateHelper::dt_edit_selectbox('Lựa chọn danh mục sản phẩm','wrapper_id',@$data -> wrapper_id,0,$cat_pro,'id', 'name',$size = 10,1,1,'Giữ phím ctrl để chọn nhiều item.');
    TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
    //TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/compress/',URL_ROOT.@$data->image),150,100);
    //TemplateHelper::dt_edit_text(FSText :: _('Mô tả'),'des',@$data -> des,'',650,450,1);
    TemplateHelper::dt_edit_text(FSText :: _('Mô tả'),'des',@$data -> des,'',100,9);
    
    $this -> dt_form_end(@$data,1,0);
?>

