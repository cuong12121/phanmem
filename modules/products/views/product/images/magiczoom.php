<?php 
global $tmpl;
//$tmpl -> addStylesheet('jquery.ad-gallery','libraries/jquery/gallery/css');
//$tmpl -> addScript('jquery.ad-gallery','libraries/jquery/gallery/js');
// colox box

$tmpl -> addScript('product_images_fotorama','modules/products/assets/js');
$tmpl -> addStylesheet('fotorama','libraries/jquery/fotorama-4.6.4');
?>
<?php $img = $data -> image?>
<div class='frame_img' >
	<div class='frame_img_inner'>
		<div class="magic_zoom_area">
			<?php if(!empty($arr_group_image)) {?>
				<div class="area_sync1">
					<div id="sync1">
						<?php $ig=0; foreach ($arr_group_image as $key => $value) {
							if($ig) break;
							$im=0;
							foreach ($list_group_image[$key] as $item) { ?>
								<div class="item <?php if($im > 0) echo 'hide'; ?>" onclick="gotoGallery(1,0,<?php echo $im; ?>,<?php echo $key; ?>);">
									<?php if(!$im){ ?>
										<?php echo set_image_webp($item-> image,'large',@$data-> name,'',0,''); ?>
									<?php } else { ?>
										<?php echo set_image_webp($item-> image,'large',@$data-> name,'owl-lazy',1,''); ?>
									<?php } ?>
								</div>
								<?php $im++; } $ig++;
							} ?>
						</div>
					</div>
				<?php } elseif(!empty($arr_color_image)) {?>
					<div class="area_sync1">
						<div id="sync1">
							<?php $ig=0; foreach ($arr_color_image as $key => $value) {
								if($ig) break;
								$im=0;
								foreach ($list_color_image[$key] as $item) { ?>
									<div class="item <?php if($im > 0) echo 'hide'; ?>" onclick="gotoGallery(2,0,<?php echo $im; ?>,<?php echo $key; ?>);">
										<?php if(!$im || 1==1){ ?>
											<?php echo set_image_webp($item-> image,'large',@$data-> name,'',0,''); ?>
										<?php } else { ?>
											<?php echo set_image_webp($item-> image,'large',@$data-> name,'owl-lazy',1,''); ?>
										<?php } ?>
									</div>
									<?php $im++; } $ig++;
								} ?>
							</div>
						</div>
					<?php } else {?>
						<?php if(!empty($data -> img_video_reality) && !empty($data -> link_video)){ ?>
							<?php $video_link = str_replace('/watch?v=', '/embed/', $data -> link_video);?>
							<a id="Zoomer" href="javascript:void(0)" data-image="<?php echo URL_ROOT.str_replace('/original/','/large/', $data -> img_video_reality); ?>" class="MagicZoomPlus item_video" title="" >
								<img onclick="popup_video_full('<?php echo $video_link ?>')" src="<?php echo URL_ROOT.str_replace('/original/','/large/', $data -> img_video_reality); ?>" >

								<span onclick="popup_video_full('<?php echo $video_link ?>')" class="play-video play-video-check">
									<img src="<?php echo URL_ROOT ?>images/video_n.png" alt="play">
								</span>
							</a>
							<input type="hidden" value="<?php echo $video_link ?>" class="video_link">
						<?php }elseif(empty($product_image_default)){ ?>
							<a id="Zoomer" href="javascript:void(0)" data-image="<?php echo URL_ROOT.str_replace('/original/','/large/', $data -> image); ?>" class="MagicZoomPlus" title="" >
								<!-- <img onclick="gotoGallery(1,0,0);" src="<?php echo URL_ROOT.str_replace('/original/','/large/', $data -> image); ?>" > -->
								<img  src="<?php echo URL_ROOT.str_replace('/original/','/large/', $data -> image); ?>" >
							</a>
						<?php }else{ ?>
							<a id="Zoomer" href="javascript:void(0)" data-image="<?php echo URL_ROOT.str_replace('/original/','/large/', $product_image_default -> image); ?>" class="MagicZoomPlus" title="" >
								<!-- <img  onclick="gotoGallery(1,0,0);" src="<?php echo URL_ROOT.str_replace('/original/','/large/', $product_image_default -> image); ?>" > -->
								<img src="<?php echo URL_ROOT.str_replace('/original/','/large/', $product_image_default -> image); ?>" >
							</a>
						<?php } ?>
					<?php } ?>
				</div>
			</div>
		</div>

		<div class='thumbs'>
			<div class="list_note_thumbs">
				<?php 
				if(!empty($arr_group_image)) { foreach ($arr_group_image as $key=> $group_image) { ?>
					<div class="item item_t_group hide" id="item_t_group_<?php echo $key; ?>"><a href="javascript:void(0)" onclick="gotoGallery(1,0,0,<?php echo $key;?>)">Xem thêm <?php echo $group_image-> name; ?> (<?php echo count($list_group_image[$key]); ?>)</a></div>
				<?php } } ?>

				<?php if(!empty($arr_color_image)){
					foreach ($arr_color_image as $key=> $color_image) { ?>
						<div class="item item_t_color hide" id="item_t_color_<?php echo $key; ?>"><a href="javascript:void(0)" onclick="gotoGallery(2,0,0,<?php echo $key;?>)">Xem thêm <?php echo $color_image-> name; ?>(<?php echo count($list_color_image[$key]); ?>)</a></div>
					<?php }}?>
				</div>

				<div class="wrapper_sync2">
					<div id="sync2<?php if($is_mobile) echo 'c'; ?>">
<!-- 		<?php if(!empty($data -> img_video_reality) && !empty($data -> link_video)){ ?>
			<?php $video_link = str_replace('/watch?v=', '/embed/', $data -> link_video);?>
			<div class="item is_video" onclick="popup_video_full('<?php echo $video_link ?>')">
				<a href="javascript:void(0)" id='<?php echo $data->img_video_reality;?>' rel="image_large" class='selected' title="<?php echo $data -> name; ?>" >
					<img src="<?php echo URL_ROOT.str_replace('/original/','/small/', $data->img_video_reality); ?>" longdesc="<?php echo URL_ROOT.$data->img_video_reality; ?>" alt="<?php echo htmlspecialchars ($data -> name); ?>"  itemprop="image" />
					<span class="play-video-small">
						<img width="30px" src="<?php echo URL_ROOT ?>images/video_n.png" alt="play">
					</span>
				</a>
			</div>
			<?php } ?> -->


			<?php $iarr = 0; ?>
			<?php  if(!empty($arr_group_image)){
				foreach ($arr_group_image as $key=> $group_image) { ?>

					<?php if($is_mobile){?>
						<div class="item item_<?php echo $iarr; ?> <?php if(!$iarr) echo 'item_active'; ?>">
							<a href="javascript:void(0)" onclick="gotoSlide(1,<?php echo $key;?>,<?php echo $iarr;?>);" id='group_image_<?php echo $group_image->id;?>' rel="image_large" class='selected' title="<?php echo $data -> name; ?>" >
								<img src="<?php echo URL_ROOT.str_replace('/original/','/small/', $list_group_image[$key][0]->image); ?>" longdesc="<?php echo URL_ROOT.$group_image->image; ?>" alt="<?php echo htmlspecialchars ($data -> name); ?>"  itemprop="image" />
								<span class="group_name"><?php echo $group_image-> name; ?></span>
							</a>
						</div>
					<?php } else { ?>
						<div class="item item_<?php echo $iarr; ?> <?php if(!$iarr) echo 'item_active'; ?>">
							<a href="javascript:void(0)" onclick="gotoSlide(1,<?php echo $key;?>,<?php echo $iarr;?>);" id='group_image_<?php echo $group_image->id;?>' rel="image_large" class='selected' title="<?php echo $data -> name; ?>" >
								<img src="<?php echo URL_ROOT.str_replace('/original/','/small/', $group_image->image); ?>" longdesc="<?php echo URL_ROOT.$group_image->image; ?>" alt="<?php echo htmlspecialchars ($data -> name); ?>"  itemprop="image" />
								<span class="group_name"><?php echo $group_image-> name; ?></span>
							</a>
						</div>
					<?php } ?>
					<?php $iarr++; } ?>
				<?php } ?>

				<?php if(!empty($arr_color_image)){
					foreach ($arr_color_image as $key=> $color_image) { ?>
						<div class="item item_<?php echo $iarr; ?>">
							<a href="javascript:void(0)" onclick="gotoSlide(2,<?php echo $key;?>,<?php echo $iarr;?>);" id='group_image_<?php echo $color_image->id;?>' rel="image_large" class='selected' title="<?php echo $data -> name; ?>" >
								<img src="<?php echo URL_ROOT.str_replace('/original/','/small/', $list_color_image[$key][0]->image); ?>" longdesc="<?php echo URL_ROOT.$list_color_image[$key][0]->image; ?>" alt="<?php echo htmlspecialchars ($data -> name); ?>"  itemprop="image" />
								<span class="group_name"><?php echo $color_image-> name; ?></span>
							</a>
						</div>
						<?php $iarr++; } ?>
					<?php } ?>
					<?php if(1==1){?>
						<?php if(!empty($list_video_review)){?>
							<div class="item">
															<a class="" href="javascript:void(0)" onclick="open_popup_content(3)">
								<img src="<?php echo URL_ROOT.'images/image_video.png'; ?>" longdesc="<?php echo URL_ROOT.'images/image_video.png'; ?>" alt="<?php echo htmlspecialchars ($data -> name); ?>"  itemprop="image" />
								<span class="group_name">Video</span>
							</a>
							</div>
						<?php } ?>
						<div class="item">
						<a class="" href="javascript:void(0)" onclick="open_popup_content(1)">
							<img src="<?php echo URL_ROOT.'images/specification.png'; ?>" longdesc="<?php echo URL_ROOT.'images/specification.png'; ?>" alt="<?php echo htmlspecialchars ($data -> name); ?>"  itemprop="image" />
							<span class="group_name">Thông số kỹ thuật</span>
						</a>
					</div>

					<?php } ?>
					<?php if(1==1){?>
<div class="item">
						<a class="" href="javascript:void(0)" onclick="open_popup_content(2)">
							<img src="<?php echo URL_ROOT.'images/content.png'; ?>" longdesc="<?php echo URL_ROOT.'images/content.png'; ?>" alt="<?php echo htmlspecialchars ($data -> name); ?>"  itemprop="image" />
							<span class="group_name">Bài viết</span>
						</a>
					</div>
					<?php } ?>
				</div>
			</div>

		</div>


		<div class="slide_FT"></div>