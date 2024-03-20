<div class="form_user_head_c">
					<span class='bold red'>Th&#244;ng tin ng&#432;&#7901;i nh&#7853;n h&#224;ng</span>
				</div>				
	<div class="form_user_footer_body">
		<!-- TABLE 							-->
		<!--	RECIPIENCE INFO				-->
		<table cellspacing="0" cellpadding="6" border="0" width="100%" class="tabl-info-customer">
			<tbody> 
			  <tr>
				<td width="173px"><b>T&#234;n ng&#432;&#7901;i nh&#7853;n h&#224;ng </b></td>
				<td width="5px">:</td>
				<td><?php echo @$order-> recipients_name; ?></td>
			  </tr>
			  <tr>
				<td><b>&#272;&#7883;a ch&#7881;  </b></td>
				<td width="5px">:</td>
				<td><?php echo @$order-> recipients_address; ?></td>
			  </tr>
			  <tr>
				<td><b>Email </b></td>
				<td width="5px">:</td>
				<td><?php echo @$order-> recipients_email; ?></td>
			  </tr>
			  <tr>
				<td><b>&#272;i&#7879;n tho&#7841;i </b></td>
				<td width="5px">:</td>
				<td><?php echo @$order-> recipients_telephone; ?></td>
			  </tr>
			  <tr>
				<td><b>Gi&#7899;i t&#237;nh </b></td>
				<td width="5px">:</td>
				<td><?php echo (@$order->recipients_sex == 'female')? "N&#7919;":"Nam"; ?>
				</td>
			  </tr>
			  <tr>
				<td width="173px"><b>Thời gian nhận</b></td>
				<td width="5px">:</td>
				<td><?php echo @$order-> received_time; ?></td>
			  </tr>
			  <tr><!--
			  <tr>
				<td width="173px"><b>Địa điểm nhận hàng</b></td>
				<td width="5px">:</td>
				<td><?php if(@$order-> here ='1'){
					echo "Nhận tại nhà hàng";
				}else{
					echo "Nhận tại địa chỉ người nhận";
				} ?></td>
			  </tr>
			  <tr>
				<td width="173px"><b>Phương thức mua hàng: </b></td>
				<td width="5px">:</td>
				<td><?php if(@$order-> pay_method ='0'){
					echo "Thanh toán trực tiếp";
				}else{
					echo "Thanh toán thông qua address";
				} ?></td>
			  </tr>
			 --></tbody>
		</table>
		<!-- ENd TABLE 							-->
			
	</div>
