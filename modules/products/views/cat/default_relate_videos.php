<?php 
	if(!empty($relate_videos)){
?>
<div class="relate_videos cls">
	<div class="relate_videos_title">
		<a href="<?php echo $cat->link_video_related; ?>" title="Video liên quan">Video liên quan</a>
	</div>
	<div class="clear"></div>
	<div class ="relate_videos_all">
		<?php foreach ($relate_videos as $key => $item) { ?>
			<?php $video = str_replace('/watch?v=', '/embed/', $item -> file_flash);?>
			<?php $link = FSRoute::_("index.php?module=videos&view=video&id=".$item->id."&code=".$item->alias); ?>
	        <div class='item' onclick="popup_video_full('<?php echo $video; ?>')">
				<div class="image">
	        		<a href="javascript:void(0)" title="<?php echo $item -> title; ?>" class="item-img">
		           		<?php echo set_image_webp($item->image,'large',@$item->title,'lazy',1,''); ?>
		            </a>
		            <svg width="40px" height="40px" x="0px" y="0px" viewBox="0 0 314.068 314.068" style="enable-background:new 0 0 314.068 314.068;" xml:space="preserve">
	 					<g>
	 						<g>
	 							<g>
	 								<path d="M293.002,78.53C249.646,3.435,153.618-22.296,78.529,21.068C3.434,64.418-22.298,160.442,21.066,235.534
	 								c43.35,75.095,139.375,100.83,214.465,57.47C310.627,249.639,336.371,153.62,293.002,78.53z M219.834,265.801
	 								c-60.067,34.692-136.894,14.106-171.576-45.973C13.568,159.761,34.161,82.935,94.23,48.26
	 								c60.071-34.69,136.894-14.106,171.578,45.971C300.493,154.307,279.906,231.117,219.834,265.801z M213.555,150.652l-82.214-47.949
	 								c-7.492-4.374-13.535-0.877-13.493,7.789l0.421,95.174c0.038,8.664,6.155,12.191,13.669,7.851l81.585-47.103
	 								C221.029,162.082,221.045,155.026,213.555,150.652z"></path>
	 							</g>
	 						</g>
	 					</g>
	 				</svg>
	            </div>	
	            <a href="javascript:void(0)" title="<?php echo $item -> title; ?>" class='name' ><span><?php echo $item -> title;?></span></a>
	            <div class='clear'></div>
				
	        </div>
		<?php } ?>
	</div>
	
</div>

<?php } ?>



<div class="popup-video-full">
	
	<div class="close" onclick="close_popup_video_full()">X</div>
	<div class="content-video">
		<div class="video">
		
		</div>
	</div>
	
</div>