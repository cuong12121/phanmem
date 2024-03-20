<br>
<fieldset id="zone-upload-analytics">
	<legend class="title">Add shop - Excel</legend>
	<div id="content-form-upload-import-excel">
		<form  action="<?php echo FSRoute::_('index.php?module=add_shop&view=excel&task=import_excel'); ?>" method="POST" enctype="multipart/form-data">
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
					
					
					
				</div>
			</div>
		</form>
	</div>
	<div class="red">Lưu ý: Không tự ý thay đổi cấu trúc của file mẫu (xóa,thêm cột)</div>
</fieldset>