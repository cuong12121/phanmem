<?php 
$tmpl -> addScript('masonry.pkgd.min','libraries/jquery/masonry/js');
?>
		<div class="productbox mt20">
		
			<div class="productlist">
				<div class="border-right"></div>
				<ul class="clearfix list-product-hot" id="box_product">
					<?php 
						include 'fetch_pages.php';
						echo $html;
					?>
				</ul>
		    </div>	 
		    <?php echo $load_more->showLoadmore();?>
		 </div>	   
<input type="hidden" value="<?php echo $keyword; ?>" id="keyword" name="keyword">
