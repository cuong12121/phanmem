<?php global $tmpl;
	$tmpl -> addStylesheet('style1','blocks/shopcart/assets/css');
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
		  		$quantity +=  $prd['quantity'];
			}
		}
	}
?>

<div class="shopcart_alert modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
		   <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Bạn vừa thêm một sản phẩm vào giỏ hàng</h4>
            </div>
			<div class="modal-body">
				<?php include 'dropdown_content.php'; ?>
			</div>
		</div>
	</div>
</div>
