 <?php
global $tmpl; 
//$tmpl -> addStylesheet("one2","blocks/videos/assets/css");
$tmpl -> addScript("one","blocks/videos/assets/js");
?>
<div class="video_one_block_body block_body cls">
	<?php $i = 0; ?>
	<?php foreach($list as $item){?>
		<?php $i ++; ?>	
		<?php $video = str_replace('/watch?v=', '/embed/', $item -> file_flash);?>
		<div class="video_item" id="one_video_play_area">
			<div class="video_item_inner video_item_inner_has_img">
	    		<img  class="video" src='<?php echo URL_ROOT.str_replace('/original/','/compress/', $item -> image); ?>' alt='<?php echo $item->title;?>' link-video="<?php echo $video;?>"  height="200"/>
	    		<div class="video-name">
		    		<div class="video-name-inner">
	    				<?php echo $item -> title; ?>
	    			</div>
	    		</div>
    		</div>
    	</div>
		<?php break; ?>
	<?php  } ?>
</div>
