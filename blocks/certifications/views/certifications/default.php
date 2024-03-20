<?php
global $tmpl,$config; 
$tmpl -> addStylesheet('default','blocks/certifications/assets/css');
FSFactory::include_class('fsstring');

$tmpl -> addStylesheet('owl.carousel','libraries/jquery/owl.carousel.2/assets');
$tmpl -> addScript('owl.carousel.min','libraries/jquery/owl.carousel.2');
$tmpl -> addScript('default','blocks/certifications/assets/js');
?>

<div class="block_certifications">
	<div class="block_certifications_body">
		<div class="block_certifications_body_l">
			<?php echo set_image_webp($cat->image,'compress',@$cat->name,'lazy',1,'');  ?>
		</div>
		<div class="block_certifications_body_r">
			<div class="block_title"><?php echo $cat->name;?></div>
			<div class="sum_cat"><?php echo $cat->des;?></div>
			<!-- <div class="box_items <?php //echo (count($list)> 4)?'box_items_sli':'';?>"> -->
			<div class="box_items box_items_sli">
				<?php 
					foreach ($list as $item) {?>
						<div class="item">
							<div class="iamge">
								<?php echo set_image_webp($item->image,'compress',@$item->title,'lazy',1,'');  ?>
							</div>
							<div class="name">
								<?php echo $item->title;?>
							</div>
						</div>
					<?php }			
				?>
			</div>
		</div>
	</div>
</div>
