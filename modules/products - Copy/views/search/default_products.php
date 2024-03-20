	<?php 
	global $tmpl; 
	$tmpl -> addStylesheet('products');
	$tmpl -> addStylesheet('cat','modules/'.$this -> module.'/assets/css');
//	$tmpl -> addScript('cat','modules/'.$this -> module.'/assets/js');
//	$tmpl -> addScript('shopcart','modules/products/assets/js');
//	$tmpl -> addScript('follow');
	?>
	
	<div class="filter_products_cat">
		<?php if(1==1) { ?>
			<div class="filter-category">
				<div class="title_filter"><span>Thương hiệu</span></div>
				<?php if(!empty($list_manf)) { foreach ($list_manf as $manf_i) {
					$link_cat = FSRoute::_('index.php?module=products&view=search&keyword='.$keyword.'&cat='.$cat.'&manf='.$manf_i->alias); ?>
					<li <?php if($manf_i->alias == @$manf_act -> alias) echo 'class="active"' ;?>><a href="<?php echo $link_cat ?>" title = "<?php echo $manf_i-> name ;?>"><?php echo $manf_i-> name; ?></a></li>
				<?php } ?>
				<li <?php if($manf=='all') echo 'class="active"' ?>><a title="Tất cả thương hiệu" href="<?php echo FSRoute::_('index.php?module=products&view=search&keyword='.$keyword.'&cat='.$cat.'&manf=all'); ?>">Tất cả thương hiệu</a></li>
			<?php } ?>	
			</div>
		<?php } ?>

	<div class="filter-category">
		<div class="title_filter"><span>Danh mục</span></div>
		<?php if(!empty($list_cat)) {
			foreach ($list_cat as $cat_i) {
			$link_cat = FSRoute::_('index.php?module=products&view=search&keyword='.$keyword.'&cat='.$cat_i->alias.'&manf='.$manf);
		?>
			<li <?php if($cat_i -> alias == @$cat_act-> alias) echo 'class="active"'; ?>><a  title="<?php echo $cat_i-> name; ?>" href="<?php echo $link_cat ?>"><?php echo $cat_i-> name; ?></a></li>
		<?php } ?>

		<li <?php if($cat=='all') echo 'class="active"'; ?>><a title="Tất cả danh mục"  href="<?php echo FSRoute::_('index.php?module=products&view=search&keyword='.$keyword.'&cat=all&manf='.$manf); ?>">Tất cả danh mục</a></li>
		<?php } ?>	
	</div>

</div>

<div class="products-cat">
	
		<div  class="title-name">		
			<h1 class="title_h1">
				<span>Có <strong ><?php echo $total?></strong> sản phẩm với từ khóa: <strong ><?php echo $keyword;?></strong><?php if($cat_act || $manf_act) echo ' Trong'; if($cat_act) echo ' danh mục <strong>'.$cat_act-> name.'</strong>'; if($manf_act) echo ' thương hiệu <strong>'.$manf_act -> name.'</strong>';?></span></h1>	
						
							
		</div>
		
		<div class="clear"></div>

		<section class='products-cat-frame'> 
			<div class='products-cat-frame-inner'>
				<?php include_once 'default_grid.php';?>
			</div>
		</section>
		<?php if(!empty($list_sell)) { ?>
			<div class="products_sell">
				<?php //include_once 'default_sell.php';?>
			</div>
		<?php } ?>
		<?php if($pagination) echo $pagination->showPagination(3); ?>
	</div>

