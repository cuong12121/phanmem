<?php
global $tmpl; 

$tmpl -> addStylesheet('default','blocks/products_viewed/assets/css');
FSFactory::include_class('fsstring');

if(!empty($list) && count($list) > 4){
	$tmpl -> addScript('default','blocks/products_viewed/assets/js');
}
?>



<?php 
if(!empty($list) && !empty($list[0])){
	?>
	<p class="block_title_product"><span>Sản phẩm đã xem</span></p>
	<div class="product_grid <?php echo count($list) > 4 ? 'product_grid_slide' : '' ?>">
		
		<?php 
		$i =0;
		foreach ($list as $item) {
			if(!empty($item)){
				$link = FSRoute::_('index.php?module=products&view=product&code='.$item->alias.'&ccode='.$item->category_alias.'&cid='.$item->category_id);
				
				?>
				<div class="item">					
				    <div class="frame_inner">
				    	<figure class="product_image ">
							<a href="<?php echo $link;?>" title='<?php echo $item->name;?>'>
								<?php echo set_image_webp($item->image,'resized',@$item->name,'lazy',1,''); ?>
							</a>
							<?php  if(!empty($item->type) && !empty($types)){ ?>
								<div class="type"><span><?php echo $types[$item->type]->name ?></span></div>
							<?php } ?>
				    	</figure>
				    	<?php if($item-> is_hot == 1){ ?>
							<span class="icon_hot">Hot</span>
						<?php } ?>

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

			<?php  } ?>
		<?php  } ?>

	</div>
	<?php } ?>