<?php
	global $tmpl; 
	$tmpl -> addStylesheet("one_large_and_list","blocks/videos/assets/css");
	$tmpl -> addScript("one_large_and_list","blocks/videos/assets/js");
?>



<a class="view-all" href="" title="xem tất cả video" >Xem thêm ›</a>

<div class="clear"></div>

 <div class="video_one_block_body block_body cls">
 	<?php $i = 0; ?>
 	<?php foreach($list as $item){?>
 		<?php $i ++; ?>	
 		<?php $video = str_replace('/watch?v=', '/embed/', $item -> file_flash);?>
 		<div class="video_item" id="one_video_play_area">
 			<div class="video_item_inner video_item_inner_has_img">
 				<img  class="videosssss lazy" id="videoooooo" data-src='<?php echo URL_ROOT.str_replace('/original/','/large/', $item -> image); ?>' alt='<?php echo $item->title;?>' link-video="<?php echo $video;?>"/>
 				<div class="video-name">
 					<div class="video-name-inner">
 						<h3><?php echo $item -> title; ?></h3>
 						
 					</div>
 				</div>
 				<div class="play-icon">
 					<span class="play-video play-video-big">
 						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 58 44" style="enable-background:new 0 0 58 44;" xml:space="preserve" width="512" height="512">
							<g id="_x31_-Video">
								<path style="fill:#DD352E;" d="M52.305,44H5.695C2.55,44,0,41.45,0,38.305V5.695C0,2.55,2.55,0,5.695,0h46.61   C55.45,0,58,2.55,58,5.695v32.61C58,41.45,55.45,44,52.305,44z"/>
								<path style="fill:#FFFFFF;" d="M21,32.53V11.47c0-1.091,1.187-1.769,2.127-1.214l17.82,10.53c0.923,0.546,0.923,1.882,0,2.427   l-17.82,10.53C22.187,34.299,21,33.621,21,32.53z"/>
							</g>

						</svg>
 					</span>
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

 		<div class="video_item_li cls" onclick="reload_video('<?php echo $video; ?>')">
 			<div class="image"><img class="lazy" data-src="<?php echo URL_ROOT.str_replace('/original/','/small/', $item -> image); ?>" alt="">
	 				<div class="play-icon">
	 					<span class="play-video">
	 						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 58 44" style="enable-background:new 0 0 58 44;" xml:space="preserve" width="512" height="512">
							<g id="_x31_-Video">
								<path style="fill:#DD352E;" d="M52.305,44H5.695C2.55,44,0,41.45,0,38.305V5.695C0,2.55,2.55,0,5.695,0h46.61   C55.45,0,58,2.55,58,5.695v32.61C58,41.45,55.45,44,52.305,44z"/>
								<path style="fill:#FFFFFF;" d="M21,32.53V11.47c0-1.091,1.187-1.769,2.127-1.214l17.82,10.53c0.923,0.546,0.923,1.882,0,2.427   l-17.82,10.53C22.187,34.299,21,33.621,21,32.53z"/>
							</g>

							</svg>

	 				</span>
	 			</div>
	 			<div class="title"><?php echo $item->title;?></div>
 			</div>
 			
 	
 		

 		<div class="clear"></div>
 	</div>


 <?php  } ?>
</div>
</div>
