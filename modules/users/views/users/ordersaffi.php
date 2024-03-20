<?php
global $tmpl, $config;
$tmpl -> addScript('form');
$tmpl -> addScript('affiliate','modules/users/assets/js');
$tmpl -> addStylesheet("affiliate","modules/users/assets/css");
?>
<?php include 'menu_user.php'; ?>

<div class="user_content">
	<div class="head_content">Đơn hàng tôi giới thiệu</div>
	<div class="filter cls">
		<div class="filter_title filter_tab">Lọc theo:</div> 
		<div class="filter_s filter_tab">
			<select name="ofmonth" id="ofmonth" class="type" onchange="filter_orders_affi(<?php echo $data-> id; ?>)">
				<option value="0"> -- Tháng -- </option>
				<?php for($i=1;$i<=12;$i++){ ?>
					<option value="<?php echo $i; ?>">Tháng <?php echo $i; ?></option>
				<?php } ?>			
			</select>		
		</div>
		<div class="filter_s filter_tab">
			<select name="ofmonth" id="ofyear" class="type" onchange="filter_orders_affi(<?php echo $data-> id; ?>)">
				<?php for($j=date("Y");$j>=2020-1;$j--){ ?>
					<option value="<?php echo $j; ?>">Năm <?php echo $j; ?></option>
				<?php } ?>			
			</select>	
		</div>

	</div>
	<div class="list_history_order">
		<?php if(!empty($list_orders)){?>
			<?php foreach ($list_orders as $order) { ?>
				<div class="item_oder">
					<div class="code_order cls"><a title="Xem chi tiết" href="/ket-thuc-don-hang-<?php echo $order-> id ?>.html" target="_blank"><span class="code"><?php echo FSText::_('Mã đơn hàng'); ?> : DH<?php echo str_pad($order -> id, 8 , "0", STR_PAD_LEFT);?></span></a>
						<span class="date_time">(<?php echo date('d/m/Y',strtotime($order -> created_time)); ?>)</span>
						<span class="status"><?php echo $order-> status?'<span class="done">Đã hoàn tất</span>':'<span class="notdone">Chưa hoàn tất</span>' ?></span>
					</div>
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
					</div>

				</div>
			<?php } ?>
		<?php } else {?>
			<div class="item_oder">
				<div class="code_order ">Bạn chưa có đơn hàng giới thiệu nào!</div></div>
			<?php } ?>
		</div>
	</div>
