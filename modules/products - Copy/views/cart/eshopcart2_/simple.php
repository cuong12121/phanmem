<?php 
global $tmpl;
$tmpl -> addTitle('Thanh toán đơn hàng');
$tmpl -> addStylesheet('cart','modules/products/assets/css');
$tmpl -> addScript('form');
$tmpl -> addScript('eshopcart2_simple','modules/products/assets/js');
$Itemid = FSInput::get('Itemid');

?>
<div class="product_cart mt20">
	<h1 class="page_title"><span>Đơn hàng</span></h1>
	<div class="detail_inner">
		<?php
		if(isset($_SESSION['cart'])) {
			$product_list = $_SESSION['cart'];
			if(count($product_list)){
				include_once 'items.php';
		?>
				<form action="#" name="eshopcart_info" method="post" id="eshopcart_info" >
		<?php 			
//							include_once 'discount.php';
//							include_once 'payments.php';
							include_once 'buyer_info.php';
					}	
				?>
				</form>
		<?php 	
		} else {
			echo "<p>Gi&#7887; h&#224;ng hi&#7879;n t&#7841;i ch&#432;a c&#243; s&#7843;n ph&#7849;m n&#224;o</p>";
		}
			?>
		<!--	Product list and price			-->
	</div>
</div>