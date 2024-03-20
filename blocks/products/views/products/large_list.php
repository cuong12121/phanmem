<?php
global $tmpl,$config,$is_mobile; 
$tmpl -> addStylesheet('large_list','blocks/products/assets/css');
// $tmpl -> addScript('large_list','blocks/products/assets/js');
FSFactory::include_class('fsstring');
?>


<div class="product-large-list cls">
	<div class="large-list-l">
	<?php
		$i = 0;
		foreach ($list as $item) {
			$link = FSRoute::_("index.php?module=products&view=product&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias.'&cid='.$item -> category_id);

	?>
		<div class="item">
			<figure class="product_image">
				<a href="<?php echo $link;?>" title='<?php echo htmlspecialchars($item->name);?>'>
					<?php echo set_image_webp($item->image,'large',@$item->name,'lazy',1,''); ?>
				</a>
				<span class="icon_hot">Hot</span>
				<?php if($item-> price_old > $item-> price) { ?>
					<span class='discount'>
						<?php echo round(($item -> price  - $item -> price_old) * 100 / $item-> price_old);?>%
					</span>
					
				<?php }?>
			</figure>
			
			<h3>
				<a href="<?php echo $link; ?>" title = "<?php echo $item -> name ; ?>" class="name" >
				<?php echo FSString::getWord(15,$item -> name); ?>
				</a>
			</h3>

			<div class='price_arae'>
				<span class='price_current'><?php echo format_money($item -> price) ?></span>
				<?php if($item-> price_old > $item-> price) { ?>
					<span class='price_old'><?php echo format_money($item -> price_old) ?></span>
				<?php }?>
			</div>
			<?php if(!empty($item->gift)){ ?>
			<div class="gift">
				<?php echo $config['icon_gift'] . $item->gift; ?>
			</div>
			<?php } ?>	
		</div>

	<?php
		if($i == 0)
			break;
	}
	?>
	</div>


	<div class="large-list-r">
	<?php
		$j = 0;
		foreach ($list as $item) {
			if($j > 0){
			$link = FSRoute::_("index.php?module=products&view=product&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias.'&cid='.$item -> category_id);
	?>
		<div class="item cls">
			<figure class="product_image">
				<a href="<?php echo $link;?>" title='<?php echo htmlspecialchars($item->name);?>'>
					<?php echo set_image_webp($item->image,'large',@$item->name,'lazy',1,''); ?>
				</a>
				<span class="icon_hot">Hot</span>
				<?php if($item-> price_old > $item-> price) { ?>
					<span class='discount'>
						<?php echo round(($item -> price  - $item -> price_old) * 100 / $item-> price_old);?>%
					</span>
					
				<?php }?>
			</figure>
			
			<div class="content-r">
				<h3>
					<a href="<?php echo $link; ?>" title = "<?php echo $item -> name ; ?>" class="name" >
					<?php echo FSString::getWord(15,$item -> name); ?>
					</a>
				</h3>

				<div class='price_arae'>
					<span class='price_current'><?php echo format_money($item -> price) ?></span>
					<?php if($item-> price_old > $item-> price) { ?>
						<span class='price_old'><?php echo format_money($item -> price_old) ?></span>
					<?php }?>
				</div>

				<?php if(!empty($item->gift)){ ?>
					<div class="gift">
						<?php echo $config['icon_gift'] . $item->gift; ?>
					</div>
				<?php } ?>

			</div>
				
		</div>

	<?php
		}
		$j++;
	}
	?>
	</div>
</div>