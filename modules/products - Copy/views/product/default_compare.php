<div class="products_compare_wrap">
	<div class="tab-title tab-title-2 cls">
		<div class="cat-title-main" id="characteristic-label">
			<h3><span id="compare-mb">So sánh sản phẩm <span>tương tự</span></span></h3>
		</div>
		<div class='compare_box'>
			<input type="text" name="compare_name" id="compare_name" placeholder="Nhập tên sản phẩm cần so sánh..." />
			<input type="hidden" id="table_name" value="<?php echo str_replace('fs_products_','',$data -> tablename); ?>" />
		</div>
	</div>
	<div class="list_vertical products_compare">
		<div class="item-related cls">
			<?php if($data-> price_old > $data-> price) {$discount_tt = round((($data -> price_old - $data -> price) /$data -> price_old) * 100);?>
				<?php if($data-> is_hot) { ?>
					<div class="discount_p">
						<?php echo 'SALE '.$discount_tt.'%'; ?>
					</div>
				<?php } ?>
			<?php } ?>
			<a class="img_a" target="_blank" href="javascript:void(0)" title="<?php echo $data -> name; ?>">
				<?php echo set_image_webp($data->image,'resized',@$data->name,'lazy',1,''); ?>
			</a>

			<div class="text-view text-view-main">
				Bạn đang xem:
			</div>

			<a class="name" href="javascript:void(0)" title="<?php echo $data -> name; ?>" >
				<?php echo $data -> name; ?>	
			</a>

			<div class="price_wrap">
				<div class="price"><?php echo format_money($data->price) ?></div>
				<?php if($data->price_old > $data->price){ ?>
					<div class="price_old"><?php echo format_money($data->price_old) ?></div>
				<?php } ?>
			</div>

			<?php 
			if(!empty($data-> promotion_info)){
				?>
				<div class="promotion_info">
					<?php echo $data-> promotion_info; ?>
				</div>
			<?php } ?>
			
		</div>

		<?php if($array_products_compare){ ?>
			<?php $k = 0; ?>
			<?php foreach ($array_products_compare as $item){?>
				<?php if($k > 2) break; ?>
				<?php $link = FSRoute::_("index.php?module=products&view=product&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias.'&cid='.$item -> category_id); ?>
				<?php 
				$ids_cp = $data -> id.'-'.$item -> id;
				$codes_cp = $data -> alias.'-va-'.$item -> alias;						
				$link_compare = FSRoute::_('index.php?module=products&view=compare&codes='.$codes_cp.'&ids='.$ids_cp); ?>

				<?php $image = URL_ROOT.str_replace('/original/', '/resized/',$item -> image);?>
				<div class="item-related cls">
					<?php if($item-> price_old > $item-> price) {$discount_tt = round((($item -> price_old - $item -> price) /$item -> price_old) * 100);?>
						<?php if($item-> is_hot) { ?>
							<div class="discount_p">
								<?php echo 'SALE '.$discount_tt.'%'; ?>
							</div>
						<?php } ?>
					<?php } ?>
					<a class="img_a" target="_blank" href="<?php echo $link; ?>" title="<?php echo $item -> name; ?>">
						<?php echo set_image_webp($item->image,'resized',@$item->name,'lazy',1,''); ?>
					</a>
					<div class="text-view">
					</div>
					<h3 class="name" href="<?php echo $link; ?>" title="<?php echo $item -> name; ?>" target="_blank" ><?php echo ($item -> name); ?></h3>
					<div class="price_wrap">
						<div class="price"><?php echo format_money($item->price) ?></div>
						<?php if($item->price_old > $item->price){ ?>
							<div class="price_old"><?php echo format_money($item->price_old) ?></div>
						<?php } ?>
					</div>

					<?php 
					if(!empty($item-> promotion_info)){
						?>
						<div class="promotion_info">
							<?php echo $item-> promotion_info; ?>
						</div>
					<?php } ?>
					<a class="link_compare" target="_blank" href="<?php echo $link_compare; ?>" title="<?php echo 'So sánh giữa '.$data -> name.' với '.$item -> name; ?>">
					So sánh chi tiết</a>
					
				</div>
				<?php $k++?>
			<?php } ?>
		<?php } ?>
		<div class='clear'></div>
	</div>

	
</div>