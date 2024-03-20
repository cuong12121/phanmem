<!-- BODY-->
<div class="form_body">
<?php include_once 'detail_status.php';?>
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
			<th width="117"><?php echo "Giá(VNĐ)"; ?></th>
			<th width="117"><?php echo "Số lượng"; ?></th>
			<th width="117"><?php echo "Tổng giá tiền"; ?></th>
		</tr>
	</thead>
	<tbody>
											<?php 
											$total_money = 0;
											$total_discount = 0;
											for($i = 0 ; $i < count($data); $i ++ ){?>
											<?php
												 $item = $data[$i];
												 $link_view_product = FSRoute::_('index.php?module=products&view=product&code='.$item -> product_alias.'&ccode='.$item -> category_alias.'&Itemid=6');
												 $total_money += $item -> total;
												 $total_discount += $item -> discount * $item -> count;
											?>
												<tr class='row<?php echo ($i%2); ?>'>
			<td align="center"><strong><?php echo ($i+1); ?></strong><br />
			</td>

			<td><a href="<?php echo $link_view_product; ?>" target="_blank">
															<?php echo $item -> product_name; ?>
														</a></td>

			<!--		PRICE 	-->
			<td><strong>
															<?php echo format_money($item -> price);  ?>
														</strong> VND</td>
			<td><input type="text" size="20" disabled="disabled"
				value="<?php echo $item->count; ?>" /></td>
			<td><span class='red'>
															<?php echo format_money($item -> total);  ?> VN&#272;
														</span></td>
		</tr>
											<?php } ?>
												<tr>
			<td colspan="4" align="right"><strong>T&#7893;ng ti&#7873;n:</strong></td>
			<td><strong class='red'><?php echo format_money($total_money); ?> VN&#272;</strong>
			</td>
		</tr>
											 <?php if($order -> payment_method){?>
											 <tr>
			<td colspan="4" align="right">
			<p class="text-left">Giảm giá ( khi mua qua address):</p>
			</td>
			<td class="total-price"><?php echo format_money($order -> total_before_discount - $order ->total_after_discount);?> VN&#272;</td>
		</tr>
		<tr>
			<td colspan="4" align="right">
			<p class="text-left">Tiền phải trả:</p>
			</td>
			<td class="total-price"><?php echo format_money($order ->total_after_discount);?> VN&#272;</td>
		</tr>
											  <?php }?>	
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
		<?php include_once 'detail_recipient.php';?>
	<!--  end RECIPIENT INFO --> <br />
<!--  CHANGE STATUS -->
		<?php include_once 'detail_status.php';?>
	<!--  end CHANGE STATUS --></div>
<!-- END BODY-->
