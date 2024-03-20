<?php  
global $toolbar;
$toolbar->setTitle(FSText :: _('Danh sách Vị trí') );
	// $toolbar->addButton('duplicate',FSText :: _('Duplicate'),'','duplicate.png');
	// $toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('cancel',FSText :: _('Cancel'),'','cancel.png'); 
	// $toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	// $toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	// $toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	// $toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');

	//	FILTER
$filter_config  = array();
$fitler_config['search'] = 1; 
$fitler_config['filter_count'] = 1;

$filter_warehouses = array();
$filter_warehouses['title'] = FSText::_('Kho hàng'); 
$filter_warehouses['list'] = @$warehouses; 
$filter_warehouses['field'] = 'name'; 

$fitler_config['filter'][] = $filter_warehouses;																

	//	CONFIG	
$list_config = array();
$list_config[] = array('title'=>'Mã','field'=>'code','ordering'=> 1, 'type'=>'text');
$list_config[] = array('title'=>'Mã vị trí','field'=>'list_code','ordering'=> 1, 'type'=>'text');
$list_config[] = array('title'=>'Name','field'=>'name','ordering'=> 1, 'type'=>'text','col_width' => '20%','arr_params'=>array('size'=> 30));
$list_config[] = array('title'=>'Danh mục','field'=>'list_parents_name','ordering'=> 1, 'type'=>'text');
$list_config[] = array('title'=>'Kho hàng','field'=>'warehouses_name','ordering'=> 1, 'type'=>'text');
$list_config[] = array('title'=>'Số lượng tối đa','field'=>'limit','ordering'=> 1, 'type'=>'text');
$list_config[] = array('title'=>'Số lượng hiện tại','field'=>'amount','ordering'=> 1, 'type'=>'text');
	// $list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
    // $list_config[] = array('title'=>'Edit','type'=>'edit');

$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');

TemplateHelper::genarate_form_liting($this, $this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>
