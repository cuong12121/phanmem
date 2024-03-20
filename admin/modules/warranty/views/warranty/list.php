<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Danh sách phiếu') );
	// $toolbar->addButton('duplicate',FSText :: _('Duplicate'),'','duplicate.png');
	// $toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
	if($_SESSION['ad_groupid'] == 1){ 
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	}
	$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png');
	if($_SESSION['ad_groupid'] == 1){ 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	}
	//$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	//$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
	
	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 
	$fitler_config['filter_count'] = 3;
	$fitler_config['text_count'] = 2;
	$text_from_date = array();
	$text_from_date['title'] =  FSText::_('Từ ngày'); 

	$text_to_date = array();
	$text_to_date['title'] =  FSText::_('Đến ngày');

	$fitler_config['text'][] = $text_from_date;
	$fitler_config['text'][] = $text_to_date;

	$filter_job = array();
	$filter_job['title'] = FSText::_('Công việc'); 
	$filter_job['list'] = @$array_job; 
	$filter_job['field'] = 'name'; 
	
	$fitler_config['filter'][] = $filter_job;	

	$filter_status = array();
	$filter_status['title'] = FSText::_('Trạng thái'); 
	$filter_status['list'] = @$array_status; 
	$filter_status['field'] = 'name'; 
															
	$fitler_config['filter'][] = $filter_status;	

	$filter_group = array();
	$filter_group['title'] = FSText::_('Bộ phận chịu phí'); 
	$filter_group['list'] = @$array_group; 
	$filter_group['field'] = 'name';								
	$fitler_config['filter'][] = $filter_group;

	//	CONFIG	
	$list_config = array();
	
	$list_config[] = array('title'=>'Ngày','field'=>'date','ordering'=> 1, 'type'=>'date','col_width' => '80px');
	$list_config[] = array('title'=>'Công việc','field'=>'job_id','type'=>'text','col_width' => '100px','arr_params'=>array('function'=>'view_job'));
	$list_config[] = array('title'=>'Trạng thái','field'=>'status','type'=>'text','col_width' => '100px','arr_params'=>array('function'=>'view_status'));
	$list_config[] = array('title'=>'Lý do không hoàn thành','field'=>'note2','type'=>'text','col_width' => '350px','arr_params');

	$list_config[] = array('title'=>'Mã vận đơn','field'=>'tracking_code','ordering'=> 1, 'type'=>'text','col_width' => '180px','col_width' => '150px','arr_params'=>array('size'=> 15));
	$list_config[] = array('title'=>'Mã đơn hàng','field'=>'code','ordering'=> 1, 'type'=>'text','col_width' => '180px','col_width' => '150px','arr_params'=>array('size'=> 15));
	$list_config[] = array('title'=>'SKU sản phẩm','field'=>'product_code','ordering'=> 1, 'type'=>'text','col_width' => '180px','col_width' => '150px','arr_params'=>array('size'=> 15));
	$list_config[] = array('title'=>'Shop','field'=>'shop_id','type'=>'text','arr_params'=>array('function'=>'view_shop'));
	$list_config[] = array('title'=>'Kho','field'=>'warehouse_id','type'=>'text','arr_params'=>array('function'=>'view_warehouse'));

	$list_config[] = array('title'=>'Tên khách hàng','field'=>'name_guest','ordering'=> 1, 'type'=>'text','col_width' => '180px','col_width' => '150px','arr_params'=>array('size'=> 15));
	$list_config[] = array('title'=>'Số điện thoại khách','field'=>'phone_guest','ordering'=> 1, 'type'=>'text','col_width' => '180px','col_width' => '150px','arr_params'=>array('size'=> 15));
	$list_config[] = array('title'=>'Địa chỉ khách','field'=>'address_guest','ordering'=> 1, 'type'=>'text','col_width' => '180px','col_width' => '350px','arr_params'=>array('size'=> 15));


	$list_config[] = array('title'=>'Chi tiết công việc','field'=>'note','type'=>'text','col_width' => '220px','arr_params');

	$list_config[] = array('title'=>'Link hình ảnh / Video','field'=>'link_video','ordering'=> 1, 'type'=>'text','col_width' => '180px','arr_params'=>array('size'=> 15));

	$list_config[] = array('title'=>'Người thực hiện','field'=>'name','ordering'=> 1, 'type'=>'text','col_width' => '120px','arr_params'=>array('size'=> 15));
	
	
	

	$list_config[] = array('title'=>'Bộ phận chịu tránh nhiệm(Chịu phí)','field'=>'room_id','type'=>'text','col_width' => '100px','arr_params'=>array('function'=>'view_room'));

	$list_config[] = array('title'=>'Mã chuyển hoàn cho khách','field'=>'code_return','type'=>'text','col_width' => '160px','arr_params');
	$list_config[] = array('title'=>'NBH chấm sao','field'=>'star','ordering'=> 1, 'type'=>'text','col_width' => '120px','arr_params'=>array('function'=>'view_star'));
	$list_config[] = array('title'=>'Edit','type'=>'edit','col_width' => '20px');
	//$list_config[] = array('title'=>'QL cho điểm','field'=>'point','ordering'=> 1, 'type'=>'text');
	//$list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
	//$list_config[] = array('title'=>'Người tạo','field'=>'creator_name','ordering'=> 1, 'type'=>'text');
	//$list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');

	//$list_config[] = array('title'=>'Actions','field'=>'id','type'=>'text','col_width' => '15%','arr_params'=>array('function'=>'view_actions'));

    
	
	// $list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this, $this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>


<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_ROOT.LINK_AMIN.'/modules/'.$this->module.'/assets/css/warranty.css' ?>" />

<script type="text/javascript" src="<?php echo URL_ROOT.LINK_AMIN.'/modules/'.$this->module.'/assets/js/warranty.js' ?>"></script>


<style type="text/css">
	#dataTables-example{
		width: 2600px !important;
		max-width: none !important;
	}
	#dataTables-example .wrap_list_pr{
		max-height: 100px;
		overflow-y: auto;
		max-width: 300px;
	}
</style>



<script>
	$(function() {
		$( "#text0" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy'});
		$( "#text1" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy'});
	});
</script>
