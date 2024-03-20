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
	$fitler_config['filter_count'] = 1;
	$fitler_config['text_count'] = 2;
	$text_from_date = array();
	$text_from_date['title'] =  FSText::_('Từ ngày'); 

	$text_to_date = array();
	$text_to_date['title'] =  FSText::_('Đến ngày');

	$fitler_config['text'][] = $text_from_date;
	$fitler_config['text'][] = $text_to_date;	


	$filter_status = array();
	$filter_status['title'] = FSText::_('Trạng thái'); 
	$filter_status['list'] = @$array_status; 
	$filter_status['field'] = 'name'; 
															
	$fitler_config['filter'][] = $filter_status;															

	//	CONFIG	
	$list_config = array();
	
	$list_config[] = array('title'=>'Ngày','field'=>'date','ordering'=> 1, 'type'=>'date');
	$list_config[] = array('title'=>'Yêu cầu nhập linh kiện','field'=>'name','ordering'=> 1, 'type'=>'text','col_width' => '15%','arr_params'=>array('size'=> 15));
	$list_config[] = array('title'=>'SKU','field'=>'sku','ordering'=> 1, 'type'=>'text','col_width' => '12%','arr_params'=>array('size'=> 15));
	$list_config[] = array('title'=>'Chi tiết yêu cầu','field'=>'note','type'=>'text','arr_params','col_width' => '22%');
	$list_config[] = array('title'=>'Số lượng','field'=>'count','ordering'=> 1, 'type'=>'text','col_width' => '6%','arr_params'=>array('size'=> 15));
	$list_config[] = array('title'=>'Trạng thái','field'=>'status','type'=>'text','arr_params'=>array('function'=>'view_status'));
	$list_config[] = array('title'=>'Nhân viên thực hiện','field'=>'employees_id','type'=>'text','arr_params'=>array('function'=>'view_employee'));
	// $list_config[] = array('title'=>'QL cho điểm','field'=>'point','ordering'=> 1, 'type'=>'text');
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
