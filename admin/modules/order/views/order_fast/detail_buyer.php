	<div class="form_user_head_c">
					<span class='bold red'>Th&#244;ng tin ng&#432;&#7901;i &#273;&#7863;t h&#224;ng</span>
	</div>				
	<div class="form_user_footer_body">
		<!-- TABLE 							-->
		<table cellspacing="0" cellpadding="6" border="0" width="100%" class="tabl-info-customer">
			<tbody> 
			  <tr>
				<td width="173px"><b>T&#234;n ng&#432;&#7901;i &#273;&#7863;t h&#224;ng </b></td>
				<td width="5px">:</td>
				<td><?php echo $order-> sender_name; ?></td>
			  </tr>
			  <tr>
				<td><b>Gi&#7899;i t&#237;nh </b></td>
				<td width="5px">:</td>
				<td><?php echo ($order->sender_sex == 'female')? "N&#7919;":"Nam"; ?>
				</td>
			  </tr>
			  <tr>
				<td><b>&#272;&#7883;a ch&#7881;  </b></td>
				<td width="5px">:</td>
				<td><?php echo $order-> sender_address; ?></td>
			  </tr>
			  <tr>
				<td><b>Email </b></td>
				<td width="5px">:</td>
				<td><?php echo $order-> sender_email; ?></td>
			  </tr>
			  <tr>
				<td><b>&#272;i&#7879;n tho&#7841;i </b></td>
				<td width="5px">:</td>
				<td><?php echo $order-> sender_telephone; ?></td>
			  </tr>
			 </tbody>
		</table>
		<!-- ENd TABLE 							-->
			
	</div>
