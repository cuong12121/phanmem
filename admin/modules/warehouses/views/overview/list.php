<?php  
global $toolbar;
$toolbar->setTitle(FSText :: _('Danh sách kho') );
	// $toolbar->addButton('duplicate',FSText :: _('Duplicate'),'','duplicate.png');
	// $toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');

	//	FILTER
$filter_config  = array();
$fitler_config['search'] = 0; 
$fitler_config['filter_count'] = 2;		

$dates = array(0=> 'Hôm nay',1=> 'Hôm qua',2=> 'Tuần này',3=> 'Tuần trước',4=> 'Tháng này',5=> 'Tháng trước');

$filter_warehouses = array();
$filter_warehouses['title'] = FSText::_('Thời gian'); 
$filter_warehouses['list'] = @$dates; 
$filter_warehouses['field'] = 'name'; 	

$filter_warehouses_2 = array();
$filter_warehouses_2['title'] = FSText::_('Kho hàng'); 
$filter_warehouses_2['list'] = @$warehouses; 
$filter_warehouses_2['field'] = 'name'; 

$fitler_config['filter'][] = $filter_warehouses;
$fitler_config['filter'][] = $filter_warehouses_2;														
	//	CONFIG	
$list_config = array();
// $list_config[] = array('title'=>'Name','field'=>'name','ordering'=> 1, 'type'=>'text','col_width' => '20%','arr_params'=>array('size'=> 30));

	// $list_config[] = array('title'=>'Mô tả','field'=>'summary','type'=>'text','arr_params');
// $list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
// $list_config[] = array('title'=>'Edit','type'=>'edit');

$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');

TemplateHelper::genarate_form_liting($this, $this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);

?>



