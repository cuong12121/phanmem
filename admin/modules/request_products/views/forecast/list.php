<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Dự báo') );
	$toolbar->addButton('add',FSText :: _('Thêm mới'),'','add.png');
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png');
?>
<div class="panel panel-default">
	<div class="panel-body">
		


	<div class="form_body">
	

	<form class="form-horizontal" action="<?php echo FSRoute::_('index.php?module='.$this -> module.'&view='.$this -> view); ?>" name="adminForm" method="post">
		
<?php
    //	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 
    $fitler_config['filter_count'] = 0;
    $fitler_config['text_count'] = 0;

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
?>	
	<div class="filter_area">
		<?php echo TemplateHelper::create_filter($fitler_config,$prefix); ?>
	</div>


	<div class="dataTable_wrapper">
		<table style="width: 100%;" id="dataTables-example" class="table table-hover table-striped table-bordered">
			<thead>
				<tr>

					<th>STT</th>
					<th width="3%">
						<input type="checkbox" onclick="checkAll(<?php echo count($list); ?>);" value="" name="toggle">
					</th>
					<th>Tên sản phẩm</th>
					<th>Mã sản phẩm</th>
					<th>Giá nhập</th>
					<th>Tổng bán offline</th>
					<th colspan="2">Tổng đặt online</th>
					<th colspan="2">SL bán TB/ 78 ngày</th>
					<th colspan="2">SL bán 60 ngày tới</th>
					<th colspan="2">Tồn kho có thể bán</th>
					<th colspan="2">Số tồn tối thiểu</th>
					<th colspan="2">Sắp chuyển kho tới</th>
					<th colspan="2">Chờ nhập hàng</th>
					<th colspan="2">SL cần nhập</th>
					<th>Tồn kho còn đủ bán trong bao nhiêu ngày</th>
					<th>Phân việc cho nhân viên</th>
					<th colspan="2">Phân hàng bắc nam</th>
				</tr>
			</thead>
			<tbody>

				<tr>
					<td></td>
					<td>1</td>
					<td>2</td>
					<td>3</td>
					<td>4</td>
					<td>5</td>
					<td colspan="2">6</td>
					<td colspan="2">[7] = [ (5 + 6) / 78]</td>
					<td colspan="2">[8] = [ (7) * 60]</td>
					<td colspan="2">[9]</td>
					<td colspan="2">[10]=(7*20)</td>
					<td colspan="2">[11]</td>
					<td colspan="2">[12]</td>
					<td colspan="2">[13] = [8 -9 +10 -11 -12]</td>
					<td>[14] = [9 /7]</td>
					<td>NV</td>
					<td colspan="2" >Liên kết với tài khoản quản lý kho</td>
				</tr>

				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>Miền bắc</td>
					<td>Miền nam</td>
					<td>Miền bắc</td>
					<td>Miền nam</td>
					<td>Miền bắc</td>
					<td>Miền nam</td>
					<td>Miền bắc</td>
					<td>Miền nam</td>
					<td>Miền bắc</td>
					<td>Miền nam</td>
					<td>Miền bắc</td>
					<td>Miền nam</td>
					<td>Miền bắc</td>
					<td>Miền nam</td>
					<td>Miền bắc</td>
					<td>Miền nam</td>
					<td></td>
					<td></td>
					<td>Số lượng để miền bắc * %= SL nhập MB</td>
					<td>Số lượng đi miền Nam * %= SL nhập NM</td>
				</tr>


				<?php $i = 1; foreach ($list as $item){
					$link = FSRoute::_('index.php?module='.$this -> module.'&view='.$this -> view.'&task=edit&id='.$item->id);
					$tb_78_mb = round(($item->buy_offline + $item->buy_online_mb) / 78,4);
					$tb_78_mn = round(($item->buy_offline + $item->buy_online_mn) / 78,4);
					$tb_60_mb = round(($item->buy_offline + $item->buy_online_mb) / 60,4);
					$tb_60_mn = round(($item->buy_offline + $item->buy_online_mn) / 60,4);
					$tb_20_mb = round(($tb_78_mb) * 20,4);
					$tb_20_mn = round(($tb_78_mn) * 20,4);
					$slcn_mb = $tb_60_mb - $item->buy_can_mb + $tb_20_mb - $item->sap_chuyen_toi_mb - $item->cho_nhap_mb;
					$slcn_mn = $tb_60_mb - $item->buy_can_mb + $tb_20_mb - $item->sap_chuyen_toi_mb - $item->cho_nhap_mn;
					
				 ?>
					<tr>
						<td><?php echo $i++ ?></td>
						<td><input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo $item->id; ?>"  name="id[]" id="cb<?php echo $i; ?>"></td>
						<td><a href="<?php echo $link ?>"><?php echo $item->name ?></a></td>
						<td><?php echo $item->code ?></td>
						<td><?php echo $item->price_import ?></td>
						<td><?php echo $item->buy_offline ?></td>
						<td><?php echo $item->buy_online_mb ?></td>
						<td><?php echo $item->buy_online_mn ?></td>
						<td><?php echo $tb_78_mb ?></td>
						<td><?php echo $tb_78_mn ?></td>
						<td><?php echo $tb_60_mb ?></td>
						<td><?php echo $tb_60_mn ?></td>
						<td><?php echo $item->buy_can_mb ?></td>
						<td><?php echo $item->buy_can_mb ?></td>
						<td><?php echo $tb_20_mb ?></td>
						<td><?php echo $tb_20_mn ?></td>
						<td><?php echo $item->sap_chuyen_toi_mb ?></td>
						<td><?php echo $item->sap_chuyen_toi_mn ?></td>
						<td><?php echo $item->cho_nhap_mb ?></td>
						<td><?php echo $item->cho_nhap_mn ?></td>
						<td><?php echo $slcn_mb ?></td>
						<td><?php echo $slcn_mn ?></td>
						<td><?php echo round(($item-> buy_can_mb / $tb_78_mb),4) + round(($item-> buy_can_mn / $tb_78_mn),4); ?></td>
						<td><?php echo !empty($employees[$item-> employees_id]) ? $employees[$item-> employees_id]->fullname : ''   ?></td>
						<td><?php echo (($slcn_mb + $slcn_mn) * $item -> phan_hang_mb) / 100 ?></td>
						<td><?php echo (($slcn_mb + $slcn_mn) * $item -> phan_hang_mn) / 100 ?></td>
					</tr>
				<?php } ?>
					

				<?php// $i++; ?>
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
	#dataTables-example{
		width: 2200px !important;
		max-width: none !important;
	}
	#dataTables-example p{
		max-height: 100px;
		overflow-y: auto;
	}
</style>
