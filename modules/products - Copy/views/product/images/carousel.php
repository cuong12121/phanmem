<?php 
global $tmpl;
//$tmpl -> addStylesheet('jquery.ad-gallery','libraries/jquery/gallery/css');
//$tmpl -> addScript('jquery.ad-gallery','libraries/jquery/gallery/js');
// colox box
$tmpl -> addStylesheet('owl.carousel','libraries/jquery/owl.carousel.2/assets');
$tmpl -> addScript('owl.carousel.min','libraries/jquery/owl.carousel.2');
$tmpl -> addStylesheet('colorbox','libraries/jquery/colorbox/css');
$tmpl -> addScript('jquery.colorbox','libraries/jquery/colorbox/js');
$tmpl -> addScript('product_images_carousel','modules/products/assets/js');
$tmpl -> addStylesheet('product_images_carousel','modules/products/assets/css');
?>
<?php $img = $data -> image?>
<div class='frame_img'>
	<div class='frame_img_inner'>
		<div id="sync1" class="owl-carousel">
			<?php $j = 0; ?>
			<?php if($img){?>
		    	 	 <div class="item">
						<a href="<?php echo URL_ROOT.$data->image; ?>" id='<?php echo $data->image;?>' rel="image_large1" class='selected cboxElement cb-image-link' title="<?php echo $data -> name; ?>"    rel="cb-image-link"   >
							<img src="<?php echo URL_ROOT.str_replace('/original/','/large/', $data->image); ?>" longdesc="<?php echo URL_ROOT.$data->image; ?>" alt="<?php echo htmlspecialchars ($data -> name); ?>"  itemprop="image" />
						</a>
		            </div>
	            <?php }else{?>
	            	<div class="item">
						<a href="<?php echo URL_ROOT.'images/no-img.png'; ?>" id='<?php echo 'images/no-img.png';?>' class='selected cboxElement cb-image-link' title="<?php echo $data -> name; ?>" rel="image_large1"  >
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
							<a href="<?php echo URL_ROOT.$item->image; ?>"     class=' cboxElement cb-image-link' rel="image_large1" title="<?php echo $data -> name; ?>" >
								<img src="<?php echo URL_ROOT.$image_small_other; ?>" longdesc="<?php echo URL_ROOT.$item->image; ?>" alt="<?php echo htmlspecialchars ($data -> name); ?>"  class="image<?php echo $i;?>" itemprop="image"/>
							</a>
						</div>
	            	<?php } ?>
	            <?php } ?>
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
