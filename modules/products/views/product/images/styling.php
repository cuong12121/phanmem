<?php 
global $tmpl;

// $tmpl -> addScript('jquery.jcarousel.min','libraries/jquery/jcarousel/js');

$tmpl -> addScript('product_images_fotorama','modules/products/assets/js');
// $tmpl -> addStylesheet('jcarousel.vert','modules/products/assets/css');

// $tmpl -> addStylesheet('magiczoomplus','libraries/jquery/magiczoomplus');
// $tmpl -> addScript('magiczoomplus','libraries/jquery/magiczoomplus');

$tmpl -> addStylesheet('fotorama','libraries/jquery/fotorama-4.6.4');

// $array1 = array("0" => $data);
// $result = array_merge($array1, $product_images);
// $total =count($product_images);
$img = $data -> image;

?>
<?php //if($total){ ?>
	<div style="position:relative; left:0px;text-align: center;margin-bottom:20px;">
		<?php echo set_image_webp($data->image,'large',@$data->name,'img-responsive',0,'style="cursor: pointer" onclick="gotoGallery(1,0,0)" data-order="1" alt="<?php echo $data -> name; ?>" itemprop="image"'); ?>

	</div>

	<div class='thumbs'>
		<?php if(@count($product_images) > 3) { ?>
			<div id="sync2" class="owl-carousel">
				<?php if($img){?>
					<div class="item">
						<a href="javascript: void(0)" id='<?php echo $data->image;?>' rel="image_large" class='selected' title="<?php echo $data -> name; ?>" onclick="gotoGallery(1,0,0)" data-order="1">
							<?php echo set_image_webp($data->image,'small',@$data->name,'',0,'itemprop="image" longdesc="'.URL_ROOT.$data->image.'"'); ?>
						</a>
					</div>
				<?php }else{?>
					<div class="item">
						<a href="javascript: void(0)" id='<?php echo 'images/no-img.png';?>' rel="image_large" class='selected' title="no-title">
							<img src="<?php echo URL_ROOT.'images/no-img_thumb.png'; ?>" longdesc="<?php echo URL_ROOT.'images/no-img.png'; ?>" alt="no-title"   itemprop="image" />
						</a>
					</div>
				<?php }?>
				<?php if(count($product_images)){?>
					<?php for($i = 0; $i < count($product_images); $i ++ ){?>
						<?php $item = $product_images[$i];?>
						<?php $image_small_other = URL_ROOT.str_replace('/original/', '/small/', $item->image); ?>	
						<div class="item">
							<a href="javascript: void(0)"  class="<?php echo $item -> color_id ? "color_thump_".$item -> color_id:""; ?>" data-order="<?php echo ($i+2); ?>" onclick="gotoGallery(1,0,<?php echo $i+1; ?>)">

								<?php $class= 'image'.$i;
								echo set_image_webp($image_small_other,'',@$data->name,$class,0,'itemprop="image" longdesc="'.URL_ROOT.$item->image.'"'); ?>
							</a>
						</div>
					<?php } ?>
				<?php } ?>
			</div>
		<?php } else { ?>
			<div id="sync2c">
				<?php if($img){?>
					<div class="item">
						<a href="javascript: void(0)" id='<?php echo $data->image;?>' rel="image_large" class='selected' title="<?php echo $data -> name; ?>" onclick="gotoGallery(1,0,0)" data-order="1">
							<?php echo set_image_webp($data->image,'small',@$data->name,'',0,'itemprop="image" longdesc="'.URL_ROOT.$data->image.'"'); ?>
						</a>
					</div>
				<?php }else{?>
					<div class="item">
						<a href="javascript: void(0)" id='<?php echo 'images/no-img.png';?>' rel="image_large" class='selected' title="no-title" onclick="gotoGallery(1,0,0)" data-order="1">
							<img src="<?php echo URL_ROOT.'images/no-img_thumb.png'; ?>" longdesc="<?php echo URL_ROOT.'images/no-img.png'; ?>" alt="no-title"   itemprop="image" />
						</a>
					</div>
				<?php }?>
				<?php if(count($product_images)){?>
					<?php for($i = 0; $i < count($product_images); $i ++ ){?>
						<?php $item = $product_images[$i];?>
						<?php $image_small_other = URL_ROOT.str_replace('/original/', '/small/', $item->image); ?>	
						<div class="item">
							<a href="javascript: void(0)"  class="<?php echo $item -> color_id ? "color_thump_".$item -> color_id:""; ?>" data-order="<?php echo ($i+2); ?>" onclick="gotoGallery(1,0,<?php echo $i+1; ?>)">
								<?php $class= 'image'.$i;
								echo set_image_webp($image_small_other,'',@$data->name,$class,0,'itemprop="image" longdesc="'.URL_ROOT.$item->image.'"'); ?>
							</a>
						</div>
					<?php } ?>
				<?php } ?>
			</div>

		<?php } ?>
	</div>

<!-- <div class="colorandpic">
	<ul class="tabscolor">
		<li class="has" onclick="gotoGallery(1,0,4)"><div><i class="itemp-slide"></i></div>Slideshow</li>
		
	    <li class="has" onclick="gotoGallery(4,0,0)"><div><i class="itemp-video"></i></div>Video</li>
	    
	</ul>
</div> -->
<div class="slide_FT"></div>
<?php //} ?>
