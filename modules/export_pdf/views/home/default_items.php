<div class="row product_grid">
	<div class="row_inner"  id="box_product">
		<?php
			
			$link_cat = FSRoute::_('index.php?module=products&view=cat&cid='.@$cat_name->id.'&ccode='.@$cat_name -> alias);

			// $link_cat = URL_ROOT.$cat_name -> alias.'-pc'.$cat_name -> id.'/sap-xep-ban-chay-nhat.html';

			if (!empty($products_in_cat)){
				for($j = 0 ; $j < count($products_in_cat); $j ++)
				{
					$item = $products_in_cat[$j];
					$Itemid = 35;
		  			$link = FSRoute::_('index.php?module=products&view=product&code='.$item -> alias.'&ccode='.$item->category_alias.'&id='.@$item->id.'&cid='.$item->category_id.'&Itemid='.$Itemid);
						include 'default_item_lazy.php';
				}
			}
		?>
	</div>
</div>
<div class="clear"></div>
<div class="xemthemhome xemthem-main">
	<a href="<?php echo $link_cat; ?>"><span>Xem thêm <?php echo @$cat_name->name ?></span></a>
</div>
