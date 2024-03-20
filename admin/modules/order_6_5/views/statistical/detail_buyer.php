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
				<td width="173px"><b>Giới tính </b></td>
				<td width="5px">:</td>
				<td><?php echo $order-> sender_sex; ?></td>
			</tr>
			<tr>
				<td width="173px"><b>User ID </b></td>
				<td width="5px">:</td>
				<td><?php echo $order-> user_id; ?></td>
			</tr>
			<tr>
				<td><b>&#272;&#7883;a ch&#7881;  </b></td>
				<td width="5px">:</td>
				<td><?php echo $order-> sender_address.', '. $order-> ward_name.', '.$order-> district_name.', '.$order-> city_name  ?></td>
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
			<tr>
				<td><b>Thông tin khác </b></td>
				<td width="5px">:</td>
				<td><?php echo $order-> sender_comments; ?></td>
			</tr>

			<tr>
				<td><b>Hình thức thanh toán</b></td>
				<td width="5px">:</td>
				<td>
					<?php 
						if($order-> is_vnpay == 1){
							echo 'Thanh toán qua VNPAY';
							echo $order -> code_vnpay == '00' ? ' - Đã thanh toán' : ' - Chưa thanh toán';
						}elseif($order-> is_vnpay == 2){
							echo 'Thanh toán qua số tài khoản ngân hàng';
						}else{
							echo 'Thanh toán tiền mặt khi nhận hàng';
						}
					?>
					
				</td>
			</tr>
		</tbody>
	</table>
	<!-- ENd TABLE 							-->

</div>

<?php if(!empty($order-> tax_company) && !empty($order-> tax_address) && !empty($order-> tax_code)){ ?>
<div class="form_user_head_c">
	<span class='bold red'>Thông tin xuất hóa đơn GTGT</span>
</div>				
<div class="form_user_footer_body">
	<!-- TABLE 							-->
	<table cellspacing="0" cellpadding="6" border="0" width="100%" class="tabl-info-customer">
		<tbody> 
			
			<tr>
				<td width="173px"><b>Công ty</b></td>
				<td width="5px">:</td>
				<td><?php echo $order-> tax_company; ?></td>
			</tr>
			<tr>
				<td width="173px"><b>Địa chỉ</b></td>
				<td width="5px">:</td>
				<td><?php echo $order-> tax_address; ?></td>
			</tr>
			<tr>
				<td width="173px"><b>Mã số thuế</b></td>
				<td width="5px">:</td>
				<td><?php echo $order-> tax_code; ?></td>
			</tr>
			
		</tbody>
	</table>
	<!-- ENd TABLE 							-->

</div>
<?php } ?>
