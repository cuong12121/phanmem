
<?php
$tmpl -> addStylesheet('products');
$tmpl -> addStylesheet('related','modules/'.$this -> module.'/assets/css');
$total_relate = count($orderProducts);
$class = '';
?>
<?php if($orderProducts && count($orderProducts)){?>
	<div class='tab-title'><span>Sản phẩm đã xem</span></div>
	<div class='product_related_mb clearfix' >
		<?php include_once 'default_grid.php';?>
	</div>
</div>
<?php } ?>

