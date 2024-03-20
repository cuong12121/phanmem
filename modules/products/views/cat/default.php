<?php 
global $tmpl, $is_mobile; 
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
			<?php  echo $tmpl -> load_position('pos2','XHTML2'); ?>
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
		<?php echo $tmpl -> load_direct_blocks('products_filter',array('style'=>'filter_no_cal_multiselect_dropdown_new','pos' => '1')); ?>

	<?php }?>


	<div class="products-cat <?php if(($cat-> tablename =='' || $cat-> tablename == 'fs_products') && 1 == 0) echo 'products-cat-full'; ?>">																											
		<?php if(!empty($list || 1==1)){ ?>
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
									<?php if(($cat-> tablename != '' && $cat-> tablename != null && $cat-> tablename != 'fs_products') || 1 == 1 ){?> 
										<?php echo $tmpl -> load_direct_blocks('products_filter',array('style'=>'filter_no_cal_multiselect_dropdown_new', 'pos' => 2)); ?>
									<?php }?>
									<div class="block_products_filter" >
										<?php echo $tmpl -> load_direct_blocks('products_filter',array('style'=>'filter_no_cal_multiselect_dropdown')); ?>	

									</div>
								</div>							
							</div>
						<?php }?>
						<div class="order-select">
							<label class="filter_select_name" id="cl_sort">Sắp xếp</label>
							<div class="filter_select_it filter_select_sort" id="b_sort">
								<span class="closs_filter"></span>
								<?php 
								foreach($array_menu as $item) {
									$link = FSRoute::addParameters('sort',$item[0]);
									if($checkmanu == 1){
										$link = str_replace('-pc'.$cat->id,'-pcm'.$cat->id,$link);
									}	
									?>
									<a title="<?php echo $item[1]?>" href="<?php echo $link; ?>" class="<?php echo $sort == $item[0] ? 'active':''; ?>" ><?php echo $item[1]?></a>
								<?php }?>
							</div>
						</div>

						<?php if(!$raw) { ?>
							<?php $filter_current = $tmpl -> get_variables('filter_current'); ?>
						<?php } ?>

					</div>
				</div>

			</div>
		<?php } ?>

		<?php if(!empty($filter_current) && 1==1){ ?>
			<?php echo $filter_current; ?>
		<?php } ?>


		<div class="clear"></div>

		<?php if($tmpl->count_block('pos5')) {?>
			<div class="pos5" >
				<?php echo $tmpl -> load_position('pos5','XHTML2'); ?>
			</div>
		<?php }?>

		<h1 class="title_h1"><?php echo $title; ?></h1>	

		<section class='products-cat-frame'> 
			<div class='products-cat-frame-inner'>
				<?php include_once 'default_grid.php';?>
			</div>
			<?php if($pagination) echo $pagination->showPagination(3); ?>
		</section>

	</div>
	<div class="clear"></div>
	<?php if(isset($description_manufactory_cat)){?>
		<div class="cat_description description">
			<div class="cat_description_detail cat_description_any">
			<?php echo str_replace('{name}', $title, $description_manufactory_cat); ?>
			</div>
			<div class="readmore " id="readmore_desc"><span class="closed">Xem thêm<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 494.148 494.148" style="enable-background:new 0 0 494.148 494.148;" xml:space="preserve">
				<g>
					<g>
						<path d="M405.284,201.188L130.804,13.28C118.128,4.596,105.356,0,94.74,0C74.216,0,61.52,16.472,61.52,44.044v406.124    c0,27.54,12.68,43.98,33.156,43.98c10.632,0,23.2-4.6,35.904-13.308l274.608-187.904c17.66-12.104,27.44-28.392,27.44-45.884    C432.632,229.572,422.964,213.288,405.284,201.188z"/>
					</g>
				</g>
			</svg></span></div>
			<div class="readmore hide" id="readany_desc"><span class="closed">Rút gọn</span></div>
		</div>
	<?php }elseif($cat->description){ ?>

		<div class="cat_description description">
			<div class="cat_description_detail cat_description_any">
			<?php echo str_replace('{name}', $title, $cat->description); ?>
		</div>
			<div class="readmore " id="readmore_desc"><span class="closed">Xem thêm<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 494.148 494.148" style="enable-background:new 0 0 494.148 494.148;" xml:space="preserve">
				<g>
					<g>
						<path d="M405.284,201.188L130.804,13.28C118.128,4.596,105.356,0,94.74,0C74.216,0,61.52,16.472,61.52,44.044v406.124    c0,27.54,12.68,43.98,33.156,43.98c10.632,0,23.2-4.6,35.904-13.308l274.608-187.904c17.66-12.104,27.44-28.392,27.44-45.884    C432.632,229.572,422.964,213.288,405.284,201.188z"/>
					</g>
				</g>
			</svg></span></div>
			<div class="readmore hide" id="readany_desc"><span class="closed">Rút gọn</span></div>
		</div>
	<?php } ?>
	<?php include 'default_tags.php';?>
	<?php if($tmpl->count_block('pos1')) {?>
		<div class="pos1" >
			<?php echo $tmpl -> load_position('pos1','XHTML2'); ?>
		</div>
	<?php }?>
</div>