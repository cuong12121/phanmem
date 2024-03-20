<!-- HEAD -->
<?php 

   // $title = @$data ? FSText::_('Edit'): FSText::_('Add'); 
    $title = 'Bật tắt giá toàn bộ website';
    global $toolbar;
    $toolbar->setTitle($title);
    $toolbar->addButton('apply',FSText::_('Apply'),'','apply.png'); 
    $toolbar->addButton('save',FSText::_('Save'),'','save.png'); 
    $toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');  

 
    $this -> dt_form_begin();
    
    TemplateHelper::dt_edit_text(FSText :: _('Name'),'title',@$data -> title);
    TemplateHelper::dt_edit_text(FSText :: _('Name 2'),'title2',@$data -> title2);
    
    TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/resized/',URL_ROOT.@$data->image),150,100);

    TemplateHelper::dt_edit_text(FSText :: _('Tóm tắt trên'),'summary',@$data -> summary,'',100,9);
    TemplateHelper::dt_edit_text(FSText :: _('Tóm tắt dưới'),'summary2',@$data -> summary2,'',100,9);
    //TemplateHelper::dt_checkbox(FSText::_('Bật giá'),'is_price',@$data -> is_price,1); 
    // TemplateHelper::dt_edit_selectbox('Lựa chọn danh mục sản phẩm','wrapper_id',@$data -> wrapper_id,0,$cat_pro,'id', 'name',$size = 10,1,1,'Giữ phím ctrl để chọn nhiều item.');
    //TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
    //TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/compress/',URL_ROOT.@$data->image),50,50);
    //TemplateHelper::dt_edit_text(FSText :: _('Mô tả'),'des',@$data -> des,'',650,450,1);
    
    $this -> dt_form_end(@$data,1,0);
?>

