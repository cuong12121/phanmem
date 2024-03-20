<?php
global $tmpl, $config;
$tmpl -> addScript('form');
$tmpl -> addScript('affiliate','modules/users/assets/js');
$tmpl -> addStylesheet("affiliate","modules/users/assets/css");
?>
<?php include 'menu_user.php'; ?>

<div class="user_content">
	<div class="head_content">Đơn hàng tôi giới thiệu</div>
	<div class="list_history_order">
		<?php if(!empty($list_orders)){?>
		<?php foreach ($list_orders as $order) { ?>
			<div class="item_oder">
				<div class="code_order cls"><a title="Xem chi tiết" href="/ket-thuc-don-hang-<?php echo $order-> id ?>.html" target="_blank"><span class="code"><?php echo FSText::_('Mã đơn hàng'); ?> : DH<?php echo str_pad($order -> id, 8 , "0", STR_PAD_LEFT);?></span></a>
					<span class="status"><?php echo $order-> status?'<span class="done">Đã hoàn tất</span>':'<span class="notdone">Chưa hoàn tất</span>' ?></span></div>
					<?php 	$total = 0; ?>
					<?php foreach ($list_detail[$order-> id] as $item_detail) { ?>
						<?php $total += $item_detail -> total; ?>
						<?php $product = @$productdt[$item_detail-> product_id];
						$link_detail_product =FSRoute::_('index.php?module=products&view=product&code='.$product->alias.'&id='.$product -> id.'&ccode='.$product -> category_alias.'&Itemid=6'); ?>
						<div class="item cls">
							<?php $image_small = URL_ROOT.str_replace('/original/', '/resized/', $product->image); ?>
							<div class="image">
								<img  src="<?php echo $image_small; ?>" alt="<?php echo htmlspecialchars ($product -> name); ?>"  />
							</div>
							<div class="title-name">
								<h2 class="name"><a class="name-product"  title='<?php  echo @$product -> name ;  ?>' target="_blink" href='<?php echo $link_detail_product; ?>' ><?php  echo @$product -> name ;  ?><?php if(@$item_detail-> note) echo ' ('.@$item_detail-> note.')'; ?></a></h2>
								<div class="quantity">Số lượng: <?php echo $item_detail -> count; ?> x <?php echo format_money($item_detail -> price); ?></div>
							</div>
							<div class="total_item">
								Tổng tiền: <span><?php echo format_money($item_detail -> total); ?></span>
							</div>
						</div>
					<?php } ?>

<!-- 					<div class="bottom">
						<p><span><?php echo FSText::_('Tổng cộng'); ?>: </span><span><?php echo format_money($total); ?></span></p>

					</div> -->

						<div class="bottom">
							<p><span><?php echo FSText::_('Tổng cộng'); ?>: </span><span><?php echo format_money($total); ?></span></p>
							<?php if($order -> code_sale){ ?>
								<?php if($order-> value_sale == 1) { ?>
									<p><span><?php echo FSText::_('Khuyến mãi'); ?>: </span><span><?php echo $order -> money_dow.'%';?></span></p>
								<?php } else { ?>
									<p><span><?php echo FSText::_('Khuyến mãi'); ?>: </span><span><?php echo format_money($order -> money_dow);?></span></p>
								<?php } ?>
							<?php if($order-> user_point) { ?>
									<p><span><?php echo FSText::_('Dùng điểm: '); ?>: </span><span><?php echo $order -> user_point.' điểm';?></span></p>
								<?php }?> 
								<p><span><?php echo FSText::_('Thanh toán'); ?>: </span><span><?php echo format_money($order -> total_after_discount - $order -> user_point*1000); ?></span></p>		
							<?php } else {?>
								<?php if($order-> user_point) { ?>
									<p><span><?php echo FSText::_('Dùng điểm: '); ?>: </span><span><?php echo $order -> user_point.' điểm';?></span></p>
									<p><span><?php echo FSText::_('Thanh toán'); ?>: </span><span><?php echo format_money($total - $order -> user_point*1000); ?></span></p>	
								<?php } else {?>
									<p><span><?php echo FSText::_('Thanh toán'); ?>: </span><span><?php echo format_money($total - @$order -> user_point*1000); ?></span></p>	
								<?php } ?>
							<?php }?>
							<p><span><?php echo FSText::_('Điểm nhận được'); ?>: </span><span><?php echo round(($order -> total_after_discount)*$config['percen_affiliate']/100/1000).' điểm'; ?></span></p>
						</div>

						

				</div>
			<?php } ?>
		<?php } else {?>
			<div class="item_oder">
				<div class="code_order ">Bạn chưa có đơn hàng giới thiệu nào!</div></div>
		<?php } ?>
		</div>
	</div>
