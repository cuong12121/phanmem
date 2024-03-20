<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('User') );
	// $toolbar->addButton('duplicate',FSText :: _('Duplicate'),'','duplicate.png');
	// $toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	//$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	//$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
	
	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 
	$fitler_config['filter_count'] = 0;
																																																																					
	//	CONFIG	
	$list_config = array();
	//$list_config[] = array('title'=>'Image','field'=>'image','type'=>'image','no_col'=>1,'arr_params'=>array('search'=>'/original/','replace'=>'/small/'));
	$list_config[] = array('title'=>'Tên đăng nhập','field'=>'username','ordering'=> 1, 'type'=>'text','col_width' => '17%');
	$list_config[] = array('title'=>'Họ tên','field'=>'fullname','ordering'=> 1, 'type'=>'text','col_width' => '17%');
	//$list_config[] = array('title'=>'Ngày sinh','field'=>'birthday','ordering'=> 1, 'type'=>'datetime');
	$list_config[] = array('title'=>'Mã chấm công','field'=>'code','ordering'=> 1, 'type'=>'text','col_width' => '8%');
	$list_config[] = array('title'=>'Số tiền shop','field'=>'money','ordering'=> 1, 'type'=>'format_money','col_width' => '10%','arr_params'=>array('size'=> 30));
	$list_config[] = array('title'=>'Nhóm','field'=>'group_id','ordering'=> 1, 'type'=>'edit_selectbox','arr_params'=>array('arry_select'=>$groups,'field_value'=>'id','field_label'=>'name','size'=>10));

	$list_config[] = array('title'=>'Kho','field'=>'id','type'=>'text','arr_params'=>array('function'=>'view_warehouses'));


	$list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
	$list_config[] = array('title'=>'Edit','type'=>'edit');
	//$list_config[] = array('title'=>'Phân quyền','field'=>'id','type'=>'text','arr_params'=>array('function'=>'view_permission'));
	$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this, $this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
		?>
