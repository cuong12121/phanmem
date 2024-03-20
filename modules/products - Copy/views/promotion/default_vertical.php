<?php 
$tmpl -> addScript('masonry.pkgd.min','libraries/jquery/masonry/js');
$filter = FSInput::get('filter');
$order = FSInput::get ('order');
?>

	<div class="box">	
		<div class="productbox">
		
			<div class="productlist">
				<div class="border-right"></div>
				<ul class="clearfix list-product-hot" id="box_product">
					<?php 
						include 'fetch_pages.php';
						echo $html;
					?>
				</ul>
		    </div>	 
		    <?php if($pagination) echo $pagination->showPagination(3);?>
		 </div>	   
	 </div>	   	 


<input type="hidden" value="<?php echo $filter; ?>" id="filter" name="filter">
<input type="hidden" value="<?php echo $order; ?>" id="order" name="order">
<input type="hidden" value="<?php echo $cat->id?>" id="category_id" name="category_id">
	