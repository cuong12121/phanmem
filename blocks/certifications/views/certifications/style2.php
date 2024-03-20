<?php
	global $tmpl, $is_mobile;
	$tmpl -> addStylesheet('style2','blocks/certifications/assets/css');
	$tmpl -> addStylesheet('lightbox','libraries/jquery/lightbox2/dist/css');
	$tmpl -> addScript('lightbox','libraries/jquery/lightbox2/dist/js');
	FSFactory::include_class('fsstring');
?>

<?php 
	if(!empty($list)){
?>

<div class="tab-title cls">
	<div class="cat-title-main">
		<span>Giấy chứng nhận</span>
	</div>
</div>
<div class="certifications cls">
	<?php if(!$is_mobile){ ?>
	<div class="certifications_body cls">
	<?php }else{
		$w = count($list) * 232; 
	?>
	<div class="certifications_body cls" style="width: <?php echo $w.'px'; ?>">
	<?php } ?>
	<?php foreach($list as $item){ ?>
			<div class="item">
				<a href="<?php echo URL_ROOT.str_replace('/original/', '/original/', $item -> image); ?>" data-lightbox="roadtrip" title="<?php echo htmlspecialchars($item->title); ?>">
				<?php echo set_image_webp($item->image,'large',@$item->title,'lazy',1,''); ?>
					<div class="name"><?php echo $item->title ?></div>
				</a>
			</div>
	<?php }?>
	</div>
</div>
<?php } ?>


