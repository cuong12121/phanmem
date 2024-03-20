<div class="form_user_head_c">
					<span class='bold red'>Tr&#7841;ng th&#225;i &#273;&#417;n h&#224;ng</span>
				</div>				
	<div class="form_user_footer_body">
		<!-- TABLE 							-->
		<!--	RECIPIENCE INFO				-->
		<table cellspacing="0" cellpadding="6" border="0" width="100%" class="tabl-info-customer">
			<tbody> 
			  <tr>
				<td width="173px"><b>Trạng thái đơn hàng</b></td>
				<td>
					<strong class = "red"><?php echo $this -> showStatus($order->status )?></strong>
				</td>
			  </tr>
			  <?php if(!$order->status  ){?>
				<tr>
					<td>Hủy đơn hàng: </td>
					<td>
						Bạn hãy click vào <a href="javascript: cancel_order(<?php echo $order ->id; ?>)" ><strong class='red'> đây</strong></a> nếu bạn muốn <strong> hủy đơn hàng </strong>này
						<br/>
<!--						Chú ý: nếu bạn hủy đơn hàng mà khách hàng đã thanh toán thì hệ thống sẽ trả lại tiền cho họ-->
					</td>
			  </tr>			  	
			  <?php }?>
			 <?php if($order->status < 1 || !$order->status  ){?>
			 	<tr>
					<td>Hoàn tất đơn hàng: </td>
					<td>
						Bạn hãy click vào <a href="javascript: finished_order(<?php echo $order ->id; ?>)" ><strong class='red'> đây</strong></a> để <strong> hoàn tất</strong> đơn hàng này
						<br/>
<!--						Chú ý: nếu bạn hoàn tất đơn hàng mà khách hàng đã thanh toán thì hệ thống sẽ trả lại tiền cho gian hàng-->
					</td>
			  </tr>
			 <?php }?>
			 </tbody>
		</table>
		<!-- ENd TABLE 							-->
			
	</div>
<script>
	function cancel_order(order_id){
		if(confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')){
			window.location='index.php?module=order&view=order&id='+order_id+'&task=cancel_order';
		}
	}
	function finished_order(order_id){
		if(confirm('Bạn có chắc chắn muốn hoàn tất đơn hàng này?')){
			window.location='index.php?module=order&view=order&id='+order_id+'&task=finished_order';
		}
	}
	function pay_penalty(order_id){
		if(confirm('Bạn có chắc chắn đã phạt thành viên này?')){
			window.location='index.php?module=order&view=order&id='+order_id+'&task=pay_penalty';
		}
	}
	function pay_compensation(order_id){
		if(confirm('Bạn có chắc chắn đã bồi thường cho thành viên này?')){
			window.location='index.php?module=order&view=order&id='+order_id+'&task=pay_compensation';
		}
	}
	
</script>