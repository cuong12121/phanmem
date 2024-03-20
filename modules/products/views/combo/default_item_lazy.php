<?php 
$link_buy = FSRoute::_("index.php?module=products&view=cart&task=buy&id=".$item->id."&Itemid=94");
$Itemid = 35;
$link = FSRoute::_('index.php?module=products&view=product&code='.$item -> alias.'&ccode='.$item->category_alias.'&id='.$item->id.'&cid='.$item->category_id.'&Itemid='.$Itemid);
$Ccode = FSInput::get('ccode');
?>
<div  class="item" >					
	<div class="frame_inner">
		<figure class="product_image "  >
			<?php $image_small = str_replace('/original/', '/resized/', $item->image); ?>
			<a href="<?php echo $link;?>" title='<?php echo htmlspecialchars($item->name);?>'  itemprop="url">
				<img itemprop="image" alt="<?php echo htmlspecialchars($item->name);?>" data-src="<?php echo URL_ROOT.$image_small;?>"  class="lazy"/>
			</a>
		</figure>
		<h2>
			<a href="<?php echo $link; ?>" title = "<?php echo htmlspecialchars($item -> name) ; ?>" class="name" >
				<?php echo FSString::getWord(15,$item -> name); ?>
			</a> 
		</h2>
		<div class="cp-dt cls">
			<?php 
				$ids_cp = $item -> id;
		        $codes_cp = $item -> alias;						
		        $link_compare = FSRoute::_('index.php?module=products&view=compare&codes='.$codes_cp.'&ids='.$ids_cp);
			?>
			<a class="btn-compare" href="<?php echo $link_compare ?>"><?php echo $config['icon_compare'] ?></a>
			<a class="btn-detail" href="<?php echo $link; ?>"><?php echo FSText::_("Chi tiết") ?><?php echo $config['icon_ar_right'] ?></a>
		</div>	

		<div class="clear"></div> 
	</div>   <!-- end .frame_inner -->
</div> 	 

