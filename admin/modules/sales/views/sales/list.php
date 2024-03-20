<link type="text/css" rel="stylesheet" media="all" href="templates/default/css/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Các chương trình sale-off') );
	$toolbar->addButton('duplicate',FSText :: _('Duplicate'),FSText :: _('You must select at least one record'),'duplicate.png');
	$toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
	
	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 
	$fitler_config['filter_count'] = 1;
	$fitler_config['text_count'] = 2;
	
	$filter_types = array();
	$filter_types['title'] = FSText::_('Type'); 
	$filter_types['list'] = @$types; 
	$filter_types['field'] = 'name'; 
	
	$text_from_date = array();
	$text_from_date['title'] =  FSText::_('Từ ngày'); 
			
	$text_to_date = array();
	$text_to_date['title'] =  FSText::_('Đến ngày'); 
	$filter_status = array();
	$fitler_config['text'][] = $text_from_date;
	$fitler_config['text'][] = $text_to_date;	
	
	
	$fitler_config['filter'][] = $filter_types;	
	
	//	CONFIG	
	$list_config = array();
	$list_config[] = array('title'=>'Tên','field'=>'name','ordering'=> 1, 'type'=>'text','col_width' => '20%','arr_params'=>array('size'=> 30));

//	$list_config[] = array('title'=>'Image','field'=>'image','type'=>'image','','arr_params'=>array('width'=> 120,'search'=>'/original/','replace'=>'/resized/'));
	//$list_config[] = array('title'=>'Giá','field'=>'price_old','no_col'=>3,'ordering'=> 1, 'type'=>'text','col_width' => '30%','arr_params'=>array('function'=>'format_money'));
//	$list_config[] = array('title'=>'Giá (min)','type'=>'label','col_width' => '20%',);
//	$list_config[] = array('title'=>'Giá bán','field'=>'price','no_col'=>3, 'type'=>'format_money','display_label'=>1,'arr_params'=>array('size'=>5));
//	$list_config[] = array('title'=>'Giảm cũ','field'=>'price_old','no_col'=>3, 'type'=>'format_money','display_label'=>1,'arr_params'=>array('size'=>5));
	$list_config[] = array('title'=>'Bắt đầu','field'=>'started_time','ordering'=> 1, 'type'=>'datetime');
	$list_config[] = array('title'=>'Kết thúc','field'=>'finished_time','ordering'=> 1, 'type'=>'datetime');
	
//	$list_config[] = array('title'=>'Đơn vị (min)','field'=>'unit', 'type'=>'text','arr_params'=>array('size'=>20));
//	$list_config[] = array('title'=>'Loại giảm giá','field'=>'discount_unit','no_col'=>3, 'type'=>'edit_selectbox','display_label'=>1,'arr_params'=>array('arry_select'=>array('percent'=>'Phần trăm','price'=>'Giá trị')));
//	$list_config[] = array('title'=>'Summary','field'=>'summary','type'=>'text','col_width' => '30%','arr_params'=>array('size'=>50,'rows'=>8));
	// $list_config[] = array('title'=>'Type','field'=>'type_name','ordering'=> 1, 'type'=>'text','col_width' => '10%');
//	$list_config[] = array('title'=>'Tổng view','field'=>'hits','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Ordering','field'=>'ordering','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>1));
//	$list_config[] = array('title'=>'Home','field'=>'show_in_home','ordering'=> 1, 'type'=>'change_status','arr_params'=>array('function'=>'home'));
	$list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
	$list_config[] = array('title'=>'Ưu tiên','field'=>'is_default','ordering'=> 1, 'type'=>'change_status');
//	$list_config[] = array('title'=>'SP KM','field'=>'is_promotion','ordering'=> 1, 'type'=>'change_status','arr_params'=>array('function'=>'promotion'));
	$list_config[] = array('title'=>'Edit','type'=>'edit');
	// $list_config[] = array('title'=>'View','field'=>'','ordering'=> 0, 'type'=>'text','arr_params'=>array('function'=>'view_data'));
//	$list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
	$list_config[] = array('title'=>'Edited time','field'=>'edited_time','ordering'=> 1, 'type'=>'datetime');
	$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this,$this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>
<style>
.filter_area input[type='text']{
}
.filter_area .row div{
	margin-bottom: 5px;
}
</style>
<script>
	$(function() {
		$( "#text0" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true} );
		$( "#text1" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true} );
	});
</script>
