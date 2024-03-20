<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Danh sách phiếu') );
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
	$fitler_config['text_count'] = 2;
	$text_from_date = array();
	$text_from_date['title'] =  FSText::_('Từ ngày'); 

	$text_to_date = array();
	$text_to_date['title'] =  FSText::_('Đến ngày');

	$fitler_config['text'][] = $text_from_date;
	$fitler_config['text'][] = $text_to_date;																

	//	CONFIG	
	$list_config = array();
	//$list_config[] = array('title'=>'Name','field'=>'name','ordering'=> 1, 'type'=>'text','col_width' => '15%','arr_params'=>array('size'=> 15));
	$list_config[] = array('title'=>'Ngày','field'=>'date','ordering'=> 1, 'type'=>'datetime');
	//$list_config[] = array('title'=>'Shop','field'=>'shop_code','ordering'=> 1, 'type'=>'text','col_width' => '6%','arr_params'=>array('size'=> 15));
	//$list_config[] = array('title'=>'Kho','field'=>'warehouse_id','type'=>'text','col_width' => '6%','arr_params'=>array('function'=>'view_warehouse'));
	//$list_config[] = array('title'=>'Sàn','field'=>'platform_id','type'=>'text','col_width' => '6%','arr_params'=>array('function'=>'view_platform'));
	//$list_config[] = array('title'=>'Tracking code','field'=>'tracking_code','ordering'=> 1, 'type'=>'text','col_width' => '12%','arr_params'=>array('size'=> 15));
	//$list_config[] = array('title'=>'SKU','field'=>'sku','ordering'=> 1, 'type'=>'text','col_width' => '6%','arr_params'=>array('size'=> 15));
	$list_config[] = array('title'=>'Tên khách','field'=>'name_custommer','ordering'=> 1, 'type'=>'text','col_width' => '15%','arr_params'=>array('size'=> 15));
	$list_config[] = array('title'=>'SĐT khách','field'=>'phone_custommer','ordering'=> 1, 'type'=>'text','col_width' => '12%','arr_params'=>array('size'=> 15));
	$list_config[] = array('title'=>'Địa chỉ khách','field'=>'address_custommer','ordering'=> 1, 'type'=>'text','col_width' => '12%','arr_params'=>array('size'=> 15));
	$list_config[] = array('title'=>'Thông tin vận chuyển','field'=>'note','type'=>'text','arr_params','col_width' => '22%');
	$list_config[] = array('title'=>'Trạng thái','field'=>'status','type'=>'text','arr_params'=>array('function'=>'view_status'));
	// $list_config[] = array('title'=>'Chi tiết lỗi','field'=>'note2','type'=>'text','arr_params','col_width' => '12%');
	// $list_config[] = array('title'=>'NBH chấm sao','field'=>'star','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=>'view_star'));
	$list_config[] = array('title'=>'QL cho điểm','field'=>'point','ordering'=> 1, 'type'=>'text');
	//$list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
	//$list_config[] = array('title'=>'Người tạo','field'=>'creator_name','ordering'=> 1, 'type'=>'text');
	//$list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');

	//$list_config[] = array('title'=>'Actions','field'=>'id','type'=>'text','col_width' => '15%','arr_params'=>array('function'=>'view_actions'));

    $list_config[] = array('title'=>'Edit','type'=>'edit');
	
	// $list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this, $this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>


<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_ROOT.LINK_AMIN.'/modules/'.$this->module.'/assets/css/warranty.css' ?>" />

<script type="text/javascript" src="<?php echo URL_ROOT.LINK_AMIN.'/modules/'.$this->module.'/assets/js/warranty.js' ?>"></script>






<script>
	$(function() {
		$( "#text0" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy'});
		$( "#text1" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy'});
	});
</script>
