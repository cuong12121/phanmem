 <?php
	global $tmpl; 
	$tmpl -> addStylesheet("video_home","blocks/videos/assets/css");
	$tmpl -> addScript("video_product","blocks/videos/assets/js");
?>


<?php foreach ($list as $key => $item) {
	
		$video = str_replace('/watch?v=', '/embed/', $item-> file_flash);
		if (strpos($video, '&') !== false) {
			$l_video =  strstr($video, '&');
			
			$video = str_replace($l_video,'',$video );
		}


	
		$image = URL_ROOT.str_replace('/original/','/compress/', $item-> image) ;
	?>
	

	<div class="video_product">
		<div class="video_product_inner video_product_inner_has_img" link-video="<?php echo $video;?>" style = "background-image: url(<?php echo $image;?>);">
    		<div class="icon">
    			<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="124.512px" height="124.512px" viewBox="0 0 124.512 124.512" style="enable-background:new 0 0 124.512 124.512;" xml:space="preserve">
						<g>
							<path d="M113.956,57.006l-97.4-56.2c-4-2.3-9,0.6-9,5.2v112.5c0,4.6,5,7.5,9,5.2l97.4-56.2
								C117.956,65.105,117.956,59.306,113.956,57.006z"></path>
						</g>
					</svg>
			</div>
		</div>

		<div class="container">
 			<div class="summary">
		 		<?php echo $item->summary;?>
		 	</div>
 		</div> 
	</div>


<?php }?>