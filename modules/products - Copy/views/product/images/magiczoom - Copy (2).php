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



		</div>

		<div id="sync1_wrapper" >
			<?php 
			if(!empty($product_images) || !empty($data -> img_video_reality) && !empty($data -> link_video)){
				$id_class = 'id="sync1" class="owl-carousel" ';
			}else{
				$id_class = 'id="no-sync1"';
			}
			?>

			<div <?php echo $id_class; ?> >
				<?php $j = 0; ?>
				<?php if($img){?>
					<?php if(empty($product_image_default)){ ?>
						<?php if(!empty($data -> img_video_reality) && !empty($data -> link_video)){ ?>
							<?php $video_link = str_replace('/watch?v=', '/embed/', $data -> link_video);?>
							<div class="item" onclick="popup_video_full('<?php echo $video_link ?>')">
								<a href="javascript:void(0)" id='<?php echo $data->image;?>' rel="image_large1" class='selected cboxElement cb-image-link' title="<?php echo $data -> name; ?>"    rel="cb-image-link"   >
									<img src="<?php echo URL_ROOT.str_replace('/original/','/large/', $data->img_video_reality); ?>" longdesc="<?php echo URL_ROOT.str_replace('/original/','/large/', $data->img_video_reality); ?>" alt="<?php echo htmlspecialchars ($data -> name); ?>"  itemprop="image" />
									<span onclick="popup_video_full('<?php echo $video_link ?>')" class="play-video play-video-check">
										<img width="30px" src="<?php echo URL_ROOT ?>images/video_n.png" alt="play">
									</span>
								</a>
							</div>
						<?php } ?>

						<div class="item">
							<a href="javascript:void(0)" id='<?php echo $data->image;?>' rel="image_large1" class='selected cboxElement cb-image-link' title="<?php echo $data -> name; ?>"    rel="cb-image-link"   >
								<img onclick="gotoGallery(1,0,0);" src="<?php echo URL_ROOT.str_replace('/original/','/large/', $data->image); ?>" longdesc="<?php echo URL_ROOT.str_replace('/original/','/large/', $data->image); ?>" alt="<?php echo htmlspecialchars ($data -> name); ?>"  itemprop="image" />
								
							</a>
						</div>
					<?php }else{ ?>
						<div class="item">
							<a href="javascript:void(0)" id='<?php echo $product_image_default->image;?>' rel="image_large1" class='selected cboxElement cb-image-link' title="<?php echo $data -> name; ?>"    rel="cb-image-link"   >
								<img onclick="gotoGallery(1,0,0);" src="<?php echo URL_ROOT.str_replace('/original/','/large/', $product_image_default->image); ?>" longdesc="<?php echo URL_ROOT.$product_image_default->image; ?>" alt="<?php echo htmlspecialchars ($data -> name); ?>"  itemprop="image" />
							</a>
						</div>
					<?php } ?>


				<?php }else{?>

					<div class="item">
						<a href="<?php echo URL_ROOT.'images/no-img.png'; ?>" id='<?php echo 'images/no-img.png';?>' class='selected cboxElement cb-image-link' title="<?php echo $data -> name; ?>" rel="image_large1"  >
							<img src="<?php echo URL_ROOT.'images/no-img_thumb.png'; ?>" longdesc="<?php echo URL_ROOT.'images/no-img.png'; ?>" alt="<?php echo $data -> name; ?>"  itemprop="image" />
						</a>
					</div>
				<?php }?>

				<?php if(!empty($product_images)){?>
					<?php for($i = 0; $i < count($product_images); $i ++ ){?>
						<?php $j ++; ?>
						<?php $item = $product_images[$i];?>
						<?php $image_small_other = str_replace('/original/', '/large/', $item->image); ?>	
						<div class="item">
							<a href="javascript:void(0)" class=' cboxElement cb-image-link <?php echo $item -> color_id ? "color_owl_".$item -> color_id:""; ?>' rel="image_large1" title="<?php echo $data -> name; ?>" >
								<img  onclick="gotoGallery(1,0,0);" src="<?php echo URL_ROOT.$image_small_other; ?>" longdesc="<?php echo URL_ROOT.$item->image; ?>" alt="<?php echo htmlspecialchars ($data -> name); ?>"  class="image<?php echo $i;?>" itemprop="image"/>
							</a>
						</div>
					<?php } ?>
				<?php } ?>

			</div>
		</div>
	</div>
</div>

<div class='thumbs'>
	<div id="sync2" class="owl-carousel">
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

		<?php  if(!empty($arr_group_image)){
			$iarr = 0;
			foreach ($arr_group_image as $key=> $group_image) { ?>
				<div class="item <?php if(!$iarr) echo 'item_active'; ?>">
					<a href="javascript:void(0)" onclick="gotoGallery(1,0,0,<?php echo $key; ?>);" id='group_image_<?php echo $group_image->id;?>' rel="image_large" class='selected' title="<?php echo $data -> name; ?>" >
						<img src="<?php echo URL_ROOT.str_replace('/original/','/small/', $group_image->image); ?>" longdesc="<?php echo URL_ROOT.$group_image->image; ?>" alt="<?php echo htmlspecialchars ($data -> name); ?>"  itemprop="image" />
						<span class="group_name"><?php echo $group_image-> name; ?></span>
					</a>
				</div>
				<?php if(!$iarr) { ?>
					<?php if(!empty($list_video_review)){?>
						<a class="item" href="javascript:void(0)" onclick="open_popup_content(3)">
							<img src="<?php echo URL_ROOT.'images/image_video.png'; ?>" longdesc="<?php echo URL_ROOT.'images/image_video.png'; ?>" alt="<?php echo htmlspecialchars ($data -> name); ?>"  itemprop="image" />
							<span class="group_name">Video</span>
						</a>
					<?php } ?>
				<?php } ?>
				<?php $iarr++; } ?>
			<?php } else {?>
				<a class="item" href="javascript:void(0)" onclick="open_popup_content(3)">
					<img src="<?php echo URL_ROOT.'images/image_video.png'; ?>" longdesc="<?php echo URL_ROOT.'images/image_video.png'; ?>" alt="<?php echo htmlspecialchars ($data -> name); ?>"  itemprop="image" />
					<span class="group_name">Video</span>
				</a>
			<?php } ?>

			<?php if(!empty($arr_color_image)){
				foreach ($arr_color_image as $key=> $color_image) { ?>
					<div class="item">
						<a href="javascript:void(0)" onclick="gotoGallery(2,0,0,<?php echo $key; ?>);" id='group_image_<?php echo $color_image->id;?>' rel="image_large" class='selected' title="<?php echo $data -> name; ?>" >
							<img src="<?php echo URL_ROOT.str_replace('/original/','/small/', $list_color_image[$key][0]->image); ?>" longdesc="<?php echo URL_ROOT.$list_color_image[$key][0]->image; ?>" alt="<?php echo htmlspecialchars ($data -> name); ?>"  itemprop="image" />
							<span class="group_name"><?php echo $color_image-> name; ?></span>
						</a>
					</div>
				<?php } ?>
			<?php } ?>
			<?php if(1==1){?>
				<a class="item" href="javascript:void(0)" onclick="open_popup_content(1)">
					<img src="<?php echo URL_ROOT.'images/specification.png'; ?>" longdesc="<?php echo URL_ROOT.'images/specification.png'; ?>" alt="<?php echo htmlspecialchars ($data -> name); ?>"  itemprop="image" />
					<span class="group_name">Thông số kỹ thuật</span>
				</a>
			<?php } ?>
			<?php if(1==1){?>
				<a class="item" href="javascript:void(0)" onclick="open_popup_content(2)">
					<img src="<?php echo URL_ROOT.'images/content.png'; ?>" longdesc="<?php echo URL_ROOT.'images/content.png'; ?>" alt="<?php echo htmlspecialchars ($data -> name); ?>"  itemprop="image" />
					<span class="group_name">Bài viết</span>
				</a>
			<?php } ?>
		</div>
	</div>


	<div class="slide_FT"></div>