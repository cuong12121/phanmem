<?php if(empty($data)){
	echo "<div>Không tồn tại sản phẩm này.";
} ?>

<table id="dataTables-example" class="table table-hover table-striped table-bordered">
	<thead>
		<tr>
			<th>
				Kho
			</th>
			<th>
				Tồn
			</th>
			<th>
				Tạm giữ
			</th>
			<th>
				Có thể bán
			</th>
			
		</tr>
	</thead>
	<tbody>
		<?php
			$amount_total = 0;
			$amount_hold_total = 0;
			foreach ($warehouses as $warehouse) {
			$amount = !empty($data[$warehouse->id]-> amount) ? $data[$warehouse->id]-> amount : 0;
			$amount_hold = !empty($data[$warehouse->id]-> amount_hold) ? $data[$warehouse->id]-> amount_hold : 0;
			$amount_total += $amount;
			$amount_hold_total += $amount_hold;

		?>
		<tr>
			<td><?php echo $warehouse->name ?></td>
			<td><?php echo $amount; ?></td>
			<td><?php echo $amount_hold; ?></td>
			<td>
				<?php echo (float)$amount - (float)$amount_hold; ?>
			</td>
		</tr>
		<?php } ?>
		<tr>
			<td>Tổng</td>
			<td><?php echo $amount_total ?></td>
			<td><?php echo $amount_hold_total ?></td>
			<td><?php echo (float)$amount_total - (float)$amount_hold_total; ?></td>
		</tr>
	</tbody>
</table>