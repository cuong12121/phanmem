<div class="col-12 col-md-6" style="margin-top: 20px;">
	<div class="panel panel-default">
		<div class="panel-heading">Thông tin</div>
		<div class="panel-body">
			<?php
			$arr_type = $this->  arr_type;
			$arr_type_import = $this->  arr_type_import;
			$arr_status = $this->  arr_status;
			$arr_status_show = $this->  arr_status_show;
			$arr_style_import = $this->  arr_style_import;

			TemplateHelper::dt_edit_text(FSText :: _('Tên phiếu'),'name',@$data -> name,'','',1,0,0);
			// TemplateHelper::dt_edit_selectbox('Loại phiếu','type',@$data -> type,0,$arr_type,$field_value = '', $field_label='');
			TemplateHelper::dt_notedit_text(FSText :: _('Loại phiếu'),'type',$arr_type[@$data -> type],'','',1,0,0);

			// TemplateHelper::dt_edit_selectbox(FSText::_('Kho hàng'),'warehouses_id',@$data -> warehouses_id,0,$warehouses,$field_value = 'id', $field_label='name',$size = 1,0);
			TemplateHelper::dt_notedit_text(FSText :: _('Kho hàng'),'warehouses_name',$data-> warehouses_name,'','',1,0,0);

						?>
			<div class="type d_type_3 <?php if($data-> type != 3) echo 'hide'; ?>">
				<?php 
				TemplateHelper::dt_notedit_text(FSText :: _('Chuyển tới Kho hàng'),'to_warehouses_name',$data-> to_warehouses_name,'','',1,0,0);
				?>
			</div>
			<?php 
			

			// TemplateHelper::dt_edit_selectbox('Loại nhập/xuất hàng','type_import',@$data -> type_import,0,$arr_type_import,$field_value = '', $field_label='');
			TemplateHelper::dt_notedit_text(FSText :: _('Loại nhập/xuất hàng'),'type_import',$arr_type_import[@$data -> type_import],'','',1,0,0);

			// TemplateHelper::dt_edit_selectbox(FSText::_('Chọn nhà cung cấp'),'supplier_id',@$data -> supplier_id,0,$supplier,$field_value = 'id', $field_label='name',$size = 1,0);

			TemplateHelper::dt_notedit_text(FSText :: _('Chọn nhà cung cấp'),'supplier_name',$data-> supplier_name,'','',1,0,0);

			TemplateHelper::dt_notedit_text(FSText :: _('Tên khách hàng'),'customer_name',@$data -> customer_name,'','',0,0,0);
			TemplateHelper::dt_notedit_text(FSText :: _('SĐT khách hàng'),'customer_telephone',@$data -> customer_telephone,'','',0,0,0);

			TemplateHelper::dt_edit_text(FSText :: _('Ghi chú'),'note',@$data -> note,'','',4,0,0);

			// TemplateHelper::dt_edit_selectbox('Tình trạng','status',@$data -> status,0,$arr_status, $field_value = '', $field_label='');

			TemplateHelper::dt_notedit_text(FSText :: _('Tình trạng'),'',$arr_status_show[@$data -> status],'','',1,0,0);

			TemplateHelper::dt_notedit_text(FSText :: _('Kiểu nhập'),'style_import',$arr_style_import[@$data -> style_import],'','',1,0,0);

			?>
		</div>
	</div>
</div>

<div class="col-12 col-md-6" style="margin-top: 20px;">
	<div class="panel panel-default">
		<div class="panel-heading"><span>Thanh toán</span><span class="vat <?php if($data-> vat) echo 'vatactive;' ?>">VAT</span></div>
		<div class="panel-body">
			<div class="dvat <?php if(!$data-> vat) echo 'hide'; ?>">
				<?php
				TemplateHelper::dt_notedit_text(FSText :: _('Loại VAT'),'typevat',$this->arr_type_discount[@$data -> typevat],'','',1,0,0);
				TemplateHelper::dt_notedit_text(FSText :: _('VAT'),'vat',@$data -> vat,'','',0,0,0);
				TemplateHelper::dt_notedit_text(FSText :: _('Số hóa đơn VAT'),'numbervat',@$data -> numbervat,'','',0,0,0);
				TemplateHelper::dt_notedit_text(FSText :: _('Ngày xuất VAT'),'datevat',@$data -> datevat,'','',0,0,0);
				?>
			</div>
			<?php
			// TemplateHelper::dt_edit_selectbox('Loại chiết khấu','discount_type',@$data -> discount_type,0,$this-> arr_type_discount,$field_value = '', $field_label='');
			TemplateHelper::dt_notedit_text(FSText :: _('Loại chiết khấu'),'discount_type',$this->arr_type_discount[@$data -> discount_type],'','',1,0,0);
			TemplateHelper::dt_notedit_text(FSText :: _('Chiết khấu'),'discount',@$data -> discount,'','',0,0,0);
			TemplateHelper::dt_notedit_text(FSText :: _('Tiền mặt'),'total_money',@$data -> total_money,'','',0,0,0);
			TemplateHelper::dt_notedit_text(FSText :: _('Chuyển khoản'),'total_ck',@$data -> total_ck,'','',0,0,0);
			TemplateHelper::dt_notedit_text(FSText :: _('Ngày hẹn thanh toán'),'date_pay',@$data -> date_pay,'','',0,0,0);
			?>
		</div>
	</div>
</div>
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
						<td width="25%">Sản phẩm</td>
						<td width="5%">Tồn</td>
						<td width="10%">Số lượng</td>
						<td width="10%">Giá</td>
						<td width="10%">Thành tiền</td>
						<td width="12%">Chiết khấu</td>
						<td width="10%">Khối lượng</td>
						<td width="10%">Link đề xuất</td>
						<td width="5%">*</td>
					</tr>
					<?php
					if(!empty($list_products)) {
						$i=0;
						foreach ($list_products as $product) {
							$i++;
							$pro = $model-> get_record('id = '.$product-> product_id,'fs_products','id,name');
							$pro_amount = $model-> get_record('product_id = '.$product-> product_id.' AND warehouses_id = '.$data-> warehouses_id,'fs_warehouses_products','amount');
							?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $pro-> name; ?></td>
								<td><?php echo $pro_amount-> amount?$pro_amount-> amount:'0'; ?></td>
								<td><?php echo $product-> amount; ?></td>
								<td><?php echo format_money($product-> price,'đ','0đ'); ?></td>
								<td><?php echo format_money($product-> amount*$product-> price,'đ','0đ'); ?></td>
								<td><?php echo format_money($product-> discount,'','0').' '.@$this-> arr_type_discount[$product-> typediscount]; ?></td>
								<td><?php echo $product-> weight; ?></td>
								<td><?php echo $product-> link; ?></td>
								<td>&nbsp;</td>
							</tr>
							<?php
						}
					}?>
				</table>
				<table id="table_products_total" class="table table-hover table-striped table-bordered dataTables-example">
					<tr>
						<td width="33%" align="right">Tổng</td>
						<td width="10%"><span class="total_amount"><?php echo $data-> total_amount; ?></span></td>
						<td width="10%">&nbsp;</td>
						<td width="10%"><span class="total_price"><?php echo format_money($data-> total_price,'đ','0đ'); ?></span></td>
						<td width="12%"><span class="total_discount"><?php echo format_money($data-> total_discount,'đ','0đ'); ?></span></td>	
						<td width="10%"><span class="total_weight"><?php echo $data-> total_weight; ?></span></td>	
						<td width="10%">&nbsp;</td>
						<td width="5%">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="3" align="right">Tổng cộng</td>
						<td colspan="5"><span class="total_price_after"><?php echo format_money($data-> total_price_after,'đ','0đ'); ?></span></td>
					</tr>
										<tr>
						<td colspan="3" align="right">Chiết khấu phiếu</td>
						<td colspan="5"><span class="discount_bill"><?php echo format_money($data-> discount_bill,'đ','0đ'); ?></span></td>
					</tr>
					<tr>
						<td colspan="3" align="right">VAT</td>
						<td colspan="5"><span class="vat_bill"><?php echo format_money($data-> vat_bill,'đ','0đ'); ?></span></td>
					</tr>
					<tr>
						<td colspan="3" align="right">Cần thanh toán</td>
						<td colspan="5"><span class="pay_bill"><?php echo format_money($data-> total_pay,'đ','0đ'); ?></span></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>

