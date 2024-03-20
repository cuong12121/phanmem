<?php 

    $title = @$data ? FSText::_('Edit'): FSText::_('Add'); 
    global $toolbar;
    $toolbar->setTitle($title);
    $toolbar->addButton('apply',FSText::_('Apply'),'','apply.png'); 
    $toolbar->addButton('save',FSText::_('Save'),'','save.png'); 
    $toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');  

 
    $this -> dt_form_begin(1,4,$title.' '.FSText::_('Nạp - trừ tiền'));

    if(!empty($data)){
?>

    <div class="form-group">
        <label class="col-md-2 col-xs-12 control-label">Shop</label>
        <div class="col-md-10 col-xs-12">
            <?php echo $data->user_name; ?>
            <input type="hidden" name="user_id" value="<?php echo $data->user_id; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 col-xs-12 control-label">Số tiền</label>
        <div class="col-md-10 col-xs-12">
            <?php echo format_money($data->money,' đ','0 đ'); ?>
             <input type="hidden" name="money" value="<?php echo $data->money; ?>">
        </div>
    </div>

<?php 
    }else{
        TemplateHelper::dt_edit_selectbox(FSText::_('Tài khoản quản lý Shop'),'user_id',@$data -> user_id,0,$users_shop,$field_value = 'id', $field_label='username',$size = 1,0,1);
        TemplateHelper::dt_edit_text(FSText :: _('Số tiền'),'money',@$data -> money,'','',1,0,FSText::_("Nếu trừ thì nhập '-' đằng trước số tiền / VD: -1000000"));
    }
    TemplateHelper::dt_edit_text(FSText :: _('Summary'),'summary',@$data -> summary);
  
    $this -> dt_form_end(@$data,1,0);
?>

