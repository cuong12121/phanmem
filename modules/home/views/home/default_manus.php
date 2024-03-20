<div class="manus-cate">
	<?php 
		// printr($sub_cats);


		if(!empty($manf_by_cat)){
		foreach ($manf_by_cat as $key => $manu) {
			// $link_cat_ft_lv0 = FSRoute::_ ( 'index.php?module=products&view=cat&cid=' . $cat->id . '&ccode=' . $cat->alias . '&filter='.@$array_manf_ft[$cat->id][$manu->name]->alias.'&Itemid=9' );

			$link_cat_ft_lv0 = FSRoute::_ ( 'index.php?module=products&view=cat&cid=' . $cat->id . '&ccode=' . $cat->alias . '&Itemid=9' );

			if(!empty($cat->alias1) || !empty($cat->alias2)){
				if(!empty($array_manf_ft[$cat->id][$manu->name]->alias)){
					$link_cat_ft_lv0 = str_replace($cat->alias,$cat->alias1.'-'.$array_manf_ft[$cat->id][$manu->name]->alias.'-'.$cat->alias2,$link_cat_ft_lv0);
					$link_cat_ft_lv0 = str_replace('-pc'.$cat->id,'-pcm'.$cat->id,$link_cat_ft_lv0);
				}

			}else{
				if(!empty($array_manf_ft[$cat->id][$manu->name]->alias)){
					$link_cat_ft_lv0 = str_replace($cat->alias,$cat->alias.'-'.$array_manf_ft[$cat->id][$manu->name]->alias,$link_cat_ft_lv0);
					$link_cat_ft_lv0 = str_replace('-pc'.$cat->id,'-pcm'.$cat->id,$link_cat_ft_lv0);
				}
				
			}


	?>
	<?php 
		$check_emty_product = $model->get_count('category_id_wrapper LIKE "%,'.$cat->id.',%"  AND manufactory =' .$manu->id , 'fs_products','id');
		if(!$check_emty_product){
			continue;
		}

	?>
		<div class="item">
			<a href="<?php echo $link_cat_ft_lv0 ?>" title="<?php echo $manu->name ?>" >
				<?php echo $manu->name ?>
				<?php if(!empty($array_manf_ft[$cat->id][$manu->name]) && !empty($array_sub_cats[$cat->id])){ ?>
				<svg fill="gray" width="10px" height="10px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M17.525 36.465l-7.071 7.07c-4.686 4.686-4.686 12.284 0 16.971L205.947 256 10.454 451.494c-4.686 4.686-4.686 12.284 0 16.971l7.071 7.07c4.686 4.686 12.284 4.686 16.97 0l211.051-211.05c4.686-4.686 4.686-12.284 0-16.971L34.495 36.465c-4.686-4.687-12.284-4.687-16.97 0z" class=""></path></svg>
				<?php } ?>
			</a>
			
			

			<div class="filter-subcat-manu">
				<?php foreach ($sub_cats as $sub_cat_filter) {

					// $link_sub_cat = FSRoute::_ ( 'index.php?module=products&view=cat&cid=' . $sub_cat_filter->id . '&ccode=' . $sub_cat_filter->alias . '&filter='.$array_manf_ft[$cat->id][$manu->name]->alias.'&Itemid=9' );

					$link_sub_cat = FSRoute::_ ( 'index.php?module=products&view=cat&cid=' . $sub_cat_filter->id . '&ccode=' . $sub_cat_filter->alias.'&Itemid=9' );

					if(!empty($array_manf_ft[$cat->id][$manu->name])){
						// $link_sub_cat = FSRoute::_ ( 'index.php?module=products&view=cat&cid=' . $sub_cat_filter->id . '&ccode=' . $sub_cat_filter->alias . '&filter='.$array_manf_ft[$cat->id][$manu->name]->alias.'&Itemid=9' );
						if(!empty($sub_cat_filter->alias1) || !empty($sub_cat_filter->alias2)){
							if(!empty($array_manf_ft[$cat->id][$manu->name]->alias)){
								$link_sub_cat = str_replace($sub_cat_filter->alias,$sub_cat_filter->alias1.'-'.$array_manf_ft[$cat->id][$manu->name]->alias.'-'.$sub_cat_filter->alias2,$link_sub_cat);
								$link_sub_cat = str_replace('-pc'.$sub_cat_filter->id,'-pcm'.$sub_cat_filter->id,$link_sub_cat);
							}

						}else{
							if(!empty($array_manf_ft[$cat->id][$manu->name]->alias)){
								$link_sub_cat = str_replace($sub_cat_filter->alias,$sub_cat_filter->alias.'-'.$array_manf_ft[$cat->id][$manu->name]->alias,$link_sub_cat);
								$link_sub_cat = str_replace('-pc'.$sub_cat_filter->id,'-pcm'.$sub_cat_filter->id,$link_sub_cat);
							}
						}



					
				?>
					<a title="<?php echo $sub_cat_filter->name . ' ' .$manu->name ?>" href="<?php echo $link_sub_cat; ?>" ><?php echo $sub_cat_filter->name . ' ' .$manu->name ?></a>


				<?php  }} ?>
			</div>
		</div>
		<?php } ?>
		<div class="item"><a href="<?php echo $link_cat ?>" title="xem tất cả">Xem tất cả <svg fill="gray" width="10px" height="10px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M17.525 36.465l-7.071 7.07c-4.686 4.686-4.686 12.284 0 16.971L205.947 256 10.454 451.494c-4.686 4.686-4.686 12.284 0 16.971l7.071 7.07c4.686 4.686 12.284 4.686 16.97 0l211.051-211.05c4.686-4.686 4.686-12.284 0-16.971L34.495 36.465c-4.686-4.687-12.284-4.687-16.97 0z" class=""></path></svg></a></div>
		<?php } ?>
</div>