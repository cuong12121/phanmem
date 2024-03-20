<?php 
global $tmpl;
$tmpl -> addStylesheet("order","modules/products/assets/css");
?>
<div class="order_info">
	<h1>
		<span class=''>Kiểm tra tình trạng đơn hàng</span>
	</h1>
	<?php 
						$link_action = "index.php?module=products&view=order";
						if(FSInput::get('order_code'))
							$link_action .= "&order_code=".FSInput::get('order_code');
						$link_action = FSRoute::_($link_action);
						?>
                       		<div class='prd_search_area mt20'>
							<form action="<?php echo $link_action?>" method="get" name="frm_search_pro_inse"  >
								<table cellspacing="0" cellpadding="6" border="0" width="100%" class="tabl-info-customer">
									<tr>
										<td align="right" width="30%"><b>Nhập mã số đơn hàng</b></td>
										<td><input type="text" name='order_code' id='order_code'  value ="<?php echo FSInput::get('order_code'); ?>" class="txt-input "/></td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>
											<input type="submit" lang="<?php echo $link_action?>" value="Kiểm tra" class='button search-order-button' >
										</td>
									</tr>
								</table>
								
								<input type="hidden" name='module' value='products' />
								<input type="hidden" name='view' value='order' />
								<input type="hidden" name='task' value='detail_status' />
							</form>
						</div>
									<div class="form_user_footer_body">
										<!-- TABLE 							-->
										<table cellpadding="5" cellspacing="0"  border="1" bordercolor="#D1D1D1" width="100%" >
											<thead>
												<tr align="center" bgcolor="white">
													<th><b>Đơn hàng#</b></th>
													<th><b>Ngày mua</b></th>
													<th><b>Gửi đến</b></th>
													<th><b>Tổng tiền</b></th>
													<th><b>Tình trạng đơn hàng</b></th>
													<th ><?php echo '&nbsp'; ?></th>
											  	</tr>
											  </thead>
											<tbody>
											<?php
											
												 $link_view =FSRoute::_('index.php?module=products&view=cart&id='.$order->id.'&task=finished&Itemid=45');
											?>
												<tr>
													<td align="center">
														<?php 
													 	$estore_code = 'DH';
													 	$estore_code .= str_pad($order -> id, 8 , "0", STR_PAD_LEFT);
														?>
														<font color='#134593'><?php echo $estore_code ?></font>
													</td>
													<td> 
														<span><?php echo date('d/m/Y',strtotime($order->created_time));?></span>
													</td>
													<td> 
														<span><?php  echo $order -> sender_name; ?></span>
													</td>
													<td> 
														<span><?php  echo format_money($order -> total_after_discount).' '; ?></span>
													</td>
													<td><font color='#134593'><i><?php echo $this -> showStatus($order -> status);?></i></font></td>
													<td><a class="thickbox" rel="<?php echo $estore_code;?>" href="<?php echo $link_view; ?>"><font color='#134593'><i>Xem đơn hàng</i></font></a></td>
												</tr>
											</tbody>
										</table>
									</div>
</div>
