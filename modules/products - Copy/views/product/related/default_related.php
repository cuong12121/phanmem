<?php if(!empty($list_related)){?>
	<div class="tab-title tab-title-2 cls">
		<div class="cat-title-main" id="characteristic-label">
			<h3><span><?php echo $title_relate; ?></span></h3>
		</div>
	</div>
	<?php if(1==1){ ?>
		<div class='product_grid product_grid_related product_grid_border <?php echo count($list_related) > 3 ? 'product_grid_slide' : '' ?>' >
			<?php $tmp = 0; ?>
			<?php foreach($list_related as $item){ 
				if(!$item){
					continue;
				}
				?>
				<?php $link = FSRoute::_("index.php?module=products&view=product&id=".@$item->id."&code=".@$item->alias."&ccode=".@$item-> category_alias.'&cid='.@$item -> category_id); ?>
				<div class="item ">			
					<?php if($item-> price_old > $item-> price) {$discount_tt = round((($item -> price_old - $item -> price) /$item -> price_old) * 100);?>
						<?php if($item-> is_hot) { ?>
							<div class="discount_p">
								<?php echo 'SALE '.$discount_tt.'%'; ?>
							</div>
						<?php } ?>
					<?php } ?>		
					<div class="frame_inner">
						<figure class="product_image ">
							<a href="<?php echo $link;?>" title='<?php echo $item->name;?>'>
								<?php echo set_image_webp($item->image,'resized',@$item->name,'lazy',1,''); ?>
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
							<div class='price_arae'> 
								<span class='price_current'><?php echo format_money($item -> price).''?></span> 
								<?php if($item-> price_old > $item-> price) {?>
									<span class='price_old'><?php echo format_money($item -> price_old) ?></span>

								<?php }?>
							</div>
							<div class="promotion_info">
								<?php echo $item-> promotion_info; ?>
							</div>
						</div>
					</div>                                        			

				</div> 
			<?php } ?>
		</div>
	<?php }else{ ?>
		<div class="product_grid_scroll">
			<?php
			$w = count($list_related) * 165; 
			?>
			<div class='product_grid' style="width: <?php echo $w.'px'; ?>">
				<?php $tmp = 0; ?>
				<?php foreach($list_related as $item){ 
					if(!$item){
						continue;
					}
					?>
					<?php $link = FSRoute::_("index.php?module=products&view=product&id=".@$item->id."&code=".@$item->alias."&ccode=".@$item-> category_alias.'&cid='.@$item -> category_id); ?>
					<div class="item">					
						<div class="frame_inner">
							<figure class="product_image ">
								<?php $image_small = str_replace('/original/', '/resized/', $item->image); ?>
								<a href="<?php echo $link;?>" title='<?php echo $item->name;?>'>
									<?php
									
									echo set_image_webp($item->image,'resized',@$item->name,'lazy',1,''); 
									
									?>
								</a>
								<?php  if(!empty($item->type) && !empty($types) && !empty($types[$item->type])){ ?>
									<div class="type"><span><?php echo $types[$item->type]->name ?></span></div>
								<?php } ?>
							</figure>

							<h3><a href="<?php echo $link; ?>" title = "<?php echo $item -> name ; ?>" class="name" >
								<?php echo FSString::getWord(15,$item -> name); ?>
							</a></h3>	
							
							<div class='price_arae'> 
								<span class='price_current'><?php echo format_money($item -> price).''?></span> 
								<?php if($item-> price_old > $item-> price) {
									$discount_tt = round((($item -> price_old - $item -> price) /$item -> price_old) * 100);
									?>
									<span class='price_old'><?php echo format_money($item -> price_old) ?></span>
									<?php if($discount_tt > 0){ ?>
										<span class="discount_tt">(-<?php echo $discount_tt ?>%)</span>
									<?php } ?>
								<?php }?>
							</div>
							<div class="clear"></div> 
						</div>   <!-- end .frame_inner -->   			
						<div class="clear"></div> 
					</div>
				<?php } ?>
			</div>
		</div>

	<?php } ?>


	
<?php } ?>
