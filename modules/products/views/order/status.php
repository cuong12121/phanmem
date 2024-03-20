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
           <div class='prd_search_area'>
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
</div>
