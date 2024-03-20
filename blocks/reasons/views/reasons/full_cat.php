<?php
global $tmpl,$config; 
	$tmpl -> addStylesheet('full_cat','blocks/utilities/assets/css');
	FSFactory::include_class('fsstring');
?>

<div class="block_utilities_full_cat">
	<div class="block_utilities_full_cat_boby">
		<?php
			if(!empty($list_cat)){
				$i = 0;
				foreach ($list_cat as $cat) {?>
					<div class="item_cat item_cat_<?php echo $i%2 ;?> utilities_item_<?php echo $i;?> cls">
						<div class="item_cat_l">
							<div class="name2_cat">
								<?php echo $cat->name2;?> 
							</div>
							<div class="name_cat">
								<?php echo $cat->name;?> 
							</div>
							<?php if($cat->des){?>
								<div class="summary_cat">
									<?php echo $cat->des;?> 
								</div>
							<?php }?>

							<?php 
								if(isset($arr_list[$cat->id]) && !empty($arr_list[$cat->id])){
									$list = $arr_list[$cat->id];
									echo '<div class = "box_item">';
									foreach ($list as $item) {?>
									 	<div class="item">
									 		<?php 
									 			if($item -> icon){?>
									 			<div class="icon_svg">
									 				<?php echo $item -> icon;?>
									 			</div>
									 		<?php }else{
									 			if($item->image){
									 				echo set_image_webp($item->image,'compress',@$item->title,'lazy',1,'');
									 			}
									 		}
									 		?>

									 		<?php if($item-> is_name ==1){?>
										 		<div class="name">
										 			<?php echo $item-> title;?>
										 		</div>
										 	<?php }?>
									 	</div>	
									<?php }
									echo '</div>';
								}
							?>

						</div>
						<div class="item_cat_r">
							<div class="image">
								<?php echo set_image_webp($cat->image,'compress',@$cat->name,'lazy',1,'');  ?>
							</div>
						</div>
					</div>	
				<?php 
				$i++;
				}
			?>
				
			<?php }
		?>
	</div>
</div>

