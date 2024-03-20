<?php 
global $tmpl;
$tmpl -> addTitle('Thanh toán đơn hàng');
$tmpl -> addStylesheet('cart','modules/products/assets/css');
$tmpl -> addScript('form');
$tmpl -> addScript('cart','modules/products/assets/js');
$Itemid = FSInput::get('Itemid');

// print_r($_COOKIE['cart']);die;

?>
<div class="product_cart mt20 cls">
	
	<div class="detail_inner">
		<?php if(!@$_COOKIE['cart']) { ?>
			<h1 class="page_title"><span><?php echo FSText::_('Đơn hàng'); ?></span></h1>
		<?php } ?>
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
		
		
		<?php
		if(isset($_COOKIE['cart'])) {
			$product_list = json_decode($_COOKIE['cart'],true);
				if(!empty($product_list)){
					echo '<div id="product_cart_load_ajax">';
					include_once 'items.php';
					echo '</div>';
					// include_once 'login.php';
				?>
				<?php if($action == 'gio-hang') { ?>
					<div class="buyer_info">
						<?php if(!@$_COOKIE['user_id']) { 
							include_once 'login.php';
							include_once 'detail_order.php';
						} else { ?>
							<?php include_once 'detail_order.php'; ?>
							<div class="a_pay"><a href="<?php echo URL_ROOT.'thanh-toan.html'; ?>">Xác nhận giỏ hàng</a></div>
							<!-- <form action="#" name="eshopcart_info" method="post" id="eshopcart_info" > -->
								<?php 			
//							include_once 'discount.php';
//							include_once 'payments.php';
								// include_once 'buyer_info.php';

								?>
								<!-- </form> -->
							<?php } ?>
						</div>
					<?php } elseif($action == 'thanh-toan') {?>

						<?php if(!@$_COOKIE['user_id']) { 
							setRedirect(URL_ROOT.'gio-hang.html');
						} else { ?>
							<div class="buyer_info">

							<?php include_once 'detail_order_checkout.php'; ?>
							<!-- <div class="a_pay"><a href="<?php echo URL_ROOT.'thanh-toan.html'; ?>">Xác nhận giỏ hàng</a></div> -->
							<!-- <form action="#" name="eshopcart_info" method="post" id="eshopcart_info" > -->
								<?php 			
//							include_once 'discount.php';
//							include_once 'payments.php';
								// include_once 'buyer_info.php';
								?>
								<!-- </form> -->
							</div>
							<?php } ?>


						<?php } ?>
					<?php } ?>
					<?php 	
				} else {
					echo '<p>'.FSText::_('Giỏ hàng đang chưa có sản phẩm nào').'</p>';
					
				}
				?>
				<!--	Product list and price			-->
			</div>
		</div>