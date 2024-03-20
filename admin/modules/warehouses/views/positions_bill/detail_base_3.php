
<?php
$arr_type = $this->  arr_type;
$arr_type_import = $this->  arr_type_import;
$arr_status = $this->  arr_status;
$arr_style_import = $this->  arr_style_import;

TemplateHelper::dt_edit_text(FSText :: _('Tên phiếu'),'name',@$data -> name,'','',1,0,0);
			// TemplateHelper::dt_edit_selectbox('Loại phiếu','type',@$data -> type,0,$arr_type,$field_value = '', $field_label='');

TemplateHelper::dt_notedit_text(FSText :: _('Loại phiếu'),'type',$arr_type[@$data -> type],'','',1,0,0);

			// TemplateHelper::dt_edit_selectbox(FSText::_('Kho hàng'),'warehouses_id',@$data -> warehouses_id,0,$warehouses,$field_value = 'id', $field_label='name',$size = 1,0);
TemplateHelper::dt_notedit_text(FSText :: _('Kho hàng'),'warehouses_name',$data-> warehouses_name,'','',1,0,0);

TemplateHelper::dt_edit_text(FSText :: _('Ghi chú'),'note',@$data -> note,'','',4,0,0);

			// TemplateHelper::dt_edit_selectbox('Tình trạng','status',@$data -> status,0,$arr_status, $field_value = '', $field_label='');

TemplateHelper::dt_notedit_text(FSText :: _('Kiểu nhập'),'style_import',$arr_style_import[@$data -> style_import],'','',1,0,0);

// TemplateHelper::dt_notedit_text(FSText :: _('Tình trạng'),'',$arr_status[@$data -> status],'','',1,0,0);

?>

<div class="col-12 col-md-12">
	<div class="panel panel-default">
		<div class="panel-heading">Danh sách sản phẩm</div>
		<div class="panel-body">
			<?php if($data-> file) { 
				?>
				<div class="form-group">
					<label class="col-md-2 col-xs-12 control-label">File đã nhập</label>
					<div class="col-md-10 col-xs-12">
						<a href="<?php echo URL_ROOT.$data-> file; ?>" target="_blank"><?php echo $data-> file_name; ?></a>
					</div>
				</div>
			<?php } ?>
			<div class="products_search_ajax hide">
				<div class="form-group ">
					<select name="type_products_search" id="type_products_search" class="form-control">
						<option value="1">Sản phẩm</option>
					</select>
					<input type="text" class="form-control" name="products_search_keyword" id="products_search_keyword" placeholder="Nhập tên, mã sản phẩm">
				</div>
				<div class="products_search_ajax_result hide"></div>
			</div>

			<div class="products_search_ajax_list">
				<table id="table_products_search_ajax_list" width="100%" bordercolor="#AAA" border="1" class="table table-hover table-striped table-bordered dataTables-example" style="margin-bottom: 0px;">
					<tr>
						<tr>
							<td width="3%">#</td>
							<td width="25%">Vị trí</td>
							<td width="15%">Mã sản phẩm</td>
							<td width="15%">Mã vạch</td>
							<td width="25%">Tên sản phẩm</td>
							<td width="12%">Số lượng</td>
							<td width="5%">*</td>
						</tr>
					</tr>
					<?php
					if(!empty($list_products)) {
						$i=0;
						foreach ($list_products as $product) {
							$i++;
							$pro = $model-> get_record('id = '.$product-> product_id,'fs_products','id,name,code,barcode');
							$pos = $model-> get_record('id = '.$product-> position_id,'fs_warehouses_positions','*');
							?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $pos-> name.' ('.$pos-> list_code.')'; ?></td>
								<td><?php echo $pro-> code; ?></td>
								<td><?php echo $pro-> barcode; ?></td>
								<td><?php echo $pro-> name; ?></td>
								<td><?php echo $product-> amount; ?></td>
								<td width="5%">&nbsp;</td>
							</tr>
							<?php
						}
					}?>
				</table>
			</div>
		</div>
	</div>
</div>

