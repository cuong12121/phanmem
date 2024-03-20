<?php
global $tmpl; 
$tmpl -> addStylesheet('default2','blocks/albums/assets/css');
?>
<div class="slider-albums cf">

	<div class="sum_alb">
		<a href="<?php echo $link;?>" title = "<?php echo $summary;?>" target="_blink"><?php echo $summary;?></a>
	</div>
	<div id="block-albums" class="cls">
		<?php  $j=0; foreach($list as $item){?>  
			<div class="item wrapper-block-item-customer item_album item_album_<?php echo $j; ?>">
				<div class="block-item-customer cf ">
					<figure class="img_album">
						<a href="<?php echo  $item->link; ?>" class='cboxElement_album cboxElement image_al cb-image-link'  title="<?php echo $item -> title; ?>" target="_blink">
							<?php echo set_image_webp($item->image,'resized',@$item->title,'lazy',1,''); ?>
						</a>
					</figure>
				</div>
			</div>
			<?php $j++;?>
		<?php }?>
	</div>					
</div>

