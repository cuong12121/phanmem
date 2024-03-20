<?php if(!$data){
				echo $error="Số điện thoại không tồn tại hoặc mã máy không chính xác, kiểm tra lại";
			}else{ ?>
			<table >
				<tr>
					<td> Họ tên </td>
					<td> Số điện thoại </td>
					<td> Mã máy </td>
					<td> Bảo hành đến ngày </td>
				</tr>
				<?php foreach ($data as $item) { ?>
					<tr>
						<td> <?php echo $item->name; ?> </td>
						<td> <?php echo $item->phone; ?> </td>
						<td> <?php echo $item->code; ?> </td>
						<td> <?php echo date('d/m/Y',strtotime($item->created_time.'+365day')) ?> </td>
					</tr>
				<?php } ?>
			</table>
				 
				<?php } ?>
