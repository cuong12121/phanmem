<div class="wrap-statics">
	<div class="table-stt">
		<div class="item">
			<div class="title">Tổng doanh thu:</div>
			<div class="money" id="doanh_thu" data="<?php echo $tong_doanh_thu ?>"><?php echo format_money($tong_doanh_thu,' đ','0 đ'); ?></div>
		</div>
		<div class="item">
			<div class="title">Tổng giá vốn:</div>
			<div class="money" id="chi_phi" data="<?php echo $tong_gia_von ?>" ><?php echo format_money($tong_gia_von,' đ','0 đ'); ?></div>
		</div>
		<div class="item">
			<div class="title">Tổng lợi nhuận:</div>
			<div class="money" id="loi_nhuan" data="<?php echo $tong_loi_nhuan ?>"><?php echo format_money($tong_loi_nhuan,' đ','0 đ'); ?></div>
		</div>
		<div class="item">
			<div class="title">Tổng đơn hàng:</div>
			<div class="money" id="tong_don_hang" data="<?php echo $tong_don_hang ?>"><?php echo format_money($tong_don_hang,'','0'); ?></div>
		</div>
	</div>
	<input id="shop_id" type="hidden" value="<?php echo $users->shop_id ?>" >
</div>

<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Lợi nhuận công ty tạm tính') );
	$toolbar->addButton('add_time',FSText :: _('Tạo mốc lợi nhuận'),'','add.png');
?>
<div class="panel panel-default">
	<div class="panel-body">
		


	<div class="form_body">
	

	<form class="form-horizontal" action="<?php echo FSRoute::_('index.php?module='.$this -> module.'&view='.$this -> view); ?>" name="adminForm" method="post">
		
<?php
    //	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 
    $fitler_config['filter_count'] = 3;
    $fitler_config['text_count'] = 2;

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

	$filter_shipping_unit = array();
	$filter_shipping_unit['title'] = FSText::_('Đơn vị vận chuyển'); 
	$filter_shipping_unit['list'] = @$shipping_unit; 
	$filter_shipping_unit['field'] = 'name'; 
	$fitler_config['filter'][] = $filter_shipping_unit;	

	$text_from_date = array();
	$text_from_date['title'] =  FSText::_('Từ ngày'); 

	$text_to_date = array();
	$text_to_date['title'] =  FSText::_('Đến ngày');

	$fitler_config['text'][] = $text_from_date;
	$fitler_config['text'][] = $text_to_date;
	$prefix = 'company_profits_items_';
	// dd($_SESSION);
?>	
	<div class="filter_area">
		<?php echo TemplateHelper::create_filter($fitler_config,$prefix); ?>
	</div>


	<div class="dataTable_wrapper">
		<table style="width: 100%;" id="dataTables-example" class="table table-hover table-striped table-bordered">
			<thead>
				<tr>
					<td>STT</td>
					<th>Tracking Code</th>
					<th>Mã đơn hàng</th>
					<th>Kho</th>
					<th>Sàn</th>
					<th>Shop</th>
					<th>Ngày</th>
					<th>Sản phẩm</th>
					<th>Tổng giá vốn</th>
					<th>Tổng giá trị đơn</th>
					<th>Lợi nhuận tạm tính</th>
				</tr>
			</thead>
			<tbody>
				<?php if(!empty($list)){
					$i=1;
					foreach ($list as $item){
						$item->detail_ids = substr($item->detail_ids, 1,-1);
						$list_item = $model->get_records('id IN ('.$item->detail_ids.')','fs_order_uploads_detail','count,product_price,product_code,total_price,import_price_company,total_price_company,sku_nhanh,sku');
						
				?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo $item-> tracking_code; ?></td>
						<td><?php echo $item-> code; ?></td>
						<td><?php echo $warehouses[$item-> warehouse_id]->code; ?></td>
						<td><?php echo $platforms[$item-> platform_id]->code; ?></td>
						<td><?php echo $item-> shop_code; ?></td>
						<td><?php echo date('d/m/Y',strtotime($item->date)); ?></td>
						<td>

							<?php if(!empty($list_item)){ ?>
								<div class="wrap_list_pr">
								<table class="table table-hover table-striped table-bordered">
									<tr>
										<th>Sku_nhanh</th>
										<th>Số lương</th>
										<th>Đơn giá nhập</th>
										<th>Thành tiền</th>
									</tr>
									<?php foreach ($list_item as $it_dt) { ?>
									<tr>
										<td><?php echo $it_dt-> sku_nhanh; ?></td>
										<td><?php echo $it_dt-> count; ?></td>
										<td><?php echo format_money($it_dt -> import_price_company,' đ','0 đ'); ?></td>
										<td><?php echo format_money($it_dt-> total_price_company,' đ','0 đ'); ?></td>
									</tr>
									<?php } ?>
								</table>
								</div>
							<?php } ?>
						</td>
						<td><?php echo format_money($item-> gia_von_cong_ty,' đ','0 đ'); ?></td>
						<td><?php echo format_money($item-> doanh_thu_cong_ty,' đ','0 đ'); ?></td>
						<td>
							<?php echo format_money($item-> profit_company,' đ','0 đ'); ?>
							<div style="color: red;font-weight: bold;"><?php echo $item->is_refund == 1 ? "Đơn hoàn" : "" ?></div>	
						</td>
					</tr>
					

				<?php $i++; }} ?>
			</tbody>
		</table>

		<div class="footer_form">
			<?php if(@$pagination) {?>
				<?php echo $pagination->showPagination();?>
			<?php } ?>
		</div>
	</div>


	

	<input type="hidden" value="<?php echo @$sort_field; ?>" name="sort_field">
	<input type="hidden" value="<?php echo @$sort_direct; ?>" name="sort_direct">
	<input type="hidden" value="<?php echo $this -> module;?>" name="module">
	<input type="hidden" value="<?php echo $this -> view;?>" name="view">
	<input type="hidden" value="" name="task">
	<input type="hidden" value="0" name="boxchecked">
	</form>
	</div>

	</div>
</div>




<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_ROOT.LINK_AMIN.'/modules/'.$this->module.'/assets/css/profits.css?t='.time(); ?>" />

<script type="text/javascript" src="<?php echo URL_ROOT.LINK_AMIN.'/modules/'.$this->module.'/assets/js/profits.js?t='.time(); ?>"></script>



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