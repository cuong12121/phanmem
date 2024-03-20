<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Banks') );
	$toolbar->addButton('duplicate',FSText :: _('Duplicate'),'','duplicate.png');
	$toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
	
	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 
	$fitler_config['filter_count'] = 1;

	$filter_citys = array();
	$filter_citys['title'] = FSText::_('Citys'); 
	$filter_citys['list'] = @$citys; 
	$filter_['field'] = 'name'; 
	
	$fitler_config['filter'][] = $filter_citys;			

	//	CONFIG	
	$list_config = array();
	

	$list_config[] = array('title'=>'Name','field'=>'name','ordering'=> 1, 'type'=>'edit_text','col_width' => '20%','arr_params'=>array('size'=> 30));
	$list_config[] = array('title'=>'Image','field'=>'image','type'=>'image','no_col'=>1,'arr_params'=>array('search'=>'/original/','replace'=>'/resized/'));
		$list_config[] = array('title'=>'Code','field'=>'code','ordering'=> 1, 'type'=>'edit_text','col_width' => '20%','arr_params'=>array('size'=> 15));

	$list_config[] = array('title'=>'Ls 3 tháng','field'=>'interest_rate_3_month','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>3));
	$list_config[] = array('title'=>'Ls 6 tháng','field'=>'interest_rate_6_month','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>3));

	$list_config[] = array('title'=>'Ls 9 tháng','field'=>'interest_rate_9_month','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>3));

	$list_config[] = array('title'=>'Ls 12 tháng','field'=>'interest_rate_12_month','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>3));

	$list_config[] = array('title'=>'Ls 24 tháng','field'=>'interest_rate_24_month','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>3));

   // $list_config[] = array('title'=>'City','field'=>'city_id','ordering'=> 1, 'type'=>'selectbox','arr_params'=>array('size'=>10));
	
	$list_config[] = array('title'=>'Ordering','field'=>'ordering','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>3));
	$list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
	// $list_config[] = array('title'=>'Description','field'=>'description','type'=>'text','arr_params');
    $list_config[] = array('title'=>'Edit','type'=>'edit');
	$list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
	$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this, $this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
		?>
