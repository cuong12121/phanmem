<?php 
global $tmpl;
$tmpl->addStylesheet('name', 'blocks/manufactories/assets/css');
FSFactory::include_class('fsstring');
?>
<div class="block-manufactories-body cls">
	<?php foreach ($list as $item) { ?>
		<?php $link = FSRoute::_("index.php?module=products&view=cat&ccode=dong-ho&cid=754&filter=" . $item->alias); ?>
			<a class="item" href="<?php echo $link; ?>" title="<?php echo $item->name; ?>">
				<?php echo $item->name; ?>
			</a>
	<?php } ?>
</div>
<div class="clear"></div>