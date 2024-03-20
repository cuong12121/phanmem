<?php 
$link_buy = FSRoute::_("index.php?module=products&view=cart&task=buy&id=".$item->id."&Itemid=94");
$Itemid = 35;
$link = FSRoute::_('index.php?module=products&view=product&code='.$item -> alias.'&ccode='.$item->category_alias.'&id='.$item->id.'&cid='.$item->category_id.'&Itemid='.$Itemid);
?>
<div  class="item" itemscope itemtype="http://schema.org/Product">					
	<div class="frame_inner">
		<link itemprop="url" href="<?php echo $link; ?>" />
		<figure class="product_image "  >
			<?php $image_small = str_replace('/original/', '/resized/', $item->image); ?>
			<a href="<?php echo $link;?>" title='<?php echo htmlspecialchars($item->name);?>'  itemprop="url">
				<img itemprop="image" alt="<?php echo htmlspecialchars($item->name);?>" data-src="<?php echo URL_ROOT.$image_small;?>"  class="lazy" />
			</a>
		</figure>
		<h2 itemprop="name"><a href="<?php echo $link; ?>" title = "<?php echo htmlspecialchars($item -> name) ; ?>" class="name" >
			<?php echo FSString::getWord(15,$item -> name); ?>
		</a> </h2>	
		<div class='price_arae' itemscope itemtype="http://schema.org/Offer">
			<div class='price_current' itemprop="price"><?php echo format_money($item -> price).''?></div>

			<?php if( $item -> price_old && $item -> price_old > $item -> price){?>
				<div class='price_old'><span><?php echo format_money($item -> price_old).''?></span></div>
			<?php }?>
		</div>
		<?php if( $item -> price_old && $item -> price_old > $item -> price && 1==2){?>
			<div class='discount'><span><?php echo '-'.round((($item -> price_old - $item -> price) /$item -> price_old) * 100).'%'; ?></span></div>
		<?php }?>
		<div class="clear"></div> 								
	</div>   <!-- end .frame_inner -->
	<div class="clear"></div> 
</div> 	 
