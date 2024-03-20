<div class="col-12 col-md-6" style="margin-top: 20px;">
	<div class="panel panel-default">
		<div class="panel-heading">Kho hàng</div>
		<div class="panel-body">
			<?php
			// $arr_type = $this->  arr_type;
			// $arr_type_import = $this->  arr_type_import;
			$arr_status = $this->  arr_status;
			$arr_style_import = $this->  arr_style_import;


			TemplateHelper::dt_notedit_text(FSText :: _('Từ Kho hàng'),'warehouses_name',$data-> warehouses_name,'','',1,0,0);


			TemplateHelper::dt_notedit_text(FSText :: _('Đến Kho hàng'),'warehouses_name',$data-> to_warehouses_name,'','',1,0,0);
			?>

		</div>
	</div>
</div>

<div class="col-12 col-md-6" style="margin-top: 20px;">
	<div class="panel panel-default">
		<div class="panel-heading"><span>Thông tin</span></div>
		<div class="panel-body">
			<?php
			TemplateHelper::dt_edit_text(FSText :: _('Tên phiếu'),'name',@$data -> name,'','',1,0,0);
			TemplateHelper::dt_edit_text(FSText :: _('Ghi chú'),'note',@$data -> note,'','',4,0,0);

			TemplateHelper::dt_notedit_text(FSText :: _('Tình trạng'),'',$arr_status[@$data -> status],'','',1,0,0);

			TemplateHelper::dt_notedit_text(FSText :: _('Kiểu nhập'),'style_import',$arr_style_import[@$data -> style_import],'','',1,0,0);
			?>
		</div>
	</div>
</div>
<div class="col-12 col-md-12">
	<div class="panel panel-default">
		<div class="panel-heading">Danh sách sản phẩm</div>
		<div class="panel-body">
			<?php if($data-> file && $data-> style_import == 2) { 
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
						<td width="10%">Mã</td>
						<td width="25%">Tên sản phẩm</td>
						<td width="5%">Có thể chuyển</td>
						<td width="10%">Số lượng</td>
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
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $pro-> code; ?></td>
								<td><?php echo $pro-> name; ?></td>
								<td><?php echo $pro_amount-> amount?$pro_amount-> amount:'0'; ?></td>
								<td>
									<?php if(1 == 1){ ?>
										<input type="number" data-bill-id = "<?php echo $data->id ?>"  data-amount-old = "<?php echo $product-> amount; ?>"  class="form-control change_amount_item_bill_<?php echo $product->id ?>" value="<?php echo $product-> amount; ?>">
										<button type="button" onclick="change_amount_item_bill(<?php echo $product->id ?>)" style="width: 100%;margin-top: 6px;background: var(--main-color);color: #fff;border: none;height: 32px;">Lưu</button>
									<?php }else{
										echo $product-> amount;
									} ?>
								</td>

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

<script type="text/javascript">
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
			url: "/admin/index.php?module=warehouses&view=bill_transfer&task=ajax_change_amount_item_bill&raw=1",
			data: {amount_old:amount_old,amount_new:amount_new,bill:bill,id:id},
			dataType: "json",
			success: function(data){
				if(data.error == false){
					$('.change_amount_item_bill_'+id).attr('data-amount-old',amount_new);
					$('.show_amount_'+id).html(data.ton);
					alert(data.message);
					location.reload();
				}else{
					alert(data.message);
				}
			}
		});
	}
</script>