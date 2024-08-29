
<?php if($users-> group_id == 1){ ?>
<div class="note-top">
	<?php if($users-> money < $config['money_min']){ ?>
	Số tiền tạm ứng của bạn còn <?php echo format_money($users-> money,' đ','0 đ'); ?>. Không thể tạo đơn hàng, vui lòng nạp thêm tiền tạm ứng.
	<?php }else{ ?>
	Số tiền tạm ứng của bạn còn <?php echo format_money($users-> money,' đ','0 đ'); ?>. Nếu số tiền tạm ứng nhỏ hơn <?php echo format_money($config['money_min'],' đ','0 đ'); ?> thì sẽ ko tạo được đơn hàng.
	<?php } ?>
</div>
<?php } ?>
<?php  

	global $toolbar;
	$toolbar->setTitle(FSText :: _('Đơn hàng') );
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png');
	?>

	<!-- <a class="toolbar" style="color:red"  href="https://test.dienmayai.com/admin/order/external/add"><span  title=" Thêm mới đơn hàng ngoài" style="background:url('https://test.dienmayai.com/admin/templates/default/images/toolbar/add.png') no-repeat"></span>Thêm mới đơn hàng ngoài</a> -->

	<?php
	$toolbar->addButton('prints',FSText :: _('In Hóa Đơn'),FSText :: _('You must select at least one record'),'print.png');
	//$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	//$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	//$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
    
    //	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 
    $fitler_config['filter_count'] = 4;
    $fitler_config['text_count'] = 2;


    $filter_houses = array();
	$filter_houses['title'] = FSText::_('Giờ'); 
	$filter_houses['list'] = @$houses; 
	$filter_houses['field'] = 'name'; 
	$fitler_config['filter'][] = $filter_houses;


    $filter_warehouses = array();
	$filter_warehouses['title'] = FSText::_('Kho'); 
	$filter_warehouses['list'] = @$warehouses; 
	$filter_warehouses['field'] = 'name'; 
	$fitler_config['filter'][] = $filter_warehouses;


	$filter_platforms = array();
	$filter_platforms['title'] = FSText::_('Sàn'); 
	$filter_platforms['list'] = @$platforms; 
	$filter_platforms['field'] = 'name'; 
	$fitler_config['filter'][] = $filter_platforms;		


	$filter_print = array();
	$filter_print['title'] = FSText::_('Trạng thái'); 
	$filter_print['list'] = array(1=>'Đã in',2=>'Chưa in');
	$fitler_config['filter'][] = $filter_print;

	$text_from_date = array();
	$text_from_date['title'] =  FSText::_('Từ ngày'); 

	$text_to_date = array();
	$text_to_date['title'] =  FSText::_('Đến ngày');

	$fitler_config['text'][] = $text_from_date;
	$fitler_config['text'][] = $text_to_date;



	//	CONFIG	
	$list_config = array();
	$list_config[] = array('title'=>'Kho','field'=>'warehouse_id','type'=>'text','arr_params'=>array('function'=>'view_warehouse'));
	$list_config[] = array('title'=>'Sàn','field'=>'platform_id','type'=>'text','arr_params'=>array('function'=>'view_platform'));
	$list_config[] = array('title'=>'Shop','field'=>'shop_id','type'=>'text','arr_params'=>array('function'=>'view_shop'));

	$list_config[] = array('title'=>'Tên file','field'=>'name','ordering'=> 1, 'type'=>'text','col_width' => '15%','arr_params'=>array('size'=> 20));

	$list_config[] = array('title'=>'Ngày','field'=>'date','ordering'=> 1, 'type'=>'datetime');
	$list_config[] = array('title'=>'Giờ','field'=>'house_id','type'=>'text','arr_params'=>array('function'=>'view_house'));

	$list_config[] = array('title'=>'Hóa đơn PDF','field'=>'id','type'=>'text','arr_params'=>array('function'=>'view_pdf'));

	$list_config[] = array('title'=>'Đơn hàng excel','field'=>'id','type'=>'text','arr_params'=>array('function'=>'view_excel'));

	//$list_config[] = array('title'=>'Trạng thái','field'=>'id','type'=>'text','arr_params'=>array('function'=>'view_print'));

	$list_config[] = array('title'=>'Edit','type'=>'edit');
    $list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
	$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this, $this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
	
	
    
?>


<script>
	$(function() {
		$( "#text0" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy'});
		$( "#text1" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy'});
	});
</script>

<style type="text/css">
	.note-top{
		color: red;
	    font-size: 16px;
	    margin-bottom: 15px;
	    text-align: center;
	}
</style>