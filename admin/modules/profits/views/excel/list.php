<br>
<fieldset id="zone-upload-analytics">
	<legend class="title">Cập nhập lợi nhuận - Excel</legend>
	<div id="content-form-upload-import-excel">
		<form  action="<?php echo FSRoute::_('index.php?module=profits&view=excel&task=import_excel'); ?>" method="POST" enctype="multipart/form-data">
			<div class="one-row-input">
				<div class="input cls">
					<div class="input-field">
						<input required="required" type="file" size="35" class="btn btn-outline btn-secondary" name="excel">
					</div>
					<div class="select-field">
						<select required="required" name="platform_id">
							<option value="">Chọn Sàn</option>
							<?php foreach ($platforms as $item) { ?>
								<option value="<?php echo $item->id ?>"><?php echo $item->name ?></option>
							<?php } ?>
						</select>
					</div>
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

<div class="download-file">
	<div class="tt-dl">Tải mẫu</div>
	<table>
		<tr>
			<td>Lazada</td>
			<td>
				<input class="btn  btn-info" type="button" value="Tải Xuống" onclick="location.href='<?php echo FSRoute::_('index.php?module=profits&view=excel&task=download_file_lazada')?>'">
			</td>
		</tr>
		<tr>
			<td>Shoppe & Đơn ngoài</td>
			<td>
				<input class="btn  btn-info" type="button" value="Tải Xuống" onclick="location.href='<?php echo FSRoute::_('index.php?module=profits&view=excel&task=download_file_shoppe')?>'">
			</td>
		</tr>
		<tr>
			<td>Tiki</td>
			<td>
				<input class="btn  btn-info" type="button" value="Tải Xuống" onclick="location.href='<?php echo FSRoute::_('index.php?module=profits&view=excel&task=download_file_tiki')?>'">
			</td>
		</tr>
	</table>
</div>


<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_ROOT.LINK_AMIN.'/modules/'.$this->module.'/assets/css/profits.css' ?>" />