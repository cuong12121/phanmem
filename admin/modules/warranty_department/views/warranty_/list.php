<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Danh sách phiếu') );
	// $toolbar->addButton('duplicate',FSText :: _('Duplicate'),'','duplicate.png');
	// $toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	//$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	//$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
	
	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 
	$fitler_config['filter_count'] = 0;																

	//	CONFIG	
	$list_config = array();
	$list_config[] = array('title'=>'Name','field'=>'name','ordering'=> 1, 'type'=>'text','col_width' => '15%','arr_params'=>array('size'=> 15));
	$list_config[] = array('title'=>'Mã sản phẩm','field'=>'code','ordering'=> 1, 'type'=>'text','col_width' => '12%','arr_params'=>array('size'=> 15));
	$list_config[] = array('title'=>'Số lượng','field'=>'amount','ordering'=> 1, 'type'=>'text','col_width' => '5%','arr_params'=>array('size'=> 15));

	$list_config[] = array('title'=>'Loại','field'=>'type','ordering'=> 1, 'type'=>'edit_selectbox','arr_params'=>array('arry_select'=>$types,'field_value'=>'id','field_label'=>'name','size'=>10));
	
	$list_config[] = array('title'=>'Lý do','field'=>'note','type'=>'text','arr_params');
	//$list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
	$list_config[] = array('title'=>'Người tạo','field'=>'creator_name','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');

	$list_config[] = array('title'=>'Actions','field'=>'id','type'=>'text','col_width' => '15%','arr_params'=>array('function'=>'view_actions'));
    $list_config[] = array('title'=>'Edit','type'=>'edit');
	
	$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this, $this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>


<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_ROOT.LINK_AMIN.'/modules/'.$this->module.'/assets/css/warranty.css' ?>" />

<script type="text/javascript" src="<?php echo URL_ROOT.LINK_AMIN.'/modules/'.$this->module.'/assets/js/warranty.js' ?>"></script>


<div class="popup_change">
	<span class="close_pu">Đóng</span>
	<div class="title_popup">
		Chọn kho
	</div>
	<select name="change_warehouses" id="change_warehouses">
		<?php foreach ($warrantys as $item) {?>
		<option value="<?php echo $item->id ?>"><?php echo $item->name ?></option>
		<?php } ?>
	</select>
	<input type="hidden" value="" id="id_change_warehouses">
	<button type="button" id="btn_change_warehouses">Đồng ý cho đổi</button>
	<button type="button" id="btn_change_return">Đồng ý cho trả</button>
</div>




