<?php
$link = FSRoute::_('index.php?module=products&view=product&code='.$item -> alias.'&ccode='.$item->category_alias.'&id='.$item->id.'&cid='.$item->category_id.'&Itemid='.$Itemid);
$arr_name_core = explode(",", $item-> name_core);
?>
<?php if($kk || !$item-> is_special ){?>
	<?php if($item-> price_old > $item-> price) {
		$discount_tt = round((($item -> price_old - $item -> price) /$item -> price_old) * 100);
	}?>
	<div class="item item_often">					
		<div class="frame_inner">
			<?php if($item-> price_old > $item-> price) {?>
				<?php if($item-> is_hot) { ?>
					<div class="discount_p">
						<?php echo 'SALE '.$discount_tt.'%'; ?>
					</div>
				<?php } ?>
			<?php } ?>
			<figure class="product_image ">
				<?php $image_small = str_replace('/original/', '/resized/', $item->image); ?>
				<a href="<?php echo $link;?>" title='<?php echo $item->name;?>'>
					<?php echo set_image_webp($item->image,'resized',@$item->name,'lazy',1,'width="204px" height="204px"'); ?>
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
					<?php if($item-> status == 1) { ?>
						<span class='price_current'><?php echo format_money($item -> price).''?></span> 
						<?php if($item-> price_old > $item-> price) {?>
							<span class='price_old'><?php echo format_money($item -> price_old) ?></span>
							<span class="discount"><?php echo '-'.$discount_tt.'%'; ?></span>
						<?php }?>
					<?php } elseif($item-> status == 2) {?>
						<span class="note">Ngừng kinh doanh</span>
					<?php } ?>
				</div>
				<div class="promotion_info">
					<?php echo $item-> promotion_info; ?>
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

				</div>
			</div>                                        			
			<div class="clear"></div> 
		</div> 	 
	<?php } else {?>
		<div class="item item_special">					
			<div class="frame_inner">
				<figure class="product_image ">
					<?php $image_small = str_replace('/original/', '/resized/', $item->image); ?>
					<a href="<?php echo $link;?>" title='<?php echo $item->name;?>'>
						<?php echo set_image_webp($item->image_hot,'resized',@$item->name,'lazy',1,'width="470px" height="220px"'); ?>
					</a>
					<?php  if(!empty($item->type) && !empty($types)){ ?>
						<div class="type"><span><?php echo $types[$item->type]->name ?></span></div>
					<?php } ?>
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
					<?php if($item-> price_old > $item-> price) {
						$discount_tt = round((($item -> price_old - $item -> price) /$item -> price_old) * 100);
					}?>
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
					<div class="promotion_info">
						<?php echo $item-> promotion_info; ?>
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

					</div>
				</div>                                        			
				<div class="clear"></div> 
			</div> 	 
		<?php } ?>

