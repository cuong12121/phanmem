<?php
global $tmpl;
//$tmpl -> addScript('partners','blocks/partners/assets/js');
$tmpl -> addStylesheet('default2','blocks/partners/assets/css');
FSFactory::include_class('fsstring');
$i = 1;

$total = count($list)
?>
<div class="partners2">
	<div class="content-partners cls">
		<?php foreach($list as $item){ ?>
			<?php $image = URL_ROOT.str_replace('/original/', '/resized/',$item -> image);?>
			<?php $link = $item -> url;?>
			<?php $class = '';?>
			<?php if($i == 1)$class .= ' first-item';?>
			<?php if($i == $total )$class .= ' last-item';?>
			<div class="box-partners<?php echo $class;?> item">
				<a href="<?php  echo $link;?>" title="<?php echo $item -> name; ?>"  rel="nofollow" target="_blink">
					<?php echo set_image_webp($item->image,'compress',@$item->name,'lazy',1,''); ?>
				</a>
			</div>
			<?php $i ++; ?>
		<?php }?>
	</div>
</div>


