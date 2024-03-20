<?php
global $tmpl;
	$tmpl -> addStylesheet('owl.carousel','libraries/jquery/owl.carousel.2/assets');
	$tmpl -> addScript('owl.carousel.min','libraries/jquery/owl.carousel.2');
	$tmpl -> addStylesheet('home','modules/certifications/assets/css');
	$tmpl -> addScript('home','modules/certifications/assets/js');	

	$check_img = check_image($home->image,'');
	if(!$check_img){
		$tmpl -> addStylesheet('nav_no_back');
	}

FSFactory::include_class('fsstring');	
?>

<div class="<?php echo ($check_img)?'detail_main_menu_fixed_img':'detail_main_menu_fixed';?>">

	<div class="certifications_home">
		<?php if($check_img){?>
			<div class="banner_img_menu" style="background-image: url(<?php echo str_replace('original', 'compress', $home->image);?>);">
				<?php //echo set_image_webp($home->image,'compress',@$home->title,'',0,'');?>
				<div class="page_title_img">
					<div class="container">
						<h1 class="heading_title">
							<span><?php echo $home->title;?></span>
						</h1>
						<div class="heading_title_core"><?php echo $home->summary;?></div>
					</div>		
				</div>
				<div class="elementor-shape elementor-shape-bottom">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
						<path class="elementor-shape-fill" d="M421.9,6.5c22.6-2.5,51.5,0.4,75.5,5.3c23.6,4.9,70.9,23.5,100.5,35.7c75.8,32.2,133.7,44.5,192.6,49.7
						c23.6,2.1,48.7,3.5,103.4-2.5c54.7-6,106.2-25.6,106.2-25.6V0H0v30.3c0,0,72,32.6,158.4,30.5c39.2-0.7,92.8-6.7,134-22.4
						c21.2-8.1,52.2-18.2,79.7-24.2C399.3,7.9,411.6,7.5,421.9,6.5z"></path>
					</svg>
				</div>
			</div>
		<?php }?>
		<div class="list_certifications">
			<div class="container">
				<div class="box_items">
					<?php $i=0;
						foreach ($list as $item) {?>
							<div class="item cls item_<?php echo $i%2;?>">
								<div class="cat_cer">
									<div class="name2">
										<?php echo $arr_cat[$item->id]-> name2;?>
									</div>
									<div class="cat_name">
										<?php echo $arr_cat[$item->id]-> name;?>
									</div>
									<div class="cat_summary">
										<?php echo $arr_cat[$item->id]-> des;?>
									</div>
								</div>
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
		</div>
	</div>
</div>
