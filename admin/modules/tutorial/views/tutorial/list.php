<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('News') );
	$toolbar->addButton('duplicate',FSText :: _('Duplicate'),'','duplicate.png');
	// $toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
	
	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 0; 
	$fitler_config['filter_count'] = 0;

	$filter_categories = array();
	//$filter_categories['title'] = FSText::_('Categories'); 
	//$filter_categories['list'] = @$categories; 
	//$filter_categories['field'] = 'treename'; 
	
	//$fitler_config['filter'][] = $filter_categories;																																																																						
	//	CONFIG	
	$list_config = array();
	$list_config[] = array('title'=>'Title','field'=>'title','ordering'=> 1, 'type'=>'edit_text','col_width' => '20%','arr_params'=>array('size'=> 30));
	$list_config[] = array('title'=>'Image','field'=>'image','type'=>'image','no_col'=>1,'arr_params'=>array('search'=>'/original/','replace'=>'/small/'));

	
	// $list_config[] = array('title'=>'Summary','field'=>'summary','type'=>'text','col_width' => '20%','arr_params'=>array('size'=>30,'rows'=>8));
	// $list_config[] = array('title'=>'Category','field'=>'category_id','ordering'=> 1, 'type'=>'edit_selectbox','arr_params'=>array('arry_select'=>$categories,'field_value'=>'id','field_label'=>'treename','size'=>10));
	//$list_config[] = array('title'=>'Danh mục','field'=>'category_name', 'type'=>'text');
	$list_config[] = array('title'=>'Ordering','field'=>'ordering','ordering'=> 1, 'type'=>'text','arr_params'=>array('size'=>3));
	// $list_config[] = array('title'=>'Tổng views','field'=>'hits','ordering'=> 1, 'type'=>'text');
	// $list_config[] = array('title'=>'Xóa cache','field'=>'id','type'=>'remove','arr_params'=>array('function'=>'remove_cache'));
	//$list_config[] = array('title'=>'Tin hot','field'=>'is_hot','ordering'=> 1, 'type'=>'change_status','arr_params'=>array('function'=>'is_hot'));
	$list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
	$list_config[] = array('title'=>'Edit','type'=>'edit');
	// $list_config[] = array('title'=>'Comment','field'=>'id','type'=>'text','arr_params'=>array('function'=>'view_comment'));
	$list_config[] = array('title'=>'Người tạo tin','field'=>'action_name','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
	$list_config[] = array('title'=>'Xem bên ngoài','field'=>'id','type'=>'text','arr_params'=>array('function'=>'view_name'));
	$list_config[] = array('title'=>'Người sửa','field'=>'action_username','ordering'=> 1, 'type'=>'action');
	$list_config[] = array('title'=>'Thời gian sửa','field'=>'updated_time','ordering'=> 1, 'type'=>'datetime');
	//$list_config[] = array('title'=>'Lịch sử','field'=>'id','type'=>'text','arr_params'=>array('function'=>'view_history'));
	$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this, $this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
		?>
