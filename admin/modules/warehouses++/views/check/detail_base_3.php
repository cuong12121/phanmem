
<?php
$arr_type = $this->  arr_type;
$arr_type_import = $this->  arr_type_import;
$arr_status = $this->  arr_status;
$arr_style_import = $this->  arr_style_import;

TemplateHelper::dt_edit_text(FSText :: _('Tên phiếu'),'name',@$data -> name,'','',1,0,0);
			// TemplateHelper::dt_edit_selectbox('Loại phiếu','type',@$data -> type,0,$arr_type,$field_value = '', $field_label='');
// TemplateHelper::dt_notedit_text(FSText :: _('Loại phiếu'),'type',$arr_type[@$data -> type],'','',1,0,0);

			// TemplateHelper::dt_edit_selectbox(FSText::_('Kho hàng'),'warehouses_id',@$data -> warehouses_id,0,$warehouses,$field_value = 'id', $field_label='name',$size = 1,0);
TemplateHelper::dt_notedit_text(FSText :: _('Kho hàng'),'warehouses_name',$data-> warehouses_name,'','',1,0,0);

TemplateHelper::dt_edit_text(FSText :: _('Ghi chú'),'note',@$data -> note,'','',4,0,0);

			// TemplateHelper::dt_edit_selectbox('Tình trạng','status',@$data -> status,0,$arr_status, $field_value = '', $field_label='');

TemplateHelper::dt_notedit_text(FSText :: _('Kiểu nhập'),'style_import',$arr_style_import[@$data -> style_import],'','',1,0,0);

TemplateHelper::dt_notedit_text(FSText :: _('Tình trạng'),'',$arr_status[@$data -> status],'','',1,0,0);

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
						<td width="3%">#</td>
						<td width="22%">Sản phẩm</td>
						<td width="10%">Tồn kho</td>
						<td width="10%">Đang giao</td>
						<td width="10%">Tồn trong kho</td>
						<td width="10%">Tạm giữ</td>
						<td width="10%">Thực tế</td>
						<td width="10%">Số lượng lệch</td>
						<td width="10%">Giá trị lệch</td>
						<td width="5%">*</td>
					</tr>
					<?php
					if(!empty($list_products)) {
						$i=0;
						foreach ($list_products as $product) {
							$i++;
							$pro = $model-> get_record('id = '.$product-> product_id,'fs_products','id,name,price');
							?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $pro-> name; ?><br>Ghi chú: <?php echo $product-> note; ?></td>
								<td><?php echo $product-> amount; ?></td>
								<td><?php echo $product-> amount_deliver; ?></td>
								<td><?php echo $product-> amount - $product-> amount_deliver; ?></td>
								<td><?php echo $product-> amount_deliver; ?></td>
								<td><?php echo $product-> reality; ?></td>
								<td><?php echo ($product-> reality - ($product-> amount - $product-> amount_deliver)); ?></td>
								<td><?php echo format_money(($product-> reality - ($product-> amount - $product-> amount_deliver))*$product-> price,'đ','0đ'); ?></td>
								<td>&nbsp;</td>
							</tr>
							<?php
						}
					}?>
				</table>
			</div>
		</div>
	</div>
</div>

