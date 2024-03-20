<script type="text/javascript" language="javascript" src="<?=URL_ROOT.'administrator/templates/default/js/jquery.layout-latest.js'?>"></script>
<script type="text/javascript" language="javascript" src="<?=URL_ROOT.'administrator/templates/default/js/jquery.form.js'?>"></script>
<script type="text/javascript" language="javascript" src="<?=URL_ROOT.'administrator/templates/default/js/jquery.MultiFile.js'?>"></script>
<script type="text/javascript" language="javascript" src="<?=URL_ROOT.'administrator/templates/default/js/jquery.validate.min.js'?>"></script>
<script type="text/javascript" language="javascript" src="<?=URL_ROOT.'administrator/templates/default/js/import.js'?>"></script>
<fieldset id="zone-upload-analytics">
	<?php if(@$cat){?>
	<legend class="title" style="color:#000;">Import sản phẩm của danh mục <strong style="color:red;"><?php echo $cat->name;?></strong></legend>
	<?php }else {?>
		<legend class="title">Thêm sản phẩm từ excel</legend>
<!--		<span style="color:red;">Cột Name trong file exel phải trùng với tên sản phẩm</span>-->
	<?php }?>
	<div class="red">Lưu ý: Không tự ý thay đổi cấu trúc của file mẫu (xóa,thêm cột)</div>
	<div id="content-form-upload-import-excel">
		<form id="frm-import-excel-for-product" action="index.php?module=products&view=add_update_excel&task=import_product" method="POST" enctype="multipart/form-data">
			<div class="one-row-input">
				<div class="input">
					<div id='frm-editing-upload-league-excel_wrap'><span>File excel: </span><input type="file" size="35" id="frm-editing-upload-league-excel" class="football-data-excel-file-import" name="excel"><span id="frm-editing-upload-league-excel_wrap_labels"></span></div>
				</div>
			</div>
			<div class="one-row-input">
				<div class="input-title">&nbsp;</div>
				<div class="input">
					<input type="submit" value="<?php echo (@$cat)?'Import':'Cập nhật'?>">
					&nbsp;
					<input type="button" value="Nhập file khác" onclick="javascritp: location.reload();">
					
					<input type="button" value="Mẫu thêm mới" onclick="location.href='index.php?module=products&view=add_update_excel&task=download_file&raw=1' ">
					<input type="button" value="Hướng dẫn nhập file" onclick="location.href='index.php?module=products&view=add_update_excel&task=download_file_tutorial&raw=1' ">
				</div>
			</div>
			<?php $cid =  FSInput::get('cid');?>
			<input type="hidden" value="<?php echo $cid; ?>" name='cid' id='cid'  />
		</form>
	</div>
</fieldset>