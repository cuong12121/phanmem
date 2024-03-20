<?php
global $tmpl,$config,$is_mobile; 
$tmpl -> addStylesheet('owl.carousel','libraries/jquery/owl.carousel.2/assets');
$tmpl -> addScript('owl.carousel.min','libraries/jquery/owl.carousel.2');
$tmpl -> addStylesheet('slideshow_hot','blocks/products/assets/css');
$tmpl -> addScript('slideshow_hot','blocks/products/assets/js');
FSFactory::include_class('fsstring');
?>
<?php if(isset($list) && !empty($list)){?>
	<div class="products_blocks_wrapper  block slideshow-hot">
		<div class="block_title cls">
			<h3><span><?php echo $title; ?></span></h3>
		</div>
		<div class="slideshow-hot-list products_blocks_slideshow_hot product_grid">
			<?php $i = 0; ?>
			<?php foreach($list as $item){
				$arr_name_core = explode(",", $item-> name_core);?>

				<?php if($item-> price_old > $item-> price) {
					$discount_tt = round((($item -> price_old - $item -> price) /$item -> price_old) * 100);
				}?>
				<?php $link = FSRoute::_("index.php?module=products&view=product&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias.'&cid='.$item -> category_id); ?>
				<div class="item <?php echo $i > 4 ? 'hide':''; ?> <?php echo $i < 5 ? 'item-block':''; ?> "   >
					<div class="frame_inner">
						<?php if($item-> is_hot) { ?>
							<div class="discount_p">
								<?php echo 'SALE '.$discount_tt.'%'; ?>
							</div>
						<?php } ?>
						<figure class="product_image ">
							<?php $image_small = str_replace('/original/', '/resized/', $item->image); ?>
							<a href="<?php echo $link;?>" title='<?php echo $item->name;?>'>
								<?php
								if($is_mobile) {
									echo set_image_webp($item->image,'resized',@$item->name,'',0,'');
								} else {
									echo set_image_webp($item->image,'resized',@$item->name,'lazy',1,''); 
								}
								?>
							</a>
						</figure>
						<div class="box_content">
							<div class="types cls">
								<?php if(!empty($types)){?>
									<?php $k  = 0;?>
									<?php foreach($types as $type){?>
										<?php if(strpos($item -> style_types,','.$type->id.',') !== false || $item -> style_types == $type->id){?>
											<?php if($type-> icon) { ?>
												<div class='product_type product_type_image product_type_<?php echo $type -> alias; ?> product_type_order_<?php echo $k; ?>'>
													<?php echo $type-> icon; ?>
													<span class="name_type"><?php echo $type -> name; ?></span>
												</div>
											<?php } else { ?>
												<div class='product_type product_type_<?php echo $type -> alias; ?> product_type_order_<?php echo $k; ?>'><?php echo $type -> name; ?></div>
											<?php } ?>
											<?php $k ++; ?>
										<?php }?>
									<?php }?>
								<?php }?>  	
							</div>
							<h3><a href="<?php echo $link; ?>" title = "<?php echo $item -> name ; ?>" class="name" >
								<?php echo FSString::getWord(15,$item -> name); ?>
							</a></h3>	

							<div class="name_core cls">
								<?php if(!empty($arr_name_core)) {
									foreach ($arr_name_core as $item_core) { if(trim($item_core)){?>
										<div class="item_name_core">
											<?php echo trim($item_core); ?>
										</div>
									<?php }} ?>
								<?php } ?>
							</div>
							<div class='price_arae'> 
								<span class='price_current'><?php echo format_money($item -> price).''?></span> 
								<?php if($item-> price_old > $item-> price) {?>
									<span class='price_old'><?php echo format_money($item -> price_old) ?></span>
									<span class="discount"><?php echo '-'.$discount_tt.'%'; ?></span>
								<?php }?>
							</div>
							<div class="stars cls">
								<?php if($item-> rate_sum && $item-> rate_count) {
									$point = $item-> rate_sum/$item-> rate_count; }
									else {
										$point = ($item -> id % 2) + 4;
									}
									?>
									<?php
									for($x=1;$x<=$point;$x++) {
										echo '<span class="star star-on"></span>';
									}
									while ($x<=5) {
										echo '<span class="star star-off"></span>';
										$x++;
									} ?>
									<span class="count"><?php echo $item-> rate_count?$item-> rate_count:'1'; ?> đánh giá</span>
								</div>
								<div class="time-dow-hotdeal">
									<div class="time">
										<div id="day_h_<?php echo $item-> id; ?>" class="time_1"></div><br>Ngày 
									</div>
									<div class="time">
										<div id="hours_h_<?php echo $item-> id; ?>" class="time_1"></div><br>Giờ
									</div>
									<div class="time">
										<div id="min_h_<?php echo $item-> id; ?>" class="time_1"></div><br>Phút 
									</div>
									<div class="time">
										<div id="sec_h_<?php echo $item-> id; ?>" class="time_1"></div><br>Giây
									</div>

									<script>
										var set_time_h_<?php echo $item->id; ?> = '<?php echo date_format(date_create($item-> date_end),'M d Y H:i:s'); ?>';
										// var set_time_h_<?php echo $item->id; ?> = 'Janary 30, 2022 15:37:25';

										
										var countDownDate_h_<?php echo $item->id; ?> = new Date(set_time_h_<?php echo $item->id; ?>).getTime();

										var x_h_<?php echo $item->id; ?> = setInterval(function() {

											var now_h_<?php echo $item->id; ?> = new Date().getTime();
											var distance_h_<?php echo $item->id; ?> = countDownDate_h_<?php echo $item->id; ?> - now_h_<?php echo $item->id; ?>;
											var days_h_<?php echo $item->id; ?> = Math.floor(distance_h_<?php echo $item->id; ?> / (1000 * 60 * 60 * 24));
											var hours_h_<?php echo $item->id; ?> = Math.floor((distance_h_<?php echo $item->id; ?> % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
											var minutes_h_<?php echo $item->id; ?> = Math.floor((distance_h_<?php echo $item->id; ?> % (1000 * 60 * 60)) / (1000 * 60));
											var seconds_h_<?php echo $item->id; ?> = Math.floor((distance_h_<?php echo $item->id; ?> % (1000 * 60)) / 1000);
											if(days_h_<?php echo $item->id; ?><10) {
												days_h_<?php echo $item->id; ?> = '0' + days_h_<?php echo $item->id; ?>;
											}
											if(hours_h_<?php echo $item->id; ?><10) {
												hours_h_<?php echo $item->id; ?> = '0' + hours_h_<?php echo $item->id; ?>;
											}
											if(minutes_h_<?php echo $item->id; ?><10) {
												minutes_h_<?php echo $item->id; ?> = '0'+minutes_h_<?php echo $item->id; ?>;
											}
											if(seconds_h_<?php echo $item->id; ?><10) {
												seconds_h_<?php echo $item->id; ?> = '0'+seconds_h_<?php echo $item->id; ?>;
											}
											document.getElementById("day_h_<?php echo $item->id; ?>").innerHTML = days_h_<?php echo $item->id; ?>;
											document.getElementById("hours_h_<?php echo $item->id; ?>").innerHTML = hours_h_<?php echo $item->id; ?>;
											document.getElementById("min_h_<?php echo $item->id; ?>").innerHTML = minutes_h_<?php echo $item->id; ?>;
											document.getElementById("sec_h_<?php echo $item->id; ?>").innerHTML = seconds_h_<?php echo $item->id; ?>;

											if (distance_h_<?php echo $item->id; ?> < 0) {
												clearInterval(x_h_<?php echo $item->id; ?>);
												document.getElementById("text-time-dow-hotdeal").innerHTML = "Đã kết thúc";
											}
										}, 1000);
									</script>
								</div>
								<div class="promotion_info">
									<?php echo $item-> promotion_info; ?>
								</div>
								<?php if($item-> quantity){ ?>
									<div class="total_sell">
										<span class="total_sell_inner">
											<span class="perent_sell" style="width: <?php echo round($item->sale / $item-> quantity * 100);?>%"></span>
											<span class="text"><?php echo $item->sale.'/'.$item-> quantity; ?> đã bán</span>
										</span>
									</div>
								<?php } ?>
							</div>
						</div>    
					</div>
					<?php $i ++; ?>
				<?php }?>
			</div>
		</div>		
	<?php } ?>
