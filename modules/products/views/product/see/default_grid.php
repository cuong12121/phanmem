<?php
FSFactory::include_class('fsstring');
$max = IS_MOBILE?2:10;
$list = $orderProducts;
?>
<div class='product_grid cls'>
	<?php $j = 0;
	if(!empty($list)){
		foreach($list as $item){
			if($j<4) {
				$_SESSION["view_fast"][]=@$item->id;
				$link = FSRoute::_('index.php?module='.$this -> module.'&view=product&code='.@$item->alias.'&ccode='.@$item->category_alias.'&cid='.@$item->category_id);
				$link_buy = FSRoute::_('index.php?module=products&view=cart&task=buy&id='.$item -> id);
				?>
				<?php 
				if($item) {
					include 'default_item_lazy.php';
				}
				?>
			<?php } ?>
			<?php $j ++; ?>
		<?php }?>
	<?php }?>
</div><!--end: .vertical-->

