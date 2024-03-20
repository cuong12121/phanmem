<?php
	global $tmpl;
	$tmpl -> addStylesheet('row','blocks/product_menu/assets/css');
	$Itemid  = 5; 
	// $tmpl -> addScript('drop_down','blocks/product_menu/assets/js');
?>

<div class="wrap-cat-pro cls">
	<?php foreach ($list2 as $item ) { 
		$link = FSRoute::_('index.php?module=products&view=cat&id='.$item->id.'&ccode='.$item->alias.'&Itemid='.$Itemid);
	?>

	<div class="item">
		<div class="icon">
			<a href="<?php echo $link; ?>"><img src="<?php echo URL_ROOT.$item->image; ?>" alt="<?php echo $item->name; ?>"></a>
		</div>
		<div class="name">
			<a href="<?php echo $link; ?>"><?php echo $item->name; ?></a>
		</div>
	</div>
	<?php } ?>
	<div class="clear"></div>
</div>