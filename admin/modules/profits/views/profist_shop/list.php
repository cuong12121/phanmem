<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Mốc lợi nhuận shop') );
	// $toolbar->addButton('add',FSText :: _('Add'),'','add.png');

	// $toolbar->addButton('excel_nhat',FSText :: _('Xuất File Nhặt'),'','Excel-icon.png');
	// $toolbar->addButton('excel_misa',FSText :: _('Misa'),'','Excel-icon.png');
	// $toolbar->addButton('excel_tong_ngay',FSText :: _('Tổng ngày'),'','Excel-icon.png');

	// $toolbar->addButton('shoot_order',FSText :: _('Bắn đơn'),FSText :: _('You must select at least one record'),'forward.png');
	// $toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	// $toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	//$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	//$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
    
    //	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 0; 
    $fitler_config['filter_count'] = 0;
    $fitler_config['text_count'] = 0;


 //    $filter_houses = array();
	// $filter_houses['title'] = FSText::_('Giờ'); 
	// $filter_houses['list'] = @$houses; 
	// $filter_houses['field'] = 'name'; 
	// $fitler_config['filter'][] = $filter_houses;


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
	$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Mã shop','field'=>'shop_code','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Thời gian từ','field'=>'go_time','ordering'=> 1, 'type'=>'date');
	$list_config[] = array('title'=>'Thời gian đến','field'=>'to_time','ordering'=> 1, 'type'=>'date');
	$list_config[] = array('title'=>'Doanh thu','field'=>'doanh_thu','type'=>'format_money');
	$list_config[] = array('title'=>'Giá vốn','field'=>'chi_phi','type'=>'format_money');
	$list_config[] = array('title'=>'Lợi nhuận tạm tính','field'=>'loi_nhuan','type'=>'format_money');
	$list_config[] = array('title'=>'Chi phí khác','field'=>'chi_phi_khac','type'=>'format_money');
	$list_config[] = array('title'=>'Lợi nhuận thực tế','field'=>'loi_nhuan_thuc','type'=>'format_money');
	$list_config[] = array('title'=>'Tổng đơn hàng','field'=>'tong_don_hang','type'=>'text');
	$list_config[] = array('title'=>'Edit','type'=>'edit');
	TemplateHelper::genarate_form_liting($this, $this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
    
?>



<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_ROOT.LINK_AMIN.'/modules/'.$this->module.'/assets/css/profits.css' ?>" />


<script>
	$(function() {
		$( "#text0" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy'});
		$( "#text1" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy'});
	});
</script>

<style type="text/css">
	.note-top{
		color: red;
	    font-size: 16px;
	    margin-bottom: 15px;
	    text-align: center;
	}
</style>