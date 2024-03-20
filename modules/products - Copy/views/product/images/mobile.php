<?php 
global $tmpl;
//$tmpl -> addStylesheet('jquery.ad-gallery','libraries/jquery/gallery/css');
//$tmpl -> addScript('jquery.ad-gallery','libraries/jquery/gallery/js');
// colox box

?>
<?php $img = $data -> image?>
<div class='frame_img'>
	<div class='frame_img_inner'>
		

		<div id="sync1_wrapper" >
			<div <?php echo count($product_images) ? 'id="sync1" class="owl-carousel" ':'id="no-sync1"'; ?>" >
				<?php $j = 0; ?>
				<?php if(count($slideshow_highlight)){?>
					<?php for($i = 0; $i < count($slideshow_highlight); $i ++ ){?>
						<?php $j ++; ?>
						<?php $item = $slideshow_highlight[$i];?>
						<?php $image_small_other = str_replace('/original/', '/original/', $item->image); ?>	
						<div class="item">
							<?php 
							$class = 'image'.$i;
							echo set_image_webp($data->image,'large',@$data->name,$class,0,'itemprop="image"'); ?>
						</div>
					<?php } ?>
				<?php } ?>
				<?php if($img){?>
					<div class="item">
						<?php echo set_image_webp($data->image,'large',@$data->name,'',0,'itemprop="image"'); ?>
					</div>
				<?php }else{?>
					<div class="item">
						<img src="<?php echo URL_ROOT.'images/no-img_thumb.png'; ?>" longdesc="<?php echo URL_ROOT.'images/no-img.png'; ?>" alt="<?php echo $data -> name; ?>"  itemprop="image" />

					</div>
				<?php }?>
				<?php if(count($product_images)){?>
					<?php for($i = 0; $i < count($product_images); $i ++ ){?>
						<?php $j ++; ?>
						<?php $item = $product_images[$i];?>
						<?php $image_small_other = str_replace('/original/', '/large/', $item->image); ?>	
						<div class="item">
						<?php 
							$class = 'image'.$i;
							echo set_image_webp($item->image,'large',@$data->name,$class.'',0,'itemprop="image"'); ?>

						</div>
					<?php } ?>
				<?php } ?>
			</div>
		</div>
		<?php if($data -> style_types){ ?>
			<?php $arr_style_type = explode(',', $data -> style_types); ?>

			<?php foreach( $arr_style_type as $st){ ?>
				<?php if($st){ ?>
					<div class= '<?php echo $st; ?>'><div><?php echo $style_types_rule[$st]; ?></div></div>
				<?php } ?>
			<?php } ?>

		<?php } ?>

	</div>
</div>

