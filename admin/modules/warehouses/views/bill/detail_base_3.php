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
		<?php if($_SESSION['ad_userid'] == 9){ ?>
		<div class="add_product_exit cls">
			<input id="code_product" type="tex" class="form-control" placeholder="Nhập mã sản phẩm">
			<input id="amount_product" type="number" class="form-control" placeholder="Số lượng">
			<input id="price_product" type="number" class="form-control" placeholder="Giá">
			<span onclick="add_product_exit(<?php echo $data->id ?>)">Bổ sung sản phẩm</span>
		</div>
		<?php } ?>
		<div class="panel-body">
		<?php if($data-> file) {  ?>
						
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
						<td width="10%">Mã</td>
						<td width="15%">Sản phẩm</td>
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
							$pro = $model-> get_record('id = '.$product-> product_id,'fs_products','id,name,code');
							$pro_amount = $model-> get_record('product_id = '.$product-> product_id.' AND warehouses_id = '.$data-> warehouses_id,'fs_warehouses_products','amount');
							?>
							<tr class="tr-item-<?php echo $product->id ?>">
								<td><?php echo $i; ?></td>
								<td><?php echo $pro-> code; ?></td>
								<td><?php echo $pro-> name; ?></td>
								<td class="show_amount_<?php echo $product->id ?>"><?php echo $pro_amount-> amount?$pro_amount-> amount:'0'; ?></td>
								<td>
									<?php if($_SESSION['ad_userid'] == 9){ ?>
										<input type="number" data-bill-id = "<?php echo $data->id ?>"  data-amount-old = "<?php echo $product-> amount; ?>"  class="form-control change_amount_item_bill_<?php echo $product->id ?>" value="<?php echo $product-> amount; ?>">
										<button type="button" onclick="change_amount_item_bill(<?php echo $product->id ?>)" style="width: 100%;margin-top: 6px;background: var(--main-color);color: #fff;border: none;height: 32px;">Lưu</button>
									<?php }else{
										echo $product-> amount;
									} ?>
								</td>
								<td><?php echo format_money($product-> price,'đ','0đ'); ?></td>
								<td><?php echo format_money($product-> amount*$product-> price,'đ','0đ'); ?></td>
								<td><?php echo format_money($product-> discount,'','0').' '.@$this-> arr_type_discount[$product-> typediscount]; ?></td>
								<td><?php echo $product-> weight; ?></td>
								<td><?php echo $product-> link; ?></td>
								<td>
									<?php if($_SESSION['ad_userid'] == 9){ ?>
									<a href="javascript:void:(0)" onclick="ajax_remove_item_bill(<?php echo $product->id ?>)">Xóa</a>
									<?php } ?>
								</td>
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

<script type="text/javascript">
	function ajax_remove_item_bill(id){
		var bill = $('.change_amount_item_bill_'+id).attr('data-bill-id');
		$.ajax({
			async:false,
			url: "/admin/index.php?module=warehouses&view=bill&task=ajax_remove_item_bill&raw=1",
			data: {id:id,bill:bill},
			dataType: "json",
			success: function(data) {
				if(data.error == false){
					$('.tr-item-'+id).hide();
					alert(data.message);
				}else{
					alert(data.message);
				}
				
			}
		});
	}

	function change_amount_item_bill(id){
		var bill = $('.change_amount_item_bill_'+id).attr('data-bill-id');
		var amount_old = $('.change_amount_item_bill_'+id).attr('data-amount-old');
		var amount_new = $('.change_amount_item_bill_'+id).val();
		if(amount_old == amount_new){
			alert("Không có thay đổi nào!");
			return false;
		}
		$.ajax({
			async:false,
			url: "/admin/index.php?module=warehouses&view=bill&task=ajax_change_amount_item_bill&raw=1",
			data: {amount_old:amount_old,amount_new:amount_new,bill:bill,id:id},
			dataType: "json",
			success: function(data) {
				// $("#table_products_search_ajax_list").load(location.hrsef+" #table_products_search_ajax_list>*","");
				if(data.error == false){
					$('.change_amount_item_bill_'+id).attr('data-amount-old',amount_new);
					$('.show_amount_'+id).html(data.ton);
					alert(data.message);
				}else{
					alert(data.message);
				}
			}
		});
	}


	function add_product_exit(bill_id){
		var code_product = $('#code_product').val();
		var amount_product = $('#amount_product').val();
		var price_product = $('#price_product').val();
		$.ajax({
			async:false,
			url: "/admin/index.php?module=warehouses&view=bill&task=ajax_add_amount_item_bill&raw=1",
			data: {code_product:code_product,amount_product:amount_product,price_product:price_product,bill_id:bill_id},
			dataType: "json",
			success: function(data) {
				if(data.error == false){
					alert(data.message);
					location.reload();
				}else{
					alert(data.message);
				}
			}
		});
	}
</script>

<style type="text/css">
	.add_product_exit{
		padding: 16px;
	}
	.add_product_exit span{
	    background: #288ad6;
	    color: #fff;
	    padding: 9px;
	    cursor: pointer;
	    border-radius: 5px;
	    display: inline-block;
	}

	.add_product_exit input{
	    width:200px !important;
	    float: left;
	    margin-right: 5px;
	}
</style>

