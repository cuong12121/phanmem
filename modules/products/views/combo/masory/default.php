	<?php 
	global $tmpl; 
	$tmpl -> addStylesheet('cat_masory','modules/'.$this -> module.'/assets/css');
	$tmpl -> addScript('jquery-migrate-1.0.0','libraries/jquery','top');
	$tmpl -> addScript('masonry.pkgd','libraries/jquery/masonry/dist/','top');
	$tmpl -> addScript('cat_masory','modules/'.$this -> module.'/assets/js','top');
	?>
<div class='product-cat'>
	<div class='product-cat-head'>
			<h1><span><?php echo FSText::_('Tất cả các sản phẩm'); ?></span></h1>
			<?php  $tmpl -> load_direct_blocks('products_subcat'); ?>
	        <div class='clear'></div>
        </div>
        <input type="hidden" value="<?php echo ceil($total/$limit_in_page); ?>" id="total_page" name="total_page">
		<input type="hidden" value="0" name="page_current" id="page_current">
		<input type="hidden" value="<?php echo $_SERVER['REQUEST_URI']; ?>" name="url_current" id="url_current">
<!--		<input type="hidden" value="<?php echo $cat -> id; ?>" name="cat_id" id="cat_id">-->
        <div class='wrapper_items' >
	        <div class='load_items' id='load_items'>
	        </div>
        </div>
        <img src="<?php echo URL_ROOT; ?>images/ajax-loader.gif" style="display: none; "  alt="loader" />
</div>

