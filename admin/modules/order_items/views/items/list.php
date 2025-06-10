<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Xuất kho') );
	// $toolbar->addButton('add',FSText :: _('Add'),'','add.png');

	$toolbar->addButton('excel_nhat',FSText :: _('Xuất File Nhặt'),'','Excel-icon.png');
	$toolbar->addButton('excel_misa',FSText :: _('Misa'),'','Excel-icon.png');
	$toolbar->addButton('excel_tong_ngay',FSText :: _('Tổng ngày'),'','Excel-icon.png');

	$toolbar->addButton('shoot_order',FSText :: _('Bắn đơn'),FSText :: _('You must select at least one record'),'forward.png');
	// $toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	// $toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	//$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	//$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
    
    //	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 
    $fitler_config['filter_count'] = 4;
    $fitler_config['text_count'] = 2;


    $filter_houses = array();
	$filter_houses['title'] = FSText::_('Giờ'); 
	$filter_houses['list'] = @$houses; 
	$filter_houses['field'] = 'name'; 
	$fitler_config['filter'][] = $filter_houses;


    $filter_warehouses = array();
	$filter_warehouses['title'] = FSText::_('Kho'); 
	$filter_warehouses['list'] = @$warehouses; 
	$filter_warehouses['field'] = 'name'; 
	$fitler_config['filter'][] = $filter_warehouses;


	$filter_platforms = array();
	$filter_platforms['title'] = FSText::_('Sàn'); 
	$filter_platforms['list'] = @$platforms; 
	$filter_platforms['field'] = 'name'; 
	$fitler_config['filter'][] = $filter_platforms;

	$filter_shipping_unit = array();
	$filter_shipping_unit['title'] = FSText::_('Đơn vị vận chuyển'); 
	$filter_shipping_unit['list'] = @$shipping_unit; 
	$filter_shipping_unit['field'] = 'name'; 
	$fitler_config['filter'][] = $filter_shipping_unit;	



	$text_from_date = array();
	$text_from_date['title'] =  FSText::_('Từ ngày'); 

	$text_to_date = array();
	$text_to_date['title'] =  FSText::_('Đến ngày');

	$fitler_config['text'][] = $text_from_date;
	$fitler_config['text'][] = $text_to_date;

	//	CONFIG	
	$list_config = array();

	$list_config[] = array('title'=>'Tracking Code','field'=>'tracking_code','ordering'=> 1, 'type'=>'text','col_width' => '8%','arr_params'=>array('size'=> 20));

	$list_config[] = array('title'=>'Order number','field'=>'code','ordering'=> 1, 'type'=>'text','col_width' => '8%','arr_params'=>array('size'=> 20));
	
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

	$list_config[] = array('title'=>'Actions','field'=>'id','type'=>'text','col_width' => '15%','arr_params'=>array('function'=>'view_actions'));

	$list_config[] = array('title'=>'record_id','field'=>'record_id','type'=>'text');

	$list_config[] = array('title'=>'Edit','type'=>'edit');
    //$list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
	$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this, $this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
    
?>



<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_ROOT.LINK_AMIN.'/modules/'.$this->module.'/assets/css/order_item.css' ?>" />

<script type="text/javascript" src="<?php echo URL_ROOT.LINK_AMIN.'/modules/'.$this->module.'/assets/js/order_item.js' ?>"></script>
