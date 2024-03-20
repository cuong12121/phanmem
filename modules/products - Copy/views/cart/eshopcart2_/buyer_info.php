<?php 
$day = @$session_order->received_time? date('d',strtotime(@$session_order->received_time)):date('d');
$month = @$session_order->received_time?date('m',strtotime(@$session_order->received_time)):date('m');
$year = @$session_order->received_time? date('Y',strtotime(@$session_order->received_time)): date('Y');
if(@$session_order->received_time)
	$hour = date('h',strtotime(@$session_order->received_time));
else 
	$hour = 0;
?>
<!--	INFOR sender and recipient			-->
	<h2><span>Th&#244;ng tin đặt h&#224;ng</span></h2>
	<div class='shopping_buyer_saller'>
			
					<!--	CONTENT IN FRAME	-->
						<div id = "msg_error"></div>
							<!--	INFO OF SENDER			-->
								
								<table  class="info-customer-gh" width="100%" border="0" cellpadding="5">
								  <tr>
									<td width="140" class="td-left"> Họ tên<font color="#FF0000"> (*)</font>: </td>
									<td ><input type="text" name="sender_name" id="sender_name"  value="<?php echo $sender_name; ?>" class="input_text" size="30"/></td>
								  </tr>
								  <tr>
									<td class="td-left">&#272;i&#7879;n tho&#7841;i: <font color="#FF0000"> (*)</font></td>
									<td><input type="text" name="sender_telephone" id="sender_telephone"  value="<?php echo $sender_telephone; ?>" class="input_text" size="30"/></td>
								  </tr>
								  <tr>
									<td class="td-left">&#272;&#7883;a ch&#7881;<font color="#FF0000"> (*)</font>: </td>
									<td><input type="text" name="sender_address" id="sender_address"  value="<?php echo $sender_address; ?>" class="input_text" size="30" /></td>
								  </tr>
								  
								  <tr>
									<td class="td-left"> Email <font color="#FF0000"> (*)</font>: </td>
									<td><input type="text" name="sender_email"  id="sender_email"  value="<?php echo $sender_email; ?>" class="input_text" size="30"/></td>
								  </tr>
								  
								  <tr>
									<td class="td-left">Chú thích đơn hàng: </td>
									<td>
										  <textarea name="sender_comments" id="sender_comments"  ><?php echo @$session_order-> sender_comments; ?></textarea>
									</td>
								  </tr>
								  <tr>
									<td class="td-left"><span>&nbsp;</span></td>
									<td>
										 Nh&#7919;ng c&#243; d&#7845;u (<font color="#FF0000"> * </font>) l&#224; b&#7855;t bu&#7897;c ph&#7843;i nh&#7853;p
									</td>
								  </tr>
								  <tr>
									<td class="td-left"><span>&nbsp;</span></td>
									<td class="test-info-next">
										<a class="button-step button-cart" href="javascript:void(0);" onclick="javascript:submitForm();" title=""> Gửi đơn hàng  &#9658; </a>
									</td>
								  </tr>
								</table>
						
						<input type="hidden" name='module' value="products" />
						<input type="hidden" name='view' value="cart" />
						<input type="hidden" name='task' value="eshopcart2_simple_save" id = 'task'/>
					<!--	end CONTENT IN FRAME	-->
					
				</div>
	<!--	end INFOR sender and recipient		-->
