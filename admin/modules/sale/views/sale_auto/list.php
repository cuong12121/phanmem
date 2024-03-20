<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Mã giảm giá tự sinh') );
	// $toolbar->addButton('duplicate',FSText :: _('Duplicate'),'','duplicate.png');
	$toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
	
	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 
	$fitler_config['filter_count'] = 0;

																																																																																																																																																																																																																																																																																																																																																																																																																			

	//	CONFIG	
	$list_config = array();
	$list_config[] = array('title'=>'Name','field'=>'name','ordering'=> 1, 'type'=>'text','col_width' => '20%','arr_params'=>array('size'=> 30));
	$list_config[] = array('title'=>'Title','field'=>'title','ordering'=> 1, 'type'=>'text','col_width' => '20%','arr_params'=>array('size'=> 30));

	// $list_config[] = array('title'=>'Ordering','field'=>'ordering','ordering'=> 1, 'type'=>'text','arr_params'=>array('size'=>3));
	$list_config[] = array('title'=>'Ngày bắt đầu','field'=>'date_start','ordering'=> 1, 'type'=>'date_start');
	$list_config[] = array('title'=>'Ngày kết thúc','field'=>'date_end','ordering'=> 1, 'type'=>'date_end');
	$list_config[] = array('title'=>'Mã giảm giá','field'=>'code','ordering'=> 1, 'type'=>'code');
	$list_config[] = array('title'=>'Số lần sử dụng','field'=>'number_sale','ordering'=> 1, 'type'=>'number_sale');
	$list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');

    $list_config[] = array('title'=>'Edit','type'=>'edit');
	$list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
	$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this,$this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
		?>
