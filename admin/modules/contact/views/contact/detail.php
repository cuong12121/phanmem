<?php
    $title = @$data ? FSText :: _('Sửa'): FSText :: _('Add'); 
    global $toolbar;
    $toolbar->setTitle($title);
    $toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
    $toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
    $toolbar->addButton('back',FSText :: _('Cancel'),'','cancel.png');   

	$this -> dt_form_begin(1,4,$title.' '.FSText::_('Liên hệ'));
    
    TemplateHelper::dt_edit_text(FSText :: _('Title'),'title',@$data -> fullname);
    TemplateHelper::dt_edit_text(FSText :: _('Người gửi'),'fullname',@$data -> fullname);
    TemplateHelper::dt_edit_text(FSText :: _('Email'),'email',@$data -> email);
    TemplateHelper::dt_edit_text(FSText :: _('Telephone'),'telephone',@$data -> telephone);
    TemplateHelper::dt_edit_text(FSText :: _('Address'),'address',@$data -> address);
    TemplateHelper::dt_edit_text(FSText :: _('Nội dung'),'content',@$data -> content,'',650,450,1,'','','col-sm-2','col-sm-10');
    TemplateHelper::dt_edit_selectbox(FSText::_('Phòng ban tiếp nhận'),'department_id',@$data -> department_id,0,$department,$field_value = 'id', $field_label='name',$size = 1,0,1);
    
    $this -> dt_form_end(@$data,1);  
?>