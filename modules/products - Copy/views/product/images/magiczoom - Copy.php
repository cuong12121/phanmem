<?php 
global $tmpl;
//$tmpl -> addStylesheet('jquery.ad-gallery','libraries/jquery/gallery/css');
//$tmpl -> addScript('jquery.ad-gallery','libraries/jquery/gallery/js');
// colox box
$tmpl -> addStylesheet('owl.carousel','libraries/jquery/owl.carousel.2/assets');
$tmpl -> addScript('owl.carousel.min','libraries/jquery/owl.carousel.2');

$tmpl -> addStylesheet('magiczoomplus','libraries/jquery/magiczoomplus');
$tmpl -> addScript('magiczoomplus','libraries/jquery/magiczoomplus');

$tmpl -> addScript('product_images_magiczoom','modules/products/assets/js');
$tmpl -> addStylesheet('product_images_magiczoom','modules/products/assets/css');
?>
<?php $img = $data -> image?>
<div class='frame_img'>
	<div class='frame_img_inner'>
		<div class="magic_zoom_area">
			<a id="Zoomer" href="<?php echo URL_ROOT.str_replace('/original/','/original/', $data -> image); ?>" class="MagicZoomPlus" data-options="expand: off; hint: always; textHoverZoomHint: <?php echo FSText::_('roll over image to zoom in');?>; zoomOn: hover" title="" >
				<img src="<?php echo URL_ROOT.str_replace('/original/','/large/', $data -> image); ?>" >
			</a>
		</div>
					
		<div id="sync1_wrapper" >
			<div <?php echo count($product_images) ? 'id="sync1" class="owl-carousel" ':'id="no-sync1"'; ?>" >
				<?php $j = 0; ?>
				<?php if($img){?>
			    	 	 <div class="item">
							<a href="javascript: void(0)' rel="image_large1" class='selected cboxElement cb-image-link' title="<?php echo $data -> name; ?>"    rel="cb-image-link"   >
								<img src="<?php echo URL_ROOT.str_replace('/original/','/large/', $data->image); ?>" longdesc="<?php echo URL_ROOT.$data->image; ?>" alt="<?php echo htmlspecialchars ($data -> name); ?>"  itemprop="image" />
							</a>
			            </div>
		            <?php }else{?>
		            	<div class="item">
							<a href="javascript: void(0)" id='<?php echo 'images/no-img.png';?>' class='selected cboxElement cb-image-link' title="<?php echo $data -> name; ?>" rel="image_large1"  >
								<img src="<?php echo URL_ROOT.'images/no-img_thumb.png'; ?>" longdesc="<?php echo URL_ROOT.'images/no-img.png'; ?>" alt="<?php echo $data -> name; ?>"  itemprop="image" />
							</a>
			            </div>
		            <?php }?>
		            <?php if(count($product_images)){?>
		            	<?php for($i = 0; $i < count($product_images); $i ++ ){?>
		            		<?php $j ++; ?>
		            		<?php $item = $product_images[$i];?>
		            		<?php $image_small_other = str_replace('/original/', '/large/', $item->image); ?>	
		            		<div class="item">
								<a href="javascript: void(0)"     class=' cboxElement cb-image-link' rel="image_large1" title="<?php echo $data -> name; ?>" >
									<img src="<?php echo URL_ROOT.$image_small_other; ?>" longdesc="<?php echo URL_ROOT.$item->image; ?>" alt="<?php echo htmlspecialchars ($data -> name); ?>"  class="image<?php echo $i;?>" itemprop="image"/>
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
 		<?php if($img){?>
	    	 	 <div class="item">
					<a href="<?php echo URL_ROOT.$data->image; ?>" id='<?php echo $data->image;?>' rel="image_large" class='selected' title="<?php echo $data -> name; ?>" >
						<img src="<?php echo URL_ROOT.str_replace('/original/','/small/', $data->image); ?>" longdesc="<?php echo URL_ROOT.$data->image; ?>" alt="<?php echo htmlspecialchars ($data -> name); ?>"  itemprop="image" />
					</a>
	            </div>
            <?php }else{?>
            	<div class="item">
					<a href="<?php echo URL_ROOT.'images/no-img.png'; ?>" id='<?php echo 'images/no-img.png';?>' rel="image_large" class='selected' title="no-title">
						<img src="<?php echo URL_ROOT.'images/no-img_thumb.png'; ?>" longdesc="<?php echo URL_ROOT.'images/no-img.png'; ?>" alt="no-title"   itemprop="image" />
					</a>
	            </div>
            <?php }?>
            <?php if(count($product_images)){?>
            	<?php for($i = 0; $i < count($product_images); $i ++ ){?>
            		<?php $item = $product_images[$i];?>
            		<?php $image_small_other = str_replace('/original/', '/small/', $item->image); ?>	
            		<div class="item">
						<a href="<?php echo URL_ROOT.$item->image; ?>"   >
							<img src="<?php echo URL_ROOT.$image_small_other; ?>" longdesc="<?php echo URL_ROOT.$item->image; ?>" alt="<?php echo htmlspecialchars ($data -> name); ?>"  class="image<?php echo $i;?>"  itemprop="image" />
						</a>
					</div>
            	<?php } ?>
            <?php } ?>
	</div>
</div>
