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
				<amp-img itemprop="image" alt="<?php echo htmlspecialchars($item->name);?>" src="<?php echo URL_ROOT.$image_small;?>"  class="" width="160" height="160" />
			</a>

		</figure>
		<div class="note_hotdeal">
			<?php if($item -> style_types){ ?>
				<?php $arr_style_type = explode(',', $item -> style_types); ?>
				<?php foreach( $arr_style_type as $st){ ?>
					<?php if($st){ ?>
						<div class= '<?php echo $st; ?> '><span><?php echo $style_types_rule[$st]; ?></span></div>
					<?php } ?>
				<?php } ?>

			<?php } ?>
		</div>

		<?php if(@$item -> is_new){ ?>
			<span class="icon_new">New</span>
		<?php }?>
		<h2 itemprop="name"><a href="<?php echo $link; ?>" title = "<?php echo htmlspecialchars($item -> name) ; ?>" class="name" >
			<?php echo FSString::getWord(15,$item -> name); ?>
		</a> </h2>	
		<div class='price_arae' itemscope itemtype="http://schema.org/Offer">
			<div class='price_current' itemprop="price"><?php echo format_money($item -> price).''?></div>

			<?php if( $item -> price_old && $item -> price_old > $item -> price){?>
				<div class='price_old'><span><?php echo format_money($item -> price_old).''?></span></div>
			<?php }?>
		</div>

		<div class="clear"></div> 
		<?php $accessories = substr($item -> accessories, strpos($item -> accessories, "<p"), strpos($item -> accessories, "</p>")+4); ?>
		<?php $accessories = str_replace('<p>-', '<p>', $accessories ); ?>
		<?php $accessories = str_replace('<p>&bull;', '<p>', $accessories ); ?>


		<div class="summary_inner"  itemprop="description">

			<?php echo  $accessories;?>

		</div>
		<?php if(count($types)){?>
			<?php $k  = 0;?>
			<?php foreach($types as $type){?>
				<?php if(strpos($item -> types,','.$type->id.',') !== false || $item -> types == $type->id){?>
					<div class='product_type product_type_<?php echo $type -> alias; ?> product_type_order_<?php echo $k; ?>'><?php echo $type -> name; ?></div>
					<?php $k ++; ?>
				<?php }?>

			<?php }?>
		<?php }?>  									
	</div>   <!-- end .frame_inner -->


	<div class="clear"></div> 
</div> 	 
