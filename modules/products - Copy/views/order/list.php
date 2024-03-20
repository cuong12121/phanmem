<link rel="stylesheet" type="text/css" media="screen" href="<?php echo URL_ROOT.'modules/products/assets/css/order.css'; ?>" />
<h2 class='head_content'>
	Lịch sử giao dịch
</h2>
<div class ="tab_content_inner order_info" >
	<table cellpadding="5" cellspacing="0"  border="1" bordercolor="#D1D1D1" width="100%" >
		<thead>
			<tr  bgcolor="#25B7E9">
				<th >Mã Đơn hàng</th>
				<th>Ngày đặt</th>
				<th>Tình trạng</th>
				<th>Chi tiết đơn hàng</th>
			</tr>
		</thead>
		<tbody>
		<?php for($i = 0 ; $i < count($data); $i ++ ){?>
		<?php
			 $item = $data[$i];
			 $link_view =FSRoute::_('index.php?module=products&view=cart&id='.$item->id.'&task=finished&Itemid=45');
		?>
			<tr>
				<td align="center">
					<?php 
				 	$estore_code = 'DH';
				 	$estore_code .= str_pad($item -> id, 8 , "0", STR_PAD_LEFT);
					?>
					<font color='#134593'><?php echo $estore_code ?></font>
				</td>
				<td align="center"> 
					<span><?php echo date('d/m/Y',strtotime($item->created_time));?></span>
				</td>
				<td align="center"><?php echo $this -> showStatus($item -> status);?></td>
				<td align="center">
					<a class="thickbox" rel="<?php echo $estore_code;?>" href="<?php echo $link_view; ?>">
					<font color='#134593'>Xem đơn hàng</font>
					</a>
				</td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
</div>
		

