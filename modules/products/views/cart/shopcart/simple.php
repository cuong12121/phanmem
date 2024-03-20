<?php 
global $tmpl,$config;
$tmpl -> addTitle('Thanh toán đơn hàng');
$tmpl -> addStylesheet('cart','modules/products/assets/css');
$tmpl -> addScript('form');
$tmpl -> addScript('cart','modules/products/assets/js');
$Itemid = FSInput::get('Itemid');

// printr($_COOKIE['cart']);
?>
<script defer src="https://maps.googleapis.com/maps/api/js?libraries=places&language=vi&key=AIzaSyBXLiAtDTeJlvyQciDwPPTRcyvRrCevSYM" type="text/javascript"></script>
            
<div class="product_cart mt20 cls">

	<?php if(isset($_COOKIE['cart'])) { ?>

	<div class="detail_inner cls">
		<div class="detail_inner_r shadow">
			<h1 class="page_title_cart"><span><?php echo FSText::_('Giỏ hàng của bạn'); ?></span></h1>
			<?php
				$product_list = json_decode($_COOKIE['cart'],true);
				// print_r($product_list);
				if(!empty($product_list)){
					echo '<div id="product_cart_load_ajax">';
					include_once 'items.php';
					echo '</div>';
				}
			?>	
		</div>

		<div class="detail_inner_l">
			<?php if(!isset($_COOKIE['user_id']) && 1==2){ ?>
			<div id="buy-type">
		        <a href="javascript:void(0)" data-show="#form-login" data-hide="#form-without-login" class="btn-buy login-buy"><b>Đăng nhập</b><span>Đã là thành viên của Hải Linh</span></a>
		        <a href="javascript:void(0)" data-show="#form-without-login" data-hide="#form-login" class="btn-buy quick-buy active"><b>Mua hàng nhanh</b><span>Dành cho khách hàng mới</span></a>
		    </div>
		    <!-- end buy-type -->
		    <?php 
		    	include_once 'detail_login.php';
		    ?>
			<?php } ?>
		    
		    <?php
				// $product_list = json_decode($_COOKIE['cart'],true);
				// include_once 'total_order.php';
			?>

		    <?php 
		    	include_once 'detail_order_checkout.php';
		    ?>
		    <!-- end info -->
		</div>

	</div>
	<?php }else{ ?>
		<h1 class="no-product-cart">Giỏ hàng đang không có sản phẩm nào <a href="<?php echo URL_ROOT ?>" title="tiếp tục mua hàng">nhấn vào đây</a> để mua hàng</h1>
	<?php } ?>
</div>