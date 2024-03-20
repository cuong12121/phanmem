<?php 
global $tmpl; 
$tmpl -> addStylesheet('products');
$tmpl -> addStylesheet('manufactory','modules/products/assets/css');
$sort = FSInput::get('order','default');
?>
						
	
<div class="products_manufactory">


	<h1 class="img-title-cat page_title">
      <span><?php echo FSText::_('Thương hiệu ').$manu -> name; ?></span>
    </h1>
	
	<div class="clear"></div>

	
	<section class="list_content ">
		<?php include_once 'default_grid.php';?>
	
		<?php if($pagination) echo $pagination->showPagination(3);?>
	</section>

 </div>

