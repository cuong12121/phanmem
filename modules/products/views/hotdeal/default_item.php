<?php 
$link_buy = FSRoute::_("index.php?module=products&view=cart&task=buy&id=".$item->id."&Itemid=94");
$Itemid = 35;
$link = FSRoute::_('index.php?module=products&view=product&code='.$item -> alias.'&ccode='.$item->category_alias.'&id='.$item->id.'&cid='.$item->category_id.'&Itemid='.$Itemid);
?>

<?php if(!$is_mobile){ ?>
<div class="item item-<?php echo $cat2->id ?> <?php echo $j >= $cat2->preview_count_item ? 'display-off ' : '' ?>">
<?php }else{ ?>
<div class="item item-<?php echo $cat2->id ?> <?php echo $j >= 6 ? 'display-off ' : '' ?>">
<?php } ?>

    <div class="frame_inner">
    	<figure class="product_image ">
    		<?php $image_small = str_replace('/original/', '/resized/', $item->image); ?>
				<a href="<?php echo $link;?>" title='<?php echo $item->name;?>'>
					<?php
						if($j >= $max){
							echo set_image_webp($item->image,'resized',@$item->name,'lazy',1,''); 
						}else{
							echo set_image_webp($item->image,'resized',@$item->name,'',0,'');
						}
					?>
				</a>
				<?php  if(!empty($item->type) && !empty($types) && !empty($types[$item->type]) ){ ?>
					<div class="type"><span><?php echo $types[$item->type]->name ?></span></div>
				<?php } ?>
    	</figure>
    	<?php if($item-> is_hot == 1 && 1==2){ ?>
			<span class="icon_hot">Hot</span>
		<?php } ?>

		<h3><a href="<?php echo $link; ?>" title = "<?php echo $item -> name ; ?>" class="name" >
				<?php echo FSString::getWord(15,$item -> name); ?>
    	</a></h3>	
		<?php if($item-> price_old > $item-> price) { ?>
			<span class='price_discount'><?php echo ceil(($item -> price  - $item -> price_old) * 100 / $item-> price_old);?>%</span>
		<?php }?>
    	<div class='price_arae'> 
			<span class='price_current'><?php echo format_money($item -> price).''?></span> 
			<?php if($item-> price_old > $item-> price) { ?>
				<span class='price_old'><?php echo format_money($item -> price_old).''?></span>
			<?php }?>
		</div>
		<div class="quantity_sold cls">
			<?php 
				$c = (int)$item-> total_item_buy; // đã bán
				$t = (int)$item-> total_item; // tổn
				$p = number_format((float)($c/$t *100),2,'.','');
			?>
			<div class="progress">
				<div class="bar">
					 <div class="percent" role="progressbar" style="background: <?php echo $cat2->code_color ?>; width:<?php echo $p;?>%;"></div>
					 <div class="text">
					 	<?php if($c < $t){ ?>
					 		Đã bán <?php echo (int)$item-> total_item_buy ?>
					 	<?php }else{ ?>
					 		Đã bán hết
					 	<?php } ?>
					 </div>
				</div>
			</div>
		</div>
		<div class="clear"></div> 

	</div>   <!-- end .frame_inner -->
                        
                    			
	<div class="clear"></div> 
</div> 	  	 
