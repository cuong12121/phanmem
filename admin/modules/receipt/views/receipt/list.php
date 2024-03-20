<?php  
global $toolbar,$is_letan,$is_quanly;
$toolbar->setTitle(FSText :: _('Phiếu nhập máy') );
$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 


// $toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 

// $toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
// $toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');

	//	FILTER
$filter_config  = array();
$fitler_config['search'] = 1; 
$fitler_config['filter_count'] = 0;

$fitler_config['text_count'] = 3;

$text_imei = array();
$text_imei['title'] =  FSText::_('IMEI'); 

$text_phone = array();
$text_phone['title'] =  FSText::_('SĐT KH'); 

$text_info = array();
$text_info['title'] =  FSText::_('Tên khách hàng'); 


$fitler_config['text'][] = $text_imei;
$fitler_config['text'][] = $text_phone;
$fitler_config['text'][] = $text_info;


//$fitler_config['filter_count'] = 4;

	//	CONFIG	
$list_config = array();
$list_config[] = array('title'=>'Tên KH','field'=>'name','ordering'=> 1, 'type'=>'text','col_width' => '10%','arr_params'=>array('size'=> 5));
$list_config[] = array('title'=>'SĐT KH','field'=>'phone','ordering'=> 1, 'type'=>'text','col_width' => '10%','arr_params'=>array('size'=> 5));
$list_config[] = array('title'=>'IMEI','field'=>'imei','ordering'=> 1, 'type'=>'action');
$list_config[] = array('title'=>'Nội dung sửa','field'=>'more_info','ordering'=> 1, 'type'=>'action');
$list_config[] = array('title'=>'Thời gian nhận','field'=>'begin_time','ordering'=> 1, 'type'=>'datetime');
$list_config[] = array('title'=>'Thời gian trả','field'=>'end_time','ordering'=> 1, 'type'=>'datetime');
$list_config[] = array('title'=>'Giá dịch vụ','field'=>'total','ordering'=> 1, 'type'=>'action');
$list_config[] = array('title'=>'Sửa xong','field'=>'published','ordering'=> 1, 'type'=>'published');
$list_config[] = array('title'=>'Edit','type'=>'edit');	
$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
TemplateHelper::genarate_form_liting($this, $this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>

<style>
.hoan_tat {
	display: block;
	padding: 5px;
	border-right: 5px;
	background: green;
	color: #fff;
	font-weight: bold;
}
.wrap-toolbar2 h1 {
	padding-top: 10px;
}
.sua_xong {
	display: block;
	padding: 5px;
	border-right: 5px;
	background: #3da6ea;
	color: #fff;
	font-weight: bold;
}
.cho_khach {
	
	display: block;
	padding: 5px;
	border-right: 5px;
	background: #003150;
	color: #fff;
	font-weight: bold;
}
.yeucau {
	display: block;
	padding: 5px;
	border-right: 5px;
	background: red;
	color: #fff;
	font-weight: bold;
}
.new {
	display: block;
	padding: 5px;
	border-right: 5px;
	background: #888888;
	color: #fff;
	font-weight: bold;
}
.suaing {
	display: block;
	padding: 5px;
	border-right: 5px;
	background: orange ;
	color: #fff;
	font-weight: bold;
}
</style>