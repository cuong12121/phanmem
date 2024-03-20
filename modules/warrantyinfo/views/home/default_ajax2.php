<?php if(!$info){
	echo $error="Số điện thoại không tồn tại hoặc mã IMEI không chính xác, kiểm tra lại";
}else{ ?>
	<div class="title_box2">Thông tin bảo hành</div>
	<table class="info2">
		<tr>
			<td>Tên sản phẩm:</td>
			<td><?php echo $info-> device_name; ?></td>
		</tr>	
		<tr>
			<td>IMEI:</td>
			<td><?php echo $info-> imei; ?></td>
		</tr>	
		<tr>
			<td>Khách hàng:</td>
			<td><?php echo $info-> name; ?></td>
		</tr>	
		<tr>
			<td>Thông tin sửa:</td>
			<td><?php echo $data?$data-> more_info: 'Máy đang không gửi sửa chữa'; ?></td>
		</tr>
		<?php if($data) { ?>
			<tr>
				<td>Ngày gửi máy:</td>
				<td><?php echo date('d/m/Y',strtotime($data-> begin_time)); ?></td>
			</tr>
			<tr>
				<td>Tình trạng:</td>
				<td><?php echo $data->published?'Đã sửa xong!':'Đang sửa chữa'; ?></td>
			</tr>
		<?php } ?>
		<tr>
			<td>Hạn bảo hành:</td>
			<td><?php echo date('d/m/Y',strtotime($info-> end_time)); ?></td>
		</tr>
	</table>
<?php } ?>
