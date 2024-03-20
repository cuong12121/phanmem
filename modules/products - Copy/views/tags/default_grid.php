<?php
FSFactory::include_class('fsstring');
$max = IS_MOBILE?2:10;
?>
<div class='product_grid product_grid_full'>
	<?php $j = 0;
	if(!empty($list)){
		foreach($list as $item){
			$link = FSRoute::_('index.php?module='.$this -> module.'&view=product&code='.$item->alias.'&ccode='.$item->category_alias.'&cid='.$item->category_id);
		?>
		<?php 
			
				include 'default_item.php';
			
		?>
		<?php $j ++; ?>

		<?php }?>
	<?php }?>
</div><!--end: .vertical-->





