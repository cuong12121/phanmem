<div class="shopcart_popup_items " >
	<div class="shopcart_popup_items_inner" >
		<?php if(isset($_SESSION['cart']) ){ ?>
			<?php $product_list = $_SESSION['cart'];?>
			<?php 
			$i = 0; 
			if($product_list) {
				foreach ($product_list as $prd) {
			  		$i++;
//			  		$total_price +=  $prd[2]* $prd[1];
//			  		$quantity +=  $prd[1];
			  		$product = isset($arr_products[$prd['product_id']])?$arr_products[$prd['product_id']]:null;
			  		if(!$product)
			  			continue;
			  		$link_detail =FSRoute::_('index.php?module=products&view=product&code='.$product->alias.'&ccode='.$product -> category_alias.'&id='.$product->id.'&cid='.$product->category_id.'&Itemid=6');
			 ?>
			 <div class="item clearfix">
			 	<a href="<?php echo $link_detail; ?>" class="item-img"> 
					 <?php if($product -> image){ ?>
                        	<?php $image_small = URL_ROOT.str_replace('/original/', '/resized/', $product->image); ?>
                        	<img width="60"  src="<?php echo $image_small; ?>" alt="<?php echo htmlspecialchars ($product -> name); ?>"  />
                        <?php } else {?>
                            <img  width="60" src="<?php echo URL_ROOT.'images/no-img.gif'; ?>" alt="<?php echo htmlspecialchars ($product -> name); ?>" />
                        <?php }?>	 
				</a> 
			 	<div class="other_info">
			 		<a class="name" href="<?php echo $link_detail; ?>" > <?php  echo $product -> name;  ?> </a> 	
			 		<div ><?php echo $prd['quantity']?> x <span class="price"><?php  echo format_money($prd['price'],'₫'); ?></span></div>
			 	</div>
			 	
			 </div>
			 <?php  		
				}
	  		}
			?>
		<?php }?>		
</div>
</div>
<div class="shopcart_popup_total clearfix">
	<span class="price_area">Tổng: <span class="price"><?php echo format_money($total_price,'₫','0 ₫');?></span></span>
	<span class="quantity_area">Số lượng: <span class="quantity"><?php echo $quantity;?></span></span>
	<a class="shopcart_bt" href="<?php echo $link_buy; ?>" title="Giỏ hàng thanh toán" rel="nofollow"><span>Thanh toán <i class="fa fa-angle-double-right"></i></span>	</a>	
</div>