<?php global $tmpl;
$tmpl -> addStylesheet('fixed_right','blocks/shopcart/assets/css');
?>
<?php 
$total_price = 0;
$quantity = 0;
$link_buy  = FSRoute::_('index.php?module=products&view=cart&task=shopcart&Itemid=94');
if(isset($_COOKIE['cart'])) {
	$product_list = json_decode($_COOKIE['cart'],true);
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

<div class="shopcart-fixed-right">
	<div class="content-fixed-right cls">
		<a class="buy_icon" href="<?php echo $link_buy; ?>" title="Giỏ hàng"  rel="nofollow">
			<svg width="50px" x="0px" y="0px" viewBox="0 0 511.999 511.999" style="enable-background:new 0 0 511.999 511.999;" xml:space="preserve">
			<g>
				<g>
					<g>
						<path d="M180.213,395.039c-32.248,0-58.48,26.232-58.48,58.48s26.233,58.48,58.48,58.48c32.248,0,58.48-26.239,58.48-58.48     C238.693,421.278,212.461,395.039,180.213,395.039z M180.213,476.201c-12.502,0-22.676-10.168-22.676-22.676     s10.174-22.676,22.676-22.676c12.508,0,22.676,10.168,22.676,22.676S192.721,476.201,180.213,476.201z"/>
						<path d="M392.657,395.039c-32.254,0-58.486,26.233-58.486,58.48c0,32.248,26.233,58.48,58.486,58.48     c32.242,0,58.48-26.233,58.48-58.48S424.899,395.039,392.657,395.039z M392.657,476.195c-12.508,0-22.682-10.174-22.682-22.676     s10.174-22.67,22.682-22.67c12.502,0,22.676,10.162,22.676,22.67C415.333,466.027,405.165,476.195,392.657,476.195z"/>
						<path d="M154.553,377.143h278.676c9.894,0,17.902-8.014,17.902-17.902c0-9.888-8.014-17.902-17.902-17.902H169.776L118.522,26.96     c-1.229-7.531-7.089-13.45-14.602-14.757L35.295,0.268c-9.769-1.695-19.012,4.828-20.707,14.566     c-1.701,9.745,4.828,19.012,14.566,20.707l56.075,9.751l51.653,316.825C138.298,370.788,145.775,377.143,154.553,377.143z"/>
					</g>
				</g>
			</g>
			<g>
				<g>
					<path d="M494.24,115.969c-3.372-4.625-8.742-7.358-14.465-7.358H115.765v35.804h339.454l-36.825,114.573H141.425v35.804h290.02    c7.769,0,14.662-5.025,17.043-12.424l48.336-150.378C498.572,126.543,497.611,120.588,494.24,115.969z"/>
				</g>
			</g>
			</svg>
		</a>
		<a class="box-text-r" href="<?php echo $link_buy; ?>" title="Giỏ hàng"  rel="nofollow">
			<span class="text-c">Giỏ hàng của bạn</span>
			<span class="quality">Có <?php echo $quantity; ?> sản phẩm</span>
		</a>
		
	</div>
</div>
