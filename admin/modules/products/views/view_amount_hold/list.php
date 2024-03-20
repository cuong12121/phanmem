<?php  
	global $toolbar;
	if(!empty($list)){
		$toolbar->setTitle(FSText::_('Danh sách đơn Tạm giữ mã sản phẩm: ') . $list[0]->product_code);
	}else{
		$toolbar->setTitle(FSText::_('Không có danh sách tạm giữ'));
	}
	// $toolbar->addButton('duplicate',FSText :: _('Duplicate'),FSText :: _('You must select at least one record'),'duplicate.png');
	// $toolbar->addButton('save_all',FSText :: _('Save'),'','save.png');
	// $toolbar->addButton('add',FSText::_('Th&#234;m m&#7899;i'),'','add.png'); 
	// $toolbar->addButton('edit',FSText::_('S&#7917;a'),FSText::_('B&#7841;n ch&#432;a ch&#7885;n b&#7843;n ghi n&#224;o !'),'edit.png'); 
	// $toolbar->addButton('remove',FSText::_('X&#243;a'),FSText::_('B&#7841;n ch&#432;a ch&#7885;n b&#7843;n ghi n&#224;o !'),'remove.png'); 
	// $toolbar->addButton('published',FSText::_('K&#237;ch ho&#7841;t'),FSText::_('B&#7841;n ch&#432;a ch&#7885;n b&#7843;n ghi n&#224;o !'),'published.png');
	// $toolbar->addButton('unpublished',FSText::_('Ng&#7915;ng k&#237;ch ho&#7841;t'),FSText::_('B&#7841;n ch&#432;a ch&#7885;n b&#7843;n ghi n&#224;o !'),'unpublished.png');
	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 

	//	CONFIG	
	$list_config = array();

	$list_config[] = array('title'=>'Tracking Code','field'=>'tracking_code','ordering'=> 1, 'type'=>'text','col_width' => '13%','arr_params'=>array('size'=> 20));
	
	
	$list_config[] = array('title'=>'Kho','field'=>'warehouse_id','type'=>'text','arr_params'=>array('function'=>'view_warehouse'));
	$list_config[] = array('title'=>'Sàn','field'=>'platform_id','type'=>'text','arr_params'=>array('function'=>'view_platform'));
	$list_config[] = array('title'=>'Shop','field'=>'shop_id','type'=>'text','arr_params'=>array('function'=>'view_shop'));
	
	$list_config[] = array('title'=>'Ngày','field'=>'date','ordering'=> 1, 'type'=>'datetime');
	$list_config[] = array('title'=>'Giờ','field'=>'house_id','type'=>'text','arr_params'=>array('function'=>'view_house'));

	$list_config[] = array('title'=>'Mã sku','field'=>'sku','ordering'=> 1, 'type'=>'text','col_width' => '5%','arr_params'=>array('size'=> 20));

	$list_config[] = array('title'=>'Mã màu','field'=>'color','ordering'=> 1, 'type'=>'text','col_width' => '5%','arr_params'=>array('size'=> 20));

	$list_config[] = array('title'=>'Mã size','field'=>'size','ordering'=> 1, 'type'=>'text','col_width' => '5%','arr_params'=>array('size'=> 20));

	$list_config[] = array('title'=>'SKU nhanh','field'=>'sku_nhanh','ordering'=> 1, 'type'=>'text','col_width' => '15%','arr_params'=>array('size'=> 20));

	$list_config[] = array('title'=>'Giá SP','field'=>'product_price','ordering'=> 1, 'type'=>'format_money','col_width' => '6%','arr_params'=>array('size'=> 20));

	$list_config[] = array('title'=>'Số lượng','field'=>'count','ordering'=> 1, 'type'=>'text','col_width' => '5%','arr_params'=>array('size'=> 20));

	$list_config[] = array('title'=>'Tổng số tiền','field'=>'total_price','ordering'=> 1, 'type'=>'format_money','col_width' => '7%','arr_params'=>array('size'=> 20));

	
	$list_config[] = array('title'=>'Đơn vị vận chuyển','field'=>'shipping_unit_name','ordering'=> 1, 'type'=>'text','col_width' => '15%','arr_params'=>array('size'=> 20));

	// $list_config[] = array('title'=>'Actions','field'=>'id','type'=>'text','col_width' => '15%','arr_params'=>array('function'=>'view_actions'));

	// $list_config[] = array('title'=>'Edit','type'=>'edit');
    //$list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
	$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	
	TemplateHelper::genarate_form_liting($this,$this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
	
	
?>

