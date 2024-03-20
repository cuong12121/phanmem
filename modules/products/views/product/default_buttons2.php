<div class='product_button2'>
	<figure>
		<img src="<?php echo URL_ROOT.str_replace('/original/', '/resized/', $data -> image); ?>" alt="<?php echo $data -> name; ?>" />
	</figure>
	<div class="product_button2_info">
		<h3><?php echo $data -> name; ?></h3>
		<div class='price_current' id="price_2" >
		<?php if(@$price_default) {
			echo format_money($price_default) ; 
		} else {echo format_money($price_by_region) ; }?>
		</div>
	</div>	
	
	<div class="button2_wrap">
		<a rel="nofollow"  id="buy-now-2"  href="javascript: void()" class="btn-buy fl"  onclick="add_fb_cart()">
			<span>
				<?php echo FSText::_('Mua ngay'); ?>
			</span>
			
		</a>
		<a rel="nofollow" href="javascript: void()" class="btn-tragop fr">
			<span>Thêm vào giỏ hàng</span>
			
		</a>
	</div>
	<div class="clear"></div>
	
</div>