<table class='compare_table' border="0" cellpadding="5px" width="100%" >
	<tr>
		<td class='title' width="45%">
			Đánh giá:
		</td>
		<td>
			<?php include 'default_base_rating.php'; ?>
		</td>
	</tr>
	<tr>
		<td class='title' width="30%">
			Nhận xét:
		</td>
		<td>
			<span class='comments'><?php echo $data -> comments_published; ?></span>
		</td>
	</tr>
	<tr>
		<td class='title' width="30%">
			Download:
		</td>
		<td>
			<span class='no_download'><?php echo $data -> download; ?></span>
		</td>
	</tr>
	<tr>
		<td class='title' width="30%">
			Loại download:
		</td>
		<td>
			<span class='download'><?php echo $data->price ? 'Premium': ' Free'; ?></span>
		</td>
	</tr>
	<tr>
		<td class='title' width="30%">
			Phí download:
		</td>
		<td>
			<span class='price_download'><?php echo $data->price ? $data->price . ' xu ': ' Free'; ?></span>
		</td>
	</tr>
</table>

