<div class="frame-large-body cls">
	<table width="100%">
		<tr>
			<th width="4.3%" height="35"><?php echo FSText::_('STT'); ?></th>
			<th width="45%"><?php echo FSText::_('Tên sản phẩm'); ?></th>
			<th width="14%"><?php echo FSText::_('Đơn giá'); ?></th>
			<th width="14%"><?php echo FSText::_('Số lượng'); ?></th>
			<th width="14%"><?php echo FSText::_('Tổng'); ?></th>
		</tr>	
		<?php
		$i = 0; 
		$total = 0;
		$quantity = 0;
		$total_discount = 0;
		foreach ($order_detail as $item) {
			$i++;
			$total += $item -> total;
			$quantity += $item -> count;
			$product = @$products[$item -> product_id];
			$link_detail_product =FSRoute::_('index.php?module=products&view=product&code='.$product->alias.'&id='.$product -> id.'&ccode='.$product -> category_alias.'&Itemid=6');
			$image_color = '';
			?>	
			<tr>
				<td style="text-align: center;"><?php echo $i ?></td>
				<td style="text-align: left;">
					<div class="title-img">
						<a href="<?php echo $link_detail_product; ?>" > 
							<?php 
								if($item -> color_id && !empty($item -> color_id && $item -> color_id !='')){
									$data_color = $model-> get_record('id = ' . $item -> color_id ,'fs_products_price','color_id');
									if($data_color){
										$image_color =  $model -> get_record('color_id = ' .$data_color->color_id. ' AND record_id = ' . $product->id,'fs_products_images','image');
									}
								}
								
							?>

							<?php if($product -> image){ ?>
								<?php if(isset($image_color) && !empty($image_color->image) ){
									$image_small = URL_ROOT.str_replace('/original/', '/small/', $image_color->image);
								}else{
									$image_small = URL_ROOT.str_replace('/original/', '/small/', $product->image);
								}?>


								<img  src="<?php echo $image_small; ?>" alt="<?php echo htmlspecialchars ($product -> name); ?>"  />
							<?php } else {?>
								<img  src="<?php echo URL_ROOT.'images/no-img.gif'; ?>" alt="<?php echo htmlspecialchars ($product -> name); ?>" />
							<?php }?>
						</a> 
					</div>
					<div class="title-name">
						<h2 class="name">
							<a class="name-product"  title='' href='<?php echo $link_detail_product; ?>' >
								<strong><?php echo @$product -> name ;?></strong><?php if(@$item-> note) echo ' ('.@$item-> note.')'; ?>
							</a>
						</h2>
						<?php
						
							echo "<div>Giá sản phẩm: " . format_money($item->price)."</div>";
							
							if(@$item-> string_info_extent != "") {
								echo 'Chọn thêm: '.$item-> string_info_extent;
							}

							if ($item->color_id){
								echo '<div> Màu '.$item->color_name .': ';
								if($item->color_price>=0){
									echo '<span class="">+'.format_money($item->color_price,'₫','0₫').'</span>'.'</div>';
								}else{
									echo '<span class="">'.format_money($item->color_price,'₫','0₫').'</span>'.'</div>';
								}
							}

							if ($item->region_id){
								echo '<div> Khu vực '.$item->region_name .': ';
								if($item->region_price >= 0 ){
									echo '<span class="">+'.format_money($item->region_price,'₫','0₫').'</span>'.'</div>';
								}else{
									echo '<span class="">'.format_money($item->region_price,'₫','0₫').'</span>'.'</div>';
								}
							}

							if ($item->warranty_id){
								echo '<div> Bảo hành '.$item->warranty_name .': ';
								if($item->warranty_price >= 0 ){
									echo '<span class="">+'.format_money($item->warranty_price,'₫','0₫').'</span>'.'</div>';
								}else{
									echo '<span class="">'.format_money($item->warranty_price,'₫','0₫').'</span>'.'</div>';
								}
							}
						
						?>
						<?php if($item-> no_services){ ?>
							<div class="no_services">Mua online không dịch vụ</div> 
						<?php } ?>
					</div>
				</td>
				<td style="text-align: center;">
					<div class="price"><?php echo format_money($item -> total / $item -> count); ?></div>
				</td>
				<td style="text-align: center;"><?php echo $item -> count; ?></td>
				<td style="text-align: center;"><div class="price"><?php echo format_money($item -> total); ?></div></td>
			</tr>


				<?php 
					$products_list_gift = $model->get_products_list_gift($product);
					if(!empty($products_list_gift)){
						foreach ($products_list_gift as $gift_item) {
						
				?>
					<tr>
						<td style="text-align: center;"></td>
						<td style="text-align: left;">
							<div class="title-img">
								<a href="javascript:void(0)" > 
									<?php if($gift_item -> image){ ?>
										<?php $image_small = URL_ROOT.str_replace('/original/', '/small/', $gift_item->image); ?>
										<img  src="<?php echo $image_small; ?>" alt="<?php echo htmlspecialchars ($gift_item -> name); ?>"  />
									<?php } else {?>
										<img  src="<?php echo URL_ROOT.'images/no-img.gif'; ?>" alt="<?php echo htmlspecialchars ($product -> name); ?>" />
									<?php }?>
								</a> 
							</div>
							<div class="title-name">
								<h2 class="name"><a class="name-product"  title='<?php  echo @$gift_item -> name ;  ?>' href='javascript:void(0)' ><?php  echo @$gift_item -> name ;  ?></h2>
							</div>
						</td>
						<td style="text-align: center;">
							<div class="price">0₫ (Qùa tặng)</div>
						</td>
						<td style="text-align: center;"><?php echo $item -> count; ?></td>
						<td style="text-align: center;"><div class="price">0₫ (Qùa tặng)</div></td>
					</tr>
				<?php }} ?>

			<?php }?>


			<!-- quà tặng theo khoản giá -->

			<?php 
				if(!empty($order->list_gift_price_range)){
					$gift_price_range_str = substr($order->list_gift_price_range, 1, -1);
					$product_gift_price_range = $model-> get_records('published = 1 AND id IN ('.$gift_price_range_str.')','fs_products_list_gift');
					if(!empty($product_gift_price_range)){
					foreach ($product_gift_price_range as $gift_item) {
					
			?>
				<tr>
					<td style="text-align: center;"></td>
					<td style="text-align: left;">
						<div class="title-img">
							<a href="javascript:void(0)" > 
								<?php if($gift_item -> image){ ?>
									<?php $image_small = URL_ROOT.str_replace('/original/', '/small/', $gift_item->image); ?>
									<img  src="<?php echo $image_small; ?>" alt="<?php echo htmlspecialchars ($gift_item -> name); ?>"  />
								<?php } else {?>
									<img  src="<?php echo URL_ROOT.'images/no-img.gif'; ?>" alt="<?php echo htmlspecialchars ($product -> name); ?>" />
								<?php }?>
							</a> 
						</div>
						<div class="title-name">
							<h2 class="name"><a class="name-product"  title='<?php  echo @$gift_item -> name ;  ?>' href='javascript:void(0)' ><?php  echo @$gift_item -> name ;  ?></h2>
						</div>
					</td>
					<td style="text-align: center;">
						<div class="price">0₫ (Qùa tặng)</div>
					</td>
					<td style="text-align: center;">1</td>
					<td style="text-align: center;"><div class="price">0₫ (Qùa tặng)</div></td>
				</tr>
			<?php }}} ?>



			</table>
			<div class="frame-large-body-mobile">
				<?php include_once 'finished_mobile.php'; ?>
			</div>
			<div class="bottom">
				<p><span><?php echo FSText::_('Tổng cộng'); ?>: </span><span><?php echo format_money($order -> total_before_discount); ?></span></p>
				<?php if($order -> code_sale){ ?>
					<p><span><?php echo FSText::_('Khuyến mãi'); ?>: </span><span>-<?php echo format_money($order -> money_dow,'₫','0');?></span></p>
					<p><span><?php echo FSText::_('Phí ship'); ?>: </span><span>Liên hệ lại !</span></p>	
					<p><span><?php echo FSText::_('Thanh toán'); ?>: </span><span>
						<?php echo format_money($order -> total_after_discount); ?></span>
					</p>	

				<?php } else {?>
					<p><span><?php echo FSText::_('Phí ship'); ?>: </span><span>Liên hệ lại !</span></p>	
					<p><span><?php echo FSText::_('Thanh toán'); ?>: </span><span><?php echo format_money($order -> total_after_discount); ?></span></p>	
				<?php }?>
			</div>

			<div class='clear'></div>
		</div>