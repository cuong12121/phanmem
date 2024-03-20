<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_ROOT; ?>/libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="<?php echo URL_ROOT; ?>/libraries/jquery/jquery.ui/jquery-ui.js"></script>
<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_ADMIN; ?>/templates/default/css/jquery-ui.css" />

<script src="<?php echo URL_ROOT.'libraries/jquery/jsxlsx';?>/shim.min.js"></script>
<script src="<?php echo URL_ROOT.'libraries/jquery/jsxlsx';?>/xlsx.full.min.js"></script>

<?php  
global $toolbar;
$toolbar->setTitle(FSText :: _('Dự kiến nhập hàng') );

if(!empty($list)) {
	$toolbar->addButtonHTML('<a class="toolbar" onclick="save_ajax()" href="javascript:void(0)"><span title="Lưu lại" style="background:url('.URL_ADMIN.'templates/default/images/toolbar/save.png) no-repeat"></span>Lưu lại</a>');
	$toolbar->addButtonHTML('<a class="toolbar" onclick="export_excel()" href="javascript:void(0)"><span title="Export Excel" style="background:url('.URL_ADMIN.'templates/default/images/toolbar/Excel-icon.png) no-repeat"></span>Export Excel</a>');
	$toolbar->addButtonHTML('<a class="toolbar"  href="/admin/warehouses/movingaverage_list"><span title="Export Excel" style="background:url('.URL_ADMIN.'templates/default/images/toolbar/duplicate.png) no-repeat"></span>Danh sách đã lưu</a>');
	// $toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
}

// $toolbar->addButton('back',FSText :: _('Cancel'),'','back.png'); 


	// $toolbar->addButton('duplicate',FSText :: _('Duplicate'),'','duplicate.png');
	// $toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
// $toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
// $toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
// $toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
// $toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
// $toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');

	//	FILTER
$filter_config  = array();
$fitler_config['search'] = 1; 
$fitler_config['filter_count'] = 3;		
$fitler_config['text_count'] = 3;

$text_from_date = array();
$text_from_date['title'] =  FSText::_('Ngày bắt đầu'); 

$text_to_date = array();
$text_to_date['title'] =  FSText::_('Ngày kết thúc'); 	


$text_days = array();
$text_days['title'] =  FSText::_('Số ngày nhập bán hàng'); 

$fitler_config['text'][] = $text_from_date;
$fitler_config['text'][] = $text_to_date;	
$fitler_config['text'][] = $text_days;	

$filter_warehouses = array();
$filter_warehouses['title'] = FSText::_('Kho hàng'); 
$filter_warehouses['list'] = @$warehouses; 
$filter_warehouses['field'] = 'name'; 	

$filter_warehouses_2 = array();
$filter_warehouses_2['title'] = FSText::_('Kho hàng so sánh'); 
$filter_warehouses_2['list'] = @$warehouses; 
$filter_warehouses_2['field'] = 'name'; 	

$filter_categories = array();
$filter_categories['title'] = FSText::_('Danh mục sản phẩm'); 
$filter_categories['list'] = @$categories; 
$filter_categories['field'] = 'name'; 	

		//Loại sản phẩm
// $filter_status = array();
// $filter_status['title'] = FSText::_('Trạng thái'); 
// $filter_status['list'] = $this-> arr_status;

$fitler_config['type'] = 'no_auto';

$fitler_config['filter'][] = $filter_warehouses;
$fitler_config['filter'][] = $filter_warehouses_2;
$fitler_config['filter'][] = $filter_categories;


	//	CONFIG	
$list_config = array();
$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text','col_width' => '10%');
// $list_config[] = array('title'=>'Ngày','field'=>'created_time','type'=>'text','no_col'=>1);
$list_config[] = array('title'=>'Name <br>(1)','field'=>'name','ordering'=> 1, 'type'=>'text','col_width' => '15%','arr_params'=>array('size'=> 30));
$list_config[] = array('title'=>'Mã SP <br>(2)','field'=>'code','ordering'=> 1, 'type'=>'text');
$list_config[] = array('title'=>'Giá nhập <br>(3)','field'=>'import_price','ordering'=> 1, 'type'=>'text');
$list_config[] = array('title'=>'Kho hàng <br>(4)','field'=>'warehouse_id','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=>'show_warehouses_name'));
$list_config[] = array('title'=>'Bán online <br>(5)','field'=>'total','ordering'=> 1, 'type'=>'text');
$list_config[] = array('title'=>'SL bán TB (trong '.@$datediff.' ngày) <br>(6)','field'=>'total','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=>'show_total_avg'));

$list_config[] = array('title'=>'Dự kiến bán (trong '.@$date_continue.' ngày tới) <br>(7)','field'=>'total','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=>'show_total_cont'));

$list_config[] = array('title'=>'Tồn có thể bán<br>(8)','field'=>'id','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=>'show_warehouses_product'));

$list_config[] = array('title'=>'Số lượng cần nhập<br>(9)','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=>'show_warehouses_product_buy'));

$list_config[] = array('title'=>'Tồn hiện tại đủ bán bao nhiêu ngày<br>(10)','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=>'show_warehouses_product_day'));

$list_config[] = array('title'=>'Tồn có thể bán ở kho cần so sánh<br>(11)','field'=>'id','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=>'show_warehouses_ss_product'));

$list_config[] = array('title'=>'Nhập hàng','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=>'show_import_product'));

// $list_config[] = array('title'=>'Kho hàng','field'=>'warehouses_name','ordering'=> 1, 'type'=>'text');

// $list_config[] = array('title'=>'Tổng SP','field'=>'total_product','ordering'=> 1, 'type'=>'text');
// $list_config[] = array('title'=>'Tổng SL','field'=>'total_amount','ordering'=> 1, 'type'=>'text');
// $list_config[] = array('title'=>'Tổng tiền','field'=>'total_price','ordering'=> 1, 'type'=>'format_money');
// $list_config[] = array('title'=>'Chiết khấu','field'=>'discount','ordering'=> 1, 'type'=>'format_money');
// $list_config[] = array('title'=>'Loại Chiết khấu','field'=>'discount_type','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=>'show_discount_type'),'no_col'=>9);
// $list_config[] = array('title'=>'File excel','field'=>'file','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=>'show_file'));
// $list_config[] = array('title'=>'Người tạo','field'=>'create_username','ordering'=> 1, 'type'=>'text');
// $list_config[] = array('title'=>'Ghi chú','field'=>'note','ordering'=> 1, 'type'=>'text');
	// $list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
// $list_config[] = array('title'=>'Tình trạng','field'=>'status','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=>'show_status'));

// $list_config[] = array('title'=>'Edit','type'=>'edit');
// $list_config[] = array('title'=>'Thao tác','type'=>'list_action','list_action' => array('edit'=> 'Sửa phiếu','print' => 'In phiếu'));

if(@$statistical1['count']) {
	include 'statistical1.php';
}
?>

<?php TemplateHelper::genarate_form_liting($this, $this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>


<!-- <div class="popup_text">
	<span class="close">X</span>
	<div class="name">Máy chiếu mini KAW-K550 - Trắng - Không size</div>
	<input class="count" type="text" value="" placeholder="Số lượng">
	<div class="buttom-click">
		<span>Đồng ý</span>
	</div>


</div> -->

<style type="text/css">
	.show_import_product{
		background: blue;
	    color: #fff !important;
	    display: block;
	    padding: 5px 20px;
	    line-height: 16px;
	    border-radius: 10px;
	}

	.popup_text{
		position: fixed;
	    top: 30%;
	    left: 50%;
	    transform: translate(-50%, -50%);
	    background: #fff;
	    padding: 20px;
	    width: 370px;
	    border: 2px solid #1293f9;
	}
	.popup_text .name{
		font-size: 16px;
    	margin-bottom: 15px;
    	font-weight: bold;
	}

	.popup_text .count{
		width: 204px;
	    line-height: 22px;
	    padding: 5px 10px;
	    border: 1px solid #9e9e9e;
	    margin-bottom: 15px;
	}

	.popup_text input{
		width: 204px;
	    line-height: 22px;
	    padding: 5px 10px;
	    border: 1px solid #9e9e9e;
	    margin-bottom: 10px;
	}
	.buttom-click span{
		display: inline-block;
	    padding: 6px 20px 5px;
	    background: #1293f9;
	    color: #fff;
	    font-size: 16px;
	}
	
</style>

<script  type="text/javascript" language="javascript">
	$(function() {
		$( "#text0" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy'});
		$( "#text1" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy'});
	});


	function show_import_product() {
		
	}

	
	function export_excel(){
		fileName = 'movingaverage_product_<?php echo time(); ?>';
		fileType = 'xlsx';
		var table = document.getElementById("dataTables-example");
		var wb = XLSX.utils.table_to_book(table, {sheet: 'Dự kiến nhập hàng'});

		var wscols = [
		{wch:5},
		{wch:20}
		];

		wb['!cols'] = wscols;
			// ws['!cols'] = wscols;
			return XLSX.writeFile(wb, null || fileName + "." + (fileType || "xlsx"));
		};


		function save_ajax(){
			keysearch = $('#keysearch').val();
			text0 = $('#text0').val();
			text1 = $('#text1').val();
			text2 = $('#text2').val();
			filter0 = $('#filter0').val();
			filter1 = $('#filter1').val();
			filter2 = $('#filter2').val();

			$.ajax({url: "index.php?module=warehouses&view=movingaverage&task=save_ajax&raw=1",
				data: {keysearch: keysearch,text0: text0, text1:text1,
					text2:text2, filter0:filter0, filter1:filter1, filter2:filter2 },
				dataType: "text",
				success: function(data) {
					if(data){
						alert(data);
						// $('#ajax_get_tags').html(data);
					}
				}
			});
		}


	</script>