<title>In phiếu Xuất nhập kho</title>
<?php 
global $config;
$user = $model-> get_record('id = '.$data-> create_userid,'fs_users','*');
$user1 = $model-> get_record('id = '.$data-> create_userid1,'fs_users','*');
$user2 = $model-> get_record('id = '.$data-> create_userid2,'fs_users','*');
?>
<div class="print">
	<div class="top cls">
		<div class="left">&nbsp;</div>
		<div class="center">
			<div class="title"><p>Phiếu chuyển kho</p></div>
			<div class="info">
				<p>Doanh nghiệp: <?php echo $config['site_name']; ?> </p>
					<p>Kho: <?php echo $data-> warehouses_name.' → '.$data-> to_warehouses_name; ?></p>
			</div>
		</div>
		<div class="right">
			<p>Liên 1</p>
			<p>Ngày in: <?php echo date('d/m/Y H:s:i',time()); ?></p>
		</div>
	</div>
	<div class="info2">
		<p><?php echo 'ID phiếu: '.$data-> id.'&nbsp;&nbsp;Time: '.date('d/m/Y H:s:i',strtotime($data-> created_time)).'&nbsp;&nbsp;Người lập: '.$user-> full_name; ?></p>
		<p><?php echo 'Người duyệt: '.@$user1-> fname.' '.@$user1-> lname.'&nbsp;&nbsp;Time: '.date('d/m/Y H:s:i',strtotime(@$data-> updated_time1)); ?></p>
		<p><?php echo 'Người nhận: '.@$user2-> fname.' '.@$user2-> lname.'&nbsp;&nbsp;Time: '.date('d/m/Y H:s:i',strtotime(@$data-> updated_time2)); ?></p>
		<p>Tình trạng: <?php echo $this-> arr_status[$data-> status]; ?></p>
	</div>
	<div class="body">
		<p></p>
		<p>Ghi chú: <?php echo $data-> note; ?></p>
		<p></p>
		<p></p>
		<table id="list_products" class="dg table table-xs stickyHeader">
			<tr>
				<th title="Số thứ tự">#</th>
				<th>Mã vạch</th>
				<th>Mã sản phẩm</th>
				<th>Tên sản phẩm</th>
				<th>IMEI</th>
				<th>Số lượng</th>
				<!-- <th>Giá</th> -->
				<!-- <th>Chiết khấu</th> -->
				<!-- <th>Thành tiền</th> -->
			</tr>

			<?php 
			$i=0;
			$total_amount = 0;
			$total_price = 0;
			foreach ($list_products as $product) {
				$total_amount += $product-> amount;

				$price = @$product-> price* $product-> amount;

				if($product-> discount) {
					if($product-> typediscount == 1) {
						$discount = $product-> discount;
					} else {
						$discount = $price*$product-> discount/100;
					}
				} else {
					$discount = 0;
				}

				$total_price = $total_price + $price - $discount;

				$i++;
				$pro = $model-> get_record('id = '.$product-> product_id,'fs_products','*');
				?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo @$pro-> ma_vach; ?></td>
					<td><?php echo @$pro-> code; ?></td>
					<td><?php echo @$pro-> name; ?></td>
					<td><?php echo @$pro-> imei; ?></td>
					<td><?php echo @$product-> amount; ?></td>
					<!-- <td><?php echo format_money(@$product-> price,'đ','0đ'); ?></td> -->
					<!-- <td><?php echo format_money(@$discount,'đ','0đ'); ?></td> -->
					<!-- <td><?php echo format_money($price - @$discount,'đ','0đ'); ?></td> -->
				</tr>
			<?php } ?>

			<tr>
				<td colspan="5" align="right"><strong>Tổng cộng</strong></td>
				<td><?php echo $total_amount; ?></td>
				<!-- <td>&nbsp;</td> -->
				<!-- <td>&nbsp;</td> -->
				<!-- <td><?php echo format_money($total_price,'đ','0đ'); ?></td> -->
			</tr>

<!-- 			<tr>
				<td colspan="5" align="right"><strong>Chiết khấu phiếu</strong></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><?php echo format_money($data-> discount_bill,'đ','0đ'); ?></td>
			</tr> -->

<!-- 			<tr>
				<td colspan="5" align="right"><strong>VAT</strong></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><?php echo format_money($data-> vat_bill,'đ','0đ'); ?></td>
			</tr> -->

<!-- 			<tr>
				<td colspan="5" align="right"><strong>Thanh toán</strong></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><?php echo format_money($data-> total_pay,'đ','0đ'); ?></td>
			</tr> -->
			
		</table>
	</div>
	<div class="footer">
		<p>&nbsp;</p>
		<!-- <p><strong>Tổng số tiền (viết bằng chữ):</strong> <?php echo numberWords($data-> total_pay); ?></p> -->
		<!-- <p>&nbsp;</p> -->
		<div class="item">
			<p><strong>Người lập phiếu</strong></p>
			<p>(Ký, họ tên)</p>
		</div>
		<div class="item">
			<p><strong>Người giao hàng</strong></p>
			<p>(Ký, họ tên)</p>
		</div>
		<div class="item">
			<p><strong>Người nhận hàng</strong></p>
			<p>(Ký, họ tên)</p>
		</div>
		<div class="item">
			<p><strong>Thủ kho</strong></p>
			<p>(Ký, họ tên)</p>
		</div>
		<div class="item">
			<p><strong>Giám đốc</strong></p>
			<p>(Ký, họ tên)</p>
		</div>
	</div>

</div>




<style>
	body {
		margin: 0;
		padding: 0;
	}
	.cls::after {
		content: '';
		display: block;
		clear: both;
	}
	p {
		margin: 0 0 10px;
	}
	table {
		width: 100%;
	}
	th {
		text-align: center;
	}
	th, td {
		padding: 5px;
		font-size: 14px;
	}
	table, th, td {
		border: 1px solid black;
		border-collapse: collapse;
	}
	.info2 {
		border-bottom: 2px solid #4D4D4D;
		padding-bottom: 5px;
	}
	.print {
		font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
		font-size: 14px;
		padding: 20px;
		box-sizing: border-box;
	}
	.print .left {
		width: 30%;
		float: left;
	}
	.print .center {
		width: 40%;
		float: left;
		text-align: center;
	}
	.print .right {
		width: 30%;
		float: left;
		text-align: right;
	}
	.print .title {
		text-transform: uppercase;
		text-align: center;
		font-size: 18px;
	}
	.footer .item {
		width: 20%;
		float: left;
		padding: 0 20px;
		box-sizing: border-box;
		text-align: center;
	}
</style>


<script>
	// window.print();
</script>