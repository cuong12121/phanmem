<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Danh sách file') );
	// $toolbar->addButton('duplicate',FSText :: _('Duplicate'),'','duplicate.png');
	// $toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	//$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	// $toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	// $toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
	
	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 
	$fitler_config['filter_count'] = 0;
	$filter_categories = array();
	$filter_categories['title'] = FSText::_('Nhóm file'); 
	$filter_categories['list'] = @$categories; 
	$filter_categories['field'] = 'name'; 
	$fitler_config['filter'][] = $filter_categories;																													

																																																																																																																																																																																																																																																																																																																																																																							
	//	CONFIG	
	$list_config = array();
	$list_config[] = array('title'=>'Tên file','field'=>'name','ordering'=> 1, 'type'=>'text','col_width' => '20%','arr_params'=>array('size'=> 30));
	$list_config[] = array('title'=>'Category','field'=>'category_id','ordering'=> 1, 'type'=>'edit_selectbox','arr_params'=>array('arry_select'=>$categories,'field_value'=>'id','field_label'=>'name','size'=>10));
	$list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
    $list_config[] = array('title'=>'Edit','type'=>'edit');
	$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this, $this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
		?>
