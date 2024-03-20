<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Products') );
	$toolbar->addButton('duplicate',FSText :: _('Duplicate'),FSText :: _('You must select at least one record'),'duplicate.png');
	$toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
		// $toolbar->addButton('is_feed',FSText :: _('Feed'),FSText :: _('You must select at least one record'),'published.png');
	// $toolbar->addButton('unis)feed',FSText :: _('Unfeed'),FSText :: _('You must select at least one record'),'unpublished.png');
	// $toolbar->addButton('export',FSText :: _('Export'),'','Excel-icon.png');
	
	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 
	$fitler_config['filter_count'] = 8;
	$fitler_config['text_count'] = 0;
	$text_from_export = array();
	$text_from_export['title'] =  FSText::_('Export từ'); 
	$text_to_export = array();
	$text_to_export['title'] =  FSText::_('Export đến'); 
	
	$filter_categories = array();
	$filter_categories['title'] = FSText::_('Categories'); 
	$filter_categories['list'] = @$categories; 
	$filter_categories['field'] = 'treename'; 
	
	//Loại sản phẩm
	$filter_type = array();
	$filter_type['title'] = FSText::_('Loại sản phẩm'); 
	$filter_type['list'] = @$types;
	
	//Loại sản phẩm
	$filter_manu = array();
	$filter_manu['title'] = FSText::_('Hãng sản xuất'); 
	$filter_manu['list'] = @$manufactories;
	 
	//SP tiêu biểu
	$filter_hot = array();
	$filter_hot['title'] = FSText::_('SP Hot'); 
	$filter_hot['list'] = array(1=>'Có',2=>'Không'); 

	$filter_sell = array();
	$filter_sell['title'] = FSText::_('SP bán chạy'); 
	$filter_sell['list'] = array(1=>'Có',2=>'Không'); 

	$filter_home = array();
	$filter_home['title'] = FSText::_('Hiện trang chủ'); 
	$filter_home['list'] = array(1=>'Có',2=>'Không');

	//Loại sản phẩm
	$filter_status = array();
	$filter_status['title'] = FSText::_('Trạng thái'); 
	$filter_status['list'] = @$style_status;

	//Loại sản phẩm
	$filter_creator = array();
	$filter_creator['title'] = FSText::_('Người tạo'); 
	$filter_creator['list'] = @$creator_arr;
	
	$fitler_config['filter'][] = $filter_categories;
	$fitler_config['filter'][] = $filter_manu;		


	$fitler_config['filter'][] = $filter_type;											
	$fitler_config['filter'][] = $filter_sell;
	$fitler_config['filter'][] = $filter_home;
	$fitler_config['filter'][] = $filter_status;
	$fitler_config['filter'][] = $filter_hot;
	$fitler_config['filter'][] = $filter_creator;
																																																																																																																																																																																																																																																																																																																																																																																																																						
	$fitler_config['text'][] = $text_from_export;
	$fitler_config['text'][] = $text_to_export;												
	//	CONFIG	
	$list_config = array();
	$list_config[] = array('title'=>'Tên','field'=>'name','ordering'=> 1, 'type'=>'text','col_width' => '20%','arr_params'=>array('size'=> 30));

	$list_config[] = array('title'=>'Image','field'=>'image','type'=>'image','no_col'=>1,'arr_params'=>array('search'=>'/original/','replace'=>'/small/'));
//	$list_config[] = array('title'=>'Giá','field'=>'price','ordering'=> 1, 'type'=>'text','col_width' => '10%','arr_params'=>array('function'=>'format_money'));
	$list_config[] = array('title'=>'Giá','type'=>'label');
	$list_config[] = array('title'=>'Giá gốc','field'=>'price_old','no_col'=>3, 'type'=>'text','display_label'=>1,'arr_params'=>array('size'=>10));
	
	$list_config[] = array('title'=>'Giá bán','field'=>'price','no_col'=>3, 'type'=>'text','display_label'=>1,'arr_params'=>array('size'=>10));

//	$list_config[] = array('title'=>'Summary','field'=>'summary','type'=>'text','col_width' => '30%','arr_params'=>array('size'=>50,'rows'=>8));

	
	// $list_config[] = array('title'=>'Tổng view','field'=>'hits','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Category','field'=>'category_name','ordering'=> 1, 'type'=>'text');

	$list_config[] = array('title'=>'Ordering','type'=>'label','no_col'=>5);
	$list_config[] = array('title'=>'Danh mục cấp 1','field'=>'ordering2','no_col'=>5, 'type'=>'edit_text','display_label'=>1,'arr_params'=>array('size'=>10));
	$list_config[] = array('title'=>'Danh mục con','field'=>'ordering','no_col'=>5, 'type'=>'edit_text','display_label'=>1,'arr_params'=>array('size'=>10));

	
	

	//$list_config[] = array('title'=>'Xóa cache','field'=>'id','type'=>'remove','arr_params'=>array('function'=>'remove_cache'));
	$list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
	$list_config[] = array('title'=>'Home','field'=>'show_in_home','ordering'=> 1, 'type'=>'change_status','arr_params'=>array('function'=>'home'));
	$list_config[] = array('title'=>'SP hot','field'=>'is_hot','ordering'=> 1, 'type'=>'change_status','arr_params'=>array('function'=>'is_hot'));
	//$list_config[] = array('title'=>'Khuyến mại','field'=>'is_promotion','ordering'=> 1, 'type'=>'change_status','arr_params'=>array('function'=>'is_promotion'));
	// $list_config[] = array('title'=>'Hotdeal','field'=>'is_hotdeal','ordering'=> 1, 'type'=>'change_status','arr_params'=>array('function'=>'is_hotdeal'));
	// $list_config[] = array('title'=>'SP mới','field'=>'is_new','ordering'=> 1, 'type'=>'change_status','arr_params'=>array('function'=>'is_new'));
	// $list_config[] = array('title'=>'SP bán chạy','field'=>'is_sell','ordering'=> 1, 'type'=>'change_status','arr_params'=>array('function'=>'is_sell'));
	// $list_config[] = array('title'=>'SP cũ','field'=>'is_old','ordering'=> 1, 'type'=>'change_status','arr_params'=>array('function'=>'is_old'));
		// $list_config[] = array('title'=>'Feed','field'=>'is_feed','ordering'=> 1, 'type'=>'change_status','arr_params'=>array('function'=>'is_feed'));
	$list_config[] = array('title'=>'Bán chạy','field'=>'is_sell','ordering'=> 1, 'type'=>'change_status','arr_params'=>array('function'=>'is_sell'));
	$list_config[] = array('title'=>'Edit','type'=>'edit');
		$list_config[] = array('title'=>'Người tạo','field'=>'creator_name','ordering'=> 1, 'type'=>'action');
	$list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
	// $list_config[] = array('title'=>'Người sửa','field'=>'action_username','ordering'=> 1, 'type'=>'action');
	$list_config[] = array('title'=>'Thời gian sửa','field'=>'edited_time','ordering'=> 1, 'type'=>'datetime');
	$list_config[] = array('title'=>'Xem bên ngoài','field'=>'id','type'=>'text','arr_params'=>array('function'=>'view_name'));
	$list_config[] = array('title'=>'Lịch sử','field'=>'id','type'=>'text','arr_params'=>array('function'=>'view_history'));
	$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting(clone $this,$this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>
<style>
.filter_area select{
	width: 120px;
}
</style>




<div id="export_form" class="export_form">
	<p>Nhập giới hạn export</p>
	<label>Export từ</label>
	<input type="text" placeholder="Export từ" class="form-control" name="export_from" id="export_from" value="0">
	<label>Export tới</label>
	<input type="text" placeholder="Export tới" class="form-control" name="export_to" id="export_to" value="500">
	<button type="button" onclick="javascript:call_export()">Export</button>
	<a href="javascript:void(0)" onclick="javascript:close_export()" id="close_export" class="close_export">X</a>
</div>
