<?php 
global $tmpl, $is_mobile, $config;
$tmpl -> addStylesheet('products');
$tmpl -> addStylesheet('hotdeal','modules/'.$this -> module.'/assets/css');
FSFactory::include_class('fsstring');
?>
<div class="box_product_cat">
	<div class="products-cat products_cat_full ">
		<h1 class="img-title-cat page_title">
	      <span><?php echo FSText::_('Sản phẩm hot') ?></span>
	    </h1>
		<section class='products-cat-frame'> 
			<div class="cat_item_store">
				<?php include 'default_grid.php';?>
			</div>
			<div class="clear"></div>
		</section>
	</div>
	<div class="clear"></div>
	<?php if($pagination) echo $pagination->showPagination(3); ?>
</div>

<?php //include 'default_remarketing.php';?>



