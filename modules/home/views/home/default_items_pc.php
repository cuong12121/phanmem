<div class="row product_grid product_grid_home cls <?php if($cat-> limit_home > 10) echo 'scroll_bar product_grid_scroll'; ?>">
	<div class="row_inner">
		<!--	EACH PRODUCT				-->
		<?php 
		$products = $array_products[$cat->id];

		$total_pro_h = count($products);
			//echo $total_pro_h;

		$kk = 0;
		foreach($products as $item){
			include 'default_item.php';	
			$kk++;
		}
		?>		
		<!--	end EACH PRODUCT				-->

		<div class="clear"></div>
		<div class="dview-all-total">
			<a href="<?php echo  $link_cat ;?>" title="Xem tất cả" class="view-all-total"> Xem thêm<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 494.148 494.148" style="enable-background:new 0 0 494.148 494.148;" xml:space="preserve">
				<g>
					<g>
						<path d="M405.284,201.188L130.804,13.28C118.128,4.596,105.356,0,94.74,0C74.216,0,61.52,16.472,61.52,44.044v406.124    c0,27.54,12.68,43.98,33.156,43.98c10.632,0,23.2-4.6,35.904-13.308l274.608-187.904c17.66-12.104,27.44-28.392,27.44-45.884    C432.632,229.572,422.964,213.288,405.284,201.188z"/>
					</g>
				</g>
			</svg></a> 
		</div>
		
	</div>
</div>