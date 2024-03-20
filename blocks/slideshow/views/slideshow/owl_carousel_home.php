<?php if(isset($data) && !empty($data)){?>
<?php

global $tmpl,$config; 
	$tmpl -> addStylesheet('owl.carousel','libraries/jquery/owl.carousel.2/assets');
	$tmpl -> addScript('owl.carousel.min','libraries/jquery/owl.carousel.2');
	$tmpl -> addScript('owl_carousel_home','blocks/slideshow/assets/js');
	$tmpl -> addStylesheet('owl_carousel_home','blocks/slideshow/assets/css');
	$toatl_sli = count($data);
?>	

	<div id="pav-slideShow">
	<div class="fs-slider-home <?php echo ($toatl_sli > 1)?'fs-slider-home_slide':'';?> " >

			<?php $i = 0; ?>
			<?php foreach($data as $item){?>

				<div class="item active2 <?php echo ($i == 0)?'':'hide';?>">	
					<a href="<?php echo ($item->url)?$item->url:$item->url2; ?>" title="<?php echo htmlspecialchars($item->name); ?>">	
						<?php if(!$i){ ?>
							<?php echo set_image_webp($item->image,'compress',@$item->name,'',0,'width="770px" height="300px"'); ?>
						<?php } else { ?>
							<?php echo set_image_webp($item->image,'compress',@$item->name,'owl-lazy',1,'width="770px" height="300px"'); ?>
						<?php } ?>
					</a>
					<?php if($item->is_text == 1){?>
					<div class="slide-content">	
						<div class="container cls">
							<div class="box_title_name">
								<?php if($item->name2 !='' || $item->name2 !=null){ ?>
			                    	<div class="title-banner-small"><?php echo $item->name2;?></div>
			                   	<?php } ?> 			
								<?php if($item->name !='' || $item->name !=null){ ?>
			                    	<h2 class="title-banner-big">
			                    		<?php if($item-> is_bold == 1){
			                    			echo '<strong>'.$item->name . '</strong>' ;
			                    		}else{
			                    			echo $item->name;
			                    		}?>			                    						                    			                    			
			                    	</h2>
			                   	<?php } ?> 
			                   	

			                    <?php if($item->summary !='' || $item->summary !=null){ ?>
			                    	<div class="description-slide"><?php echo $item->summary;?></div>
			                    <?php } ?>

			                    <?php if($item->url2 || $item->url){?>
			                    	<div class="box_bottom_slide">
				                    	<?php  if($item->url){?>
					                   		<a class="button-slide" href="<?php echo $item->url; ?>" title="<?php echo htmlspecialchars($item->name); ?>"><?php echo $item->url_name;?></a>
					                   <?php }?>
					                   <?php  if($item->url2){?>
				                   			<a class="button-slide" href="<?php echo $item->url2; ?>" title="<?php echo htmlspecialchars($item->name); ?>"><?php echo $item->url_name2;?></a>
				                   		<?php } ?>
			                   		</div>
			                   <?php } ?>
		                   </div>	
						</div>
	                    
                	</div>
                	<?php }?>
				</div>

			
			<?php $i++; }?>
		</div>
	</div>

<?php }?>
