<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Danh sách kho') );
	// $toolbar->addButton('duplicate',FSText :: _('Duplicate'),'','duplicate.png');
	// $toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('cancel',FSText :: _('Thoát'),'','cancel.png'); 
	// $toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	// $toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	// $toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	// $toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
	
	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 
	$fitler_config['filter_count'] = 0;																

	//	CONFIG	
	$list_config = array();
	$list_config[] = array('title'=>'Kho hàng','field'=>'filter0','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=>'show_ware'));

	$list_config[] = array('title'=>'Từ khóa tìm kiếm','field'=>'keysearch','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Từ ngày','field'=>'text0','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Đến ngày','field'=>'text1','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Số ngày nhập bán hàng','field'=>'text2','ordering'=> 1, 'type'=>'text');


	// $list_config[] = array('title'=>'Từ khóa tìm kiếm','field'=>'keyword','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Kho hàng so sánh','field'=>'filter1','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=>'show_ware'));
	$list_config[] = array('title'=>'Danh mục sản phẩm','field'=>'filter2','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=>'show_cat_product'));
	
	// $list_config[] = array('title'=>'Mô tả','field'=>'summary','type'=>'text','arr_params');
	// $list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
    $list_config[] = array('title'=>'Views','type'=>'view_gav');
	
	$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this, $this-> module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
		?>
