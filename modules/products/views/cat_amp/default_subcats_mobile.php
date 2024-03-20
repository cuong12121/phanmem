<div class="list_sub_cats_wrapper_mobile">
		<div class="list_sub_cats_wrapper">
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
				
				if(!empty($str_manufactory_title) AND $str_manufactory_title != ''){
					$check_item = $model->get_record('category_id_wrapper LIKE "%,' .$cat_s->id .',%" AND manufactory_name = "' .$str_manufactory_title.'"','fs_products','id');
				}else{
					$check_item = $model->get_record('category_id_wrapper LIKE "%,' .$cat_s->id .',%"','fs_products','id');
				}
				if(!empty($check_item)){
			?>

				<div class="item">
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