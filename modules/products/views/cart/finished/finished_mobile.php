<?php
				  $i = 0; 
				  $total = 0;
				  $quantity = 0;
				  $total_discount = 0;
			  		foreach ($order_detail as $item) {
				  		$i++;
				  		$total += $item -> total;
				  		$quantity += $item -> count;
				  		$product = @$products[$item -> product_id];
				  		$link_detail_product =FSRoute::_('index.php?module=products&view=product&code='.$product->alias.'&id='.$product -> id.'&ccode='.$product -> category_alias.'&Itemid=6');
					  	 
				?>
					<div class="list-product-oder">
						<div class="title-img">
							<a href="<?php echo $link_detail_product; ?>" > 
								 <?php if($product -> image){ ?>
		                        	<?php $image_small = URL_ROOT.str_replace('/original/', '/resized/', $product->image); ?>
		                        	<img width="80" height="100" src="<?php echo $image_small; ?>" alt="<?php echo htmlspecialchars ($product -> name); ?>"  />
		                        <?php } else {?>
		                            <img  width="80" height="100" src="<?php echo URL_ROOT.'images/no-img.gif'; ?>" alt="<?php echo htmlspecialchars ($product -> name); ?>" />
		                        <?php }?>
							</a> 
						</div>
						<div class="title-name">
							<h2 class="name"><a class="name-product"  title='' href='<?php echo $link_detail_product; ?>' ><?php  echo @$product -> name;  ?></a></h2>
							<p>Mã sản phẩm: <span><?php echo $product->code; ?></span><p>
							<p>Đơn giá: <span class="price"><?php echo format_money($item -> price,'VNĐ'); ?></span></p>
							<p>Số lượng: <span><?php echo $item -> count; ?></span></p>
						</div>
						<div class='clear'></div>
					</div>
				<?php }?>
				<div class='clear'></div>