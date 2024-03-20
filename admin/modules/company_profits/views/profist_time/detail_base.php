<table cellspacing="1" class="admintable">
	<div class="form-group ">
		<label class="col-md-2 col-xs-12 control-label">Tổng đơn hàng</label>
		<div class="col-md-10 col-xs-12">
			<?php echo $data -> tong_don_hang ?>
		</div>
		<input type="hidden" name="tong_don_hang" value="<?php echo $data -> tong_don_hang ?>">
		<input type="hidden" name="loi_nhuan" value="<?php echo $data -> loi_nhuan ?>">
	</div>
	<div class="form-group ">
		<label class="col-md-2 col-xs-12 control-label">Mã shop</label>
		<div class="col-md-10 col-xs-12">
			<?php echo $data -> shop_code; ?>
		</div>
	</div>
	<div class="form-group ">
		<label class="col-md-2 col-xs-12 control-label">Doanh thu</label>
		<div class="col-md-10 col-xs-12">
			<?php echo format_money(@$data -> doanh_thu) ?>
		</div>
	</div>
	<div class="form-group ">
		<label class="col-md-2 col-xs-12 control-label">Chi phí</label>
		<div class="col-md-10 col-xs-12">
			<?php echo format_money(@$data -> chi_phi) ?>
		</div>
	</div>
	<div class="form-group ">
		<label class="col-md-2 col-xs-12 control-label">Lợi nhuận tam tính</label>
		<div class="col-md-10 col-xs-12">
			<?php echo format_money(@$data -> loi_nhuan) ?>
		</div>
	</div>
	
	<div class="form-group ">
		<label class="col-md-2 col-xs-12 control-label">Chi phí khác</label>
		<div class="col-md-10 col-xs-12">
			<?php echo format_money(@$data -> chi_phi_khac) ?>
		</div>
	</div>

	<div class="form-group ">
		<label class="col-md-2 col-xs-12 control-label">Lợi nhuận thực tế</label>
		<div class="col-md-10 col-xs-12">
			<?php echo format_money(@$data ->loi_nhuan_thuc) ?>
		</div>
	</div>

	<?php TemplateHelper::dt_edit_file(FSText :: _('Chi phí khác (Excel)'),'file_xlsx',@$data->file_xlsx); ?>
	
	<div class="form-group ">
		<label class="col-md-2 col-xs-12 control-label">Mẫu chi phí Excel</label>
		<div class="col-md-10  col-xs-12"><a style="color: rgba(255, 153, 0, 0.79);" href="<?php echo URL_ROOT ?>files/profits/mau_chi_phi.xlsx">Tải xuống</a>
		
	</div>

</table>