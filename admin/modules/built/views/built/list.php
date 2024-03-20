<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<?php  
global $toolbar;
$toolbar->setTitle(FSText :: _('Danh sách') );
// $toolbar->addButton('add',FSText :: _('Add'),'','add.png');
//$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
//$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
// $toolbar->addButton('export',FSText :: _('Export'),'','Excel-icon.png');



$filter_config  = array();
$fitler_config['search'] = 1; 
$fitler_config['filter_count'] = 0;
$fitler_config['text_count'] = 0;

// $text_from_date = array();
// $text_from_date['title'] =  FSText::_('Từ ngày'); 

// $text_to_date = array();
// $text_to_date['title'] =  FSText::_('Đến ngày'); 

// $text_idpro = array();
// $text_idpro['title'] =  FSText::_('ID sản phẩm'); 

// $filter_status = array();
// $filter_status['title'] =  FSText::_('Trạng thái'); 
// $filter_status['list'] = @$array_obj_status;

// $filter_order_type = array();
// $filter_order_type['title'] =  FSText::_('Kênh bán'); 
// $filter_order_type['list'] = @$order_type; 

// $fitler_config['filter'][] = $filter_status;
// $fitler_config['filter'][] = $filter_order_type;
// $fitler_config['text'][] = $text_from_date;
// $fitler_config['text'][] = $text_to_date;
// $fitler_config['text'][] = $text_idpro;



//	CONFIG	
$list_config = array();

// $list_config[] = array('title'=>'Mã đơn hàng','field'=>'','type'=>'','arr_params'=>array('function'=>'desc_order_code'));
$list_config[] = array('title'=>'Name','field'=>'name','ordering'=> 1, 'type'=>'text');
// $list_config[] = array('title'=>'Người mua','field'=>'sender_name','ordering'=> 1, 'type'=>'text');
// $list_config[] = array('title'=>'Email','field'=>'sender_email','ordering'=> 1, 'type'=>'text');
// $list_config[] = array('title'=>'SĐT','field'=>'sender_telephone','ordering'=> 1, 'type'=>'text');
// $list_config[] = array('title'=>'Địa chỉ','field'=>'sender_address','ordering'=> 1, 'type'=>'text');
// $list_config[] = array('title'=>'Giá trị','field'=>'total_after_discount','ordering'=> 1, 'type'=>'format_money');
// $list_config[] = array('title'=>'Ngày tạo','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
// $list_config[] = array('title'=>'Trạng thái','field'=>'status','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=>'showStatus'));

$list_config[] = array('title'=>'Edit','type'=>'edit');
$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');

TemplateHelper::genarate_form_liting($this,$this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>
<script>
	// $(function() {
	// 	$( "#text0" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy'});
	// 	$( "#text1" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy'});
	// });
</script>
