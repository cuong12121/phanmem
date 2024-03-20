<div class="product_grid_home_mobile">
	<div class="category-mobile">

		<?php if(isset($sub_cats) && $sub_cats){ ?>

			<?php if(count($sub_cats) <= 6 ){ ?>
				<div class="category-mobile-style-1">
				<?php foreach ($sub_cats as $sub_cat) {
					$link_sub_cat = FSRoute::_ ( 'index.php?module=products&view=cat&cid=' . $sub_cat->id . '&ccode=' . $sub_cat->alias . '&Itemid=' . $Itemid );
				?>
					<a href="<?php echo $link;?>" title='<?php echo $item->name;?>'>
						<span class="image"><?php echo set_image_webp($sub_cat->image_icon_cat,'resized',@$sub_cat->name,'lazy',1,''); ?></span>
						<span class="name"><?php echo @$sub_cat->name ?></span>
					</a>
				<?php } ?>
				</div>
			<?php }else{ ?>
				<div class="category-mobile-style-2">
					<?php
						$w = count($sub_cats) * 115; 
					?>
					<div class="category-mobile-style-2-inner" style="width: <?php echo $w.'px'; ?>">
					<?php foreach ($sub_cats as $sub_cat) {
						$link_sub_cat = FSRoute::_ ( 'index.php?module=products&view=cat&cid=' . $sub_cat->id . '&ccode=' . $sub_cat->alias . '&Itemid=' . $Itemid );
					?>
						<a href="<?php echo $link;?>" title='<?php echo $item->name;?>'>
							<span class="image"><?php echo set_image_webp($sub_cat->image_icon_cat,'resized',@$sub_cat->name,'lazy',1,''); ?></span>
							<span class="name"><?php echo @$sub_cat->name ?></span>
						</a>
					<?php } ?>
					</div>
				</div>

			<?php } ?>


		<?php } ?>
	</div>
	
	<?php if(!empty($manf_by_cat)){ ?>


	
	<!-- manu -->
	<div class="manufactory-mobile">
		<div class="manu-name">Hãng <?php echo $cat->name;?></div>
		
		<div class="manus-cate-mobile">

			<?php if(count($manf_by_cat) > 6){ ?>
				<div class="manus-cate-mobile-style1">
					<div class="item-top cls">
					<?php 
						// printr($manf_by_cat);
						foreach ($manf_by_cat as $k => $manu) {
							$link_cat_ft_lv0 = FSRoute::_ ( 'index.php?module=products&view=cat&cid=' . $cat->id . '&ccode=' . $cat->alias . '&filter='.@$array_manf_ft[$cat->id][$manu->name]->alias.'&Itemid=9' );
					?>
						
						<a href="<?php echo $link_cat_ft_lv0 ?>" title="<?php echo $manu->name ?>" >
							<?php echo set_image_webp($manu->image,'resized',@$manu->name,'lazy',1,''); ?>
						</a>
						
						<?php if($k >=3 ) break; } ?>
					</div>
					
					
					<div class="manu-scroll">
						<?php $w = (count($manf_by_cat) - 4)  * 165;  ?>
						<div class="manu-scroll-inner" style="width: <?php echo $w.'px'; ?>">
							<?php 
								foreach ($manf_by_cat as $key => $manu) {
									if($key <= 3)
										continue;
								$link_cat_ft_lv0 = FSRoute::_ ( 'index.php?module=products&view=cat&cid=' . $cat->id . '&ccode=' . $cat->alias . '&filter='.@$array_manf_ft[$cat->id][$manu->name]->alias.'&Itemid=9' );
							?>
								
								<a href="<?php echo $link_cat_ft_lv0 ?>" title="<?php echo $manu->name ?>" >
									<span class="image"><?php echo set_image_webp($manu->image,'resized',@$manu->name,'',0,''); ?></span>
								</a>
								

							<?php } ?>
						</div>
					</div>
				</div>	
		
			<?php }else{ ?>
				<div class="manus-cate-mobile-style2 cls">
					<?php
						foreach ($manf_by_cat as $key => $manu) {
							$link_cat_ft_lv0 = FSRoute::_ ( 'index.php?module=products&view=cat&cid=' . $cat->id . '&ccode=' . $cat->alias . '&filter='.@$array_manf_ft[$cat->id][$manu->name]->alias.'&Itemid=9' ); 
					?>
						<a href="<?php echo $link_cat_ft_lv0 ?>" title="<?php echo $manu->name ?>" >
							<span class="image"><?php echo set_image_webp($manu->image,'resized',@$manu->name,'lazy',1,''); ?></span>
						</a>
					<?php } ?>
				</div>
			<?php } ?>
		<!-- end manus-cate-mobile -->
	</div>
	</div>
	<!-- end manu -->
	<?php } ?>
</div>