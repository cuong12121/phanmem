<?php if(isset($data) && !empty($data)){?>
<?php

global $tmpl; 

$tmpl -> addStylesheet('owl.carousel','libraries/jquery/owl.carousel.2/assets');
$tmpl -> addScript('owl.carousel.min','libraries/jquery/owl.carousel.2');
$tmpl -> addScript('owl_carousel.min','blocks/slideshow/assets/js');
$tmpl -> addStylesheet('owl_carousel','blocks/slideshow/assets/css');
	
//$tmpl -> addStylesheet('slideshow','blocks/slideshow/assets/css');
//$tmpl -> addStylesheet('owl.carousel','libraries/jquery/owl.carousel');
//$tmpl -> addStylesheet('owl.theme','libraries/jquery/owl.carousel');
//$tmpl -> addScript('owl.carousel','libraries/jquery/owl.carousel');
//$tmpl -> addScript('progress_bar','libraries/jquery/owl.carousel');
//$tmpl -> addScript('slideshow','blocks/slideshow/assets/js');
?>	

			<div id="pav-slideShow">
				<div id="fs-slider" class="owl-carousel">
					<?php $i = 0; ?>
					<?php foreach($data as $item){?>	
						<div class="item <?php echo $i ? 'hide':''; ?>">	
	            			<a href="<?php echo $item->url; ?>" title="<?php echo htmlspecialchars($item->name); ?>">	
						<?php if(!$i){ ?>
							<?php echo set_image_webp($item->image,'compress',@$item->name,'',0,'width="770px" height="300px"'); ?>
						<?php } else { ?>
							<?php echo set_image_webp($item->image,'compress',@$item->name,'owl-lazy',1,'width="770px" height="300px"'); ?>
						<?php } ?>
							</a>
							<div class="name"><?php echo $item -> name; ?></div>
						</div>
						<?php $i ++; ?>
					<?php }?>
				</div>
			</div>

<?php }?>
