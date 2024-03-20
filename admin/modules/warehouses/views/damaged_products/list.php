<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_ROOT; ?>/libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="<?php echo URL_ROOT; ?>/libraries/jquery/jquery.ui/jquery-ui.js"></script>
<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_ADMIN; ?>/templates/default/css/jquery-ui.css" />

<?php  
global $toolbar;
$toolbar->setTitle(FSText :: _('Danh sách hàng lỗi') );
	// $toolbar->addButton('duplicate',FSText :: _('Duplicate'),'','duplicate.png');
	// $toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');

	//	FILTER
$filter_config  = array();
$fitler_config['search'] = 1; 
// $fitler_config['filter_count'] = 2;		
$fitler_config['text_count'] = 1;



$text_products = array();
$text_products['title'] =  FSText::_('Tên, mã sản phẩm'); 

// $text_positions = array();
// $text_positions['title'] =  FSText::_('Tên, mã vị trí'); 	

$fitler_config['text'][] = $text_products;

// $fitler_config['text'][] = $text_positions;	

$filter_warehouses = array();
$filter_warehouses['title'] = FSText::_('Kho hàng'); 
$filter_warehouses['list'] = @$warehouses; 
$filter_warehouses['field'] = 'name'; 	

		//Loại sản phẩm
$filter_status = array();
$filter_status['title'] = FSText::_('Trạng thái'); 
$filter_status['list'] = $this-> arr_status;

$fitler_config['filter'][] = $filter_warehouses;
$fitler_config['filter'][] = $filter_status;


	//	CONFIG	
$list_config = array();
$list_config[] = array('title'=>'Id / Thời gian','field'=>'id','ordering'=> 1, 'type'=>'text','col_width' => '10%');
$list_config[] = array('title'=>'Ngày','field'=>'created_time','type'=>'text','no_col'=>1);
$list_config[] = array('title'=>'Tên sản phẩm','field'=>'name','ordering'=> 1, 'type'=>'text');
$list_config[] = array('title'=>'Mã sản phẩm','field'=>'code','ordering'=> 1, 'type'=>'text');

$list_config[] = array('title'=>'Kho hàng','field'=>'warehouses_name','ordering'=> 1, 'type'=>'text');

// $list_config[] = array('title'=>'Loại phiếu','field'=>'id','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=>'show_type'),'no_col'=>4);

$list_config[] = array('title'=>'SL tồn','field'=>'amount','ordering'=> 1, 'type'=>'text');
$list_config[] = array('title'=>'SL lỗi','field'=>'damaged','ordering'=> 1, 'type'=>'text');
// $list_config[] = array('title'=>'Tổng tiền','field'=>'total_price','ordering'=> 1, 'type'=>'format_money');
// $list_config[] = array('title'=>'Chiết khấu','field'=>'discount','ordering'=> 1, 'type'=>'format_money');
// $list_config[] = array('title'=>'Loại Chiết khấu','field'=>'discount_type','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=>'show_discount_type'),'no_col'=>9);
// $list_config[] = array('title'=>'File excel','field'=>'file','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=>'show_file'));
$list_config[] = array('title'=>'Người tạo','field'=>'create_username','ordering'=> 1, 'type'=>'text');
$list_config[] = array('title'=>'Ghi chú','field'=>'note','ordering'=> 1, 'type'=>'text');
	// $list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
// $list_config[] = array('title'=>'Tình trạng','field'=>'status','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=>'show_status'));

// $list_config[] = array('title'=>'Edit','type'=>'edit');
// $list_config[] = array('title'=>'Thao tác','type'=>'list_action','list_action' => array('edit'=> 'Sửa phiếu','print' => 'In phiếu'));
TemplateHelper::genarate_form_liting($this, $this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>
