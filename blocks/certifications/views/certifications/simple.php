<?php
global $tmpl;
$tmpl -> addStylesheet('owl.carousel','libraries/jquery/owl.carousel.2/assets');
$tmpl -> addScript('owl.carousel.min','libraries/jquery/owl.carousel.2');
$tmpl -> addScript('simple','blocks/partners/assets/js');
$tmpl -> addStylesheet('simple','blocks/partners/assets/css');
FSFactory::include_class('fsstring');
$i = 1;

$total = count($list)
?>
<div class="partners">
	<div class="partners-inner">
		<div class="content-partners owl-carousel">
		<?php foreach($list as $item){ ?>
			<?php $image = URL_ROOT.str_replace('/original/', '/resized/',$item -> image);?>
			<?php $link = $item -> url;?>
			<?php $class = '';?>
			<?php if($i == 1)$class .= ' first-item';?>
			<?php if($i == $total )$class .= ' last-item';?>
				<div class="box-partners<?php echo $class;?> item">
		    		<a href="<?php  echo $link;?>" title="<?php echo $item -> name; ?>"  rel="nofollow" target="_blink">
		    			<img src="<?php echo $image;?>" alt="<?php $item->name;?>" />
		    		</a>
				</div>
				<?php $i ++; ?>
		<?php }?>
		</div>
	</div>
</div>


