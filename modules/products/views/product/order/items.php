<!--	Product list and price			-->
<div class='shopcart_product'>
	<table width="100%" border="0" class="table-product-pack" cellpadding="10">
		<thead>
			<tr class="head-tr">
				<td width="40%"><b><span>Sản phẩm</span></b></td>
				<td ><b><span>Số lượng</span></b></td>
				<td >&nbsp;</td>
				<td ><b><span>Đơn giá/ VNĐ</span></b></td>
				<td >&nbsp;</td>
				<td ><b><span>Thành tiền/ VNĐ</span></b></td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="name-product"><span><?php  echo $data -> name;?></span></td>
				<td>
					<input class="numbers-pro" id="numbers-pro" type="text"  value="1" size="4"  onkeypress="return isNumberKey(event)" />
				</td>
				<td>x</td>
				<td class="price-product" >
				<?php if($data -> discount && $data -> price_old && isset($data ->date_end) && $data ->date_end !='' && $data->date_end >  date('Y-m-d H:i:s')  && isset($data ->date_start) && $data ->date_start !='' && $data->date_start <  date('Y-m-d H:i:s')  &&  isset($data ->quantity) && ($data ->quantity) > 0  && $data ->quantity != ''){?>
					<span><?php  echo format_money($data->price); ?></span>
					<input  id="price-product" type="hidden"  value="<?php echo $data->price;?>" />
				<?php }else{?>
					<span><?php  echo format_money($data->price_old); ?></span>
					<input  id="price-product" type="hidden"  value="<?php echo $data->price_old;?>" />
				<?php }?>
				</td>
				
				<td>=</td>
				<td class="total-price" id='total-price' ></td>
			</tr>
 			<tr>
				<td colspan="5" align="left"><b><span>Tổng tiền</span></b></td>
				<td class="total-price-end" id="total-price-end"></td>
			</tr>
		</tbody>
	</table>
</div>
