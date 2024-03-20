		<?php 	
		$max_price =$price_by_region;
		$min_price =$price_by_region;
		?>
		<?php if(!empty($price_by_color)){?>					
			<?php 	
			foreach ($price_by_color as $cl){	   				
				if($cl->price > 0){
					$price_buffer = $price_by_region + $cl->price;
				}else if($cl->price <= 0){
					if(is_numeric($price_by_region)  && is_numeric($cl->price)){
					}
					$price_buffer =is_numeric($price_by_region) - is_numeric($cl->price);
				}
				if($price_buffer > $max_price)
					$max_price = $price_buffer;

				if($price_buffer < $min_price)
					$min_price = $price_buffer;
			}	
			?>
		<?php }?>

		<?php if(!empty($prices_extend_default)) {
			$price_default = $price_by_region;
			foreach ($prices_extend_default as $price_extend_default) {
				$price_default = $price_default + (int)($price_extend_default-> price);
			}
		} ?>

		<div class="price_wrapper cls">
			<?php if($data-> status != 2) { ?>
			<div class='price price_active price1 cls <?php if(@$data-> sale_off) echo 'price_sale_off'; ?>' itemprop="offers" itemscope="" itemtype="https://schema.org/AggregateOffer">
				<link itemprop="availability" href="https://schema.org/InStock">

					<div class='price_current ' id="price"  content="<?php echo $data -> price; ?>">
						<?php if(isset($price_default)) {
							echo format_money($price_default) ; 
						} else {echo format_money($price_by_region) ; }?>
					</div>

					<meta itemprop="lowPrice" content="<?php echo $min_price; ?>">
					<meta itemprop="highPrice" content="<?php echo $max_price; ?>">


					<?php if($data -> sale){ ?>
						<meta itemprop="itemOffered" name="itemOffered" content="<?php echo $data -> sale; ?>">
					<?php } else {?>
						<meta itemprop="itemOffered" name="itemOffered" content="10">
					<?php } ?>	
					<?php if($data -> quantity){ ?>
						<meta itemprop="offerCount" name="offerCount" content="<?php echo $data -> quantity; ?>">
					<?php }  else {?> 
						<meta itemprop="offerCount" name="offerCount" content="1">
					<?php } ?>

					<meta itemprop="priceCurrency" content="VND">
					<?php if($data -> discount && $data -> price_old || @$data-> sale_off){?>
						<div class='price_old'>
							<span class="price_old_nb" id="price_old" content="<?php echo $data -> price_old; ?>"> <?php echo format_money($data -> price_old); ?></span>
							<span class="discount_o"><?php echo round(($data -> price - $data -> price_old)/$data -> price_old*100);  ?>%</span>
						</div>
					<?php }?>
				</div>
				<input type="hidden" id="no_services" name="no_services" value="0">
				<input type="hidden" id="price2" value="<?php echo $data-> price2;?>">
				<?php if($data-> price2) { ?>
					<div class="price price2 cls">
						<div class="note_price2">
							Mua Online không dịch vụ
						</div>
						<div class="price_text"><?php echo format_money($data-> price2); ?></div>

						<?php if($data -> price_old || $data -> price){?>
							<?php if($data -> price_old){?>
								<div class='price_old'>
									<span class="price_old_nb" id="price_old" content="<?php echo $data -> price_old; ?>"> <?php echo format_money($data -> price_old); ?></span>
									<span class="discount_o"><?php echo round(($data -> price2 - $data -> price_old)/$data -> price_old*100);  ?>%</span>
								</div>
							<?php } else {?>
								<div class='price_old'>
									<span class="price_old_nb" id="price_old" content="<?php echo $data -> price; ?>"> <?php echo format_money($data -> price); ?></span>
									<span class="discount_o"><?php echo round(($data -> price2 - $data -> price)/$data -> price*100);  ?>%</span>
								</div>
							<?php } ?>
						<?php } ?>
					</div>
				<?php } ?>
			<?php } else {?>
				<div class='price price3'>
					<div class='price_current'>
						Sản phẩm ngừng kinh doanh
					</div>
				</div>
			<?php } ?>
			</div>

			<div class="clear"></div>
			<?php if( $data -> manufactory_name){ ?>
				<meta itemprop="brand" content="<?php echo $data -> manufactory_name; ?>">
			<?php }  else{?>
				<meta itemprop="brand" content="<?php echo $config['site_name']; ?>">
			<?php  } ?>



			<?php if(!empty($price_by_warranty)){?>
				<select class="boxwarranty" onchange="load_quick(this);" name="warranty_curent_id">
					<option value="0"  data-price="0" data-type="warranty">Chế độ bảo hành</option>
					<?php foreach ($price_by_warranty as $item){?>
						<option <?php echo $item->is_default == 1 ? 'selected' : '' ?> class="<?php echo $item->is_default == 1 ? 'trigger_is_default' : ''  ?>"  value="<?php echo $item->id ?>" data-price="<?php echo ($item -> price)?$item -> price:0;?>" data-type="warranty"  ><?php echo $item -> warranty_name?></option>
					<?php }	?>
				</select>
				<div class="warranty_aq">
					<?php global $config;?>
					<font><i class="icon_v1 "></i></font>
					<span class="warranty_popup"><?php echo $config['warranty_aq']; ?></span>
				</div>
				<div class="clear"></div>
			<?php }?>
			<div class="end-product-base-top"></div>




			<div>
				<?php if($data-> code) { ?>
					<meta itemprop="mpn" content="<?php echo $data -> code; ?>">
					<meta itemprop="sku" content="<?php echo $data -> code; ?>">
				<?php } else {?>
					<meta itemprop="mpn" content="<?php echo $data -> id; ?>">	
					<meta itemprop="sku" content="<?php echo $data -> id; ?>">	
				<?php } ?>
			</div>

			<div class="info_base">

				<div class="_attributes">
					<?php if(count($price_by_extend_group)){ ?>
						<div class="all_ground_extend">
							<?php foreach ($price_by_extend_group as $price_extend_group){ ?>


								<?php if($extends_groups_data[$price_extend_group->group_extend_id]->style_types == 2){ ?>    <!--  kiểu màu sắc -->
								<div class="ground_extend_item">
									<div class="ground_extend_name"><?php echo $price_extend_group-> ground_extend_name?>:</div>
									<div class="item_extend_name">
										<?php foreach ($price_by_extend[$price_extend_group -> group_extend_id]   as $item){?>
											<div style="background-color:#<?php echo $item -> color ?> " class="item_color item group_extend_<?php echo $price_extend_group-> group_extend_id ?> item_extend_id_<?php echo $item->id ?>" data-group = "group_extend_<?php echo $price_extend_group-> group_extend_id ?>" data-id = "<?php echo $item->id ?>" data-group-id = "<?php echo $price_extend_group->group_extend_id ?>" data-price = "<?php echo $item->price ? $item->price : 0 ?>">
											</div>

										<?php }	?>
									</div>

									<?php }elseif($extends_groups_data[$price_extend_group->group_extend_id]->style_types == 3){ ?> <!-- kiểu select -->
									<div class="ground_extend_item ground_extend_item_select">
										<div class="ground_extend_name ground_extend_name_select"><?php echo $price_extend_group-> ground_extend_name?>:</div>

										<!-- dùng để tricger select -->
										<div class="item_extend_name item_extend_name_hide">
											<?php foreach ($price_by_extend[$price_extend_group -> group_extend_id]   as $item){?>
												<div class="<?php echo $item->is_default == 1 ? ' trigger_is_default_price_extend' : '' ?> item-<?php echo $price_extend_group->group_extend_id ?>-<?php echo $item->id ?> item group_extend_<?php echo $price_extend_group-> group_extend_id ?> item_extend_id_<?php echo $item->id ?>" data-group = "group_extend_<?php echo $price_extend_group-> group_extend_id ?>" data-id = "<?php echo $item->id ?>" data-group-id = "<?php echo $price_extend_group->group_extend_id ?>" data-price = "<?php echo $item->price ? $item->price : 0 ?>">
													<div class="extend_name">
														<?php echo $item -> extend_name;?>
													</div>
													<div class="extend_price">
														<?php
														echo format_money($item->price + $data->price); 
														?>
													</div>
												</div>

											<?php }	?>
										</div>
										<!-- dùng để trigger select -->

										<select class="onchange_trigger">
											<option><?php echo ucfirst($price_extend_group-> ground_extend_name) ?></option>
											<?php foreach ($price_by_extend[$price_extend_group -> group_extend_id]   as $item){?>
												<option <?php echo $item->is_default == 1 ? 'selected' : '' ?> class="data-style-select-<?php echo $item->id ?>" data-group-id = "<?php echo $price_extend_group->group_extend_id ?>" value="<?php echo $item->id ?>"><?php echo $item -> extend_name;?></option>
											<?php }	?>

										</select>


									<?php }else{ ?>
										<div class="ground_extend_item">
											<div class="ground_extend_name"><?php echo ucfirst($price_extend_group-> ground_extend_name) ?>:</div>
											<div class="item_extend_name">
												<?php foreach ($price_by_extend[$price_extend_group -> group_extend_id]   as $item){?>
													<div class="<?php echo $item->is_default == 1 ? 'trigger_is_default_price_extend' : '' ?> item group_extend_<?php echo $price_extend_group-> group_extend_id ?> item_extend_id_<?php echo $item->id ?>" data-group = "group_extend_<?php echo $price_extend_group-> group_extend_id ?>" data-id = "<?php echo $item->id ?>" data-group-id = "<?php echo $price_extend_group->group_extend_id ?>" data-price = "<?php echo $item->price ? $item->price : 0 ?>">
														<div class="extend_name">
															<?php echo $item -> extend_name;?>
														</div>
														<i></i>
													</div>

												<?php }	?>
											</div>
										<?php } ?>


										<input type="hidden" class="box_extend_arr" name="box_extend[]" value="0" id="ip_item_extend_id_<?php echo $price_extend_group-> group_extend_id ?>">
									</div>
								<?php } ?>
							</div>
						<?php  } ?>

					</div>


					<?php if(!empty($price_by_color)){?>
						<div class="_color">
							<label>Màu sắc: </label>
							<?php 	foreach ($price_by_color as $item){
								$price_color =0;
								if($item->price > 0){
									$price_color = '+'.format_money($item->price,'₫') ;
								}else if($item->price < 0){
									$price_color = format_money($item->price,'₫') ;
								}else{
									$price_color = '+0₫';
								}
								?>
								<a href="javascript:void(0)" class="data_color_item data_color_<?php echo $item -> color_id;?> Selector <?php echo $item ->is_default == 1 ? 'is_default_color' : ''  ?>"  onclick="load_quick(this);" data-price="<?php echo $item -> price;?>" data-price-old="<?php echo $item -> price_old;?>" data-type="color"  data-id="<?php echo $item -> id;?>"   data-color="<?php echo $item -> color_id;?>" data-name="<?php echo $item -> color_name;?>">
									<span  class="color_item icon_v1" data-toggle="tooltip" data-original-title="<?php echo $price_color ;?>"  style="background-color: <?php  echo '#'.$item->color_code?>;">
										<!-- <font><?php //echo $price_color ;?></font> -->
									</span>
								</a>
							<?php 	 }	?>

							<input type="hidden" value="" id="color_curent_id" name="color_curent_id">
						</div>

					<?php }?>



					<?php if($data-> promotion) { ?>
						<div class="promotion_base">
							<div class="title">
								<p class="t">Khuyến mại</p>
								<div class="promotion_title">
									<?php echo $data-> promotion_title; ?>
								</div>
							</div>
							<div class="info">
								<div class="promotion1"><?php echo $data-> promotion;?></div>
								<div class="promotion2 hide"><?php echo $data-> promotion2;?></div>

							</div>
							<div class="note">
								<span>(*)</span>&nbsp;<?php echo $data-> promotion_note; ?>
							</div>
						</div>
					<?php } ?>
					<?php if($data-> services) { ?>
						<div class="services">
							<div class="title">Chọn thêm các dịch vụ <span>miễn phí chỉ có ở VINALNK</span></div>
							<?php $services = explode(",", trim($data-> services,',')); 
							if(!empty($services)) {
								foreach ($services as $item_services) {
									if($item_services) {
										$data_services = $model-> get_record('id = '.$item_services,'fs_products_services','*');
										if($data_services){ ?>
											<div class="item_services">
												<input type="checkbox" class="iservices" name="services[]" id="services_<?php echo $data_services-> id; ?>" value="<?php echo $data_services-> id; ?>">
												<label for="services_<?php echo $data_services-> id; ?>"><span class="services_name"><?php echo $data_services-> name; ?></span></label>
											</div>
										<?php }
									}
								}
							}
							?>
						</div>
					<?php } ?>


					<?php
					if(!empty($sale)){?>
						<div class="wraper_sale">
							<div class="sale_day cls">
								<div class="sale_date">		

									<div class="cls buy_fast_body hide">
										<input type="text" value="" placeholder="" id="sale_date" name="sale_date" class="keyword input-text" />
										<button type="button" class="button-sale-date button" onclick="myCoppy()">Sao chép </button>
									</div>
									<?php 	
									global $insights;
									if (!$insights){ ?>
										<div class="title-share-fb cls">
											<div class="button-share"><?php include "share_facebook_coupon.php" ?></div>
										</div>
										<div class="clear"></div>
									<?php } ?>
									<?php 
									$url = $_SERVER['REQUEST_URI'];
									$return = base64_encode($url);	
									?>
									<?php 
									if($sale -> link_share ==""){
										$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";		
									}else{
										$actual_link = $sale->link_share;	
									}	
									?>
									<!-- <input type='hidden' name="link_share_fb_conf"  id="link_share_fb_conf" value="<?php //echo $config['link_share_facebook']?>"/> -->
									<input type='hidden' name="link_share_product" id="link_share_product" value="<?php echo $actual_link ?>"/>
									<input type='hidden'  name="id" value="<?php echo $data -> id; ?>"/>
									<input type="hidden" name="price_key_share" value="<?php echo $sale->money_dow; ?>">						
								</div>
							</div>
							<div class="clear"></div>
							<div class="text_aaa hide"><a href="javascript:void(0)" onclick="buy_add_product(<?php echo $data-> id; ?>)" class="text_cart" title="Thanh toán">Sử dụng mã này</a></div>
						</div>
					<?php } ?>


					<div class='detail_button product_detail_bt cls'>

						<!-- <div class="text">Số lượng:</div> -->
						<div class="numbers-row hide">
							<input name="buy_count" id="buy_count" value="1" type="text" placeholder="Số lượng">
							<span class="inc button" data="inc"><svg  width="10px" height="10px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" ><path fill="gray" d="M17.525 36.465l-7.071 7.07c-4.686 4.686-4.686 12.284 0 16.971L205.947 256 10.454 451.494c-4.686 4.686-4.686 12.284 0 16.971l7.071 7.07c4.686 4.686 12.284 4.686 16.97 0l211.051-211.05c4.686-4.686 4.686-12.284 0-16.971L34.495 36.465c-4.686-4.687-12.284-4.687-16.97 0z" class=""></path></svg></span>
							<span class="dec button" data="dec"><svg  width="10px" height="10px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" ><path fill="gray" d="M17.525 36.465l-7.071 7.07c-4.686 4.686-4.686 12.284 0 16.971L205.947 256 10.454 451.494c-4.686 4.686-4.686 12.284 0 16.971l7.071 7.07c4.686 4.686 12.284 4.686 16.97 0l211.051-211.05c4.686-4.686 4.686-12.284 0-16.971L34.495 36.465c-4.686-4.687-12.284-4.687-16.97 0z" class=""></path></svg></span>
						</div>
						<div class="clear"></div>

						<?php if($data-> status ==1){ ?>
							<div class="wrap-btm-buy cls">
								<button type="submit"class="btn-buy-222 fl" id="buy-now-222">
									<span>
										<?php echo FSText::_('Mua ngay'); ?>
									</span>
								</button>
								<?php if(1==2){ ?>
									<a href="javascript:void(0)" class="btn-tragop fr" data-toggle="modal">
										<span>Trả góp lãi xuất thấp</span>
										<p>(Tư vấn qua điện thoại)</p>
									</a>
								<?php } ?>

								<a  href="javascript:void(0)" onclick="add_to_cart(<?php echo $data-> id; ?>)" class="btn-dathang" data-toggle="modal">
									<font>Thêm vào giỏ hàng</font>
								</a>

							</div>		
						<?php } ?>

						<div class="clear"></div>
					</div>

				</div>


