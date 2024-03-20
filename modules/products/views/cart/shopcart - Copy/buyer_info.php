<?php 
$day = @$session_order->received_time? date('d',strtotime(@$session_order->received_time)):date('d');
$month = @$session_order->received_time?date('m',strtotime(@$session_order->received_time)):date('m');
$year = @$session_order->received_time? date('Y',strtotime(@$session_order->received_time)): date('Y');
if(@$session_order->received_time)
	$hour = date('h',strtotime(@$session_order->received_time));
else 
	$hour = 0;

?>
<?php $disable_card = 0; ?>
<?php if(isset($_COOKIE['user_id']) && $card_code) $disable_card = 1; ?>
<!--	INFOR sender and recipient			-->

<div class="form_label"> <?php echo FSText::_('Thông tin đặt hàng'); ?></div>
<?php if($disable_card){ ?>
	<div class="form_desc"> <?php echo FSText::_('Nhập mã thẻ để tính lại chiết khấu (nếu có)'); ?></div>
<?php } ?>
<!-- <?php if(!isset($_COOKIE['user_id'])){ ?>
	<div class="form_desc">Hãy <a href='<?php echo FSRoute::_('index.php?module=users&view=users&task=register&Itemid=12'); ?>' class="red" title="Đăng ký thành viên"><?php echo FSText::_('ĐẮNG KÝ thành viên'); ?></a> để được hưởng nhiều ưu đãi hơn</div>
	<?php } ?> -->
	<div class='shopping_buyer_saller'>
		
		<!--	CONTENT IN FRAME	-->
		<div id = "msg_error"></div>
		<!--	INFO OF SENDER			-->
		<div class="info-customer-gh">
			<div class="tr">
				<div class="td_label">
					<?php echo FSText::_('Mã giảm giá ( nếu có)'); ?>:
				</div>
				<div class="td_value">
					<input type="text" name="card_code" id="card_code"  value="<?php echo $card_code; ?>" class="input_text" size="30" <?php echo $disable_card?'disabled="disabled"':''; ?> />
					<?php if(!$disable_card){ ?>
						<button type="button" onclick="myFunction_77();" class="resubmit_form"><i class="fa fa-refresh"></i><?php echo FSText::_('Tính lại chiết khấu'); ?></button>
					<?php } ?>
				</div>
			</div>	
			<div class="tr">
				<div class="td_label">
					<?php echo FSText::_('Họ tên'); ?><font color="#FF0000"> (*)</font>:
				</div>
				<div class="td_value">					
					<input type="text" name="sender_name" id="sender_name"  value="<?php echo !empty($data_user) ? $data_user->full_name : '' ?>" class="input_text" size="30"/>
				</div>
			</div>	
			<div class="tr">
				<div class="td_label">
					<?php echo FSText::_('Điện thoại'); ?> <font color="#FF0000"> (*)</font>:
				</div>
				<div class="td_value">					
					<input type="text" name="sender_telephone" id="sender_telephone"  value="<?php echo !empty($data_user) ? $data_user->telephone : '' ?>" class="input_text" size="30"/>
				</div>
			</div>	
			<div class="tr">
				<div class="td_label">
					<?php echo FSText::_('Địa chỉ'); ?>:
				</div>
				<div class="td_value">					
					<input type="text" name="sender_address" id="sender_address"  value="<?php echo !empty($data_user) ? $data_user->address : '' ?>" class="input_text" size="30" />
				</div>
			</div>	
			<div class="tr">
				<div class="td_label">
					Email :
				</div>
				<div class="td_value">					
					<input type="text" name="sender_email"  id="sender_email"  value="<?php echo !empty($data_user) ? $data_user->email : '' ?>" class="input_text" size="30"/>
				</div>
			</div>	
			<div class="tr">
				<div class="td_label">
					<?php echo FSText::_('Chú thích đơn hàng'); ?>:
				</div>
				<div class="td_value">					
					<textarea name="sender_comments" id="sender_comments"  ><?php echo @$session_order-> sender_comments; ?></textarea>
				</div>
			</div>	
			<div class="tr">
				<div class="td_label">
					&nbsp;
				</div>
				<div class="td_value">					
					<?php echo FSText::_('Những trường có dấu'); ?> (<font color="#FF0000"> * </font>) <?php echo FSText::_('là bắt buộc phải nhập'); ?>
				</div>
			</div>	
			<div class="tr">
				<div class="td_label">
					&nbsp;
				</div>
				<div class="td_value">					
					<a class="button-step button-cart" href="javascript:void(0);" onclick="javascript:submitForm();" title=""> <?php echo FSText::_('Gửi đơn hàng'); ?>  &#9658; </a>
				</div>
			</div>	
		</div>

		<input type="hidden" name='module' value="products" />
		<input type="hidden" name='view' value="cart" />
		<!-- <input type="hidden" name="price_send" id="price_send" value=" '.$check_code-> money_dow.'"> -->
		<input type="hidden" name='price_send_h' id="price_send_h" value="0" />
		<input type="hidden" name='code_card_send_h' id="code_card_send_h" value="0" />
		<input type="hidden" name='type_down_h' id="type_down_h" value="0" />
		<input type="hidden" name='task' value="" id = 'task_buyer_form' />
		<!--	end CONTENT IN FRAME	-->

	</div>
	<!--	end INFOR sender and recipient		-->


	<!--	end INFOR sender and recipient		-->
	<script type="text/javascript">
		function myFunction_77() {
		$('.label_error').prev().remove();
		$('.label_error').remove();
		// if(!notEmpty("card_code","Bạn phải nhập mã giảm giá"))
		// 	return false;
		var code_share = <?php echo json_encode(@$sale->code); ?>;
		var type_coupon = <?php echo json_encode(@$sale->type_sale); ?>;
		var money_dow = <?php echo json_encode(@$sale->money_dow); ?>;
		var code_input = $('#card_code').val();
		var total_noshipping = $('#price_total').val();
		var input_code_share  = $('#card_code').val();
		var num_dow=$('#price_send').val();
		$.ajax({
			type: "POST",
			url: "/index.php?module=products&view=cart&task=check_code&raw=1&code_input="+code_input+"&total_noshipping="+total_noshipping,
			data: {code_input:code_input,total_noshipping:total_noshipping},
			dataType: 'json',
			success: function(data) {
				if(data.error == false){
					$('#total-price').html(data.html);
					$('#price_send_h').val(data.price_send);
					$('#code_card_send_h').val(data.code_card_send);
					$('#type_down_h').val(data.type_down);
				} else {
					alert('Mã không tồn tại.');
				}
			}
		});

</script>
