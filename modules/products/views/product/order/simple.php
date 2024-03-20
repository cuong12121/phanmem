<?php 
global $tmpl;
//$tmpl -> addStylesheet('cart','modules/products/assets/css');
$tmpl -> addScript('form');
$tmpl -> addScript('product','modules/products/assets/js');
$Itemid = FSInput::get('Itemid');

?>
<div class='eshopcart'>
	<div id="eshopcart-header">
		<div class="citation"><span>Quý khách muốn mua sản phẩm này, vui lòng điền thông tin vào "Đơn đặt hàng"  dưới đây &gt;&gt;&gt;</span></div>
		<div class="images">
			<img src="<?php echo URL_ROOT.'images/icon_hg.gif'?>">
		</div>
		<h3><span>Đơn đặt hàng</span></h3>
	</div>
	<div id="eshopcart-detail">
		<?php	include_once 'items.php';?>
		<form action="#" name="eshopcart_info" method="post" id="eshopcart_info" >
			<?php include_once 'buyer_info.php';?>
		</form>
		<!--	Product list and price			-->
	</div>
</div>
