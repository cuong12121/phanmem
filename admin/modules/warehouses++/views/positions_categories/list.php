<?php  
global $toolbar;
$toolbar->setTitle(FSText :: _('Danh mục vị trí') );
$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');

    //	FILTER
$filter_config  = array();
$fitler_config['search'] = 1; 
$fitler_config['filter_count'] = 1;

$filter_warehouses = array();
$filter_warehouses['title'] = FSText::_('Kho hàng'); 
$filter_warehouses['list'] = @$warehouses_all; 
$filter_warehouses['field'] = 'name'; 	

$fitler_config['filter'][] = $filter_warehouses;

	//	CONFIG	
$list_config = array();
$list_config[] = array('title'=>'Tên','field'=>'treename','ordering'=> 1, 'type'=>'text','col_width' => '30%','arr_params'=>array('size'=> 40),'align'=>'left');
$list_config[] = array('title'=>'Mã','field'=>'code','ordering'=> 1, 'type'=>'text');
$list_config[] = array('title'=>'Vị trí','field'=>'list_parents_name','ordering'=> 1, 'type'=>'text','align'=>'left');
$list_config[] = array('title'=>'Kho hàng','field'=>'warehouses_name','ordering'=> 1, 'type'=>'text');
$list_config[] = array('title'=>'Số lượng vị trí','field'=>'id','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=>'count_position'));
	//$list_config[] = array('title'=>'Image','field'=>'image','type'=>'image','no_col'=>1,'arr_params'=>array('width'=>150,'height'=>100));
	// $list_config[] = array('title'=>'Ordering','field'=>'ordering','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>3));
	// $list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');

$list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
// $list_config[] = array('title'=>'Edit','type'=>'edit');
$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
$list_config[] = array('title'=>'Thao tác','type'=>'list_action','list_action' => array('edit'=> 'Sửa','print' => 'In mã vạch'));


TemplateHelper::genarate_form_liting($this, $this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);

?>
