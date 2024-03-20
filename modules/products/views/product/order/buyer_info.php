<!--	INFOR sender and recipient			-->
<fieldset>
	<legend><b><span>Thông tin giao nhận sản phẩm</span></b></legend>
	<p><small>Vui lòng cung cấp chính xác số điện thoại và địa chỉ để Siêu thị Giá Sốc dùng để liên lạc khi giao sản phẩm cho Quý khách</small></p>
	<div class='shopping_buyer_saller'>
		<!--	CONTENT IN FRAME	-->
			<div class="info-customer-gh">
				<table width="100%" border="0" cellpadding="10">
					  <tr>
						<td width="30%" align="right"><span>Người nhận</span></td>
						<td ><input type="text" name="sender_name" id="sender_name"  value="" class="input_text" size="30"/></td>
					  </tr>
					  <tr>
					    <td align="right"><span>Số điện thoại</span></td>
						<td><input type="text" name="sender_telephone" id="sender_telephone"  value="" class="input_text" size="30"/></td>
					  </tr>
					  <tr>
						<td align="right"><span>Email</span></td>
						<td><input type="text" name="sender_email"  id="sender_email"  value="" class="input_text" size="30"/></td>
					  </tr>
					  <tr>
						<td align="right"><span>Địa chỉ</span></td>
						<td><input type="text" name="sender_address" id="sender_address"  value="" class="input_text" size="30" /></td>
					  </tr>
					  <tr>
					  	<td colspan="2">
					  		<b><span>Thêm thông tin</span></b>
					  		<p><small>Vui  lòng ghi thêm các thông tin yêu cầu về màu sắc, size hoặc thời gian giao hàng... vào phần Ghi chú để giúp cho Siêu thị Giá Sốc có đầy đủ thông tin chính xác để giao sản phẩm nhanh chóng tới tận tay quý khách hàng.</small></p>
					  	</td>
					  </tr>	
					  <tr>
					  	<td align="right"><span>Ghi chú</span></td>
						<td>
							  <textarea name="sender_comments" id="sender_comments" cols="52" rows="3"><?php echo @$session_order-> sender_comments; ?></textarea>
						</td>
					  </tr>
					  <tr>
					  	<td colspan="2" align="center">
					  		<a class="button-step" href="javascript:void(0);" onclick="javascript:submitForm();" title=""> Gửi đơn hàng  &#9658; </a>
					  	</td>
					  </tr>	
				</table>
			</div>
			<input type="hidden" name='module' value="products" />
			<input type="hidden" name='view' value="product" />
			<input type="hidden" name='quantity' value="" id='quantity'/>
			<input type="hidden" name='task' value="eshopcart2_simple_save" id = 'task'/>
		<!--	end CONTENT IN FRAME	-->
					
				</div>
</fieldset>				
	<!--	end INFOR sender and recipient		-->
