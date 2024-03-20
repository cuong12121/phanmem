<?php 
global $tmpl, $is_mobile, $config; 
if(!$raw) { 
	$tmpl -> addStylesheet('products');
	$tmpl -> addStylesheet('cat','modules/'.$this -> module.'/assets/css');
	$tmpl -> addScript('cat','modules/'.$this -> module.'/assets/js');

	$tmpl -> addStylesheet('owl.carousel','libraries/jquery/owl.carousel.2/assets');
	$tmpl -> addScript('owl.carousel.min','libraries/jquery/owl.carousel.2');
}
//	$tmpl -> addScript('shopcart','modules/products/assets/js');
//	$tmpl -> addScript('follow');
FSFactory::include_class('fsstring');
$Itemid = 35;
?>

<div class="block_products_filter" style="display: none;">
	<?php echo $tmpl -> load_direct_blocks('products_filter',array('style'=>'filter_no_cal_multiselect_dropdown')); ?>	
	<?php $filter_current = $tmpl -> get_variables('filter_current'); ?>	
</div>

<div class="products_cat">
	<div class="banner">
		<?php  echo $tmpl -> load_direct_blocks('banners',array('style'=>'products_cat','category_id'=>'4')); ?>
	</div>

	<?php if($tmpl->count_block('pos2')) { ?>
		<div class="pos2">
			<div class="container">
				<?php  echo $tmpl -> load_position('pos2','XHTML2'); ?>
			</div>
		</div>
	<?php } ?>

	<?php if(!empty($description) AND $description !='' || !empty($cat->summary) AND $cat->summary !='' ){?>
		<article class='summary_cat cls'>
			<div class="summary_content">
				<?php 
				if(!empty($description)){
					echo str_replace('{name}', $title, $description);
				}else{
					echo str_replace('{name}', $title,$cat->summary);

				}
				?>
			</div>
			<?php include 'default_tags.php'; ?>
		</article>
	<?php } ?>
	<?php if(($cat-> tablename != '' && $cat-> tablename != null && $cat-> tablename != 'fs_products') || 1 == 1 ){?> 
		<?php echo $tmpl -> load_direct_blocks('products_filter',array('style'=>'filter_no_cal_multiselect_dropdown_new')); ?>

	<?php }?>

	<?php if(!empty($filter_current) && 1==1){ ?>
		<?php echo $filter_current; ?>
	<?php } ?>

	<div class="products-cat <?php if(($cat-> tablename =='' || $cat-> tablename == 'fs_products') && 1 == 0) echo 'products-cat-full'; ?>">								<!-- 																			
		<?php if(!empty($list)){ ?>
			<div class="field_title">
				<div  class="title-name cls">
					<div class="products_filter_price" >
						<?php echo $tmpl -> load_direct_blocks('products_filter',array('style'=>'filter_no_cal_multiselect_dropdown')); ?>	
						
					</div>
					<div class="feature_sort">
						<?php if($cat-> tablename != 'fs_products'){?>
							<div class="feature">						
								<label class="filter_select_name" id="cl_feature">Bộ lọc</label>
								<div class="filter_select_it" id="b_feature">
									<span class="closs_filter"></span>
									<div class="block_products_filter" >
										<?php echo $tmpl -> load_direct_blocks('products_filter',array('style'=>'filter_no_cal_multiselect_dropdown')); ?>	

									</div>
								</div>							
							</div>
						<?php }?>
						<?php if(!$raw) { ?>
							<?php $filter_current = $tmpl -> get_variables('filter_current'); ?>
						<?php } ?>

					</div>
				</div>

			</div>
			<?php } ?> -->


			<div class="clear"></div>

			<?php if($tmpl->count_block('pos5')) {?>
				<div class="pos5" >
					<div class="container">
						<?php echo $tmpl -> load_position('pos5','XHTML2'); ?>

					</div>
				</div>
			<?php }?>

			<h1 class="title_h1"><?php echo $title; ?></h1>	

			<?php if(!empty($sub_cats)) { 
				for($ic=1;$ic < 25;$ic++) {
					// $sub_cats[$ic] = $sub_cats[0];
				}

				?>
				<div class="sub_cats">
					<div class="item_scat item_scat_active">
						<figure>
							<a href="javascript:void(0)" title="Nổi bật">
								<img src="<?php echo URL_ROOT.$config['icon_hot']; ?>" alt="Nổi bật">
							</a>
						</figure>
						<div class="cat_name">
							<a href="javascript:void(0)" title="Nổi bật">Nổi bật</a>
						</div>
					</div>
					<?php $is=0; foreach ($sub_cats as $sub_cat) { 
						$link_subcat= FSRoute::_('index.php?module=products&view=cat&ccode='.$sub_cat->alias.'&cid='.$sub_cat->id.'&Itemid='.$Itemid);?>
						<?php if($is==18) { ?>
							<div class="item_scat item_readmore_subcat">
								<figure>
									<a href="javascript:void(0)" class="readmore_subcat" title="Xem thêm">
										<img src="<?php echo URL_ROOT.$config['icon_readmore']; ?>" alt="Xem thêm">
									</a>
								</figure>
								<div class="cat_name">
									<a href="javascript:void(0)" title="Xem thêm">Xem thêm</a>
								</div>
							</div>
						<?php } ?>
						<div class="item_scat <?php if($is>=18) echo 'item_scat_more hide' ?>">
							<figure>
								<a href="<?php echo $link_subcat; ?>" title="<?php echo $sub_cat-> name; ?>">
									<?php echo set_image_webp($sub_cat-> image,'resized',@$item->name,'lazy',1,''); ?>
								</a>
							</figure>
							<div class="cat_name">
								<a href="<?php echo $link_subcat; ?>" title="<?php echo $sub_cat-> name; ?>"><?php echo $sub_cat-> name; ?></a>
							</div>
						</div>
						<?php $is++; } ?>
						<?php if(count($sub_cats) > 18) { ?>
							<div class="item_scat item_readany_subcat hide">
								<figure>
									<a href="javascript:void(0)" class="readany_subcat" title="Ẩn bớt">
										<img src="<?php echo URL_ROOT.$config['icon_readany'];?>" alt="Ẩn bớt">
									</a>
								</figure>
								<div class="cat_name">
									<a href="javascript:void(0)" title="Ẩn bớt">Ẩn bớt</a>
								</div>
							</div>
						<?php } ?>
					</div>
				<?php } ?>

				<section class='products-cat-frame'> 
					<div class='products-cat-frame-inner'>
						<?php include_once 'default_grid_ppk.php';?>
					</div>
					<?php if($pagination) echo $pagination->showPagination(3); ?>
				</section>

			</div>
			<?php if(!empty($sub_cats)) { 
				// for($ic=1;$ic < 25;$ic++) {
				// 	$sub_cats[$ic] = $sub_cats[0];
				// }

				?>
				<div class="sub_cats sub_cats_bottom">
					<div class="item_scat item_scat_active">
						<figure>
							<a href="javascript:void(0)" title="Nổi bật">
								<img src="<?php echo URL_ROOT.$config['icon_hot']; ?>" alt="Nổi bật">
							</a>
						</figure>
						<div class="cat_name">
							<a href="javascript:void(0)" title="Nổi bật">Nổi bật</a>
						</div>
					</div>
					<?php $is=0; foreach ($sub_cats as $sub_cat) { 
						$link_subcat= FSRoute::_('index.php?module=products&view=cat&ccode='.$sub_cat->alias.'&cid='.$sub_cat->id.'&Itemid='.$Itemid);?>
						<?php if($is==18) { ?>
							<div class="item_scat item_readmore_subcat">
								<figure>
									<a href="javascript:void(0)" class="readmore_subcat" title="Xem thêm">
										<img src="<?php echo URL_ROOT.$config['icon_readmore']; ?>" alt="Xem thêm">
									</a>
								</figure>
								<div class="cat_name">
									<a href="javascript:void(0)" title="Xem thêm">Xem thêm</a>
								</div>
							</div>
						<?php } ?>
						<div class="item_scat <?php if($is>=18) echo 'item_scat_more hide' ?>">
							<figure>
								<a href="<?php echo $link_subcat; ?>" title="<?php echo $sub_cat-> name; ?>">
									<?php echo set_image_webp($sub_cat-> image,'resized',@$item->name,'lazy',1,''); ?>
								</a>
							</figure>
							<div class="cat_name">
								<a href="<?php echo $link_subcat; ?>" title="<?php echo $sub_cat-> name; ?>"><?php echo $sub_cat-> name; ?></a>
							</div>
						</div>
						<?php $is++; } ?>
						<?php if(count($sub_cats) > 18) { ?>
							<div class="item_scat item_readany_subcat hide">
								<figure>
									<a href="javascript:void(0)" class="readany_subcat" title="Ẩn bớt">
										<img src="<?php echo URL_ROOT.$config['icon_readany'];?>" alt="Ẩn bớt">
									</a>
								</figure>
								<div class="cat_name">
									<a href="javascript:void(0)" title="Ẩn bớt">Ẩn bớt</a>
								</div>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
				<div class="clear"></div>
				<?php if(isset($description_manufactory_cat)){?>
					<div class="cat_description description">
						<?php echo str_replace('{name}', $title, $description_manufactory_cat); ?>
					</div>
				<?php }elseif($cat->description){ ?>
					<div class="cat_description description">
						<?php echo str_replace('{name}', $title, $cat->description); ?>
					</div>
				<?php } ?>
				<?php include 'default_tags.php';?>
				<?php if($tmpl->count_block('pos1')) {?>
					<div class="pos1" >
						<div class="container">
							<?php echo $tmpl -> load_position('pos1','XHTML2'); ?>
						</div>
					</div>
				<?php }?>
			</div>