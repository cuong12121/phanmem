<?php foreach ($list_product_combo as $key => $list_product ) { ?>
	<div class="product_grid product_combo cls">
		<?php $total = 0; $total_old = 0; ?>
		<?php $i_combo = 0; $str_combo = '';
		 foreach ($list_product as $item) { 
		 	if(!$i_combo) {
		 		$str_combo .= $item-> id;
		 	}
		 	else {
		 		$str_combo .= '_'.$item-> id;
		 	}
			$total += $item-> price;
			$total_old += $item-> price_old;
			$link = FSRoute::_('index.php?module=products&view=product&code='.$item -> alias.'&ccode='.$item->category_alias.'&id='.$item->id.'&cid='.$item->category_id.'&Itemid='.$Itemid); ?>
			<div class="item item_combo">
				<div class="frame_inner">
					<figure class="product_image "  >
						<a href="<?php echo $link;?>" title='<?php echo htmlspecialchars($item->name);?>'>
							<?php echo set_image_webp($item->image,'resized',@$item->name,'lazy',1,''); ?>
						</a>
					</figure>
					<!-- <span class="icon_hot">Hot</span> -->
					<?php if($item-> price_old > $item-> price) { ?>
						<span class='price_discount'><?php echo ceil(($item -> price  - $item -> price_old) * 100 / $item-> price_old);?>%</span>
					<?php }?>
					<h2><a href="<?php echo $link; ?>" title = "<?php echo $item -> name ; ?>" class="name" >
						<?php echo FSString::getWord(15,$item -> name); ?>
					</a></h2>	
					<div class='price_arae'>
						Giá: 
						<span class='price_current'><?php echo format_money($item -> price).''?></span> 
						<?php if($item-> price_old > $item-> price) { ?>
							<span class='price_old'><?php echo format_money($item -> price_old).''?></span>
						<?php }?>
					</div>
					<div class="clear"></div> 
				</div>   <!-- end .frame_inner -->
			</div>
		<?php $i_combo++; } ?>
		<div class="buy_total">
			<a href="javascript:void(0)" title="Mua combo" onclick="buy_combo(<?php echo $key;  ?>)">Mua combo</a>
			<input type="hidden" id="str_id_combo_<?php echo $key; ?>" value="<?php echo  $str_combo;?>">
			<div class="total"><?php echo format_money($total)?>
			</div>
		</div>
	</div>
	<?php } ?>