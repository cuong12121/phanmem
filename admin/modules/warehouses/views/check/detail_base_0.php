<?php
$arr_type = $this->  arr_type;
$arr_type_import = $this->  arr_type_import;
$arr_status = $this->  arr_status;
$arr_style_import = $this->  arr_style_import;

TemplateHelper::dt_edit_text(FSText :: _('Tên phiếu'),'name',@$data -> name,'','',1,0,0);
TemplateHelper::dt_edit_selectbox(FSText::_('Kho hàng'),'warehouses_id',@$data -> warehouses_id,0,$warehouses,$field_value = 'id', $field_label='name',$size = 1,0);

TemplateHelper::dt_edit_text(FSText :: _('Ghi chú'),'note',@$data -> note,'','',4,0,0);

TemplateHelper::dt_edit_selectbox('Kiểu nhập','style_import',@$data -> style_import,0,$arr_style_import, $field_value = '', $field_label='');

TemplateHelper::dt_edit_selectbox('Tình trạng','status',@$data -> status,0,$arr_status, $field_value = '', $field_label='');
?>


<div class="col-12 col-md-12">
	<div class="style_import <?php if($data-> style_import == 2) echo 'hide'; ?>" id="d_style_import_1">
		<div class="panel panel-default">
			<div class="panel-heading">Danh sách sản phẩm</div>
			<div class="panel-body">
				<div class="products_search_ajax">
					<div class="form-group ">
						<select name="type_products_search" id="type_products_search" class="form-control">
							<option value="1">Sản phẩm</option>
						</select>
						<input type="text" class="form-control products_search_keyword" name="products_search_keyword" id="products_search_keyword" placeholder="Nhập tên, mã sản phẩm">
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
								<tr class="products_item_selected" id="products_item_selected_<?php echo $pro-> id; ?>">
									<td><span class="products_stt"><?php echo $i; ?></span></td>
									<td><span class="item_title"><?php echo $pro-> name; ?><br><input style="max-width:200px" type="text" name="ajax_products_note_<?php echo $pro-> id; ?>"  id="ajax_products_note_<?php echo $pro-> id; ?>" placeholder="Ghi chú" value="<?php echo $product-> note; ?>"></span><input type="hidden" name="ajax_products[]" value="<?php echo $pro-> id; ?>"><input type="hidden" name="ajax_products_price_<?php echo $pro-> id; ?>"  id="ajax_products_price_<?php echo $pro-> id; ?>" value="<?php echo $pro-> price; ?>"></span></td>
									<td><span><?php echo $product-> amount; ?><input type="hidden" id="ajax_products_amount_<?php echo $pro-> id; ?>" name="ajax_products_amount_<?php echo $pro-> id; ?>" value="<?php echo $product-> amount; ?>"></span></td>
									<td><span><?php echo $product-> amount_deliver; ?></span><input type="hidden" id="ajax_products_amount_deliver_<?php echo $pro-> id; ?>" name="ajax_products_amount_deliver_<?php echo $pro-> id; ?>" value="<?php echo $product-> amount_deliver; ?>"></td>
									<td><span><?php echo $product-> amount - $product-> amount_deliver; ?></span><input type="hidden" id="ajax_products_amount_on_<?php echo $pro-> id; ?>" name="ajax_products_amount_on_<?php echo $pro-> id; ?>" value="<?php echo $product-> amount - $product-> amount_deliver; ?>"></td>
									<td><span><?php echo @$product-> amount_hold?@$product-> amount_hold:0; ?>
								</span><input type="hidden" id="ajax_products_amount_hold_<?php echo $pro-> id; ?>" name="ajax_products_amount_hold_<?php echo $pro-> id; ?>" value="<?php echo $product-> amount_hold; ?>"></td>


								<td><input type="number" name="ajax_products_reality_<?php echo $pro-> id; ?>" id="ajax_products_reality_<?php echo $pro-> id; ?>" onkeyup="ajax_products_update(<?php echo $pro-> id; ?>)" value="<?php echo $product-> reality; ?>"></td>

								<td><span id="diff_amount_<?php echo $pro-> id; ?>"><?php echo ($product-> reality - ($product-> amount - $product-> amount_deliver))  ?></span></td>

								<td><span id="diff_price_<?php echo $pro-> id; ?>">
									<?php echo format_money(($product-> reality - ($product-> amount - $product-> amount_deliver))*$pro-> price,'đ','0đ') ?>
								</span></td>

								<td><a href="javascript:void(0)" onclick="remove_ajax_products(<?php echo $pro-> id; ?>)">Xóa</a></td>
							</tr>
							<?php
						}
					}?>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="style_import <?php if($data-> style_import == 1) echo 'hide'; ?>" id="d_style_import_2">
	<div id="content-form-upload-import-excel">
		<div class="panel panel-default">
			<div class="panel-heading">Nhập file Excel</div>
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

				<div class="form-group">
					<label class="col-md-2 col-xs-12 control-label">Nhập file</label>
					<div class="col-md-10 col-xs-12">
						<div id='frm-editing-upload-league-excel_wrap'><input type="file" size="35" id="frm-editing-upload-league-excel" class="football-data-excel-file-import" name="file_excel"><span id="frm-editing-upload-league-excel_wrap_labels"></span></div>
					</div>
				</div>
				<div class="form-group">
					<div class="input-title">&nbsp;</div>
							<div class="input">
								<a class="btn btn-primary" style="color: #fff;" target="_blank" href="<?php echo URL_ADMIN.'/import/excel/check/demo_warehouses_check.xls';?>">Mẫu thêm mới</a>
							</div>
				</div>
			</div>
			<?php
			if($data-> style_import == 2) {		
				?>
				<div class="panel panel-default">
					<div class="panel-heading">Danh sách sản phẩm</div>
					<div class="panel-body">
						<div class="products_search_ajax_list">
							<table id="table_products_search_ajax_list_2" width="100%" bordercolor="#AAA" border="1" class="table table-hover table-striped table-bordered dataTables-example" style="margin-bottom: 0px;">
								<tr>
									<td width="3%">#</td>
									<td width="10%">Mã</td>
									<td width="20%">Sản phẩm</td>
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
										$pro = $model-> get_record('id = '.$product-> product_id,'fs_products','id,name,code');
										?>
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo $pro-> code; ?></td>
											<td><?php echo $pro-> name; ?><br>Ghi chú: <?php echo $product-> note; ?></td>
											<td><?php echo $product-> amount; ?></td>
											<td><?php echo $product-> amount_deliver; ?></td>
											<td><?php echo ($product-> amount - $product-> amount_deliver); ?></td>
											<td><?php echo $product-> amount_hold; ?></td>
											<td><?php echo $product-> reality; ?></td>
											<td><?php echo $product-> reality - ($product-> amount - $product-> amount_deliver); ?></td>
											<td><?php echo format_money($product-> price *($product-> reality - ($product-> amount - $product-> amount_deliver)),'đ','0đ' ); ?></td>
											<td>&nbsp;</td>
										</tr>
										<?php
									}
								}?>
							</table>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
</div>

<style>
	#table_products_search_ajax_list input{
		max-width: 100px;
		line-height: 32px !important;
		height: 32px !important;
		padding: 0 10px;
		float: left;
		border: 1px solid #ccc;
		border-radius: 3px;
	}
	#table_products_search_ajax_list select{
		max-width: 100px;
		line-height: 32px !important;
		height: 32px !important;
		/*padding: 0 10px;*/
		float: left;
		border: 1px solid #ccc;
		border-radius: 3px;
	}
</style>


<script>

	$('#discount_type').change(function(){
		update_all_products();
	})
	$('#discount').change(function(){
		update_all_products();
	})
	$('#typevat').change(function(){
		update_all_products();
	})
	$('#vat').change(function(){
		update_all_products();
	})

	$('#type_import').change(function(){
		type_import = $(this).val();
		$('.type_import').addClass('hide');
		$('.d_type_import_'+type_import).removeClass('hide');
	})

	$('#type').change(function(){
		type = $(this).val();
		$('.type').addClass('hide');
		$('.d_type_'+type).removeClass('hide');
	})

	$('#style_import').change(function(){
		style_import = $(this).val();
		$('.style_import').addClass('hide');
		$('#d_style_import_'+style_import).removeClass('hide');
	})

	update_stt();
	update_all_products();


	$('#products_search_keyword').keyup(function(){
		type_products_search = $('#type_products_search').val();
		products_search_keyword = $('#products_search_keyword').val();
		warehouses_id = $('#warehouses_id').val();
		$('.products_search_ajax_result').removeClass('hide');
		$.get("/<?php echo LINK_AMIN; ?>/index.php?module=warehouses&view=check&task=ajax_products_search_keyword&raw=1",
			{type_products_search:type_products_search,products_search_keyword:products_search_keyword,warehouses_id:warehouses_id}, 
			function(html){
				$('.products_search_ajax_result').html(html);
			});
	})

	function set_products(id){

		amount = $('#data_product_amount_'+id).val();
		amount_deliver = $('#data_product_amount_deliver_'+id).val();
		amount_hold = $('#data_product_amount_hold_'+id).val();
		amount_on = amount - amount_deliver;

		name = $('#data_product_name_'+id).val();
		price = $('#data_product_price_'+id).val();

				// alert(price);
				price = price.split(".").join("");
				price_name = $('#data_product_price_name_'+id).val();

				if(!$('#products_item_selected_'+id).length) {
					html = '<tr class="products_item_selected" id="products_item_selected_'+id+'">';
					html += '<td><span class="products_stt"></span></td>';
					html += '<td><span class="item_title">'+name+'<br><input type="hidden" name="ajax_products[]" value="'+id+'" /><input style="max-width:200px" type="text" name="ajax_products_note_'+id+'" id="ajax_products_note_'+id+'"  value="" placeholder="Ghi chú" /><input type="hidden" name="ajax_products_price_'+id+'" id="ajax_products_price_'+id+'"  value="'+price+'" /></span></td>';
					html += '<td><span>'+amount+'</span><input type="hidden" name="ajax_products_amount_'+id+'" id="ajax_products_amount_'+id+'" value="'+amount+'" /></td>';
					html += '<td><span>'+amount_deliver+'</span><input type="hidden" name="ajax_products_amount_deliver_'+id+'" id="ajax_products_amount_deliver_'+id+'" value="'+amount_deliver+'" /></td>';
					html += '<td><span>'+amount_on+'</span><input type="hidden" name="ajax_products_amount_on_'+id+'" id="ajax_products_amount_on_'+id+'" value="'+amount_on+'" /></td>';
					html += '<td><span>'+amount_hold+'</span></td>';
					html += '<td><input type="number" name="ajax_products_reality_'+id+'" id="ajax_products_reality_'+id+'" onkeyup="ajax_products_update('+id+')" value="1" /></td>';
					html += '<td><span id="diff_amount_'+id+'">'+(1 - amount_on)+'</span></td>';
					html += '<td><span id="diff_price_'+id+'">'+format_money(((1 - amount_on)*parseInt(price)),'đ')+'</span></td>';

					html += '<td><a href="javascript:void(0)" onclick="remove_ajax_products('+id+')">Xóa</a></td>';
					html += '</tr>';
					$('#table_products_search_ajax_list').append(html);
				}

				$('.products_search_ajax_result').addClass('hide');

				update_stt();
				// update_all_products();

			}

			function ajax_products_update(id){

				reality = $('#ajax_products_reality_'+id).val();
				amount = $('#ajax_products_amount_'+id).val();
				price = $('#ajax_products_price_'+id).val();
				price = price.split(".").join("");

		// alert(price);

		amount_on = $('#ajax_products_amount_on_'+id).val();

		diff = reality - amount_on;
		diff_price = diff*price;

		// alert(reality);
		// alert(amount_on);

		$('#diff_amount_'+id).text(diff);
		$('#diff_price_'+id).text(format_money(diff_price,'đ'));

	}

	function update_all_products(){

		total_amount = 0;
		total_price = 0;
		total_price_after = 0;
		total_discount = 0;
		total_weight = 0;

		$(".products_item_selected").each(function( index ) {
			id_items = $(this).attr('id');
			id= id_items.replace('products_item_selected_','');

			amount = $('#ajax_products_amount_'+id).val();
			price = $('#ajax_products_price_'+id).val();
			price = price.split(".").join("");
			typediscount = $('#ajax_products_typediscount_'+id).val();
			discount = $('#ajax_products_discount_'+id).val();
			weight = $('#ajax_products_weight_'+id).val();

			total_amount += parseInt(amount);
			total_price += parseInt(price)*parseInt(amount);
			total_weight += parseInt(weight)*parseInt(amount);

			if(discount) {
				if(typediscount == 1) {
					total_discount += parseInt(discount);
				} else {
					total_discount += parseInt(discount)*parseInt(price)*parseInt(amount)/100;
				}
			}
		})


		total_price_after = total_price - total_discount;

		discount_bill = $('#discount').val();
		if(discount_bill) {
			typediscount_bill = $('#discount_type').val();
			if(typediscount_bill == 1) {
				discount_bill = discount_bill;
			} else {
				discount_bill = total_price_after*discount_bill/100;
			}
		} else {
			discount_bill = 0;
		}

		vat_bill = $('#vat').val();
		if(vat_bill) {
			typevat_bill = $('#typevat').val();
			if(typevat_bill == 1) {
				vat_bill = vat_bill;
			} else {
				vat_bill = total_price_after*vat_bill/100;
			}
		} else {
			vat_bill = 0;
		}

		pay_bill = total_price_after - discount_bill + vat_bill;

		pay_bill = format_money(pay_bill,'đ');
		discount_bill = format_money(discount_bill,'đ');
		vat_bill = format_money(vat_bill,'đ');

		total_price = format_money(total_price,'đ');
		total_discount = format_money(total_discount,'đ');
		total_price_after = format_money(total_price_after,'đ');
		total_weight = format_money(total_weight,'');


		$('.total_amount').text(total_amount);
		$('.total_price').text(total_price);
		$('.total_discount').text(total_discount);
		$('.total_weight').text(total_weight);
		$('.total_price_after').text(total_price_after);

		$('.discount_bill').text(discount_bill);
		$('.vat_bill').text(vat_bill);
		$('.pay_bill').text(pay_bill);

	}

	function format_money(price,dv){
		if(parseInt(price) > 0) {
			var price = price.toString();
			var format_money = "";
			while (parseInt(price) > 999) {
				format_money = "." + price.slice(-3) + format_money;
				price = price.slice(0, -3);
			} 
			result = price + format_money + dv;
		} else {
			var price = (0 - price).toString();
			var format_money = "";
			while (parseInt(price) > 999) {
				format_money = "." + price.slice(-3) + format_money;
				price = price.slice(0, -3);
			} 
			result = '-' +price + format_money + dv;
		}


		return result;
	}

	function remove_ajax_products(id){
		$('#products_item_selected_'+id).remove();
		update_stt();
	}

	function update_stt(){
		i = 1;
		$(".products_stt").each(function( index ) {
			$( this ).text(i);
			i++;
		})
	}
</script>