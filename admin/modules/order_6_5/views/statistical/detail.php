	
<!-- HEAD -->
<?php
$title = @$order ? FSText :: _('Xem đơn hàng ').'DH'.str_pad($order -> id, 8 , "0", STR_PAD_LEFT): FSText :: _('Add'); 
global 
$toolbar;
$toolbar->setTitle($title);
//	$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
// $toolbar->addButton('',FSText :: _('Print'),'','print.png',0,1); 
$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   
?>
<!-- END HEAD-->

<!-- BODY-->
<div class="form_body">
	<div> Mã đơn hàng: <strong><?php echo 'DH'.str_pad($order -> id, 8 , "0", STR_PAD_LEFT); ?></strong></div>

<!-- 	<?php if($order -> coderesult == 100) { ?>
		<div>Đã gửi sms cho khách hàng đến SĐT: <?php echo $order-> sender_telephone;  ?> (SMSID: <?php echo $order-> smsid; ?>)</div>
	<?php } else {?>
		<div>Gửi tin nhắn lỗi: <?php echo $order-> errormessage; ?></div>
		<?php } ?> -->
		<?php if($order ->is_instalment ){ ?>
			<h3>Mua trả góp: </h3>
			<div> Trả trước: <strong><?php echo $order -> instalment_percent_before.'%'; ?></strong></div>
			<div> Thời gian vay: <strong><?php echo $order -> instalment_months.' tháng'; ?></strong></div>
			<?php $arr_certificates = array(1=>'CMND + Hộ Khẩu',2=>'CMND + Bằng lái xe',3=>'Giấy tờ chứng minh thu nhập',4=>'Sinh viên',5=>'Công chức - Giáo viên'); ?>
			<div> Xác thực: <strong><?php echo @$arr_certificates[$order -> instalment_certificate]; ?></strong></div>


			<div> Trả trước: <strong><?php echo format_money($order -> instalment_money_before,'','0'); ?></strong></div>
			<div> Trả hàng tháng: <strong><?php echo format_money($order -> instalment_money_per_month,'','0').'/tháng'; ?></strong></div>
			<div> Tổng phải trả: <strong><?php echo format_money($order -> instalment_money_total,'','0').''; ?></strong></div>
		<?php } ?>
		<br/>
		<?php $print = FSInput::get('print',0,'int');?>
		<?php if(!$print){?>
			<?php include_once 'detail_status.php';?>
		<?php }?>
		<br />
		<form
		action="index.php?module=<?php echo $this -> module;?>&view=<?php echo $this -> view;?>"
		name="adminForm" method="post" enctype="multipart/form-data">
		<table cellpadding="6" cellspacing="0" border="1" bordercolor="#CECECE"
		width='100%'>
		<thead>
			<tr>
				<th width="30">STT</th>
				<th>Tên sản phẩm</th>
				<th width="160"><?php echo "Giá(VNĐ)"; ?></th>

				<th width="50"><?php echo "Số lượng"; ?></th>
				<th width="220"><?php echo "Thêm"; ?></th>
				<th width="180"><?php echo "Tổng giá tiền"; ?></th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$total_money = 0;
			$total_discount = 0;
			for($i = 0 ; $i < count($data); $i ++ ){?>
				<?php
				$item = $data[$i];
				$link_view_product = FSRoute::_('index.php?module=products&view=product&id='.$item->product_id.'&code='.$item -> product_alias.'&ccode='.$item -> category_alias.'&Itemid=6');
				$total_money += $item -> total;
				$total_discount += $item -> discount * $item -> count;
				?>
				<tr class='row<?php echo ($i%2); ?>'>
					<td align="center"><strong><?php echo ($i+1); ?></strong></td>

					<td>
						<a href="<?php echo $link_view_product; ?>" target="_blank"><?php echo $item -> product_name; ?></a>
					</td>

					<!--		PRICE 	-->
					<td>
						<strong><?php echo format_money($item -> price);  ?></strong>
					</td>
					<td>
						<input type="text" disabled="disabled"value="<?php echo $item->count; ?>" />
					</td>
					<td align="center">
						<?php 
						if(@$item-> string_info_extent != "") {
							echo 'Chọn thêm: '.$item-> string_info_extent;
						}
						?> 
					</td>
					<td>
						<span class='red'><?php echo format_money($item -> total);  ?> </span>
					</td>
				</tr>


				<?php if(!empty($item -> list_gift_name)){ 
					$list_gift_name = substr($item -> list_gift_name, 0, -1);
					
					$list_gift_name = explode(',',$list_gift_name);
					
					foreach ($list_gift_name as $list_gift_it) {
					
				?>

					<tr class='row<?php echo ($i%2); ?>'>
						
						<td align="center"><strong></strong></td>

						<td>
							<a href="#"><?php echo $list_gift_it; ?></a>
						</td>

						<!--		PRICE 	-->
						<td>
							<strong>0đ (Quà tặng)</strong>
						</td>
						<td>
							<input type="text" disabled="disabled"value="<?php echo $item->count; ?>" />
						</td>
						<td align="center">
							
						</td>
						<td>
							<span class='red'>0đ (Quà tặng)</span>
						</td>
					</tr>
				<?php }} ?>



			<?php } ?>
			<tr>
				<td colspan="5" align="right"><strong>T&#7893;ng ti&#7873;n:</strong></td>
				<td>
					<strong class='red'><?php echo format_money($total_money); ?> </strong>
				</td>
			</tr>
			<!-- <tr>
				<td colspan="5" align="right"><strong>Dùng điểm: </strong></td>
				<td>
					<strong class='red'><?php// echo $order-> user_point.' điểm'; ?> </strong>
				</td>
			</tr> -->
			<?php if($order-> code_sale) { ?>
				<tr>
					<td colspan="5" align="right"><strong>Khuyến mãi:</strong></td>
					<?php if($order-> value_sale == 1) { ?>
						<td>
							<strong class='red'><?php echo $order-> money_dow; ?> % (<span style="color: blue;"><?php echo $order-> code_sale;  ?></span>)</strong>
						</td>
					<?php } else { ?>
						<td>
							<strong class='red'><?php echo format_money($order-> money_dow); ?>(<span style="color: blue;"><?php echo $order-> code_sale;  ?></span>)</strong>
						</td>
					<?php } ?>
				</tr>
				<tr>
					<td colspan="5" align="right"><strong>Thanh toán:</strong></td>
					<td>
						<strong class='red'><?php echo format_money($order-> total_after_discount - $order-> user_point * 1000); ?> </strong>
					</td>
				</tr>
			<?php } else { ?>

				<tr>
					<td colspan="5" align="right"><strong>Thanh toán:</strong></td>
					<td>
						<strong class='red'><?php echo format_money($total_money - $order-> user_point * 1000); ?> </strong>
					</td>
				</tr>

			<?php } ?>
		</tbody>
	</table>
	<?php if(@$data->id) { ?>
		<input type="hidden" value="<?php echo $data->id; ?>" name="id">
	<?php }?>
	<input type="hidden" value="<?php echo $this -> module;?>"
	name="module"> <input type="hidden" value="<?php echo $this -> view;?>"
	name="view"> <input type="hidden" value="" name="task"> <input
	type="hidden" value="0" name="boxchecked"></form>
	<!-- end FORM	MAIN - ORDER						--> <!--  ESTORE INFO -->
	<?php // include_once 'detail_estore.php';?>
	<!--  end ESTORE INFO --> <br />
	<!--  SENDER INFO -->
	<?php include_once 'detail_buyer.php';?>
	<!--  end SENDER INFO --> <br />
	<!--  RECIPIENT INFO -->
	<?php //include_once 'detail_recipient.php';?>
	<!--  end RECIPIENT INFO --> <br />
	<?php // include_once 'detail_payment.php';?>
	<br />
	<br />
</div>
<!-- END BODY-->

<script  type="text/javascript" language="javascript">
	print_page();
	function print_page(){
		var width = 800;
		var centerWidth = (window.screen.width - width) / 2;
//	    var centerHeight = (window.screen.height - windowHeight) / 2;
$('.Print').click(function(){
	link = window.location.href;
	link += '&print=1';
	window.open(link, "","width="+width+",menubar=0,resizable=1,scrollbars=1,statusbar=0,titlebar=0,toolbar=0',left="+ centerWidth + ",top=0");
});
}
</script>
