<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Danh sách phiếu') );
	// $toolbar->addButton('duplicate',FSText :: _('Duplicate'),'','duplicate.png');
	// $toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
	
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	
	$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png');
	
	//$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	
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
	$list_config[] = array('title'=>'Tên SP','field'=>'name','ordering'=> 1, 'type'=>'text','col_width' => '160px','arr_params'=>array('size'=> 15));

	$list_config[] = array('title'=>'Mã SP','field'=>'code_product','ordering'=> 1, 'type'=>'text','col_width' => '160px','arr_params'=>array('size'=> 15));
	// /$list_config[] = array('title'=>'Mô tả','field'=>'description','ordering'=> 1, 'type'=>'text','col_width' => '180px','arr_params'=>array('size'=> 15));
	$list_config[] = array('title'=>'Số lượng','field'=>'count','ordering'=> 1, 'type'=>'text','col_width' => '70px','arr_params'=>array('size'=> 15));
	$list_config[] = array('title'=>'Nâng cấp gì','field'=>'nang_cap','ordering'=> 1, 'type'=>'text','col_width' => '160px','arr_params'=>array('size'=> 15));
	$list_config[] = array('title'=>'Giá','field'=>'price','ordering'=> 1,'col_width' => '70px','type'=>'format_money');
	$list_config[] = array('title'=>'TG sản xuất','field'=>'date_san_xuat','col_width' => '70px','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Giá VCQT','field'=>'price_import','col_width' => '70px','ordering'=> 1, 'type'=>'format_money');
	$list_config[] = array('title'=>'Giá dự kiến về việt nam','field'=>'price_to_hn','col_width' => '70px','ordering'=> 1, 'type'=>'format_money');

	//$list_config[] = array('title'=>'Đã tìm xong','field'=>'is_find','ordering'=> 1, 'type'=>'text','col_width' => '70px','col_width' => '160px','arr_params'=>array('size'=> 15),'arr_params'=>array('function'=>'view_find'));
	//$list_config[] = array('title'=>'Lý do không hoàn thành','field'=>'not_finish','ordering'=> 1,'col_width' => '70px', 'type'=>'text','col_width' => '160px','arr_params'=>array('size'=> 15));
	//$list_config[] = array('title'=>'Ghi chú','field'=>'note','ordering'=> 1, 'type'=>'text','col_width' => '160px','arr_params'=>array('size'=> 15));
	//$list_config[] = array('title'=>'Đề xuất','field'=>'propose','ordering'=> 1, 'type'=>'text','col_width' => '160px','arr_params'=>array('size'=> 15));
	$list_config[] = array('title'=>'Duyệt','field'=>'is_import','type'=>'text','col_width' => '160px','arr_params'=>array('function'=>'view_import'));
	$list_config[] = array('title'=>'Ngày đặt hàng','field'=>'ngay_dat_hang','ordering'=> 1, 'type'=>'date','col_width' => '100px','arr_params'=>array('size'=> 15));
	$list_config[] = array('title'=>'ĐVVC','field'=>'dvvc','ordering'=> 1, 'type'=>'text','col_width' => '160px','arr_params'=>array('size'=> 15));
	$list_config[] = array('title'=>'Mã đơn hàng','field'=>'code','ordering'=> 1, 'type'=>'text','col_width' => '160px','arr_params'=>array('size'=> 15));
	$list_config[] = array('title'=>'Mã ký gửi','field'=>'code_deposit','ordering'=> 1, 'type'=>'text','col_width' => '160px','arr_params'=>array('size'=> 15));
	$list_config[] = array('title'=>'Ngày phát hành','field'=>'date_phat_hanh','ordering'=> 1, 'type'=>'date','col_width' => '160px','arr_params'=>array('size'=> 15));
	$list_config[] = array('title'=>'Ngày đến kho TQ','field'=>'date_to_tq','ordering'=> 1, 'type'=>'date','col_width' => '160px','arr_params'=>array('size'=> 15));
	$list_config[] = array('title'=>'Ngày đến kho','field'=>'date_to_ha_noi','ordering'=> 1, 'type'=>'date','col_width' => '160px','arr_params'=>array('size'=> 15));
	$list_config[] = array('title'=>'GHI CHÚ [Của NV nhập hàng]','field'=>'note_nhan_vien_nhan_hang','ordering'=> 1, 'type'=>'text','col_width' => '160px','arr_params'=>array('size'=> 15));
	$list_config[] = array('title'=>'GHI CHÚ NHẬN HÀNG','field'=>'note_nhan_hang','ordering'=> 1, 'type'=>'text','col_width' => '160px','arr_params'=>array('size'=> 15));
	$list_config[] = array('title'=>'Hàng thiếu, lỗi vỡ','field'=>'product_error','ordering'=> 1, 'type'=>'text','col_width' => '160px','arr_params'=>array('size'=> 15));
	$list_config[] = array('title'=>'Nhập hàng khiếu nại','field'=>'nhap_hang_khieu_nai','ordering'=> 1, 'type'=>'text','col_width' => '160px','arr_params'=>array('size'=> 15));
	$list_config[] = array('title'=>'Phân việc cho nhân viên','field'=>'employees_id','ordering'=> 1, 'type'=>'text','col_width' => '160px','arr_params'=>array('size'=> 15),'arr_params'=>array('function'=>'view_employee'));
	$list_config[] = array('title'=>'Time line (Bao phút)','field'=>'time_line','ordering'=> 1,'col_width' => '70px','type'=>'text');
	$list_config[] = array('title'=>'Trạng thái','field'=>'status','type'=>'text','col_width' => '160px','arr_params'=>array('function'=>'view_status'));
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
		width: 3500px !important;
		max-width: none !important;
	}
	#dataTables-example .wrap_list_pr{
		max-height: 100px;
		overflow-y: auto;
	}
</style>