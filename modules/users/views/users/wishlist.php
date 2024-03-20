<?php
global $tmpl;
$tmpl -> addScript('form');
// $tmpl -> addScript('wishlist','modules/users/assets/js');
$tmpl -> addStylesheet("wishlist","modules/users/assets/css");
?>
<?php include 'menu_user.php'; ?>
<div class="user_content">
	<div class="head_content">Sản phẩm yêu thích <?php if(!empty($list_wishlist)) ?>(<?php echo count($list_wishlist); ?>)</div>
	<div class="list_products">
		<?php if(!empty($list_wishlist)) { ?>
			<?php 	$total = 0; ?>
			<?php foreach ($list_wishlist as $item) { 
				$product = $products[$item-> product_id];
				$link_detail_product =FSRoute::_('index.php?module=products&view=product&code='.$product->alias.'&id='.$product -> id.'&ccode='.$product -> category_alias.'&Itemid=6'); ?>
				<div class="item cls">
					<?php $image_small = URL_ROOT.str_replace('/original/', '/resized/', $product->image); ?>
					<div class="image">
						<img  src="<?php echo $image_small; ?>" alt="<?php echo htmlspecialchars ($product -> name); ?>"  />
					</div>
					<div class="title-name">
						<h2 class="name"><a class="name-product"  title='<?php  echo @$product -> name ;  ?>' target="_blink" href='<?php echo $link_detail_product; ?>' ><?php  echo @$product -> name ;  ?></a></h2>
					</div>
					<div class="price_area">
						Giá: <span class="price"><?php echo format_money($product -> price); ?></span>
						<br><span class="price_old"><?php echo format_money($product -> price_old); ?></span>
					</div>
				</div>
			<?php } ?>
		<?php } else { echo '<div class="item">Không có sản phẩm yêu thích nào!</div>';}?>

	</div>

</div>
