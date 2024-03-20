	<!--	CONTENT IN FRAME	-->
	<br/>
	<fieldset>
		<legend>Ph&#432;&#417;ng th&#7913;c thanh to&#225;n</legend>
	
	<table class="tabl-remo-formalism" border="0" cellspacing="0" cellpadding="5" width="100%">
	
		<tr class="row-reno-formalism">
			<td width="10" align="right" valign="top">
				<?php $checked = isset($session_order-> payment_method)?$session_order-> payment_method:0?>
				<input type="radio" name="payment_method" <?php echo (!$checked)?"checked='checked'":""; ?>  value='0'/>
			</td>
			<td width="110" align="left">
				Thanh toán <strong>trực tiếp</strong> khi nhận hàng
			</td>
	  	</tr>
		<tr class="row-reno-formalism">
			<td align="right" valign="top">
				<input type="radio" name="payment_method" <?php echo ($checked == 1)?"checked='checked'":""; ?>  value='1'/>
			</td>
			<td align="left">
				Thanh toán trực tuyến bằng tài khoản ngân hàng thông qua <strong>OnePay nội địa</strong>
			</td>
	  	</tr>
		<!--
		<tr class="row-reno-formalism">
			<td align="right" valign="top">
				<input type="radio" name="payment_method" < ?php  echo ($checked == 2 )?"checked='checked'":""; ?>  value='2'/>
			</td>
			<td align="left">
				Thanh toán trực tuyến bằng tài khoản ngân hàng thông qua <strong>OnePay Quốc tế</strong>
			</td>
	  	</tr>
		-->
	</table>
	<!--	end CONTENT IN FRAME	-->
	</fieldset>
