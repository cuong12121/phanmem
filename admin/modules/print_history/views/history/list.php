<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Lịch sử in') );
	// $toolbar->addButton('add',FSText :: _('Add'),'','add.png');
	//$toolbar->addButton('statistic_packages',FSText :: _('Thống kê'),'','statistic-icon.png');
	// $toolbar->addButton('excel_nhat',FSText :: _('Xuất File Nhặt'),'','Excel-icon.png');
	// $toolbar->addButton('excel_misa',FSText :: _('Misa'),'','Excel-icon.png');
	// $toolbar->addButton('excel_tong_ngay',FSText :: _('Tổng ngày'),'','Excel-icon.png');

	// $toolbar->addButton('shoot_order',FSText :: _('Bắn đơn'),'','forward.png');
	// $toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	// $toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	//$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	//$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
    
    //	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 
    $fitler_config['filter_count'] = 3;
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

	$text_from_date = array();
	$text_from_date['title'] =  FSText::_('Thời gian in'); 

	$text_to_date = array();
	$text_to_date['title'] =  FSText::_('Đến');

	$fitler_config['text'][] = $text_from_date;
	$fitler_config['text'][] = $text_to_date;


	//	CONFIG	
	$list_config = array();
	$list_config[] = array('title'=>'Kho','field'=>'warehouse_id','type'=>'text','arr_params'=>array('function'=>'view_warehouse'));
	$list_config[] = array('title'=>'Sàn','field'=>'platform_id','type'=>'text','arr_params'=>array('function'=>'view_platform'));
	$list_config[] = array('title'=>'Giờ','field'=>'house_id','type'=>'text','arr_params'=>array('function'=>'view_house'));
	
	$list_config[] = array('title'=>'File in','field'=>'id','type'=>'text','arr_params'=>array('function'=>'view_pdf'));

	$list_config[] = array('title'=>'File pdf đếm','field'=>'id','type'=>'text','arr_params'=>array('function'=>'view_pdf_dem'));



	$list_config[] = array('title'=>'Trạng thái','field'=>'id','type'=>'text','arr_params'=>array('function'=>'view_status'));
	$list_config[] = array('title'=>'Người in','field'=>'action_username','ordering'=> 1, 'type'=>'text','col_width' => '30%','arr_params'=>array('size'=> 20));

    $list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
    if($test==1){
    	echo "<pre>";
    	var_dump($list);
    	echo "</pre>";
    }	

	//$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this, $this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
    
?>



<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_ROOT.LINK_AMIN.'/modules/'.$this->module.'/assets/css/history.css' ?>" />

<script type="text/javascript" src="<?php echo URL_ROOT.LINK_AMIN.'/modules/'.$this->module.'/assets/js/history.js' ?>"></script>
