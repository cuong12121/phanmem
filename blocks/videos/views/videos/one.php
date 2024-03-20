 <?php
global $tmpl; 
$tmpl -> addStylesheet("one","blocks/videos/assets/css");
$tmpl -> addScript("one","blocks/videos/assets/js");
?>
<div class="video_one_block_body block_body cls">
	<?php $i = 0; ?>
	<?php foreach($list as $item){?>
		<?php $i ++; ?>	
		<?php $video = str_replace('/watch?v=', '/embed/', $item -> file_flash);?>
		<div class="video_item" id="one_video_play_area">
			<div class="video_item_inner video_item_inner_has_img">
	    		<img  class="video" src='<?php echo URL_ROOT.str_replace('/original/','/resized/', $item -> image); ?>' alt='<?php echo $item->title;?>' link-video="<?php echo $video;?>"  height="200"/>
	    		<div class="video-name">
		    		<div class="video-name-inner">
	    				<?php echo $item -> title; ?>
	    			</div>
	    			<div class="video-time-inner">
	    				<?php echo date('d/m/Y',strtotime($item -> created_time)); ?>
	    			</div>
	    		</div>
    		</div>
    	</div>
		<?php break; ?>
	<?php  } ?>
	
	<?php $i = 0; ?>
	<div class="list_video_below cls">
	<?php foreach($list as $item){?>
		<?php $i ++; ?>	
		<?php // if($i == 1) continue;?>
		<?php $video = str_replace('/watch?v=', '/embed/', $item -> file_flash);?>
		<div class="video_item">
			<div class="video_item_inner video_item_inner_has_img" onclick="reload_video('<?php echo $video; ?>')">
	    		<img  class="video " src='<?php echo URL_ROOT.str_replace('/original/','/small/', $item -> image); ?>' alt='<?php echo $item->title;?>' link-video="<?php echo $video;?>" />
    		</div>
    	</div>
	<?php  } ?>
	</div>
</div>
