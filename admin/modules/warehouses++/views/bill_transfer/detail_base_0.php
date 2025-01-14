<div class="col-12 col-md-6" style="margin-top: 20px;">
	<div class="panel panel-default">
		<div class="panel-heading">Kho hàng</div>
		<div class="panel-body">
			<?php

			$arr_status = $this->  arr_status1;
			$arr_style_import = $this->  arr_style_import;

			TemplateHelper::dt_edit_selectbox(FSText::_('Từ Kho hàng'),'warehouses_id',@$data -> warehouses_id,0,$warehouses,$field_value = 'id', $field_label='name',$size = 1,0);

			TemplateHelper::dt_edit_selectbox(FSText::_('Chuyển tới Kho hàng'),'to_warehouses_id',@$data -> to_warehouses_id,0,$warehouses,$field_value = 'id', $field_label='name',$size = 1,0);
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

			TemplateHelper::dt_edit_selectbox('Tình trạng','status',@$data -> status,0,$arr_status, $field_value = '', $field_label='');

			TemplateHelper::dt_edit_selectbox('Kiểu nhập','style_import',@$data -> style_import,0,$arr_style_import, $field_value = '', $field_label='');
			?>
		</div>
	</div>
</div>

<div class="col-12 col-md-12">
	<div class="style_import <?php if($data-> style_import == 2) echo 'hide'; ?>" id="d_style_import_1">
		<div class="panel panel-default">
			<div class="panel-heading">Danh sách sản phẩm</div>
			<div class="panel-body">
				<div class="products_search_ajax">
					<div class="form-group ">
						<select name="type_products_search" id="type_products_search" class="form-control products_search_keyword">
							<option value="1">Sản phẩm</option>
						</select>
						<input type="text" class="form-control products_search_keyword" name="products_search_keyword" id="products_search_keyword" placeholder="Nhập tên, mã sản phẩm" autocomplete="off">
					</div>
					<div class="products_search_ajax_result hide"></div>
				</div>

				<div class="products_search_ajax_list">
					<table id="table_products_search_ajax_list" width="100%" bordercolor="#AAA" border="1" class="table table-hover table-striped table-bordered dataTables-example" style="margin-bottom: 0px;">
						<tr>
							<td width="3%">#</td>
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
								$pro = $model-> get_record('id = '.$product-> product_id,'fs_products','id,name');
								
								$pro_amount = $model-> get_record('product_id = '.$product-> product_id.' AND warehouses_id = '.$data-> warehouses_id,'fs_warehouses_products','amount');
								?>
								<tr class="products_item_selected" id="products_item_selected_<?php echo $pro-> id; ?>">
									<td><span class="products_stt"><?php echo $i; ?></span></td>
									<td><span class="item_title"><?php echo $pro-> name; ?><input type="hidden" name="ajax_products[]" value="<?php echo $pro-> id; ?>"></span></td>
									<td><span><?php echo $pro_amount-> amount?$pro_amount-> amount:'0'; ?></span></td><td><span class="item_title"><input type="number" name="ajax_products_amount_<?php echo $pro-> id; ?>" onchange="ajax_products_update(<?php echo $pro-> id; ?>)" id="ajax_products_amount_<?php echo $pro-> id; ?>" value="<?php echo $product-> amount; ?>"></span></td>
									<!-- <td><input type="text" name="ajax_products_price_<?php echo $pro-> id; ?>" id="ajax_products_price_<?php echo $pro-> id; ?>" onchange="ajax_products_update(<?php echo $pro-> id; ?>)" value="<?php echo format_money($product-> price,'','0'); ?>"></td> -->
									<!-- <td><span id="ajax_products_pricename_<?php echo $pro-> id; ?>"><?php echo format_money($product-> price*$product-> amount,'đ','0đ'); ?></span></td> -->
									<!-- <td><select style="max-width:40px" id="ajax_products_typediscount_<?php echo $pro-> id; ?>" name="ajax_products_typediscount_<?php echo $pro-> id; ?>" onchange="ajax_products_update(<?php echo $pro-> id; ?>)"> -->
<!-- 										<option value="1">$</option>
										<option value="2" <?php if($product-> typediscount == 2)  echo 'selected';?>>%</option>
									</select> -->
									<!-- <input type="text" style="max-width:90px" name="ajax_products_discount_<?php echo $pro-> id; ?>" id="ajax_products_discount_<?php echo $pro-> id; ?>" onchange="ajax_products_update(<?php echo $pro-> id; ?>)" value="<?php echo $product-> discount; ?>"></td> -->
									<!-- <td><input type="text" name="ajax_products_weight_<?php echo $pro-> id; ?>" id="ajax_products_weight_<?php echo $pro-> id; ?>" onchange="ajax_products_update(<?php echo $pro-> id; ?>)" value="<?php echo $product-> weight; ?>"></td> -->
									<!-- <td><input type="text" name="ajax_products_link_<?php echo $pro-> id; ?>" id="ajax_products_link_<?php echo $pro-> id; ?>" value="<?php echo $product-> link; ?>"></td> -->
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
							<a class="btn btn-primary" style="color: #fff;" target="_blank" href="<?php echo URL_ADMIN.'/import/excel/bill_transfer/demo_warehouses_bill_transfer.xls';?>">Mẫu thêm mới</a>
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
											$pro = $model-> get_record('id = '.$product-> product_id,'fs_products','id,name');
											$pro_amount = $model-> get_record('product_id = '.$product-> product_id.' AND warehouses_id = '.$data-> warehouses_id,'fs_warehouses_products','amount');
											?>
											<tr>
												<td><?php echo $i; ?></td>
												<td><?php echo $pro-> name; ?></td>
												<td><?php echo @$pro_amount-> amount; ?></td>
												<td><?php echo $product-> amount; ?></td>
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
		$.get("/<?php echo LINK_AMIN; ?>/index.php?module=warehouses&view=bill&task=ajax_products_search_keyword&raw=1",
			{type_products_search:type_products_search,products_search_keyword:products_search_keyword,warehouses_id:warehouses_id}, 
			function(html){
				$('.products_search_ajax_result').html(html);
			});
	})

	function set_products(id){

		amount = $('#data_product_amount_'+id).val();
		name = $('#data_product_name_'+id).val();
		price = $('#data_product_price_'+id).val();
		price_name = $('#data_product_price_name_'+id).val();
		weight = $('#data_product_weight_'+id).val();
		if(!weight) {
			weight = 0;
		}

		if(!$('#products_item_selected_'+id).length) {
			html = '<tr class="products_item_selected" id="products_item_selected_'+id+'">';
			html += '<td><span class="products_stt"></span></td>';
			html += '<td><span class="item_title">'+name+'<input type="hidden" name="ajax_products[]" value="'+id+'" /></span></td>';
			html += '<td><span>'+amount+'</span></td>';
			html += '<td><span class="item_title"><input type="number" name="ajax_products_amount_'+id+'" onchange="ajax_products_update('+id+')" id="ajax_products_amount_'+id+'" value="1" /></span></td>';
			html += '<td><input type="text" name="ajax_products_price_'+id+'" id="ajax_products_price_'+id+'" onchange="ajax_products_update('+id+')"  value="'+price+'" /></td>';
			html += '<td><span id="ajax_products_pricename_'+id+'">'+price_name+'</span></td>';
			html += '<td><select style="max-width:40px" id="ajax_products_typediscount_'+id+'" name="ajax_products_typediscount_'+id+'" onchange="ajax_products_update('+id+')"><option value="1">$</option><option value="2">%</option></select><input type="text" style="max-width:90px" name="ajax_products_discount_'+id+'" id="ajax_products_discount_'+id+'" onchange="ajax_products_update('+id+')" value="" /></td>';
			html += '<td><input type="text" name="ajax_products_weight_'+id+'" id="ajax_products_weight_'+id+'" onchange="ajax_products_update('+id+')" value="'+weight+'" /></td>';
			html += '<td><input type="text" name="ajax_products_link_'+id+'" id="ajax_products_link_'+id+'" /></td>';
			html += '<td><a href="javascript:void(0)" onclick="remove_ajax_products('+id+')">Xóa</a></td>';
			html += '</tr>';
			$('#table_products_search_ajax_list').append(html);
		}

		$('.products_search_ajax_result').addClass('hide');

		update_stt();
		update_all_products();

	}

	function ajax_products_update(id){

		amount = $('#ajax_products_amount_'+id).val();
		price = $('#ajax_products_price_'+id).val();
		price = price.split(".").join("");
		typediscount = $('#ajax_products_typediscount_'+id).val();
		discount = $('#ajax_products_discount_'+id).val();
		weight = $('#ajax_products_weight_'+id).val();

		total_price = price*amount;

		total_price = format_money(total_price,'đ');

		$('#ajax_products_pricename_'+id).text(total_price);

		update_all_products();

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
		var price = price.toString();
		var format_money = "";
		while (parseInt(price) > 999) {
			format_money = "." + price.slice(-3) + format_money;
			price = price.slice(0, -3);
		} 
		result = price + format_money + dv;
		return result;
	}

	function remove_ajax_products(id){
		$('#products_item_selected_'+id).remove();
		update_stt();
		update_all_products();
	}

	function update_stt(){
		i = 1;
		$(".products_stt").each(function( index ) {
			$( this ).text(i);
			i++;
		})
	}
</script>