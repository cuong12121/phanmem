

<?php 
	// $url = $data -> file_flash;
	// parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
	// echo $my_array_of_vars['v'];
	// die;
?>


<?php if($data -> file_flash) { ?>
	<?php 
		$video = str_replace('/watch?v=', '/embed/', $data -> file_flash);
		if (strpos($video, '&') !== false) {
			$l_video =  strstr($video, '&');
			
			$video = str_replace($l_video,'',$video );
		}

	?>

	<?php $image_webp = $this -> image_webp(URL_ROOT.str_replace('/original/','/large/', $data->image)) ;?>
		<div class="video_item" id="one_video_play_area">
			<div class="video_item_inner video_item_inner_has_img">
	    		<img  class="video" srcset="<?php echo $image_webp; ?>" src='<?php echo URL_ROOT.str_replace('/original/','/large/', $data -> image); ?>' alt='<?php echo $data->title;?>' link-video="<?php echo $video;?>"  />
	    		<div class="video-name">
		    		<div class="video-name-inner">
	    				<?php echo $data -> title; ?>
	    			</div>
	    		</div>
	    		<div class="icon"><svg id="" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
 							<g>
 								<path d="M490.24,113.92c-13.888-24.704-28.96-29.248-59.648-30.976C399.936,80.864,322.848,80,256.064,80   c-66.912,0-144.032,0.864-174.656,2.912c-30.624,1.76-45.728,6.272-59.744,31.008C7.36,138.592,0,181.088,0,255.904   C0,255.968,0,256,0,256c0,0.064,0,0.096,0,0.096v0.064c0,74.496,7.36,117.312,21.664,141.728   c14.016,24.704,29.088,29.184,59.712,31.264C112.032,430.944,189.152,432,256.064,432c66.784,0,143.872-1.056,174.56-2.816   c30.688-2.08,45.76-6.56,59.648-31.264C504.704,373.504,512,330.688,512,256.192c0,0,0-0.096,0-0.16c0,0,0-0.064,0-0.096   C512,181.088,504.704,138.592,490.24,113.92z"></path>
 								<polygon style="fill:#FAFAFA;" points="192,352 192,160 352,256  "></polygon>
 							</g>
 						</svg></div>
    		</div>
    	</div>


<?php }?>