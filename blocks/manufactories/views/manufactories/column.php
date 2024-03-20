<?php 
global $tmpl;
$tmpl->addStylesheet('column', 'blocks/manufactories/assets/css');
FSFactory::include_class('fsstring');
?>


<div class="block-manufactories cls">
	<?php foreach ($list as $item) { ?>
		<?php $image = URL_ROOT . str_replace('//original/', '/large/', $item->image_home); ?>
		<?php $link = FSRoute::_("index.php?module=manufactories&view=cat&ccode=dong-ho&cid=139&manu=" . $item->alias . "&Itemid=9"); ?>
		<div class="item">
			<a href="<?php echo $link; ?>" title="<?php echo $item->name; ?>">
				<img class="lazy" data-src="<?php echo $image; ?>" alt="<?php $item->name; ?>" />
			</a>
		</div>
	<?php } ?>
	<div class="clear"></div>
	<div class="view-all"><a href="<?php echo FSRoute::_('index.php?module=manufactories'); ?>">Xem tất cả</a></div>	

</div>
<div class="clear"></div>