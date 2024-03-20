<?php 
?>
<!-- HEAD -->
	<?php 
	
	$title = @$data ? FSText :: _('Chỉnh sửa giao diện gian hàng '): FSText :: _('Thêm mới giao diện gian hàng '); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png'); 
	$toolbar->addButton('apply',FSText::_('Apply'),'','apply.png'); 
	$toolbar->addButton('save',FSText::_('Save'),'','save.png'); 
	$toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');   
	
	$this -> dt_form_begin();
	TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1); 
	if(@$tid){
			 foreach ($template as $tmp) {
			 	if($tmp->id == $tid){
					TemplateHelper::dt_edit_text(FSText :: _('Template(Giao diện ngoài website)'),'template',@$tmp -> template,'',650,450,1); 
			 	}
			 }
			}else if(isset($data->id)){
			 		TemplateHelper::dt_edit_text(FSText :: _('Template(Giao diện ngoài website)'),'template',@$data -> template,'',650,450,1); 
			 	}
	$this -> dt_form_end(@$data);
	?>
	
<!-- END HEAD-->
