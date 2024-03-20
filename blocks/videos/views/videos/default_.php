 <?php
 global $tmpl,$is_mobile; 
 $tmpl -> addStylesheet("default","blocks/videos/assets/css");
 $tmpl -> addScript("videos","blocks/videos/assets/js");
 ?>

	<div class="block_title cls">
			<?php if($link_title){?>
				<a  href="<?php echo $link_title; ?>" title="<?php echo $title; ?>">
				<?php echo $title ;?></a>
			<?php } else {?>
				
					<?php echo $title ;?>
				
			<?php }?>
	</div>
	<?php 
		if(!empty($list)){
			$to = count($list);
			$sli = '';
			if(!$is_mobile && $to>=3){
				$sli = 'video_slide';
			}
		}
	?>
	<div class="videos_block_body_body">
	 <div class="videos_block_body block_body cls <?php echo $sli;?>">
	 	<?php foreach($list as $item){?>
	 		<?php if(!$item -> file_flash) continue;?>
	 		<?php 
	 			//$video = str_replace('/watch?v=', '/embed/', $item -> file_flash);
				$video = str_replace('/watch?v=', '/embed/', $item -> file_flash);

				if (strpos($video, '&') !== false) {
					$l_video =  strstr($video, '&');				
					$video = str_replace($l_video,'',$video);
				}	
	 		?>
	 		<div class="video_item">
	 			<div class="video_item_inner video_item_inner_has_img">
	 				<img  class="video owl-video" data-src='<?php echo URL_ROOT.str_replace('/original/','/resized/', $item -> image); ?>' alt='<?php echo $item->title;?>' link-video="<?php echo $video;?>" />
	 				<svg xmlns="http://www.w3.org/2000/svg"  viewBox="-21 -117 682.66672 682" ><path d="m626.8125 64.035156c-7.375-27.417968-28.992188-49.03125-56.40625-56.414062-50.082031-13.703125-250.414062-13.703125-250.414062-13.703125s-200.324219 0-250.40625 13.183593c-26.886719 7.375-49.03125 29.519532-56.40625 56.933594-13.179688 50.078125-13.179688 153.933594-13.179688 153.933594s0 104.378906 13.179688 153.933594c7.382812 27.414062 28.992187 49.027344 56.410156 56.410156 50.605468 13.707031 250.410156 13.707031 250.410156 13.707031s200.324219 0 250.40625-13.183593c27.417969-7.378907 49.03125-28.992188 56.414062-56.40625 13.175782-50.082032 13.175782-153.933594 13.175782-153.933594s.527344-104.382813-13.183594-154.460938zm-370.601562 249.878906v-191.890624l166.585937 95.945312zm0 0"/></svg>
	 			</div>
	 			<div class="video-name">
	 				<div class="video-name-inner">
	 					<?php echo $item -> title; ?>
	 				</div>
	 			</div>
	 		</div>
	 	<?php  } ?>
	 </div>
</div>