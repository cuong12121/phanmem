<div class="row product_grid">
	<div class="row_inner"  id="box_product_<?php echo $cat_special->id ?>">
		<!--	EACH PRODUCT				-->
		<?php 
		$products = $products_special;
		for($j = 0 ; $j < count($products); $j ++)
		{
			$item = $products[$j];
			$link_buy = FSRoute::_("index.php?module=products&view=cart&task=buy&id=".$item->id."&Itemid=94");
			$Itemid = 35;
  			$link = FSRoute::_('index.php?module=products&view=product&code='.$item -> alias.'&ccode='.$item->category_alias.'&id='.$item->id.'&cid='.$item->category_id.'&Itemid='.$Itemid);
  			global $insights;
  			if($insights)
				include 'default_item_lazy.php';
			else              
				include 'default_item.php';
		}
		?>		
		<!--	end EACH PRODUCT				-->
        <div class="clear"></div> 
	</div>
</div>