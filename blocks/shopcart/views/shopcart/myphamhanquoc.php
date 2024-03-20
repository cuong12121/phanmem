<?php 
	$total_price = 0;
	$quantity = 0;
	$link_buy  = FSRoute::_('index.php?module=products&view=cart&task=eshopcart2&Itemid=94');
	if(isset($_SESSION['cart'])) {
		$product_list = $_SESSION['cart'];
//				 prdid,quality, price, discount/
		$i = 0; 
		if($product_list) {
			foreach ($product_list as $prd) {
		  		$i++;
		  		$total_price +=  $prd[2]* $prd[1];
		  		$quantity +=  $prd[1];
			}
  		}
	}
	
?>
<div class="shopcart_simple block_content">
	<div class='count'><a class="buy_img" href="<?php echo $link_buy; ?>" title="Giỏ hàng thanh toán" rel="nofollow"><font><?php echo $quantity; ?></font><span>sản phẩm</span></a></div>
</div>
