<?php  
global $toolbar;
$toolbar->setTitle(FSText :: _('Vị trí sản phẩm') );
	// $toolbar->addButton('duplicate',FSText :: _('Duplicate'),'','duplicate.png');
	// $toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 

	// $toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	// $toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	// $toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');

$toolbar->addButton('cancel',FSText :: _('Cancel'),'','cancel.png'); 
	//	FILTER
$filter_config  = array();
$fitler_config['search'] = 1; 
$fitler_config['filter_count'] = 1;
$fitler_config['text_count'] = 2;

$text_products = array();
$text_products['title'] =  FSText::_('Tên, mã sản phẩm'); 

$text_positions = array();
$text_positions['title'] =  FSText::_('Tên, mã vị trí'); 	

$fitler_config['text'][] = $text_products;
$fitler_config['text'][] = $text_positions;	


$filter_warehouses = array();
$filter_warehouses['title'] = FSText::_('Kho hàng'); 
$filter_warehouses['list'] = @$warehouses; 
$filter_warehouses['field'] = 'name'; 

$fitler_config['filter'][] = $filter_warehouses;																

	//	CONFIG	
$list_config = array();
$list_config[] = array('title'=>'Mã sản phẩm','field'=>'product_id','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=>'show_product_code'));
$list_config[] = array('title'=>'Mã vạch','field'=>'product_id','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=>'show_product_barcode'));
$list_config[] = array('title'=>'Tên sản phẩm','field'=>'product_id','ordering'=> 1, 'type'=>'text','col_width' => '20%','arr_params'=>array('function'=>'show_product_name'));
$list_config[] = array('title'=>'Số lượng','field'=>'amount','ordering'=> 1, 'type'=>'text');
$list_config[] = array('title'=>'Mã vị trí','field'=>'position_id','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=>'show_position_list_code'));
$list_config[] = array('title'=>'Vị trí','field'=>'position_id','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=>'show_position_name'));
// $list_config[] = array('title'=>'Danh mục','field'=>'list_parents_name','ordering'=> 1, 'type'=>'text');
$list_config[] = array('title'=>'Kho hàng','field'=>'warehouses_name','ordering'=> 1, 'type'=>'text');
// $list_config[] = array('title'=>'Số lượng tối đa','field'=>'limit','ordering'=> 1, 'type'=>'text');


	// $list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
    // $list_config[] = array('title'=>'Edit','type'=>'edit');

$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');

TemplateHelper::genarate_form_liting($this, $this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>
