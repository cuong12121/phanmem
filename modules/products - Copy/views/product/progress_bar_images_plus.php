 <?php  	global $tmpl;

// $tmpl -> addStylesheet('progress_bar_plus','modules/products/assets/css');

?>
<div id="progress_bar_plus" class=" owl-carousel">

	<?php foreach($product_images as $item){?>	
		<?php
			  $image =  URL_ROOT.str_replace('/original/','/large/', $item -> image);
			?>
		<div class="item ">	
				<img class="img-responsive" onerror="javascript:this.src='<?php echo URL_ROOT?>images/NA568x316.jpg';" src="<?php echo $image;?>" alt="">
				
				<?php  if($item -> content){ ?>
				<div class="img_content">	
					<?php echo @$item -> content ?>
				</div>	
				<?php } ?>
			</div>
<?php }?>
</div>
