<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<link type="text/css" rel="stylesheet" media="all" href="templates/default/css/jquery-ui.css" />
<?php  
global $toolbar;
$toolbar->setTitle(FSText :: _('Khôi phục trạng thái') );
// $toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
$toolbar->addButton('export_nomal',FSText :: _('Export'),'','Excel-icon.png');
?>
<div class="form_body">
	<form action="index.php?module=<?php echo $this -> module;?>&view=<?php echo $this -> view;?>" name="adminForm" method="post">
		
		<!--	FILTER	-->
		<?php 
//			$filter_config  = array();
//			$fitler_config['search'] = 1; 
//			$fitler_config['filter_count'] = 2;

//		$filter_estore = array();
//			$filter_estore['title'] = FSText::_('Tin thuộc gian hàng'); 
//			$filter_estore['list'] = @$estores; 
//			$filter_estore['field'] = 'estore_name';

//		$fitler_config['filter'][] = $filter_estore;
//			$fitler_config['filter'][] = $filter_categories;
		
		$filter_config  = array();
		$fitler_config['search'] = 1; 
		$fitler_config['filter_count'] = 1;
		$fitler_config['text_count'] = 3;

		$text_from_date = array();
		$text_from_date['title'] =  FSText::_('Từ ngày'); 

		$text_to_date = array();
		$text_to_date['title'] =  FSText::_('Đến ngày'); 

		$text_userid = array();
		$text_userid['title'] =  FSText::_('Userid'); 

		$filter_status = array();
		$filter_status['title'] =  FSText::_('Trạng thái'); 
		$filter_status['list'] = @$array_obj_status; 

		$fitler_config['filter'][] = $filter_status;
		$fitler_config['text'][] = $text_from_date;
		$fitler_config['text'][] = $text_to_date;
		$fitler_config['text'][] = $text_userid;
		echo $this -> create_filter($fitler_config);
		?>
		<!--	END FILTER	-->
		
		<div class="form-contents">
			<table border="1" class="tbl_form_contents table table-hover table-striped table-bordered" bordercolor="#CCCCCC" cellpadding="2">
				<thead>
					<tr>
						<th width="3%">
							#
						</th>
						<th width="3%">
							<input type="checkbox" onclick="checkAll(<?php echo count($list); ?>);" value="" name="toggle">
						</th>
						<th>
							<?php echo  TemplateHelper::orderTable(FSText :: _('Mã đơn hàng'), 'a.id',@$sort_field,@$sort_direct) ; ?>
						</th>
						<th class="title">
							<?php echo  TemplateHelper::orderTable(FSText :: _('Người mua'), 'a.sender_name',@$sort_field,@$sort_direct) ; ?>
						</th>
						<th class="title">
							<?php echo  TemplateHelper::orderTable(FSText :: _('SĐT'), 'a.sender_telephone',@$sort_field,@$sort_direct) ; ?>
						</th>
						<!-- <th class="title">
							Tên SP
						</th> -->
						<!-- <th class="title">
							Thông tin thêm
						</th> -->
						<th class="title">
							<?php echo  TemplateHelper::orderTable(FSText :: _('Giá trị'), 'total_after_discount',@$sort_field,@$sort_direct) ; ?>
						</th>
						<th class="title"  >
							<?php echo  TemplateHelper::orderTable(FSText :: _('Ngày mua'), 'created_time',@$sort_field,@$sort_direct) ; ?>
						</th>
						<th class="title"  >
							<?php echo  TemplateHelper::orderTable(FSText :: _('Trạng thái'), 'status',@$sort_field,@$sort_direct) ; ?>
						</th>
						<th class="title" width="7%">
							<?php echo FSText :: _('Chi tiết'); ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 0; ?>
					<?php $total = 0;?>
					<?php if(@$list){?>
						<?php foreach ($list as $row) { ?>
							<?php $total += $row -> total_after_discount; ?>
							<?php $link_view = "index.php?module=".$this -> module."&view=".$this -> view."&task=edit&id=".$row->id; ?>
							<?php $order_detail = isset($list_order_details[$row -> id])?$list_order_details[$row -> id]:null; ?>

							<tr class="row<?php echo $i%2; ?>">
								<td><?php echo $i+1; ?></td>
								<td>
									<input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo $row->id; ?>"  name="id[]" id="cb<?php echo $i; ?>">
								</td>
								<td>
									<?php 
									$estore_code = 'DH';
									$estore_code .= str_pad($row -> id, 8 , "0", STR_PAD_LEFT);
									?>
									<a href="<?php echo $link_view;?>"  /> <?php echo $estore_code; ?></a>
									<?php if($row -> is_vnpay == 1){ ?>
										( Thanh toán qua VNPAY <?php echo $row -> code_vnpay == '00' ? ' - Đã thanh toán' : ' - Chưa thanh toán' ?> )	
									<?php }elseif($row -> type == 'fast'){ ?>
										<strong>( Mua nhanh)<strong>
										<?php } ?>
								</td>
								<td><?php echo $row -> sender_name; ?></td>
								<td><?php echo $row -> sender_telephone; ?></td>
								
								<!-- <td><?php// echo @$order_detail -> product_name.' ('.@$order_detail -> product_id.')'; ?></td> -->
								
								

								<!-- <td> -->
								<?php 
								// if(@$order_detail-> string_info_extent != "") {
								// 	echo 'Chọn thêm: '.$order_detail-> string_info_extent;
								// }

								// if(@$order_detail-> extend_price != "") {
								// 	$extend_price = explode(',',$order_detail-> extend_price);
								// 	foreach ($extend_price as $extend_price_it) {
								// 		$price_extend = $model-> price_extend($extend_price_it);
								// 		if($price_extend) {
								// 			echo '<div>'.$price_extend-> ground_extend_name.':'.$price_extend->extend_name.'</div>';
								// 			echo '<span class="red">('.format_money($price_extend->price).')</span>';
								// 		}

								// 	# code...
								// 	}
								// }

								// if (@$order_detail->memory_id){
								// 	echo '<div>Bộ nhớ:'.$order_detail->memory_name.'</div>';
								// 	echo '<span class="red">('.format_money($order_detail->memory_price).')</span>';
								// }
								// if (@$order_detail->color_id){
								// 	// echo "<br>";
								// 	echo '<div>Màu '.$order_detail->color_name.'</div>';
								// 	echo '<span class="">'.format_money($order_detail->color_price).'</span>';
								// }
								// if (@$order_detail->warranty_id){
								// 	echo '<div>Bảo hành : '.$order_detail->warranty_name.'</div>';
								// 	echo '<span class="red">('.format_money($order_detail->warranty_price).')</span>';
								// }
								// if (@$order_detail->origin_id){
								// 	echo '<div>Xuất xứ : '.$order_detail->origin_name.'</div>';
								// 	echo '<span class="red">('.format_money($order_detail->origin_price).')</span>';
								// }
								// if (@$order_detail->species_id){
								// 	echo '<div>RAM : '.$order_detail->species_name.'</div>';
								// 	echo '<span class="red">('.format_money($order_detail->species_price).')</span>';
								// }
								// else {
								// 	// echo "Không có!";
								// }
								?>
								
							<!-- </td> -->
							<td><strong class ="red"><?php echo format_money($row -> total_after_discount); ?></strong><strong></strong>
							</td>
							<td><?php echo $row -> created_time; ?>

						</td>
						<td><?php echo $this -> showStatus($row -> status); ?>
					</td>
					<td> <?php echo TemplateHelper::edit($link_view); ?></td>
				</tr>
				<?php $i++; ?>
			<?php }?>
		<?php }?>
		<tr>
			<td colspan="5" align="right">
				<strong> Tổng trang hiện tại:</strong>
			</td>
			<td colspan="5" align="left">
				<strong class='red'><?php echo format_money($total); ?></strong> 
			</td>
		</tr>
		<tr>
			<td colspan="5" align="right">
				<strong> Tổng sản phẩm tất cả các trang: <span class='red'><?php echo $total_all_id ?></span> </strong>
			</td>
			<td colspan="5" align="left">
				<strong class='red'><?php echo format_money($total_all); ?></strong> 
			</td>
		</tr>
	</tbody>
</table>
</div>
<div class="footer_form">
	<?php if(@$pagination) {?>
		<?php echo $pagination->showPagination();?>
	<?php } ?>
</div>

<input type="hidden" value="<?php echo @$sort_field; ?>" name="sort_field">
<input type="hidden" value="<?php echo @$sort_direct; ?>" name="sort_direct">
<input type="hidden" value="<?php echo $this -> module;?>" name="module">
<input type="hidden" value="<?php echo $this -> view;?>" name="view">
<input type="hidden" value="" name="task">
<input type="hidden" value="0" name="boxchecked">
</form>
</div>
<script>
	$(function() {
		$( "#text0" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy'});
		$( "#text1" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy'});
	});
</script>
<style>
.filter_area input[type="text"] {
	width: 100px;
	display: inline-block;
	margin-left: 10px;
	/* max-width: 100%; */
	/* width: auto; */
	padding: 6px 12px;
	font-size: 14px;
	line-height: 1.42857143;
	color: #555;
	background-color: #fff;
	background-image: none;
	border: 1px solid #ccc;
	border-radius: 4px;
	-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
	box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
	-webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
	-o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
	transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;

}
.filter_area button {
	color: #fff;
	background-color: #337ab7;
	border-color: #2e6da4;
	display: inline-block;
	padding: 6px 12px;
	margin-bottom: 0;
	font-size: 14px;
	font-weight: 400;
	line-height: 1.42857143;
	text-align: center;
	white-space: nowrap;
	vertical-align: middle;
	-ms-touch-action: manipulation;
	touch-action: manipulation;
	cursor: pointer;
	-webkit-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	user-select: none;
	background-image: none;
	border: 1px solid transparent;
	border-radius: 4px;
}
.filter_area select {
	display: inline;
	max-width: 100%;
	width: auto;
	padding: 6px 12px;
	font-size: 14px;
	line-height: 1.42857143;
	color: #555;
	background-color: #fff;
	background-image: none;
	border: 1px solid #ccc;
	border-radius: 4px;
	-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
	box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
	-webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
	-o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
	transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
}

</style>