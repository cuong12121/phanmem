<?php if(!empty($list_video_review)){?>
	<div class="title-box-product">Video sản phẩm</div>
	<div class="list_video_review">
		<?php foreach($list_video_review as $item){?>
		 	<?php if(!$item -> link) continue;?>
		 	<?php 
		 		parse_str( parse_url($item -> link, PHP_URL_QUERY ), $my_array_of_vars );
		 		$id_video = $my_array_of_vars['v']; 
		 		$video = 'https://www.youtube.com/embed/'.$id_video;
		 		
		 	?>
	 		<div class="video_item">
	 			<div class="video_item_inner video_item_inner_has_img">
	 				<?php 
	 					if(!empty($item ->image)){
	 						echo set_image_webp($item->image,'large','Video '.$data->name,'video lazy',1,'link-video='.$video); 
	 					}else{
	 				?>
						<img  class="video" src='<?php echo "https://i.ytimg.com/vi/".$id_video."/hqdefault.jpg" ?>' alt='<?php echo "Video ".$data->name;?>' link-video="<?php echo $video;?>" />
	 				<?php } ?>

	 				<span class="play-video">
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 58 44" style="enable-background:new 0 0 58 44;" xml:space="preserve" width="512" height="512">
							<g id="_x31_-Video">
								<path style="fill:#DD352E;" d="M52.305,44H5.695C2.55,44,0,41.45,0,38.305V5.695C0,2.55,2.55,0,5.695,0h46.61   C55.45,0,58,2.55,58,5.695v32.61C58,41.45,55.45,44,52.305,44z"></path>
								<path style="fill:#FFFFFF;" d="M21,32.53V11.47c0-1.091,1.187-1.769,2.127-1.214l17.82,10.53c0.923,0.546,0.923,1.882,0,2.427   l-17.82,10.53C22.187,34.299,21,33.621,21,32.53z"></path>
							</g>

						</svg>
					</span>
	 			</div>
		 	</div>
		<?php  } ?>
	</div>
<?php } ?>

