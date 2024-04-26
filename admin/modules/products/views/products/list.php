<?php  
global $toolbar;
$toolbar->setTitle(FSText :: _('Products') );
	// $toolbar->addButton('duplicate',FSText :: _('Duplicate'),FSText :: _('You must select at least one record'),'duplicate.png');
	// $toolbar->addButton('save_all',FSText :: _('Save'),'','save.png');
$toolbar->addButton('export',FSText :: _('Xuất exel'),'','Excel-icon.png');
$toolbar->addButton('print_barcode_open',FSText :: _('In mã vạch'),FSText :: _(''),'print.png'); 

	// $toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png');
if( $_SESSION['ad_groupid'] != 1){
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	$toolbar->addButton('reset_amount_hold',FSText :: _('Reset tạm giữ'),'','remove.png');
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png');
}

	// $toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
		// $toolbar->addButton('is_feed',FSText :: _('Feed'),FSText :: _('You must select at least one record'),'published.png');
	// $toolbar->addButton('unis)feed',FSText :: _('Unfeed'),FSText :: _('You must select at least one record'),'unpublished.png');


//	FILTER


$filter_config  = array();
$fitler_config['search'] = 1; 
$fitler_config['filter_count'] = 2;
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

	//kho
$filter_warehouses = array();
$filter_warehouses['title'] = FSText::_('Kho'); 
$filter_warehouses['list'] = @$warehouses;


$fitler_config['filter'][] = $filter_categories;
$fitler_config['filter'][] = $filter_warehouses;	


$fitler_config['text'][] = $text_from_export;
$fitler_config['text'][] = $text_to_export;		

	//	CONFIG	
$list_config = array();
$list_config[] = array('title'=>'Image','field'=>'image','type'=>'image','','arr_params'=>array('search'=>'/original/','replace'=>'/original/'));
$list_config[] = array('title'=>'Mã vạch','field'=>'barcode','ordering'=> 1, 'type'=>'text','col_width' => '15%','arr_params'=>array('size'=> 20));

//$list_config[] = array('title'=>'Mã','field'=>'code','ordering'=> 1, 'type'=>'text','col_width' => '15%','arr_params'=>array('size'=> 20));

$list_config[] = array('title'=>'Mã','field'=>'id','ordering'=> 1, 'type'=>'text','col_width' => '15%','arr_params'=>array('function'=>'show_code'));

$list_config[] = array('title'=>'Tên','field'=>'name','ordering'=> 1, 'type'=>'text','col_width' => '20%','arr_params'=>array('size'=> 30));
if($_SESSION['ad_groupid'] !=1){
	$list_config[] = array('title'=>'Giá nhập','field'=>'import_price','ordering'=> 1, 'type'=>'format_money','display_label'=>0,'arr_params'=>array('size'=>10));
}

$list_config[] = array('title'=>'Giá bán','field'=>'price','ordering'=> 1, 'type'=>'format_money','display_label'=>0,'arr_params'=>array('size'=>10));

$list_config[] = array('title'=>'Giá bán đóng gói','field'=>'price_pack','ordering'=> 1, 'type'=>'format_money','display_label'=>0,'arr_params'=>array('size'=>10));

$list_config[] = array('title'=>'Giá bán thấp nhất','field'=>'price_min','ordering'=> 1, 'type'=>'format_money','display_label'=>0,'arr_params'=>array('size'=>10));
$list_config[] = array('title'=>'Hàng chuyển kho','field'=>'product_transfer','ordering'=> 1, 'display_label'=>0, 'type'=>'text', 'arr_params'=>array('size'=>10));



	//if(!empty($_SESSION [$this->prefix . 'filter1']) && $_SESSION [$this->prefix . 'filter1'] > 0){
$list_config[] = array('title'=>'Tồn','field'=>'amount','ordering'=> 1, 'type'=>'text','col_width' => '5%');
	//}else{
		//$list_config[] = array('title'=>'Tồn','field'=>'id','ordering'=> 0, 'type'=>'text','col_width' => '5%','arr_params'=>array('function'=>'view_amount'));
	//}


$list_config[] = array('title'=>'Tổng tồn','field'=>'id','ordering'=> 0, 'type'=>'text','col_width' => '5%','arr_params'=>array('function'=>'view_amount_all'));


$list_config[] = array('title'=>'Tạm giữ','field'=>'id','ordering'=> 0, 'type'=>'text','col_width' => '5%','arr_params'=>array('function'=>'view_amount_hold'));

if(!empty($_SESSION [$this->prefix . 'filter1']) && $_SESSION [$this->prefix . 'filter1'] > 0){
	$list_config[] = array('title'=>'Có thể bán','field'=>'amount_can_by','ordering'=> 1, 'type'=>'text','col_width' => '5%');
}else{
	$list_config[] = array('title'=>'Có thể bán','field'=>'id','ordering'=> 0, 'type'=>'text','col_width' => '5%','arr_params'=>array('function'=>'view_can_buy'));
}



$list_config[] = array('title'=>'Edit','type'=>'edit');

$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');

TemplateHelper::genarate_form_liting(clone $this,$this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>
<style>
	.filter_area select{
		width: 120px;
	}
	
	.panel{
            position: relative;
        } 
        
       
	
	 .scrolltable{
        position: absolute;
        background: #fff;
        top:0;
        width: 250%;
	 }
	 
	 .scrolltable th{
	    
	    width: 117px;    
	 }   
	 
	 .remove_border{
	     
        border:0 !important;
    }
	 
	 .scrolltable th:nth-child(1), .scrolltable th:nth-child(2){
	     width: 30px !important;
	 }
	 
	 .scrolltable th:nth-child(6){
	     
	     width: 300px !important;
	 }
	 
	 .wrap_list_pr{
	     width: 100px;
	 }
	 
	 tr td:nth-child(6) .wrap_list_pr{
	     width:283px !important;
	    
	 }
	 
	 tr td:nth-child(6){
	     width: 300px !important;
	 }
	 
	 tr th:nth-child(6){
	     width: 300px !important;
	 }
	 
	 tr td:nth-child(1), tr td:nth-child(2){
	     width: 30px !important;
	 }
	 
	 tr th:nth-child(1), tr th:nth-child(2){
	     width: 30px !important;
	 }
	 
	
	 .dataTable_wrapper{
	     overflow-x: unset !important;
	 }
	 
	 #page-wrapper .table-bordered>thead>tr>th, #page-wrapper .table-bordered>tbody>tr>td {
        width: 117px;
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



<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_ROOT.LINK_AMIN.'/modules/'.$this->module.'/assets/css/products.css?t='.time(); ?>" />

<script type="text/javascript" src="<?php echo URL_ROOT.LINK_AMIN.'/modules/'.$this->module.'/assets/js/products.js?t='.time(); ?>"></script>

<div id="popup-image" class="popup-page-list">
	<div class="close-pu" onclick="close_popup()">
		X
	</div>
	<div class="show-html">
		
	</div>
</div>

<div id="show_info_product" class="popup-page-list">
	<div class="close-pu" onclick="close_popup()">
		X
	</div>
	<div class="tabs-info">
		<div class="tab tab1 active_tab" data-id="1" onclick="show_tab_content(this)">
			Thông tin
		</div>
		<div class="tab" data-id="2" onclick="show_tab_content(this)">
			Tồn kho
		</div>
	</div>
	<div class="contents-info">
		
	</div>
</div>
<?php if($_SESSION['ad_groupid'] !=1){ ?>
<style type="text/css">
	.dataTable_wrapper tr th:nth-child(10) a,.dataTable_wrapper tr td:nth-child(10){
		color: red !important;
	}
</style>
<?php }else{ ?>
<style type="text/css">
	.dataTable_wrapper tr th:nth-child(9) a,.dataTable_wrapper tr td:nth-child(9){
		color: red !important;
		position: relative;
	}
	
	
	
</style>

<?php } ?>
<script>
    $(document).ready(function() {
            $('.form-horizontal').scroll(function() {
              // Lấy vị trí cuộn hiện tại của trang
              var scrollPosition = $(this).scrollTop();
              
              if(scrollPosition>=200){
                    if(!$('.table-bordered thead').hasClass('scrolltable')){
                        
                        $('.table-bordered thead').addClass('scrolltable');
                        
                        
                        $('.scrolltable tr th').addClass('remove_border');

                        
                    }  
                  
              }
              else{
                  if($('.table-bordered thead').hasClass('scrolltable')){
                    
                    $('.scrolltable tr th').removeClass('remove_border');
                        
                     $('.table-bordered thead').removeClass('scrolltable');
                      
                     
                      
                  }
              }
        
             
            });
          });
</script>


