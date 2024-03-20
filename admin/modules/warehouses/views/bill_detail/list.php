<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_ROOT; ?>/libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="<?php echo URL_ROOT; ?>/libraries/jquery/jquery.ui/jquery-ui.js"></script>
<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_ADMIN; ?>/templates/default/css/jquery-ui.css" />

<?php  
global $toolbar;
$toolbar->setTitle(FSText :: _('Sản phẩm xuất nhập kho') );
	// $toolbar->addButton('duplicate',FSText :: _('Duplicate'),'','duplicate.png');
	// $toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
//$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
//$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
//$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png');

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
$filter_warehouses['title'] = FSText::_('Kho hàng'); 
$filter_warehouses['list'] = @$warehouses; 
$filter_warehouses['field'] = 'name'; 	

		//Loại sản phẩm
$filter_type = array();
$filter_type['title'] = FSText::_('Loại phiếu'); 
$filter_type['list'] = $this-> arr_type;

		//Loại sản phẩm
$filter_type_import = array();
$filter_type_import['title'] = FSText::_('Kiểu'); 
$filter_type_import['list'] = $this-> arr_type_import;

		//Loại sản phẩm
// $filter_status = array();
// $filter_status['title'] = FSText::_('Trạng thái'); 
// $filter_status['list'] = $this-> arr_status;

$fitler_config['filter'][] = $filter_warehouses;
$fitler_config['filter'][] = $filter_type;		
$fitler_config['filter'][] = $filter_type_import;	
// $fitler_config['filter'][] = $filter_status;

$fitler_config['text'][] = $text_from_date;
$fitler_config['text'][] = $text_to_date;											

	//	CONFIG	
$list_config = array();

// $list_config[] = array('title'=>'Id / Thời gian','field'=>'id','ordering'=> 1, 'type'=>'text','col_width' => '10%','arr_params'=>array('have_link_edit'=> '#')); 

$list_config[] = array('title'=>'Id / Thời gian','field'=>'id','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=>'show_record_id'));


$list_config[] = array('title'=>'Ngày','field'=>'created_time','type'=>'text','no_col'=>1);

$list_config[] = array('title'=>'Sản phẩm','field'=>'product_name','ordering'=> 1, 'type'=>'text','col_width' => '15%');

$list_config[] = array('title'=>'Kho hàng','field'=>'id','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=>'show_ware'));
$list_config[] = array('title'=>'SL','field'=>'amount','ordering'=> 1, 'type'=>'text');
$list_config[] = array('title'=>'Tồn','field'=>'ton','ordering'=> 1, 'type'=>'text');
$list_config[] = array('title'=>'Giá','field'=>'price','ordering'=> 1, 'type'=>'format_money');
$list_config[] = array('title'=>'Tổng tiền','field'=>'id','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=>'show_total'));
$list_config[] = array('title'=>'Ghi chú','field'=>'note','ordering'=> 1, 'type'=>'text');
// $list_config[] = array('title'=>'Loại Chiết khấu','field'=>'discount_type','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=>'show_discount_type'),'no_col'=>9);
// $list_config[] = array('title'=>'File excel','field'=>'file','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=>'show_file'));
// $list_config[] = array('title'=>'Người tạo','field'=>'create_username','ordering'=> 1, 'type'=>'text');
// $list_config[] = array('title'=>'Ghi chú','field'=>'note','ordering'=> 1, 'type'=>'text');
// $list_config[] = array('title'=>'Tình trạng','field'=>'status','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=>'show_status'));
// $list_config[] = array('title'=>'Thao tác','type'=>'list_action','list_action' => array('edit'=> 'Sửa phiếu','print' => 'In phiếu'));

TemplateHelper::genarate_form_liting($this, $this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>


<script>
	$(function() {
		$( "#text0" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy'});
		$( "#text1" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy'});
	});
</script>