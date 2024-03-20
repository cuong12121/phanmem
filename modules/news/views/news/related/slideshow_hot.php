<?php if(isset($relate_products_list) && !empty($relate_products_list)){?>
	<div class="block_title"><span>Sản phẩm liên quan</span></div>
	<div class="products_blocks_wrapper  block slideshow-hot cls">
		<div class="slideshow-hot-list products_blocks_slideshow_hot"  id="<?php echo "products_blocks_slideshow_hot_1" ?>">
			<?php foreach($relate_products_list as $item){?>
				<?php $link = FSRoute::_("index.php?module=products&view=product&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias.'&cid='.$item -> category_id); ?>
				<div  class="item item-block" itemscope itemtype="http://schema.org/Product">					
					<div class="frame_inner">
						<link itemprop="url" href="<?php echo $link; ?>" />
						<figure class="product_image "  >
							<?php $image_small = str_replace('/original/', '/resized/', $item->image); ?>
							<a href="<?php echo $link;?>" title='<?php echo $item->name;?>'  itemprop="url">
								<img itemprop="image" alt="<?php echo $item->name;?>" src="<?php echo URL_ROOT.$image_small;?>" />
							</a>
						</figure>

						<h2 itemprop="name">
							<a href="<?php echo $link; ?>" title = "<?php echo $item -> name ; ?>" class="name" >
								<?php echo FSString::getWord(15,$item -> code); ?>
							</a> 
						</h2>
						<div class="cat_name"><?php echo $item-> category_name  . ' '.strtolower($item-> manufactory_name) ;?></div>	

						<div class='price_arae' itemscope itemtype="http://schema.org/Offer">
							<?php if( $item -> price_old && $item -> price_old > $item -> price){?>
								<div class='price_old'>
									<?php echo format_money($item -> price_old)?>
								</div>
							<?php }?>
							<div class='price_current' itemprop="price">
								<?php echo format_money($item -> price)?>
							</div>

						</div>

						<div class="clear"></div> 

					</div>   <!-- end .frame_inner -->
					<div class="clear"></div> 
				</div> 	 

			<?php }?>
		</div>
	</div>		
<?php }?>
