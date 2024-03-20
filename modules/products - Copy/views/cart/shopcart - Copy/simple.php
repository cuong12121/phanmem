<?php 
global $tmpl,$config;
$tmpl -> addTitle('Thanh toán đơn hàng');
$tmpl -> addStylesheet('cart','modules/products/assets/css');
$tmpl -> addScript('form');
$tmpl -> addScript('cart','modules/products/assets/js');
$Itemid = FSInput::get('Itemid');



?>
<div class="product_cart mt20 cls">
	<div class="detail_inner">
		
		<?php 
		$is_gift = 0;

		if(@$price_below){
			if($type_below == 7){
				$sale_alert .= FSText::_('Bạn đã mua đơn hàng'). '<strong> >= '.format_money($price_below). '</strong> '.FSText::_('nên bạn được nhận quà ở phía dưới').'. ';
				$is_gift = 1;
			}else{
				$sale_alert .= FSText::_('Bạn đã mua đơn hàng'). '<strong> >= '.format_money($price_below).'</strong> '.FSText::_('nên bạn được chiết khấu').'. ';
			}
			if($price_above){
				if($type_above == 7){
					$sale_alert .= FSText::_('Tuy nhiên, nếu bạn mua đơn hàng'). '<strong> >= '.format_money($price_above). '</strong> '.FSText::_('thì quà của bạn sẽ hấp dẫn hơn.');
				}else{
					$sale_alert .= FSText::_('Tuy nhiên, nếu bạn mua đơn hàng'). '<strong> >= '.format_money($price_above). '</strong> '.FSText::_('thì bạn được chiết khấu cao hơn.');
				}
			}
		}else{
			if(@$price_above){
				if($type_above == 7){
					$sale_alert .= FSText::_('Nếu bạn mua đơn hàng >='.format_money($price_above).', những phần quà hấp dẫn đang đời bạn.');
				}else{
					$sale_alert .= FSText::_('Nếu bạn mua đơn hàng >='.format_money($price_above).', thì bạn được chiết khấu.');
				}
			}
		}

		?>
		<?php if($sale_alert){ ?>
			<div class="sale_alert"><?php echo $sale_alert; ?></div>
		<?php } ?>

		<?php
			if($is_gift && $gifts){
				include_once 'buyer_gifts.php';
			}
		?>
		
		<h1 class="page_title_cart"><span><?php echo FSText::_('Giỏ hàng'); ?></span></h1>

		<?php

		if(isset($_COOKIE['cart'])) {
			$product_list = json_decode($_COOKIE['cart'],true);
			// printr($product_list);
				if(!empty($product_list)){
					echo '<div id="product_cart_load_ajax">';
					include_once 'items.php';
					echo '</div>';

				 	include_once 'detail_order_checkout.php';
				
				}?>
		<?php 	
		}else{
		?>
			<div class="no-product-cart">Giỏ hàng đang không có sản phẩm nào <a href="<?php echo URL_ROOT ?>" title="tiếp tục mua hàng">nhấn vào đây</a> để mua hàng</div>
		<?php } ?>
	</div>
</div>