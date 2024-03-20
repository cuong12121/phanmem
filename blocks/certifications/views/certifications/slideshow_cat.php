<?php
global $tmpl;
	$tmpl -> addStylesheet('owl.carousel','libraries/jquery/owl.carousel.2/assets');
	$tmpl -> addScript('owl.carousel.min','libraries/jquery/owl.carousel.2');
	$tmpl -> addStylesheet('slideshow_cat','blocks/certifications/assets/css');
	$tmpl -> addScript('slideshow_cat','blocks/certifications/assets/js');	
	FSFactory::include_class('fsstring');
	$toatl_cer = '';
	if(!empty($list)){
		$toatl_cer = count($list);
	}
		
?>

	<div class="list_certifications <?php echo ($toatl_cer > 1)?'list_certifications_slide':'';?> cls">
		
		<div class="cat_cer">
			<div class="name2">
				<?php echo $cat-> name2;?>
			</div>
			<div class="cat_name">
				<?php echo $cat-> name;?>
			</div>
			<div class="cat_summary">
				<?php echo $cat-> des;?>
			</div>
		</div>

		<div class="box_items">
			<?php $i=0;
				foreach ($list as $item) {?>
					<div class="item cls item_<?php echo $i%2;?>">
						
						<div class="image">
							<?php echo set_image_webp($item->image,'compress',@$item->title,'',0,'');?>
						</div>
						<div class="box_content">
							<div class="name"><?php echo $item-> title;?></div>
						</div>
					</div>
				<?php 
				$i++;
				}
			?>
		</div>
	</div>
