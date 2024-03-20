<script language="javascript" type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Danh sách') );
	// $toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
	// $toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	// $toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	// $toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	// $toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
	$toolbar->addButton('export_nomal',FSText :: _('Export'),'','Excel-icon.png');
	
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
	$list_config[] = array('title'=>'Name','field'=>'name','ordering'=> 1, 'type'=>'text','col_width' => '30%');
	$list_config[] = array('title'=>'SĐT','field'=>'phone','ordering'=> 1, 'type'=>'text','col_width' => '30%');
	$list_config[] = array('title'=>'Email','field'=>'email','ordering'=> 1, 'type'=>'text','col_width' => '30%');
	$list_config[] = array('title'=>'Tin nhắn','field'=>'message','ordering'=> 1, 'type'=>'text','col_width' => '30%');
	// $list_config[] = array('title'=>'Tên sản phẩm','field'=>'product_name','ordering'=> 1, 'type'=>'text','col_width' => '30%');
	// $list_config[] = array('title'=>'Mã sản phẩm','field'=>'product_code','ordering'=> 1, 'type'=>'text','col_width' => '30%');
	// $list_config[] = array('title'=>'Edit','type'=>'edit');
	$list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
	$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this,$this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);

?>

<script>
	$(function() {
		$( "#text0" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy'});
		$( "#text1" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy'});
	});
</script>