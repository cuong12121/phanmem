<?php 
global $tmpl,$is_mobile;
$tmpl->addStylesheet('row2', 'blocks/manufactories/assets/css');
FSFactory::include_class('fsstring');
?>

<div class="block-manufactories-row2-all">

	<?php $w = count($list)  * 114;  ?>
	<?php if($is_mobile){ ?>
	<div class="block-manufactories-row2 cls" style="width: <?php echo $w.'px'; ?>">
	<?php }else{ ?>
		<div class="block-manufactories-row2 cls ">
	<?php } ?>
		<?php $i=1; foreach ($list as $item) { ?>
			<?php $image = URL_ROOT . str_replace('/original/', '/resized/', $item->image); ?>
			<?php  $link = FSRoute::_('index.php?module=products&view=manufactory&code='.$item->alias.'&id='.$item->id);?>
			<?php if($is_mobile){ ?>
			<div class="item" style="width: 110px;">
			<?php }else{ ?>
			<div class="item">
			<?php } ?>

				<a href="<?php echo $link; ?>" title="<?php echo $item->name; ?>">
					<?php echo set_image_webp($item->image,'resized',@$item->name,'',0,''); ?>
				</a>
				<?php if($i == count($list)){ ?>
					<a rel="nofollow" class="view-more" href="<?php echo URL_ROOT.'thuong-hieu.html' ?>" title="Xem thêm thương hiệu">
						<span>Xem thêm</span>
					</a>
				<?php } ?>
			</div>

		<?php $i++; } ?>
	</div>
</div>
