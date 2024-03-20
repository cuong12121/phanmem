<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_ROOT; ?>/libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="<?php echo URL_ROOT; ?>/libraries/jquery/jquery.ui/jquery-ui.js"></script>
<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_ADMIN; ?>/templates/default/css/jquery-ui.css" />

<?php  
global $toolbar;
$toolbar->setTitle(FSText :: _('Danh sách chuyển kho') );
	// $toolbar->addButton('duplicate',FSText :: _('Duplicate'),'','duplicate.png');
	// $toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png');

	//	FILTER
$filter_config  = array();
$fitler_config['search'] = 1; 
$fitler_config['filter_count'] = 3;	
$fitler_config['text_count'] = 2;

$text_from_date = array();
$text_from_date['title'] =  FSText::_('Từ ngày'); 

$text_to_date = array();
$text_to_date['title'] =  FSText::_('Đến ngày'); 		

$filter_warehouses = array();
$filter_warehouses['title'] = FSText::_('Từ kho hàng'); 
$filter_warehouses['list'] = @$warehouses; 
$filter_warehouses['field'] = 'name'; 	

$filter_warehouses2 = array();
$filter_warehouses2['title'] = FSText::_('Đến kho hàng'); 
$filter_warehouses2['list'] = @$warehouses; 
$filter_warehouses2['field'] = 'name'; 

		//Loại sản phẩm
// $filter_type = array();
// $filter_type['title'] = FSText::_('Loại phiếu'); 
// $filter_type['list'] = $this-> arr_type;

		//Loại sản phẩm
// $filter_type_import = array();
// $filter_type_import['title'] = FSText::_('Kiểu'); 
// $filter_type_import['list'] = $this-> arr_type_import;

		//Loại sản phẩm
$filter_status = array();
$filter_status['title'] = FSText::_('Trạng thái'); 
$filter_status['list'] = $this-> arr_status;

$fitler_config['filter'][] = $filter_warehouses;
$fitler_config['filter'][] = $filter_warehouses2;
// $fitler_config['filter'][] = $filter_type;		
// $fitler_config['filter'][] = $filter_type_import;	
$fitler_config['filter'][] = $filter_status;

$fitler_config['text'][] = $text_from_date;
$fitler_config['text'][] = $text_to_date;											

	//	CONFIG	
$list_config = array();
$list_config[] = array('title'=>'Id / Thời gian','field'=>'id','ordering'=> 1, 'type'=>'text','col_width' => '10%');
$list_config[] = array('title'=>'Ngày','field'=>'created_time','type'=>'text','no_col'=>1);
$list_config[] = array('title'=>'Name','field'=>'name','ordering'=> 1, 'type'=>'text','col_width' => '15%','arr_params'=>array('size'=> 30));

$list_config[] = array('title'=>'Từ Kho hàng','field'=>'warehouses_name','ordering'=> 1, 'type'=>'text');
$list_config[] = array('title'=>'Đến Kho hàng','field'=>'to_warehouses_name','ordering'=> 1, 'type'=>'text');

// $list_config[] = array('title'=>'Loại phiếu','field'=>'id','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=>'show_type'),'no_col'=>4);

$list_config[] = array('title'=>'Tổng SP','field'=>'total_product','ordering'=> 1, 'type'=>'text');
$list_config[] = array('title'=>'Tổng SL','field'=>'total_amount','ordering'=> 1, 'type'=>'text');
// $list_config[] = array('title'=>'Tổng tiền','field'=>'total_price_after','ordering'=> 1, 'type'=>'format_money');
// $list_config[] = array('title'=>'Chiết khấu','field'=>'discount','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=>'show_discount'));
// $list_config[] = array('title'=>'Loại Chiết khấu','field'=>'discount_type','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=>'show_discount_type'),'no_col'=>9);
$list_config[] = array('title'=>'File excel','field'=>'file','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=>'show_file'));
$list_config[] = array('title'=>'Người tạo','field'=>'create_username','ordering'=> 1, 'type'=>'text');
$list_config[] = array('title'=>'Ghi chú','field'=>'note','ordering'=> 1, 'type'=>'text');
	// $list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');

$list_config[] = array('title'=>'Kho chuyển','field'=>'id','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=>'show_status'));

$list_config[] = array('title'=>'Kho nhận','field'=>'id','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=>'show_status2'));


// $list_config[] = array('title'=>'Edit','type'=>'edit');
$list_config[] = array('title'=>'Thao tác','type'=>'list_action','list_action' => array('edit'=> 'Sửa phiếu','print' => 'In phiếu','revoke' => 'Hủy phiếu'));
TemplateHelper::genarate_form_liting($this, $this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>


<script>
	$(function() {
		$( "#text0" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy'});
		$( "#text1" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy'});
	});

	function change_status_ajax(id, status){
		$.ajax({
			url: '<?php echo URL_ADMIN; ?>index.php?module=warehouses&view=bill_transfer&task=change_status_ajax&raw=1',
			type : 'POST',
			data: {id: id, status: status},
			success : function(data){
				$('.dataTable_wrapper').load(location.href+" div.dataTable_wrapper>*","");
			}
		});
	}
</script>