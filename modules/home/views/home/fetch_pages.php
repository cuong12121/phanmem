<?php FSFactory::include_class('fsstring'); ?>
				<div class="products_item_content">
					<?php $i=0;foreach ($list as $item) {
						$link_buy = FSRoute::_("index.php?module=products&view=cart&task=buy&id=".$item->id."&Itemid=94");
						$link = FSRoute::_('index.php?module=products&view=product&code='.$item -> alias.'&id='.$item -> id.'&ccode='.$item->category_alias);	
						?>
								<?php include 'default_item.php';?>     
							<?php $i++;?>
					<?php }?>
					<div class="clear"></div>
				</div>	