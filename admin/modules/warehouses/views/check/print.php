<?php 
global $config;
$user = $model-> get_record('id = '.$data-> create_userid,'fs_users','*');
?>
<div class="print">
	<div class="top cls">
		<div class="left">&nbsp;</div>
		<div class="center">
			<div class="title"><p>Phiếu kiểm kho</p></div>
			<div class="info">
				<!-- <p>Kiểu: <?php echo $this-> arr_type_import[$data-> type_import] ?></p> -->
				<p>Doanh nghiệp: <?php echo $config['site_name']; ?> </p>
					<p>Kho: <?php echo $data-> warehouses_name;?></p>
			</div>
		</div>
		<div class="right">
			<p>Liên 1</p>
			<p>Ngày in: <?php echo date('d/m/Y H:s:i',time()); ?></p>
		</div>
	</div>
	<div class="info2">
		<p><?php echo 'ID phiếu: '.$data-> id.'&nbsp;&nbsp;Time: '.date('d/m/Y H:s:i',strtotime($data-> created_time)).'&nbsp;&nbsp;Người lập: '.$user-> fullname; ?></p>
	</div>
	<div class="body">
		<p></p>
		<p>Ghi chú: <?php echo $data-> note; ?></p>
		<p></p>
		<table id="list_products" class="dg table table-xs stickyHeader">
			<tr>
				<th title="Số thứ tự">#</th>
				<th>Mã vạch</th>
				<th>Mã sản phẩm</th>
				<th>Tên sản phẩm</th>
				<th>Tồn kho</th>
				<th>Đang chuyển</th>
				<th>Tồn thực tế</th>
				<th>Chênh lệch</th>
				<th>Ghi chú</th>
			</tr>

			<?php 
			$i=0;
			$total_reality = 0;
			$total_product = 0;
			foreach ($list_products as $product) {
				$total_reality += @$product-> reality;
				$i++;
				$pro = $model-> get_record('id = '.$product-> product_id,'fs_products','*');
				?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo @$pro-> ma_vach; ?></td>
					<td><?php echo @$pro-> code; ?></td>
					<td><?php echo @$pro-> name; ?></td>
					<td><?php echo @$product-> amount?@$product-> amount:0; ?></td>
					<td><?php echo @$product-> amount_deliver?@$product-> amount_deliverL:0; ?></td>
					<td><?php echo @$product-> reality; ?></td>
					<td><?php echo (@$product-> reality - (@$product-> amount - @$product-> amount_deliver)); ?></td>
					
					<td><?php echo @$product-> note; ?></td>
				</tr>
			<?php } ?>

			<tr>
				<td colspan="6" align="right">Tổng số lượng</td>
				<td colspan="3"><?php echo $total_reality; ?></td>
			</tr>
			
		</table>
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
	window.print();
</script>