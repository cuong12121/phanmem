<!-- <link rel="stylesheet" type="text/css" media="screen" href="<?php echo URL_ROOT; ?>modules/users/assets/css/list_products.css" />  -->
<div class="list_products">
	<?php if(!empty($list_products)) { 
		foreach ($list_products as $product ) { 
			$link_detail_product =FSRoute::_('index.php?module=products&view=product&code='.$product->alias.'&id='.$product -> id.'&ccode='.$product -> category_alias.'&Itemid=6'); ?>
			<div class="item cls">
				<?php $image_small = URL_ROOT.str_replace('/original/', '/resized/', $product->image); ?>
				<div class="image">
					<img  src="<?php echo $image_small; ?>" alt="<?php echo htmlspecialchars ($product -> name); ?>"  />
				</div>
				<div class="title-name">
					<h2 class="name"><a class="name-product"  title='<?php  echo @$product -> name ;  ?>' target="_blink" href='<?php echo $link_detail_product; ?>' ><?php  echo @$product -> name ;  ?></a></h2>
					<div class="price_area">
						Giá: <span class="price"><?php echo format_money($product -> price); ?></span>
						<span class="price_old"><?php echo format_money($product -> price_old); ?></span>
					</div>
					<div class="clear"></div>
					Link: <input type="text" value="<?php echo $link_detail_product.'?affiliate='.$data-> affiliate_code; ?>" id="link_<?php echo $product-> id; ?>">
				</div>
				<div class="copy_link">
					<a href="javascript:void(0)" onclick="copy_link_pro(<?php echo $product-> id;?>)">Copy Link</a>
				</div>
			</div> 
		<?php }?>
	<?php } else { echo '<div class="item">Không có sản phẩm nào!</div>';?>

<?php } ?>

<?php if(@$cpage > 1) { ?>
	<div class="pagination">
		<?php if($cpage < 6 ) { 
			for($i = 1; $i <= $cpage; $i++) { ?>
				<span><a class="<?php if($page == $i) echo 'current'; ?>" href="javascript:void(0)" onclick="search_products(<?php echo $i; ?>)"><?php echo $i; ?></a></span>
			<?php } ?>
		<?php } else { 

			if($page > 1) {?> 
				<span><a href="javascript:void(0)" onclick="search_products(<?php echo 1; ?>)">‹‹</a></span>
				<span><a href="javascript:void(0)" onclick="search_products(<?php echo $page-1; ?>)">‹</a></span>
			<?php } ?>

			<?php if($page < 3) {?>
				<?php for($i = 1; $i <= 5; $i++) { ?>
					<span><a class="<?php if($page == $i) echo 'current'; ?>" href="javascript:void(0)" onclick="search_products(<?php echo $i; ?>)"><?php echo $i; ?></a></span>
				<?php } ?>
			<?php } else {?>
				<?php for($i = $page - 2; $i <= $page+2; $i++) { ?>
					<?php if($i<= $cpage) { ?>
						<span><a class="<?php if($page == $i) echo 'current'; ?>" href="javascript:void(0)" onclick="search_products(<?php echo $i; ?>)"><?php echo $i; ?></a></span>
					<?php } ?>
				<?php } ?>
			<?php } ?>

			<?php if($page < $cpage) { ?> 
				<span><a href="javascript:void(0)" onclick="search_products(<?php echo $page+1; ?>)">›</a></span>
				<span><a href="javascript:void(0)" onclick="search_products(<?php echo $cpage; ?>)">››</a></span>
			<?php } ?>

		<?php } ?>
	</div>
<?php } ?>
</div>