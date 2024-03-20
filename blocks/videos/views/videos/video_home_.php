 <?php
 global $tmpl; 
 	$tmpl -> addStylesheet("video_home","blocks/videos/assets/css");
 	$tmpl -> addScript("video_home","blocks/videos/assets/js");
 ?>

 <div class="videos_block_body block_body cls" id="bl_video">
 	<?php foreach($list as $item){?>

 		<div class="video_item">
 			<div class="video_item_inner video_item_inner_has_img">
 				<?php echo set_image_webp($item -> image,'compress',@$item -> name,'lazy',1,''); ?>

 				<video width="100%" height="auto" poster="<?php echo URL_ROOT.str_replace('/original/', '/compress/', $item -> image.'.webp');?>" id="video_<?php echo $item->id;?>"  loop="" muted="" >           		
            			<source src="<?php echo URL_ROOT.$item->link_video;?>" type="video/mp4">
		 		</video>		 				 		
		 			<div class="btn_play_pause pause"  onclick="playPause(<?php echo $item->id;?>)"></div>
	 		</div>
	 		<div class="container">
	 			<div class="summary">
			 		<?php echo $item->summary;?>
			 	</div>
	 		</div> 		
 		</div>
 	<?php  } ?>	
</div>
