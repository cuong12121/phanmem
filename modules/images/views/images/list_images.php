<div id="gallery" style="display:none;">

 			 <?php if(!empty($getlist_images)){?>
		            	<?php for($i = 0; $i < count($getlist_images); $i ++ ){?>
		            	
		            		<?php $item = $getlist_images[$i];?>
		            		<?php $image_small_other = str_replace('/original/', '/large/', $item->image); ?>
		            		

						<a href="<?php echo URL_ROOT?>">
						<img class="lazy" alt="<?php echo htmlspecialchars ($data -> name); ?>"
						     data-src="<?php echo URL_ROOT.$image_small_other; ?>"
						     data-image="<?php echo URL_ROOT.$item->image ?>"
						     data-image-mobile="<?php echo URL_ROOT.$image_small_other; ?>"
						     data-thumb-mobile="<?php echo URL_ROOT.$image_small_other; ?>"
						     data-description="<?php echo htmlspecialchars ($data -> name); ?>"
						     style="display:none">
						</a>
		            	<?php } ?>
		            <?php } ?>
			</div>