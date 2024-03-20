
<div class="box_product_home">
	<?php if($cat->image_mb){?>
		<div class="cate_image_mb">
			<a href="<?php echo $link_cat; ?>" title='<?php echo htmlspecialchars($cat->name);?>'>
				<?php if(!IS_MOBILE){
					echo set_image_webp($cat->image_mb,'large',@$cat->name,'lazy',1,'');
				}else{
					echo set_image_webp($cat->image_mb,'resized',@$cat->name,'lazy',1,'');
				}?>
				
			</a>
		</div>
	<?php }?>
	<?php 
		$products = $array_products[$cat->id];
		$total_pro_h = count($products);
	?>

	<div class="tab_product_home_mb">
		<div class="product_grid product_grid_home_mb cls" style="--i:<?php echo $total_pro_h;?>">	
				<!--	EACH PRODUCT				-->
				<?php 

					$kk = 0;
					foreach($products as $item){
						include 'default_item.php';	
					}
				?>		
				<!--	end EACH PRODUCT -->	      			
		</div>
		
	</div>
	<div class="view_all_pro_mb">
		<a class="" href="<?php echo $link_cat; ?>" title="<?php echo $cat->name;?>" >Xem thêm</a>
	</div>
</div>