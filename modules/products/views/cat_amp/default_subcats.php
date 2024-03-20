<?php if(!empty($sub_cats)){ ?>
<div class="list_sub_cats_wrapper_sroll">
	<?php if($is_mobile){
		$w = count($sub_cats) * 110; 
	?>
	<div class="list_sub_cats_wrapper" style="width: <?php echo $w.'px'; ?>">
	<?php }else{ ?>
	<div class="list_sub_cats_wrapper">
	<?php } ?>
		<?php foreach ($sub_cats as $cat_s){
			if($checkmanu == 1){
				$link_cat_s  = FSRoute::_('index.php?module=products&view=cat&cid='.$cat_s->id.'&ccode='.$cat_s->alias.'&Itemid=5');
				$link_cat_s = str_replace('-pc'.$cat_s->id,'-pcm'.$cat_s->id,$link_cat_s);
				if(!empty($cat_s->alias1) AND !empty($cat_s->alias2)){
					
					$link_cat_s = str_replace($cat_s->alias,$cat_s->alias1.'-'.$filter_old.'-'.$cat_s->alias2,$link_cat_s);
				}else{

					$link_cat_s = str_replace($cat_s->alias,$cat_s->alias.'-'.$filter_old,$link_cat_s);
				}
			}else{
				$link_cat_s  = FSRoute::_('index.php?module=products&view=cat&cid='.$cat_s->id.'&ccode='.$cat_s->alias.'&Itemid=5');
			}
		?>

			<?php 
				if($manufactory_id && strpos(','.$cat_s->manufactory_related.',', ','.$manufactory_id.',') !== false){
			?>
				<?php if($is_mobile){ ?>
				<div class="item item-mobile">
				<?php }else{ ?>
				<div class="item">
				<?php } ?>
					<a href="<?php echo $link_cat_s; ?>" title="<?php echo $cat_s-> name . ' '. $str_manufactory_title; ?>">
						<?php echo set_image_webp($cat_s->image_icon_cat,'resized',@$cat_s->name,'',0,''); ?>
						<span>
							<?php
							 	if(!empty($cat_s->name1) AND !empty($cat_s->name2)){
									echo $cat_s-> name1.' '. $str_manufactory_title .' ' .$cat_s-> name2 ;
								}else{
									echo $cat_s-> name.' '. $str_manufactory_title;
								}
							?>
						</span>	
					</a>
				</div>
			<?php }?>

			<?php if(!$manufactory_id){ ?>
				<?php if($is_mobile){ ?>
				<div class="item item-mobile">
				<?php }else{ ?>
				<div class="item">
				<?php } ?>
					<a href="<?php echo $link_cat_s; ?>" title="<?php echo $cat_s-> name . ' '. $str_manufactory_title; ?>">
						<?php echo set_image_webp($cat_s->image_icon_cat,'resized',@$cat_s->name,'',0,''); ?>
						<span>
							<?php
							 	if(!empty($cat_s->name1) AND !empty($cat_s->name2)){
									echo $cat_s-> name1.' '. $str_manufactory_title .' ' .$cat_s-> name2 ;
								}else{
									echo $cat_s-> name.' '. $str_manufactory_title;
								}
							?>
						</span>	
					</a>
				</div>
			<?php } ?>
		<?php } ?>
	</div>
</div>

	<div class="clear"></div>
<?php } ?>