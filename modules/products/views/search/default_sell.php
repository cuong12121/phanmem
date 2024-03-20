<?php 
$tmpl -> addStylesheet('owl.carousel','libraries/jquery/owl.carousel.2/assets');
$tmpl -> addScript('owl.carousel.min','libraries/jquery/owl.carousel.2');
$tmpl -> addScript('sell','modules/'.$this -> module.'/assets/js');
?>
<div class="title_sell">Top <?php echo count($list_sell); ?> sản phẩm bán chạy nhất.</div>
<div class="clear"></div>
<div class='product_grid'>
	<div class="owl-carousel" id="sell_gird">
		<?php foreach($list_sell as $item){
			include 'default_item_lazy.php';
		} ?>	
	</div>
</div>