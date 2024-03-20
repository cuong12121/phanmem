<?php if(!$data){
	echo $error="Số điện thoại không tồn tại hoặc mã IMEI không chính xác, kiểm tra lại";
}else{ ?>
	<table class="info">
		<tr>
			<td> Họ tên </td>
			<td> Số điện thoại </td>
			<td> IMEI </td>
			<td> Tên máy </td>
			<td> Bảo hành từ ngày </td>
			<td> Bảo hành đến ngày </td>
		</tr>
		<?php foreach ($data as $item) { ?>
			<tr>
				<td> <?php echo $item->name; ?> </td>
				<td> <?php echo $item->phone; ?> </td>
				<td> <?php echo $item->imei; ?> </td>
				<td> <?php echo $item->device_name; ?> </td>
				<td> <?php echo $item-> begin_time?date('d/m/Y',strtotime($item-> begin_time)):'Đang cập nhật!' ?> </td>
				<td> <?php echo $item-> end_time?date('d/m/Y',strtotime($item-> end_time)):'Đang cập nhật!' ?> </td>
			</tr>
		<?php } ?>
	</table>
<?php } ?>
