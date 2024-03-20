<div class="buyer_info">
	<form action="#" name="eshopcart_info" method="post" id="eshopcart_info" >
		<input  placeholder="Họ tên (*)" type="text" name="sender_name" id="name_user" value="<?php echo !empty($data_user) ? $data_user->full_name : '' ?>" class="input_text" size="30">
		<input placeholder="Điện thoại (*)" type="text" name="sender_telephone" id="telephone_user" value="<?php echo !empty($data_user) ? $data_user->telephone : '' ?>" class="input_text" size="30">
		<input placeholder="Email" type="text" name="sender_email" id="sender_email" value="<?php echo !empty($data_user) ? $data_user->email : '' ?>" class="input_text" size="30">
		<input placeholder="Địa chỉ (*)" type="text" name="sender_address" id="address_user" value="<?php echo !empty($data_user) ? $data_user->address : '' ?>" class="input_text" size="30">
		<textarea placeholder="Ghi chú" name="sender_comments" id="sender_comments"></textarea>
		
		
		<div class="purchase-provisions">
			<div class="title">
				Hướng Dẫn và Quy định Mua hàng Online
			</div>
			<div class="content">
				<?php echo $config['note-payment'] ?>
			</div>
			<div class="checkbox">
				<input required="" id="checkboxid" name="igone" value="0" type="checkbox">
				<span>Tôi đã đọc kỹ và hoàn toàn đồng ý với quy định mua hàng ở trên</span>
			</div>
		</div>

		<a class="button-submit" href="javascript:void(0);" onclick="javascript:submitForm();" title=""> <?php echo FSText::_('Thanh toán'); ?> </a>
		

					
						
		<input type="hidden" name='module' value="products" />
		<input type="hidden" name='view' value="cart" />
		<!-- <input type="hidden" name="price_send" id="price_send" value=" '.$check_code-> money_dow.'"> -->
		<input type="hidden" name='price_send_h' id="price_send_h" value="0" />
		<input type="hidden" name='code_card_send_h' id="code_card_send_h" value="0" />
		<input type="hidden" name='type_down_h' id="type_down_h" value="0" />
		<input type="hidden" name='task' value="" id = 'task_buyer_form' />
		<input type="hidden" name='is_vnpay' value="0" id = 'is_vnpay' />
		<input type="hidden" name='bank_code' value="0" id = 'bank_code_ip' />
	</form>
</div>
