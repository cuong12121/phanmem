<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Danh sách phiếu') );
	// $toolbar->addButton('duplicate',FSText :: _('Duplicate'),'','duplicate.png');
	// $toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
	if($_SESSION['ad_groupid'] != 8){ 
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	}
	$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png');
	if($_SESSION['ad_groupid'] != 8){ 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	}
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


	// $filter_find = array();
	// $filter_find['title'] = FSText::_('Đã tìm ?'); 
	// $filter_find['list'] = @$array_find; 
	// $filter_find['field'] = 'name'; 
	
	// $fitler_config['filter'][] = $filter_find;	

	$filter_status = array();
	$filter_status['title'] = FSText::_('Trạng thái'); 
	$filter_status['list'] = @$array_status; 
	$filter_status['field'] = 'name'; 
															
	$fitler_config['filter'][] = $filter_status;																

	//	CONFIG	
	$list_config = array();

	$list_config[] = array('title'=>'Ngày tạo','field'=>'created_time','ordering'=> 1, 'type'=>'date','col_width' => '100px','arr_params'=>array('size'=> 15));
	$list_config[] = array('title'=>'Người đề xuất','field'=>'creator_id','ordering'=> 1, 'type'=>'text','col_width' => '100px','arr_params'=>array('size'=> 15),'arr_params'=>array('function'=>'view_creator'));

	$list_config[] = array('title'=>'Tên sản phẩm','field'=>'name','ordering'=> 1, 'type'=>'text','col_width' => '160px','arr_params'=>array('size'=> 15));
	$list_config[] = array('title'=>'Mô tả','field'=>'description','ordering'=> 1, 'type'=>'text','col_width' => '180px','arr_params'=>array('size'=> 15));
	$list_config[] = array('title'=>'Số lượng','field'=>'count','ordering'=> 1, 'type'=>'text','col_width' => '70px','arr_params'=>array('size'=> 15));
	$list_config[] = array('title'=>'Yêu cầu nhập cho miền','field'=>'yeu_cau_kho','ordering'=> 1, 'type'=>'text','col_width' => '70px','arr_params'=>array('size'=> 15));
	$list_config[] = array('title'=>'List 5 link nhà cung cấp','field'=>'link','ordering'=> 1, 'type'=>'text','col_width' => '160px','arr_params'=>array('size'=> 15));
	$list_config[] = array('title'=>'Duyệt nhập','field'=>'status','ordering'=> 1, 'type'=>'text','col_width' => '160px','arr_params'=>array('size'=> 15),'arr_params'=>array('function'=>'view_status'));
    $list_config[] = array('title'=>'Edit','type'=>'edit','col_width' => '60px');
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

<style type="text/css">
	#dataTables-example{
		/*width: 3500px !important;*/
		/*max-width: none !important;*/
	}
	#dataTables-example .wrap_list_pr{
		max-height: 100px;
		overflow-y: auto;
	}
</style>