<?php 
global $tmpl;
$tmpl -> addStylesheet('owl.carousel','libraries/jquery/owl.carousel.2/assets');
$tmpl -> addScript('owl.carousel.min','libraries/jquery/owl.carousel.2');
$tmpl->addStylesheet('row', 'blocks/manufactories/assets/css');
$tmpl -> addScript('row', 'blocks/manufactories/assets/js');
FSFactory::include_class('fsstring');
?>


<div class="block-manufactories block-manufactories-row cls">
	<div class="owl-carousel">
	<?php foreach ($list as $item) { ?>
		<?php $image = URL_ROOT . str_replace('/original/', '/resized/', $item->image); ?>
		<?php 
			$link = FSRoute::_("index.php?module=products&view=cat&ccode=dong-ho&cid=593&manu=" . $item->alias);
		 ?>
		<div class="item">
			<a href="<?php echo $link; ?>" title="<?php echo $item->name; ?>">
				<?php echo set_image_webp($item->image,'resized',@$item->name,'owl-lazy',1,''); ?>
			</a>
		</div>
	<?php } ?>
	</div>
</div>
