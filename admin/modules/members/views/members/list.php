<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Thành viên') );
	// $toolbar->addButton('duplicate',FSText :: _('Duplicate'),'','duplicate.png');
	$toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
	
	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 0; 
	$fitler_config['filter_count'] = 0;																												

																																																																																																																																																																																																																																																																																																																																																																							
	//	CONFIG	
	$list_config = array();
	$list_config[] = array('title'=>'Tên đăng nhập / Email','field'=>'username','type'=>'text','arr_params');
	$list_config[] = array('title'=>'Họ tên','field'=>'full_name','ordering'=> 1, 'type'=>'text','col_width' => '20%','arr_params'=>array('size'=> 30));
	$list_config[] = array('title'=>'Ngày tạo','field'=>'created_time','ordering'=> 1, 'type'=>'text','col_width' => '20%');
	$list_config[] = array('title'=>'Điểm','field'=>'point','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Hạng thành viên','field'=>'level_name','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Tổng chi trong năm','field'=>'id','ordering'=> 1, 'type'=>'text', 'arr_params'=>array('function'=>'view_total'));
   // $list_config[] = array('title'=>'City','field'=>'city_id','ordering'=> 1, 'type'=>'selectbox','arr_params'=>array('size'=>10));
	// $list_config[] = array('title'=>'% tích','field'=>'save_point','type'=>'text','arr_params');

	$list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
    $list_config[] = array('title'=>'Edit','type'=>'edit');
	
	$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this, $this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
		?>
