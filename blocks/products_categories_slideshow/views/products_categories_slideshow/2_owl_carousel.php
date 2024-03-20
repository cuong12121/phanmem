<?php if(isset($data) && !empty($data)){?>
	<?php

	global $tmpl; 

	$tmpl -> addStylesheet('owl.carousel','libraries/jquery/owl.carousel.2/assets');
	$tmpl -> addScript('owl.carousel.min','libraries/jquery/owl.carousel.2');
	$tmpl -> addScript('2_owl_carousel.min','blocks/slideshow/assets/js');
	$tmpl -> addStylesheet('2_owl_carousel','blocks/slideshow/assets/css');
	
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
				<?php $link_admin = $link_admin_banner.$item-> id; ?>
				<div class="item <?php echo $i ? 'hide':''; ?>">	
					<a href="<?php echo $item->url; ?>" title="<?php echo htmlspecialchars($item->name); ?>">	
						<?php if(!$i){ ?>
							<img src="<?php echo URL_ROOT.str_replace('/original/', '/compress/', $item -> image); ?>" alt="<?php echo htmlspecialchars($item->name); ?>"  />
						<?php }else{ ?>
							<img class="owl-lazy"  data-src="<?php echo URL_ROOT.str_replace('/original/', '/compress/', $item -> image); ?>" alt="<?php echo htmlspecialchars($item->name); ?>"  />
						<?php } ?>
					</a>
					<div class="name"><?php echo $item -> name; ?></div>
					<?php if($check_edit) { ?>
						<li class="admin_edit_detail"><a rel="nofollow" target="_blank" href="<?php echo $link_admin;?>" title="Sửa chi tiết"></a></li>
					<?php } ?>
				</div>
				<?php $i ++; ?>
			<?php }?>
		</div>

		<div class='thumbs'>
			<div id="sync2"  >
				<?php foreach($data as $item){?>	
					<div class="item hide">	
						
						<?php echo $item -> name; ?>
						
					</div>
				<?php }?>
			</div>
		</div>


	</div>

<?php }?>
