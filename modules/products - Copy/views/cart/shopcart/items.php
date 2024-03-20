<?php 
	global $tmpl,$config;
	// printr($product_list);
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
		$ship_HL = 0;
		$price_ship = 0;
		$total_kg = 0;
		$km_ship = '';
		$check_set_kg = 1; // đã nhâp trọng lượng trong admin 1 là ok 0 là chưa
		if($product_list) {
		?>
	
		<?php
			foreach ($product_list as $prd) {
				$i++;
				$product = $this -> getProductById($prd['product_id']);
				if(!$product){
					continue;
				}

				//Check đơn vị vận chuyển có phải Hải Linh Ko
				$cat_product = $model-> get_record('id = ' . $product-> category_id,'fs_products_categories','hai_linh_ship');
				//$cat_product->hai_linh_ship;
				if ($cat_product->hai_linh_ship == 1) {
				    $ship_HL = 1;
				}
				
				if(!empty($product-> manufactory) && !empty($product->category_id) ){
					$cat_kilogam = $model->get_record('category_id = '.$product->category_id . ' AND manufactory_id = '. $product-> manufactory,'fs_products_categories_kilogam','kilogam');
				}
				
				if(!empty($cat_kilogam)){
					$total_kg += $prd['quantity'] * $cat_kilogam->kilogam;
				}else{
					$check_set_kg = 0; // chưa nhập trọng lượng
				}

				/////////


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
				$total_item = 0;

				// echo $prd['box_extend_string'];
				// print_r($arr_info_extent);

				if(!empty($prd['box_extend_string'])){
					$arr_extend_item = explode(',',$prd['box_extend_string']);
					foreach ($arr_extend_item as $extend_item_val ){
						// echo $extend_item_val;
						if($extend_item_val != 0 AND !empty($extend_item_val)){
							$extend_item = $model -> get_record_by_id($extend_item_val,'fs_products_price_extend');
							
							// echo "<pre>";
							
							$arr_info_extent[] = $extend_item-> extend_name . ": +" . format_money($extend_item-> price,'₫','0₫');
							$total_price_extent  += (float)$extend_item-> price; 
						}
					}
				}
				
				if(!empty($arr_info_extent)){
					$string_info_extent =  implode(' ; ',$arr_info_extent);
				}

			

				// Tính thêm giá màu
				$price_color = 0;
				$color_name = "";
				$color_id ="";
				$image_color = '';
				if($prd['color_id'] && $prd['color_id'] !=0){
					$data_price_color =  $model -> get_record('id = ' . $prd['color_id'] . ' AND record_id = ' . $product->id,'fs_products_price');
					if(!empty($data_price_color)){
						$price_color  = (float)$data_price_color-> price;
						$color_name =  "Màu: " . $data_price_color-> color_name;
						$color_id =  $data_price_color-> id;
					}
					$data_color = $model-> get_record('id = ' . $prd['color_id'] ,'fs_products_price','color_id');
					if($data_color){
						$image_color =  $model -> get_record('color_id = ' .$data_color->color_id. ' AND record_id = ' . $product->id,'fs_products_images','image');
					}
				}



				// Tính thêm giá khu vực
				$price_region = 0;
				$region_name = "";
				$region_id = "";
			
				if($prd['region_id'] && $prd['region_id'] !=0){
					$data_price_region =  $model -> get_record('id = ' . $prd['region_id'] . ' AND record_id = ' . $product->id,'fs_products_regions_price');
					if(!empty($data_price_region)){
						$price_region  = (float)$data_price_region-> price;
						$region_name =  "Khu vực: " . $data_price_region-> region_name;
						$region_id =  $data_price_region-> id;
					}
				}


				// Tính thêm giá bảo hành
				$price_warranty = 0;
				$warranty_name = "";
				$warranty_id = "";
			
				if($prd['warranty_id'] && $prd['warranty_id'] !=0){
					$data_price_warranty =  $model -> get_record('id = ' . $prd['warranty_id'] . ' AND record_id = ' . $product->id,'fs_warranty_price');
					if(!empty($data_price_warranty)){
						$price_warranty  = (float)$data_price_warranty-> price;
						$warranty_name =  "Bảo hành: " . $data_price_warranty-> warranty_name;
						$warranty_id =  $data_price_warranty-> id;
					}
				}

				$total +=  ($price_warranty + $price_region + $price_color + $total_price_extent + $prd['price'] ) * $prd['quantity'];
				$total_item = ($price_warranty + $price_region + $price_color + $total_price_extent + $prd['price'] ) * $prd['quantity'];

				$quantity += $prd['quantity'];

				$link_del_prd =FSRoute::_('index.php?module=products&view=cart&task=edel&id='.$prd['product_id'].'&sid='.base64_encode(@$prd['sid']).'&id_combo='.@$prd['id_combo'].'&parent_product='.@$prd['parent_product'].'&Itemid=65&no_services='.@$prd['no_services']);
				$link_detail_prd =FSRoute::_('index.php?module=products&view=product&code='.$product->alias.'&ccode='.$product -> category_alias.'&id='.$product->id.'&Itemid=6');
				?>	


				<div class="row-table">
					<div class="col-td">
						<a href="<?php echo $link_detail_prd; ?>" > 
							<?php if($product -> image){ ?>
								<?php

									if(isset($image_color) && !empty($image_color->image) ){
										$image_small = URL_ROOT.str_replace('/original/', '/small/', $image_color->image);
									}else{
										$image_small = URL_ROOT.str_replace('/original/', '/small/', $product->image);
									} 
									
								?>
								<img width="120px" src="<?php echo $image_small; ?>" alt="<?php echo htmlspecialchars ($product -> name); ?>"  />
							<?php } else {?>
								<img width="120px" src="<?php echo URL_ROOT.'images/no-img.gif'; ?>" alt="<?php echo htmlspecialchars ($product -> name); ?>" />
							<?php }?>

							<a href="<?php echo $link_del_prd; ?>" title="Xóa" class="del-item">
								<?php echo $config['icon_bin'] ?>Xóa
							</a>
						</a> 
					</div>

					<div class="col-td">
						<a class="name-item" title="<?php  echo $prd_name ?>" href="<?php echo $link_detail_prd; ?>" > <?php  echo $prd_name ?> <?php echo @$prd['unit']? ' ('.@$prd['unit'].')':'';  ?><?php if(@$combo-> name) echo '(<strong>'.$combo-> name.'</strong>)'; ?> <?php if(@$prd['parent_product'] && @$prd['parent_product'] != $prd['product_id']){ echo '(<strong>Mua kèm</strong>)';}?> </a>
						
						<div class="string_info_extent">

							<?php
								if(!empty($string_info_extent)){ 
									echo "Giá sản phẩm: " . format_money($prd['price']). " , " . $string_info_extent;
								}else{
									echo "Giá sản phẩm: " . format_money($prd['price']);
								}
							?>

							<?php 
								if(isset($data_price_color) && !empty($data_price_color) && $prd['color_id'] !=0){
									if($price_color >=0){
										echo ' ,' .$color_name . ': +'.format_money($price_color,'₫','0₫');
									}else{
										echo ' ,' .$color_name . ': '.format_money($price_color,'₫','0₫');
									}
									
								}
							?>


							<?php 
								if(isset($data_price_region) && !empty($data_price_region) && $prd['region_id'] !=0){
									if($price_region >=0){
										echo ' ,' .$region_name . ': +'.format_money($price_region,'₫','0₫');
									}else{
										echo ' ,' .$region_name . ': '.format_money($price_region,'₫','0₫');
									}
									
								}
							?>

							<?php 
								if(isset($data_price_warranty) && !empty($data_price_warranty) && $prd['warranty_id'] !=0){
									if($price_warranty >=0){
										echo ' ,' .$warranty_name . ': +'.format_money($price_warranty,'₫','0₫');
									}else{
										echo ' ,' .$warranty_name . ': '.format_money($price_warranty,'₫','0₫');
									}
									
								}
							?>

						</div>
						<?php if(@$prd['no_services']){?>
							<div class="no_services">Mua online không dịch vụ</div>
						<?php } ?>
					</div>

					<div class="col-td col-td-number">
						<span class="price">
							<?php  echo format_money($total_item); ?>	
						</span>

						<?php if(@!$prd['parent_product'] && @!$prd['parent_product'] != !$prd['product_id']){ ?>
						<span class="btn-minus" onclick="load_ajax_cart('<?php echo @$prd['sid'] ?>','minus')">-</span>
						<?php } ?>

						<?php if(@!$prd['parent_product'] && @!$prd['parent_product'] != !$prd['product_id']){ ?>

						<input onkeyup ="onchange_number('<?php echo @$prd['sid'] ?>')" <?php if((@($prd['parent_product']) && @$prd['parent_product'] != $prd['product_id']) || @$prd['id_combo']) echo 'readonly'; ?> class="numbers-pro  <?php if((@($prd['parent_product']) && @$prd['parent_product'] != $prd['product_id']) || @$prd['is_combo']) echo 'creadonly'; ?>" type="text" min="0" max="1000"  value="<?php echo $prd['quantity']?>"  name="<?php echo 'quantity_'.@$prd['sid']; ?>" size="8px" id="<?php echo 'quantity_'.@$prd['sid']; ?>"/>

						<?php }else{ ?>

						<input <?php if((@($prd['parent_product']) && @$prd['parent_product'] != $prd['product_id']) || @$prd['id_combo']) echo 'readonly'; ?> class="numbers-pro  <?php if((@($prd['parent_product']) && @$prd['parent_product'] != $prd['product_id']) || @$prd['is_combo']) echo 'creadonly'; ?>" type="text" min="0" max="1000"  value="<?php echo $prd['quantity']?>"  name="<?php echo 'quantity_'.@$prd['sid']; ?>" size="8px" id="<?php echo 'quantity_'.@$prd['sid']; ?>"/>

						<?php } ?>


						<?php if(@!$prd['parent_product'] && @!$prd['parent_product'] != !$prd['product_id']){ ?>
						<span class="btn-plus" onclick="load_ajax_cart('<?php echo @$prd['sid'] ?>','plus')">+</span>
						<?php } ?>
						<span class="error-number-item <?php echo 'error_'.@$prd['sid']; ?>"></span>
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
							<strong><?php echo $gift_item->name ?></strong>
						</div>
						<div class="col-td col-td-number">
							<span class="price"><?php  echo '0đ (Quà tặng)'; ?></span>
							<span><?php echo $prd['quantity'] ?></span>
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

		<!-- Quà tặng theo khoảng giá -->
				<?php 
					$gift_price_range = $model-> get_record('published = 1 AND price_min <= ' . $total . ' AND price_max >= ' . $total,'fs_products_gift_price_range');
					if(!empty($gift_price_range)){
						$gift_price_range_str = substr($gift_price_range->products_gift, 1, -1);
						$product_gift_price_range = $model-> get_records  ('published = 1 AND id IN ('.$gift_price_range_str.')','fs_products_list_gift');
						//mức tiêp theo

						$ordering_next = $gift_price_range -> ordering + 1;
 
						$gift_price_range_next = $model-> get_record('published = 1 AND ordering = '. $ordering_next,'fs_products_gift_price_range');

					}

					if(!empty($product_gift_price_range)){
						foreach ($product_gift_price_range as $product_gift_price_range_item) {
						

				?>
					<div class="row-table">
						<div class="col-td">
							<a href="javascript:void(0)" > 
								<?php if($product_gift_price_range_item -> image){ ?>
									<?php $image_small = URL_ROOT.str_replace('/original/', '/resized/', $product_gift_price_range_item->image); ?>
									<img width="120px" src="<?php echo $image_small; ?>" alt="<?php echo htmlspecialchars ($product_gift_price_range_item -> name); ?>"  />
								<?php } else {?>
									<img width="120px" src="<?php echo URL_ROOT.'images/no-img.gif'; ?>" alt="<?php echo htmlspecialchars ($product -> name); ?>" />
								<?php }?>	 
							</a> 
						</div>
						<div class="col-td">
							<strong><?php echo $product_gift_price_range_item->name ?></strong>
						</div>
						<div class="col-td col-td-number">
							<span class="price"><?php  echo '0đ (Quà tặng)'; ?></span>
							<span>1</span>
						</div>
					</div>


				<?php }} ?>


				<!-- END quà tặng theo khoảng giá -->



				<!-- Gợi ý quà tặng ở mức tiếp theo -->

				<?php 
					if(!empty($gift_price_range_next)){
						$gift_price_range_str_next = substr($gift_price_range_next->products_gift, 1, -1);
						$product_gift_price_range_next = $model-> get_records  ('published = 1 AND id IN ('.$gift_price_range_str_next.')','fs_products_list_gift');
						if(!empty($product_gift_price_range_next)){
							
				?>
					
						<?php 
							$product_gift_price_range_item_next_name = "";
							foreach ($product_gift_price_range_next as $product_gift_price_range_item_next) {
								$product_gift_price_range_item_next_name .= " ". $product_gift_price_range_item_next -> name . ",";
							}

						?>
						<div class="gift_price_next">Khi tổng giá trị đơn hàng đạt <strong><?php echo format_money($gift_price_range_next->price_min,'₫','0₫') ?></strong> bạn sẽ nhận được: <strong><?php echo substr($product_gift_price_range_item_next_name, 0, -1); ?></strong> </div>
					

				<?php }} ?>
				
				<!-- Gợi ý quà tặng ở mức tiếp theo -->	  
				
		</div>

		
		
		<input type="hidden" value="<?php echo $total; ?>" id="price_total">
		<div class="clearfix"></div>			
		<input type="hidden" name='Itemid' value="<?php echo $Itemid; ?>" />
		<input type="hidden" name='module' value="products" />
		<input type="hidden" name='view' value="cart" />
		<input type="hidden" name='task' value="recal" id = 'task'/>
	</form>
</div>




<div class="total-card-code cls">
	<?php if(1==1){ ?>
	<div class="card_code cls">
		<input placeholder="Nhập mã giảm giá" type="text" name="card_code" id="card_code" value="<?php echo isset($_SESSION['code_sale_input']) ? $_SESSION['code_sale_input'] : '' ?>" class="input_text" size="30" />
		
		<button type="button" onclick="myFunction_code();" class="resubmit_form"><?php echo FSText::_('Áp dụng'); ?>
		</button>
		
		<div class="clear"></div>
		<div id="massage_voucher">
			<?php echo isset($_SESSION['code_sale_message']) ? $_SESSION['code_sale_message'] : '' ?>
		</div>

		<div class="note">
			<?php echo $config['note_voucher'] ?>
		</div>
	</div>
	<?php } ?>
	<div class="ship-total" >
		<div class="total-mn cls">
			<font><?php echo FSText::_('Tổng cộng');?>: </font>
			<span class="price_tongcong"><?php echo format_money(($total));?></span>
		</div>

		<?php if(1==2){ ?>
		<div class="cart-code-mn cls">
			<font><?php echo FSText::_('Mã giảm giá');?>: </font>
			<span class="price-cart-code"><?php echo isset($_SESSION['code_sale_price_down']) ? format_money($_SESSION['code_sale_price_down']) : '' ?></span>
		</div>
		<?php } ?>

		<?php 
	    	include_once 'ships.php';
	    ?>
		

		<div class="total-price-inner cls">
			<font><?php echo FSText::_('Thanh toán');?>: </font>
			
			<span class="price_thanhtoan">
				<?php
					if(isset($_SESSION['code_sale_price_down'])){ 
						echo format_money($total - $_SESSION['code_sale_price_down']);
					}else{
						echo format_money($total);
						
					}
				?>
			</span>
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
		if(!notEmpty("card_code","Bạn phải nhập mã giảm giá"))
			return false;

		var code_input = $('#card_code').val();
		var price_ship = $('#price_ship').val();
	
		$.ajax({
			type: "POST",
			url: "/index.php?module=products&view=cart&task=check_code&raw=1&code_input="+code_input,
			data: {code_input:code_input,price_ship:price_ship},
			dataType: 'json',
			success: function(data) {
				
				if(data.error == false && data.type_down){
					if(data.type_down == 1) {
						text_price_chietkhau = data.price_send+ '%';
					} else {
						text_price_chietkhau = data.price_send+ 'đ';
					}
					$('.price-cart-code').html(data.total_down);	
					$('.price_thanhtoan').html(data.total_code);
					$('#code-sale').val(code_input);
					

				}else{
					// $('#code-sale').val('');

				}

				$.ajax({
					type: "POST",
					url: "/index.php?module=products&view=cart&task=recal_ajax_map&raw=1",
					cache: false,
					success: function(html){
						$("#product_cart_load_ajax").html(html);
					}
				});
				$('#massage_voucher').html(data.message);
				
			}
		});
	}

</script>



