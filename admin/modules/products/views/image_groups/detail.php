<!-- HEAD -->
	<?php 
	
	$title = @$data ? FSText::_('Edit'): FSText::_('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('apply',FSText::_('Apply'),'','apply.png'); 
	$toolbar->addButton('save',FSText::_('Save'),'','save.png'); 
	$toolbar->addButton('save_add',FSText::_('Save & New'),'','save.png'); 
	$toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');   
	
	$this -> dt_form_begin();
	//TemplateHelper::dt_edit_text(FSText :: _('Name'),'name2',@$data -> name2);
	TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name,'',60,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
	// $style_types = array('1'=>'Ô vuông','3'=>'Select');

	TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/small/',URL_ROOT.@$data->image),150,150,'Kích cỡ ảnh: 150x150');

	// TemplateHelper::dt_edit_selectbox('Kiểu hiển thị thêm giá','style_types',@$data -> style_types,0,$style_types,'id', 'name',$size = 1,0,1);
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
	
	$this -> dt_form_end(@$data,1,0);
	
	?>

