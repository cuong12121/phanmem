<br>
<fieldset id="zone-upload-analytics">
	<legend class="title">Tạo - sửa sản phẩm bằng Excel</legend>
	<div id="content-form-upload-import-excel">
		<form  action="<?php echo FSRoute::_('index.php?module=add_product&view=excel&task=import_excel'); ?>" method="POST" enctype="multipart/form-data">
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

			

					<a class="download_file" target="_blank" href="<?php echo FSRoute::_('index.php?module=add_product&view=excel&task=download_file');?>?time=<?php echo time(); ?>">Tải File Sản phẩm</a>
					<input class="btn btn-danger" type="button" value="Nhập file khác" onclick="javascritp: location.reload();">

				</div>
			</div>
		</form>
	</div>
	<div class="red">Lưu ý: Không tự ý thay đổi cấu trúc của file mẫu (xóa,thêm cột)</div>
</fieldset>

<style type="text/css">
	.download_file{
		background: #009688;
	    padding: 7px 10px;
	    display: inline-block;
	    border-radius: 5px;
	    color: #fff !important;
	}
</style>