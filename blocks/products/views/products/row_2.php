<?php
	global $tmpl;
	$tmpl -> addStylesheet('row_2','blocks/products/assets/css');
	FSFactory::include_class('fsstring');
?>

<div class="row_2_list">
	<div class="product_grid">
		<?php if(!empty($list)){?>
			<?php foreach ($list as $item){ 
				$link = FSRoute::_("index.php?module=products&view=product&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias.'&cid='.$item -> category_id);
				?>
				<div class="item">
					<figure class="product_image">
						<a href="<?php echo $link;?>" title="<?php echo $item->name;?>">
							<?php echo set_image_webp($item->image,'resized',@$item->name,'lazy',1,'');  ?>
						</a>						
					</figure>
					<div class="box_content">
						<h2>
							<a href="<?php echo $link; ?>" title = "<?php echo $item -> name ; ?>" class="name" >
							<?php echo FSString::getWord(15,$item -> name); ?>
							</a>
						</h2>

						<div class='price_arae'>
							<span class='price_current'><?php echo format_money($item -> price).''?></span>
							<?php if($item-> price_old > $item-> price) { ?>

								<?php if(1==2){?>
								<span class='price_discount'><?php echo ceil(($item -> price  - $item -> price_old) * 100 / $item-> price_old);?>%</span>
								<div class="clear"></div>
							<?php }?>

								<div class='price_old'><?php echo format_money($item -> price_old).''?></div>
							<?php }?>
						</div>
						<div class="add_cart">
							Thêm vào giỏ
						</div>
					</div>
				</div>
			<?php } ?>
		<?php } ?>
	</div>
</div>