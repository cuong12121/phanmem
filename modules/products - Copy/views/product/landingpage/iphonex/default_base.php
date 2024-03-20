<?php global $is_mobile; ?>

<section class=" section section1 cls">
	<div class="container">
		<div class="left base_left">
			<h1 itemprop="name"><?php echo $data -> name; ?></h1>
			<img alt="<?php echo $data -> name; ?>" src="/modules/products/assets/images/iphonex/iphonex.png" /> 

			 <a  rel="nofollow"  id="buy-now"  href="javascript: void()" class="btn-buy fl"  onclick="add_fb_cart()">
				<font>Đặt hàng ngay</font>
				<span>(Giao hàng tận nơi miễn phí)</span>
			</a>
			<a   href="<?php echo FSRoute::_('index.php?module=products&view=instalment&id='.$data -> id); ?>"  class="btn-tragop fr" data-toggle="modal">
				<font>Trả góp lãi suất 0%</font>
				<span>(Xét duyệt qua điện thoại)</span>
			</a>
			<div class="clear"></div>
			
			
			
			<div class="hotline_detail">
				<i class="icon_v1"></i>
				<?php echo $config['hotline_detail_product'];?>
			</div>
			<!--	TAGS		-->
			
			<input type="hidden" name='record_alias' id='record_alias' value='<?php echo $data -> alias; ?>'>
			<input type="hidden" name='record_id' id='record_id' value='<?php echo $data -> id; ?>'>
			<input type="hidden" name='table_name'  id ='table_name' value='<?php echo str_replace('fs_products_','', $data -> tablename); ?>'>


			<?php include 'modules/' . $this->module . '/views/' . $this->view .'/default_orders.php';?>
			<?php include 'modules/' . $this->module . '/views/' . $this->view .'/default_share.php';?>

			
		</div>
		<div class="right base_right">
			<img alt="<?php echo $data -> name; ?>" src="/modules/products/assets/images/iphonex/bnipx.png" /> 
		</div>
	</div>

</section>