<br>
<fieldset id="zone-upload-analytics">
	<legend class="title">Bắn hàng ra kho - Excel</legend>
	<div id="content-form-upload-import-excel">
		<form  action="<?php echo FSRoute::_('index.php?module=warehouse_sales&view=excel&task=import_excel'); ?>" method="POST" enctype="multipart/form-data">
			<div class="one-row-input">
				<div class="input">
					<div ><input type="file" size="35" class="btn btn-outline btn-secondary" name="excel"></div>
				</div>
			</div>
			<div class="one-row-input">
				<div class="input-title">&nbsp;</div>
				<div class="input">
					<input class="btn  btn-success" type="submit" value="<?php echo (@$cat)?'Import':'Cập nhật'?>">
					&nbsp;
					<input class="btn btn-danger" type="button" value="Nhập file khác" onclick="javascritp: location.reload();">
					
					
					<input class="btn  btn-info" type="button" value="Tải mẫu " onclick="location.href='<?php echo FSRoute::_('index.php?module=warehouse_sales&view=excel&task=download_file')?>'">
				</div>
			</div>
		</form>
	</div>
	<div class="red">Lưu ý: Không tự ý thay đổi cấu trúc của file mẫu (xóa,thêm cột)</div>
</fieldset>