<?php 
global $tmpl; 
$tmpl -> addStylesheet('products');

?>

<h2 class="title_h1">
	<span>Sản phẩm</span>
</h2>
<div class="products-cat-search">	
	<section class='products-cat-frame'> 
		<div class='products-cat-frame-inner'>
		<?php include_once 'default_grid.php';?>
		</div>
	</section>
	
	<?php if($pagination) echo $pagination->showPagination(3); ?>
</div>

