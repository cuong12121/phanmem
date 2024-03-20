<?php 
 global $tmpl;
 $tmpl -> addStylesheet('countdown','modules/products/assets/css');
 $tmpl -> addStylesheet('jquery.countdown','libraries/jquery/jquery.countdown.package-1.6.3');
 $tmpl -> addScript('jquery.countdown','libraries/jquery/jquery.countdown.package-1.6.3');
 $tmpl -> addScript('jquery.countdown-vi','libraries/jquery/jquery.countdown.package-1.6.3');
 $tmpl -> addScript('countdown','modules/products/assets/js');
 ?>
 
<div class='product_base'>
	<div class='frame-one'>
	<h1><span><?php echo $data -> name; ?></span></h1>
	<div class='price_area'  >
		<span class='price'><?php echo format_money($data -> price_old,'đ'); ?>	</span>
		<?php if($data -> price_old){?>
        	<span class='price_old'><?php echo format_money($data -> price_old,'đ'); ?></span>
	   	<?php }?>
	</div>
	<div class='share_inner'  >
		<span class='like'><?php echo $data -> like; ?> yêu thích</span>
        <span class='comments_no'><?php echo $data -> comments_published; ?> bình luận</span>
	</div>
	<div class='ship'  >
		Phí vận chuyển: <strong>20.000 đ</strong>
	</div>
	<div class='manufactory'  >
		<span class='field_label'>Thương hiệu:</span> <span  class='field_value'><?php echo $data -> manufactory_name; ?></span>
	</div>
	<div class='sizes'  >
		<span class='field_label'>Size: </span>
				<span class='field_value'><?php echo $data -> size_name; ?></span>
	</div>
	<div class='status'  >
		<span class='field_label'>Tình trạng: </span>
				<span><?php echo $data -> status; ?></span>
	</div>
	<div class='colors'  >
		<span class='field_label'>Màu sắc: </span>
		<?php if(count($colors)){?>
			<?php foreach($colors as $item){ ?>
				<span><?php echo $item -> name; ?></span>
			<?php }?>
		<?php }?>
	</div>
	
	<?php if ($data -> summary){?>
		<div class='summary'  >
			<?php echo $data -> summary; ?>
		</div>
	<?php }?>
	</div>
	<div class='frame-three'>
		<div class="buy-now">
			<a href="javascript: buy_add(<?php echo $data ->id; ?>)">
				<span class="button-cart">Thêm vào giỏ hàng</span>
			</a>
		</div>
		<div class="make_offer">
			<a href="javascript: make_offer(<?php echo $data ->id; ?>)">
				<span class="make_offer">Trao đổi sản phẩm</span>
			</a>
		</div>
		<div class='clear'></div>
	</div>
	<div class='hotline_order'>
		<span>Hotline đặt hàng: <span class="red"><?php echo $config['hotline1'];?></span>
	</div>
	<input type="hidden" name='record_id' id='record_id' value='<?php echo $data -> id; ?>'>
	<input type="hidden" name='table_name'  id ='table_name' value='<?php echo str_replace('fs_products_','', $data -> tablename); ?>'>
</div>