<?php global $tmpl,$config;
$tmpl -> addStylesheet('shopcart_simple','blocks/shopcart/assets/css');
?>
<?php 
$total_price = 0;
$quantity = 0;
$link_buy  = FSRoute::_('index.php?module=products&view=cart&task=shopcart&Itemid=94');
if(isset($_COOKIE['cart'])) {
	// $product_list = $_SESSION['cart'];
	$product_list = json_decode($_COOKIE['cart'],true);
		// print_r($product_list);die;
//				 prdid,quality, price, discount/
	$i = 0; 
	if($product_list) {
		foreach ($product_list as $prd) {
			$i++;
			$total_price +=  @$prd['price']* @$prd['quantity'];
			$quantity +=  @$prd['quantity'];
		}
	}
}

?>
<div class="shopcart_simple block_content">
	<a class="buy_icon" href="<?php echo $link_buy; ?>" title="Giỏ hàng"  rel="nofollow">
		<?php echo $config['icon_shopcart']; ?>
		<span class="text-c">Giỏ hàng</span>
		<!-- &nbsp; -->

	<span class="quality"><?php echo $quantity; ?></span>
</a>
</div>
