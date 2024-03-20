<?php if(isset($data) && !empty($data)){?>
<?php

global $tmpl; 
$tmpl -> addStylesheet('owl.carousel','libraries/jquery/owl.carousel.2/assets');
$tmpl -> addScript('owl.carousel.min','libraries/jquery/owl.carousel.2');
$tmpl -> addScript('owl_carousel_home','blocks/slideshow/assets/js');
$tmpl -> addStylesheet('owl_carousel_home','blocks/slideshow/assets/css');
?>	

	<div id="pav-slideShow">
	<div id="fs-slider-home" class="owl-carousel">
			<?php $i = 0; ?>
			<?php foreach($data as $item){?>

				<div class="item <?php echo 'hide'; ?>">	
					<a href="<?php echo $item->url; ?>" title="<?php echo htmlspecialchars($item->name); ?>">	
						<?php if(!$i){ ?>

							<?php echo set_image_webp($item->image,'compress',@$item->name,'',0,''); ?>
						<?php } else { ?>
							<?php echo set_image_webp($item->image,'compress',@$item->name,'owl-lazy',1,''); ?>
						<?php } ?>
					</a>				
                
				</div>

			
			<?php $i++; }?>
		</div>
	</div>

<?php }?>
