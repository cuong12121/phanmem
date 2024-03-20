<?php global $tmpl;
	$tmpl -> addStylesheet('dropdown','blocks/shopcart/assets/css');
?>
<?php 
	$total_price = 0;
	$quantity = 0;
	$link_buy  = FSRoute::_('index.php?module=products&view=cart&task=shopcart&Itemid=94');
	if(isset($_SESSION['cart'])) {
		$product_list = $_SESSION['cart'];
		
		if($product_list) {
			$i = 0;			
			foreach ($product_list as $prd) {
		  		$i++;
		  		$total_price +=  $prd['quantity']* $prd['price'];
		  		if(isset($prd['is_gift']) && $prd['is_gift'] == 1){

		  		}else{
		  			$quantity +=  $prd['quantity'];
		  		}
		  		
			}
		}
	}
?>
<div class="shopcart block_content">
	<div class="departure">
			<a  href="<?php echo $link_buy; ?>" title="<?php echo "Giỏ hàng"; ?>">Giỏ hàng</a>		
			<a  href="<?php echo $link_buy; ?>"  title="<?php echo "Giỏ hàng"; ?>">(<font><?php echo $quantity; ?></font>) sản phẩm</a>
	</div>	
	
	<div class="dropdown">
		<div class="shopcart_popup_inner">
			<?php include 'dropdown_content.php'; ?>
		</div>
	</div>
</div>
