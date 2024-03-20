 <?php
 global $tmpl,$is_mobile; 
 $tmpl -> addStylesheet("default","blocks/videos/assets/css");
 $tmpl -> addScript("videos","blocks/videos/assets/js");

 if(!IS_MOBILE){
 	$tt = 3;
 }else{
 	$tt = 2;
 }
 ?>
 <?php if(1==2) { ?>
 <div class="block_title cls">
 	<?php if($link_title){?>
 		<a href="<?php echo $link_title; ?>" title="<?php echo $title; ?>">
 			<?php echo $title ;?></a>
 		<?php } else {?>
 			<?php echo $title ;?>
 		<?php }?>
 	</div>
 <?php } ?>
 	<?php 
 	if(!empty($list)){
			// $to = count($list);
			// $sli = '';
			// $owl = 'lazy';
			// $it = 'item_video_pc';
			// if(!IS_MOBILE && $to > $tt){
			// 	$sli = 'video_slide';
			// 	$owl = 'owl-lazy';
			// 	$it = '';
			// }
 		$sli = 'video_slide';
 		$owl = 'owl-lazy';
 		$it = '';
 	}
 	?>
 	<div class="videos_block_body_body">
 		<div class="remore">
 			<a href="video.html" title="Xem thêm">Xem thêm<svg width="10px" height="10px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M17.525 36.465l-7.071 7.07c-4.686 4.686-4.686 12.284 0 16.971L205.947 256 10.454 451.494c-4.686 4.686-4.686 12.284 0 16.971l7.071 7.07c4.686 4.686 12.284 4.686 16.97 0l211.051-211.05c4.686-4.686 4.686-12.284 0-16.971L34.495 36.465c-4.686-4.687-12.284-4.687-16.97 0z" class=""></path></svg></a>
 		</div>
 		<div class="videos_block_body block_body cls <?php echo $sli;?>">
 			<?php 
 			$i = 1;
 			foreach($list as $item){?>
 				<?php if(!$item -> file_flash) continue;?>
 				<?php 

				//$video = str_replace('/watch?v=', '/embed/', $item -> file_flash);
 				$video = $item -> file_flash;
 				if (strpos($video, '&') !== false) {
 					$l_video =  strstr($video, '&');				
 					$video = str_replace($l_video,'',$video);
 				}
 				?>
 				<div class="item_video item_video2  <?php echo $it ;?> <?php echo ($i > $tt)?'hiden':'';?>">
 					<!-- <div class="video_item_inner video_item_inner_has_img" style="background-image:url('<?php //echo URL_ROOT.$item->image;?>'); "> -->
 						<?php echo set_back_webp(URL_ROOT.str_replace('/original/','/resized/', $item -> image),'','','video_item_inner video_item_inner_has_img ','',''); ?>
 						<!-- <img  src='<?php //echo URL_ROOT.str_replace('/original/','/resized/', $item -> image); ?>' alt='<?php //echo $item->title;?>'/> -->

 						<?php //echo set_image_webp($item->image,'resized',@$item->title,$owl,1,''); ?>
 						<a class="video owl-video" rel="nofollow" href="<?php echo $video;?>">
 						</a>
 						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
 							<g>
 								<g>
 									<path d="M256,0C114.833,0,0,114.844,0,256s114.833,256,256,256s256-114.844,256-256S397.167,0,256,0z M357.771,264.969    l-149.333,96c-1.75,1.135-3.771,1.698-5.771,1.698c-1.75,0-3.521-0.438-5.104-1.302C194.125,359.49,192,355.906,192,352V160    c0-3.906,2.125-7.49,5.563-9.365c3.375-1.854,7.604-1.74,10.875,0.396l149.333,96c3.042,1.958,4.896,5.344,4.896,8.969    S360.813,263.01,357.771,264.969z"/>
 								</g>
 							</g>
 						</svg>
 					</div>
 					<div class="video-name">
 						<div class="video-name-inner">
 							<?php echo $item -> title; ?>
 						</div>
 					</div>
 					<div class="info">
 						<span><?php echo $item-> hits?$item-> hits:'99'; ?> lượt xem</span>
 						<span>|</span>
 						<span><?php echo $item-> date_published?$item-> date_published:'01-01-2021'; ?></span>

 					</div>
 				</div>
 				<?php  $i++; } ?>
 			</div>
 		</div>