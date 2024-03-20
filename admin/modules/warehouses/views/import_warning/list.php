<?php  
global $toolbar;
$toolbar->setTitle(FSText :: _('Cảnh báo nhập hàng ').$check_number_day.' ngày qua' );
	// $toolbar->addButton('duplicate',FSText :: _('Duplicate'),'','duplicate.png');
	// $toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
// $toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
// $toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
// $toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
// $toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
// $toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');

 $toolbar->addButton('back',FSText :: _('Cancel'),'','back.png'); 

	//	FILTER
$filter_config  = array();
$fitler_config['search'] = 1; 
$fitler_config['filter_count'] = 0;		
$fitler_config['text_count'] = 1;

$text_days = array();
$text_days['title'] =  FSText::_('Số ngày đã bán (20)');
$fitler_config['text'][] = $text_days;	

	//	CONFIG	
$list_config = array();
$list_config[] = array('title'=>'Name','field'=>'name','ordering'=> 1, 'type'=>'text','col_width' => '20%','arr_params'=>array('size'=> 30));
$list_config[] = array('title'=>'Mã sản phẩm','field'=>'code','type'=>'text');
$list_config[] = array('title'=>'Đã bán','field'=>'total','type'=>'text');
$list_config[] = array('title'=>'Tồn có thể bán','field'=>'amount_sell','type'=>'text');
$list_config[] = array('title'=>'Cần nhập thêm','field'=>'amount_import','type'=>'text');
	// $list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
    // $list_config[] = array('title'=>'Edit','type'=>'edit');

$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');

TemplateHelper::genarate_form_liting($this, $this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,@$pagination);
?>
