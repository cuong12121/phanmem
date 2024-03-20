<?php 
	// printr($_COOKIE['cart']);
?>

<?php if(isset($_COOKIE['cart']) AND !empty($product_list)) { ?>

<div class='shopcart_product'>
	<form action="#" method="post" name="shopcart" >
		<div class="table-wrap">
		<?php
		$i = 0; 
		$id_last = 0;
		$total = 0;
		$quantity = 0;
		$cat_id_last = 0;
		$total_price_extent = 0;
		
		if($product_list) {
		?>
		<div class="row-table">
			<div class="col-td">Hình ảnh</div>
			<div class="col-td">Tên sản phẩm</div>
			<div class="col-td">Số lượng</div>
			<div class="col-td">Đơn giá</div>
			<div class="col-td">Tổng cộng</div>
		</div>

		<?php
			foreach ($product_list as $prd) {
				$i++;
				$product = $this -> getProductById($prd['product_id']);
				if(!$product){
					continue;
				}
				$prd_name = $product -> name;
				if(@$prd['id_combo']) {
					$combo = $this -> getComboById($prd['id_combo']);
				} else {
					$combo = '';
				}

				$id_last = $prd['product_id'];

				$cat_id_last = $product -> category_id;

				//Thêm giá khác
				$arr_info_extent = array();
				$arr_extend_item = array();
				$string_info_extent = '';
				$arr_extend_item = array();
				
				$total_price_extent=0;

				// echo $prd['box_extend_string'];
				// print_r($arr_info_extent);

				if(!empty($prd['box_extend_string'])){
					$arr_extend_item = explode(',',$prd['box_extend_string']);
					foreach ($arr_extend_item as $extend_item_val ){
						// echo $extend_item_val;
						if($extend_item_val != 0 AND !empty($extend_item_val)){
							$extend_item = $model -> get_record_by_id($extend_item_val,'fs_products_price_extend');
							
							// echo "<pre>";
							
							$arr_info_extent[] = $extend_item-> extend_name . ": +" . format_money($extend_item-> price);
							$total_price_extent  += $extend_item-> price; 
						}
					}
				}
				
				if(!empty($arr_info_extent)){
					$string_info_extent =  implode(' ; ',$arr_info_extent);
				}

				// echo $string_info_extent ;
				// die;

				// Tính thêm giá màu

				$price_color = 0;
				$color_name = "";
				$color_id ="";

				if($prd['color_id'] !=0){

					$data_price_color =  $model -> get_record('id = ' . $prd['color_id'] . ' AND record_id = ' . $product->id,'fs_products_price');
					if(!empty($data_price_color)){
						$price_color  = (int)$data_price_color-> price;
						$color_name =  "Màu " . $data_price_color-> color_name;
						$color_id =  $data_price_color-> id;
					}
				}
				// echo  $total_price_extent;
				$total +=  ($price_color + $total_price_extent + $prd['price'] ) * $prd['quantity'];

				// $total +=  $prd['price']* $prd['quantity'];

				$quantity += $prd['quantity'];

				// $link_del_prd = FSRoute::_('index.php?module=products&view=cart&task=edel&id='.$prd['product_id'].'&box_extend_string='.@$prd['box_extend_string'].'&color_id='.@$prd['color_id'].'&Itemid=65');
				$link_del_prd =FSRoute::_('index.php?module=products&view=cart&task=edel&id='.$prd['product_id'].'&sid='.base64_encode(@$prd['sid']).'&id_combo='.@$prd['id_combo'].'&parent_product='.@$prd['parent_product'].'&Itemid=65');
				$link_detail_prd =FSRoute::_('index.php?module=products&view=product&code='.$product->alias.'&ccode='.$product -> category_alias.'&id='.$product->id.'&Itemid=6');
				?>	


				<div class="row-table">
					<div class="col-td">
						<a href="<?php echo $link_detail_prd; ?>" > 
							<?php if($product -> image){ ?>
								<?php $image_small = URL_ROOT.str_replace('/original/', '/resized/', $product->image); ?>
								<img width="120px" src="<?php echo $image_small; ?>" alt="<?php echo htmlspecialchars ($product -> name); ?>"  />
							<?php } else {?>
								<img width="120px" src="<?php echo URL_ROOT.'images/no-img.gif'; ?>" alt="<?php echo htmlspecialchars ($product -> name); ?>" />
							<?php }?>	 
						</a> 
					</div>

					<div class="col-td">
						<a class="name-item" title="<?php  echo $prd_name ?>" href="<?php echo $link_detail_prd; ?>" > <?php  echo $prd_name ?> <?php echo @$prd['unit']? ' ('.@$prd['unit'].')':'';  ?><?php if(@$combo-> name) echo '(<strong>'.$combo-> name.'</strong>)'; ?> <?php if(@$prd['parent_product'] && @$prd['parent_product'] != $prd['product_id']){ echo '(<strong>Mua kèm</strong>)';}?> </a>
						<?php if(!@$prd['is_gift']){?>
							<a href="<?php echo $link_del_prd; ?>" title="Xóa" class="del-item">
								x
							</a>
						<?php } ?>
						<div>

							<?php
								if(!empty($string_info_extent)){ 
									echo "Giá SP: " . format_money($prd['price']). " , " . $string_info_extent;
								}else{
									echo "Giá SP: " . format_money($prd['price']);
								}
							?>

							<?php 
								if(isset($data_price_color) && !empty($data_price_color) && $prd['color_id'] !=0){
									echo ' ,' .$color_name . ':' .format_money($price_color);
								}
							?>	
						</div>
					</div>

					<div class="col-td col-td-number">
						<span class="btn-minus" onclick="load_ajax_cart('<?php echo @$prd['sid'] ?>','minus')">-</span>
						<input onkeyup ="onchange_number('<?php echo @$prd['sid'] ?>')" <?php if((@($prd['parent_product']) && @$prd['parent_product'] != $prd['product_id']) || @$prd['id_combo']) echo 'readonly'; ?> class="numbers-pro  <?php if((@($prd['parent_product']) && @$prd['parent_product'] != $prd['product_id']) || @$prd['is_combo']) echo 'creadonly'; ?>" type="text" min="0" max="1000"  value="<?php echo $prd['quantity']?>"  name="<?php echo 'quantity_'.@$prd['sid']; ?>" size="8px" id="<?php echo 'quantity_'.@$prd['sid']; ?>"/>
						<span class="btn-plus" onclick="load_ajax_cart('<?php echo @$prd['sid'] ?>','plus')">+</span>
					</div>

					<div class="col-td">

						<div class="price_product">
							<?php if(!@$prd['is_gift']){?>
							<span class="price"><?php  echo format_money($prd['price']); ?></span>
							<?php if($prd['price_old']){?>
								<span class="price_old"><?php  echo format_money($prd['price_old']); ?></span>
							<?php }?>
							<?php }else{?>
								<span class="price"><?php  echo '0 đ (Quà tặng)'; ?></span>
							<?php }?>
						</div>
						
					</div>
					<div class="col-td">
						<div class="price">
							<?php if(!@$prd['is_gift']){?>
								<?php echo format_money(($price_color + $total_price_extent + $prd['price'] ) * $prd['quantity']); ?>
							<?php }else{?>
								<div class="price"><?php  echo '0 đ (Quà tặng)'; ?></div>
							<?php }?>
							
						</div>
					</div>
				</div>

				<!-- Quà tặng -->

				<?php 
					$products_list_gift = $model->get_products_list_gift($product);
					if(!empty($products_list_gift)){
						foreach ($products_list_gift as $gift_item) {
						
				?>
					<div class="row-table">
						<div class="col-td">
							<a href="javascript:void(0)" > 
								<?php if($gift_item -> image){ ?>
									<?php $image_small = URL_ROOT.str_replace('/original/', '/resized/', $gift_item->image); ?>
									<img width="120px" src="<?php echo $image_small; ?>" alt="<?php echo htmlspecialchars ($product -> name); ?>"  />
								<?php } else {?>
									<img width="120px" src="<?php echo URL_ROOT.'images/no-img.gif'; ?>" alt="<?php echo htmlspecialchars ($product -> name); ?>" />
								<?php }?>	 
							</a> 
						</div>

						<div class="col-td">
							<?php echo $gift_item->name ?>
							
							
						</div>

						<div class="col-td col-td-number" style="text-align: center;">
							<span><?php echo $prd['quantity'] ?></span>
						</div>

						<div class="col-td">
							<div class="price_product">
								<span class="price"><?php  echo '0đ (Quà tặng)'; ?></span>
							</div>
						</div>
						<div class="col-td">
							<div class="price">
								<div class="price"><?php  echo '0đ (Quà tặng)'; ?></div>
							</div>
						</div>
					</div>


				<?php } }?>

				<!-- END Quà tặng -->

		<?php 
			}

		}
		$cat_last = $this -> getProductCategoryById($cat_id_last);
		if($cat_last)
			$link_continue_buy = FSRoute::_('index.php?module=products&view=cat&ccode='.$cat_last->alias.'&cid='.$cat_last->id.'&Itemid=4');
		$link_del_all =FSRoute::_('index.php?module=products&view=cart&task=del_all&Itemid=65');
		$link_order = '#';
		?>		  
				
		</div>

		<div class="all-button-cart cls">
			<?php if($cat_last){?>
				<input class="button-cart" type="button" name="next_step" id="sub-next-buy" onclick="javascript:window.location = '<?php echo $link_continue_buy; ?>'" value="<?php echo FSText::_('Tiếp tục mua hàng'); ?>"/>
			<?php }?>
			<input class="button-cart" type="button" name="remove"  value="Xóa tất cả" onclick="javascript:window.location = '<?php echo $link_del_all; ?>'"/>
		</div>
		
		<input type="hidden" value="<?php echo $total; ?>" id="price_total">
		<div class="clearfix"></div>			
		<input type="hidden" name='Itemid' value="<?php echo $Itemid; ?>" />
		<input type="hidden" name='module' value="products" />
		<input type="hidden" name='view' value="cart" />
		<input type="hidden" name='task' value="recal" id = 'task'/>
	</form>
</div>

<div class="payment-type-title">Hình thức thanh toán</div>
<div class="payment-type">
	<label class="container-rd">Thanh toán tiền mặt khi nhận hàng (COD)
	  <input onclick="pay_mothod(0)" type="radio" checked="checked" name="radio" value="1">
	  <span class="checkmark"></span>
	</label>
	<label class="container-rd">Thanh toán qua số tài khoản ngân hàng
	  <input onclick="pay_mothod(2)" type="radio" name="radio"  value="2">
	  <span class="checkmark"></span>
	</label>
	<!-- danh sách STK ngân hàng -->
    <?php if(!empty($list_bankings)){ ?>
	    <div class="list_bankings cls">
	    	<?php foreach ($list_bankings as $banking){ ?>
	    		<div class="item">
	    			<div class="name">Tên: <?php echo $banking->name ?> </div>
	    			<div class="branch">Chi nhánh: <?php echo $banking->branch ?></div>
	    			<div class="account">Số tài khoản: <?php echo $banking->account ?></div>
	    			<div class="account_name">Chủ tài khoản: <?php echo $banking->account_name ?></div>
	    		</div>
	    	<?php } ?>
	    </div>
	<?php } ?>
	<!-- end danh sách STK ngân hàng -->
	<label class="container-rd">Thanh toán bằng VNPAY
	  <input onclick="pay_mothod(1)" type="radio" name="radio"  value="1">
	  <span class="checkmark"></span>
	</label>
	
	

	<!-- <div class="bank-code-wrap cls">
        <label for="bank_code">Ngân hàng</label>
        <select name="bank_code" id="bank_code" class="form-control">
            <option value="">Không chọn</option>
            <option value="NCB"> Ngân hàng NCB</option>
            <option value="AGRIBANK"> Ngân hàng Agribank</option>
            <option value="SCB"> Ngân hàng SCB</option>
            <option value="SACOMBANK">Ngân hàng SacomBank</option>
            <option value="EXIMBANK"> Ngân hàng EximBank</option>
            <option value="MSBANK"> Ngân hàng MSBANK</option>
            <option value="NAMABANK"> Ngân hàng NamABank</option>
            <option value="VNMART"> Vi dien tu VnMart</option>
            <option value="VIETINBANK">Ngân hàng Vietinbank</option>
            <option value="VIETCOMBANK"> Ngân hàng VCB</option>
            <option value="HDBANK">Ngân hàng HDBank</option>
            <option value="DONGABANK"> Ngân hàng Dong A</option>
            <option value="TPBANK"> Ngân hàng TPBank</option>
            <option value="OJB"> Ngân hàng OceanBank</option>
            <option value="BIDV"> Ngân hàng BIDV</option>
            <option value="TECHCOMBANK"> Ngân hàng Techcombank</option>
            <option value="VPBANK"> Ngân hàng VPBank</option>
            <option value="MBBANK"> Ngân hàng MBBank</option>
            <option value="ACB"> Ngân hàng ACB</option>
            <option value="OCB"> Ngân hàng OCB</option>
            <option value="IVB"> Ngân hàng IVB</option>
            <option value="VISA"> Thanh toan qua VISA/MASTER</option>
        </select>
    </div>
 -->
    
    


</div>



<div class="total-card-code cls">
	<div class="card_code cls">
		<div class="text">Nhập mã phiếu giảm giá của bạn nếu có</div>
		<input type="text" name="card_code" id="card_code" value="<?php echo @$card_code; ?>" class="input_text" size="30" <?php echo @$disable_card?'disabled="disabled"':''; ?> />
		<?php if(!@$disable_card){ ?>
			<button type="button" onclick="myFunction_code();" class="resubmit_form"><?php echo FSText::_('Áp dụng'); ?></button>
		<?php } ?>
	</div>

	<div class="ship-total" >
		<div class="total-mn cls">
			<font><?php echo FSText::_('Thành tiền');?>: </font>
			<span class="price_tongcong"><?php echo format_money(($total - @$total_discount_by_cardcode));?></span>
			<!-- <input type="hidden" id="price_tongcong" value="<?php //echo $total - @$total_discount_by_cardcode; ?>"> -->
		</div>


		<div class="cart-code-mn cls">
			<font><?php echo FSText::_('Mã giảm giá');?>: </font>
			<span class="price-cart-code">0₫</span>
		</div>

		<div class="ship-mn cls">
			<font><?php echo FSText::_('Phí vân chuyển');?>: </font>
			<span class="price_ship">Chúng tôi sẽ liên hệ với bạn sau.</span>

			<!-- <input type="hidden" id="price_ship" value="<?php //echo @$city_user-> price_ship; ?>"> -->
		</div>
		
		

		<div class="total-price-inner cls">
			<font><?php echo FSText::_('Tổng cộng');?>: </font>
			<span class="price_thanhtoan"><?php echo format_money(($total - @$total_discount_by_cardcode + @$city_user-> price_ship));?></span>
		</div>

	</div>

</div>

<?php }else{
	echo '<p>'.FSText::_('Giỏ hàng đang chưa có sản phẩm nào').'</p>';
} ?>



		<script type="text/javascript">
			function myFunction_code() {
				$('.label_error').prev().remove();
				$('.label_error').remove();
		// alert('aaaa');
		// $("#modal_alert1").addClass('hide');
		// if(!notEmpty("card_code","Bạn phải nhập mã giảm giá"))
		// 	return false;
		var code_share = <?php echo json_encode(@$sale->code); ?>;
		var type_coupon = <?php echo json_encode(@$sale->type_sale); ?>;
		var money_dow = <?php echo json_encode(@$sale->money_dow); ?>;
		var code_input = $('#card_code').val();
		var total_noshipping = $('#price_total').val();
		// alert(total_noshipping);
		var input_code_share  = $('#card_code').val();
		var num_dow=$('#price_send').val();
		var heso_savepoint = $('#heso_savepoint').val();
		$.ajax({
			type: "POST",
			url: "/index.php?module=products&view=cart&task=check_code&raw=1&code_input="+code_input+"&total_noshipping="+total_noshipping,
			data: {code_input:code_input,total_noshipping:total_noshipping},
			dataType: 'json',
			success: function(data) {
				if(data.error == false && data.type_down){
					if(data.type_down == 1) {
						text_price_chietkhau = data.price_send+ '%';
					} else {
						text_price_chietkhau = data.price_send+ 'đ';
					}
					save_point = Math.round(heso_savepoint*data.val_total_code);
					// $('.point_save').html(save_point+' điểm');
					// $('.price_tongcong').html(data.total_code);
					if(text_price_chietkhau){
						$('.price_chietkhau').html('<span class="code_sale">Giảm giá: </span>'+'Mã giảm giá '+text_price_chietkhau);
					}
					
					$('#price_send_h').val(data.price_send);

					let money_sale=parseInt(data.total_down);
					var money_s = money_sale.toString();
					// console.log(money_s)

					var format_money2 = "";
					while (parseInt(money_s) > 999) {
						format_money2 = "." + money_s.slice(-3) + format_money2;
						money_s = money_s.slice(0, -3);
					} 
					result2 = money_s + format_money2 + 'đ';
					if(result2){
						$('.price-cart-code').html("-"+result2);
					}
					
					// console.log(data.total_down);
					$('#code_card_send_h').val(data.code_card_send);
					$('#type_down_h').val(data.type_down);
					$('#price_tongcong').val(data.total_value);

					// alert(vc)

					
					var price_tongcong = data.total_value;
					// var price_ship = $('#price_ship').val();
					var price_thanhtoan = price_tongcong;
					var price_thanhtoan = price_thanhtoan.toString();
					var format_money = "";
					while (parseInt(price_thanhtoan) > 999) {
						format_money = "." + price_thanhtoan.slice(-3) + format_money;
						price_thanhtoan = price_thanhtoan.slice(0, -3);
					} 
					result = price_thanhtoan + format_money + 'đ';
					$('.price_thanhtoan').text(result);
					if(result){
						$('#total_after .right_price .price').text(result);
					}
					
				} else {
					$('.price_chietkhau').html('');
					$('.price-cart-code').html("");

					var price_tongcong = data.total_value;
					// var price_ship = $('#price_ship').val();
					var price_thanhtoan = price_tongcong;
					var price_thanhtoan = price_thanhtoan.toString();
					var format_money = "";
					while (parseInt(price_thanhtoan) > 999) {
						format_money = "." + price_thanhtoan.slice(-3) + format_money;
						price_thanhtoan = price_thanhtoan.slice(0, -3);
					} 
					result = price_thanhtoan + format_money + 'đ';
					$('.price_thanhtoan').text(result);
					if(result){
						$('#total_after .right_price .price').text(result);
					}
					// $('#total_after .right_price .price').text("");
					 // $("#modal_alert1").removeClass('hide');
					 
					 $("#modal_alert1").show();
					 $("#modal_alert1 .modal_alert_body").html(data.error2);
					}
				}
			});
	}

</script>