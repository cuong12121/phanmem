<link type="text/css" rel="stylesheet" media="all" href="templates/default/css/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Products') );
	$toolbar->addButton('remove',FSText :: _('Xóa vĩnh viễn'),FSText :: _('You must select at least one record'),'remove.png'); 
	
	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 
	$fitler_config['filter_count'] = 1;
	$fitler_config['text_count'] = 2;
	
	$filter_categories = array();
	$filter_categories['title'] = FSText::_('Categories'); 
	$filter_categories['list'] = @$categories; 
	$filter_categories['field'] = 'treename'; 
	
	$text_from_date = array();
	$text_from_date['title'] =  FSText::_('Từ ngày'); 
			
	$text_to_date = array();
	$text_to_date['title'] =  FSText::_('Đến ngày'); 
	$filter_status = array();
	$fitler_config['text'][] = $text_from_date;
	$fitler_config['text'][] = $text_to_date;	
	
	//Loại sản phẩm
	$filter_type = array();
	$filter_type['title'] = FSText::_('Loại sản phẩm'); 
	$filter_type['list'] = @$type;
	 
	//SP tiêu biểu
	$filter_hot = array();
	$filter_hot['title'] = FSText::_('SP tiêu biểu'); 
	$filter_hot['list'] = array(1=>'Có',2=>'Không'); 
	
	$fitler_config['filter'][] = $filter_categories;	
	$fitler_config['filter'][] = $filter_type;																																																																																																																																																																																																																																																																																																																																																																																																																							
	$fitler_config['filter'][] = $filter_hot;																																																																																																																																																																																																																																																																																																																																																																																																																							
	//	CONFIG	
	$list_config = array();
	$list_config[] = array('title'=>'Tên','field'=>'name','ordering'=> 1, 'type'=>'edit_text','col_width' => '30%','arr_params'=>array('size'=> 30));
	$list_config[] = array('title'=>'Image','field'=>'image','type'=>'image','','arr_params'=>array('width'=> 120,'search'=>'/original/','replace'=>'/resized/'));
	$list_config[] = array('title'=>'Category','field'=>'category_name','ordering'=> 1, 'type'=>'text','col_width' => '20%');
	$list_config[] = array('title'=>'Khôi phục','field'=>'id','type'=>'text','arr_params'=>array('function'=>'restore'));
	$list_config[] = array('title'=>'Nhân viên xóa','field'=>'eraser_name','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Thời gian xóa','field'=>'eraser_time','ordering'=> 1, 'type'=>'datetime');
	$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this,$this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>
<style>
.filter_area select,#text0,#text1{
	width: 120px;
}

</style>
<script>
	$(function() {
		$( "#text0" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true} );
		$( "#text1" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true} );
	});
</script>
