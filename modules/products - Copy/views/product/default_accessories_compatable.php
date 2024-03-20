<div class="popup_chose_other_compatables hide">
	<div class="popup_chose_other_compatables_inner">
		<div class="close_popup_chose_other_compatables">x</div>
		<?php $itypes_compatables=0; foreach ($types_compatables as $types_compatable) { ?>
			<div class="popup_products_other_compatables hide" id="popup_products_other_compatables_<?php echo $types_compatable-> group_id?>">
				<div class="other_title">
					Chọn <?php echo $types_compatable-> group_name; ?> khác
				</div>
				<div class="clear"></div>
				<div class="product_grid">
					<?php foreach($products_compatables[$types_compatable-> group_id] as $products_compattb){?>
						<div class='product_compatables_item item'>
							<div class="frame_inner">
								<!-- <?php echo $products_compattb-> id; ?> -->
								<?php $product_item = @$product_compatable_id[$products_compattb -> product_compatable_id]; ?>
								<?php if($product_item){?>
									<?php $link  = FSRoute::_('index.php?module=products&view=product&code='.$product_item -> alias.'&id='.$product_item -> id.'&ccode='.$product_item -> category_alias.'&Itemid=37');?>
									<figure class="product_image ">
										<?php echo set_image_webp($product_item->image,'resized',@$product_item-> name,'lazy',1,''); ?>
									</figure>
									
									<h2 class="name_compatable">
										<div class="check">
										</div><a target="_blank" href="<?php echo $link; ?>"  title="<?php echo htmlspecialchars ($product_item -> name); ?>"> <?php echo $product_item -> name; ?></a></h2>
										<div class='price_arae'>
											<span class='price_current'><?php echo format_money($products_compattb -> price).''?></span>
											<?php if($products_compattb-> price_old > $products_compattb-> price) { ?>
												<span class='price_old'><?php echo format_money($products_compattb -> price_old).''?></span>
											<?php }?>
										</div>
										<a href="<?php echo $link; ?>"  title="<?php echo htmlspecialchars ($product_item -> name); ?>"><span class="button-detail"></span></a>
										<div class="clear"></div>
										<div class="chose_product_other_compatables"><a href="javascript:void(0)" onclick="chose_product_other_compatables(<?php echo $data-> id ?>,<?php echo $products_compattb-> product_compatable_id; ?>,<?php echo $types_compatable-> group_id; ?>)">Chọn sản phẩm này</a></div>
									</div>
								</div>
							<?php } ?>
						<?php } ?>
					</div>
				</div>
				<?php $itypes_compatables++; ?>
			<?php } ?>
		</div>
	</div>

	<?php $total_money_compatable = $price;?>
	<?php $total_money_compatable_old = $price;?>
	<!-- <?php //if(!empty($products_compatables)){?> -->
	<?php if(!empty($types_compatables)){?>
		<?php $str_id_compatables = ''; $i_str_id_compatables = 0;
		foreach ($types_compatables as $types_compatable) {
			if($i_str_id_compatables) {
				$str_id_compatables .= '_'.$products_compatables[$types_compatable-> group_id][0]-> product_compatable_id;
			} else {
				$str_id_compatables .= $products_compatables[$types_compatable-> group_id][0]-> product_compatable_id;
			}
			$i_str_id_compatables++;
		}?>

		<?php  //print_r($products_compatable);?>
		<div class="product_compatables">
			<div class="tab-title">
				<span>Ưu đãi khi mua cùng</span>
			</div>
			<div class="product_grid">
				<input type="hidden" id="product_price" name="product_price" value="<?php echo $price;?>">
				<input type="hidden" id="str_id_compatables" value="<?php echo $str_id_compatables; ?>">
				<div class="item">
					<div class="frame_inner">
						<figure class="product_image ">
							<?php echo set_image_webp($data->image,'resized',@$data-> name,'lazy',1,''); ?>
						</figure>
						<?php if($data-> price_old > $data-> price && 1==2) { ?>
							<span class='price_discount'><?php echo ceil(($data -> price  - $data -> price_old) * 100 / $data-> price_old);?>%</span>
						<?php }?>
						<h2><a href="<?php echo FSRoute::_('index.php?module=products&view=product&code='.$data -> alias.'&id='.$data -> id.'&ccode='.$data -> category_alias.'&Itemid=37'); ?>"  title="<?php echo htmlspecialchars ($data -> name); ?>"> <?php echo $data -> name; ?></a>
						</h2>
						<div class='price_arae'>
							<span class='price_current'><?php echo format_money($data -> price).''?></span>
							<?php if($data-> price_old > $data-> price) { ?>
								<span class='price_old'><?php echo format_money($data -> price_old).''?></span>
							<?php }?>
						</div>
					</div>
				</div>

				<?php foreach($types_compatables as $types_compatable){?>
					<div class='product_compatables_item item' id = "product_compatables_item_<?php echo $types_compatable-> group_id; ?>">
						<input type="hidden" id="active_product_compatables_item_<?php echo $types_compatable-> group_id; ?>" value="<?php echo $products_compatables[$types_compatable-> group_id][0] -> product_compatable_id;?>">
						<div class="frame_inner">
							<!-- <?php echo $products_compatables[$types_compatable-> group_id][0]-> id; ?> -->
							<?php $product_item = @$product_compatable_id[$products_compatables[$types_compatable-> group_id][0] -> product_compatable_id]; ?>
							<?php if($product_item){?>
								<?php $total_money_compatable += ($products_compatables[$types_compatable-> group_id][0] -> price); ?>
								<?php $total_money_compatable_old += ($product_item -> price_old); ?>
								<?php $link  = FSRoute::_('index.php?module=products&view=product&code='.$product_item -> alias.'&id='.$product_item -> id.'&ccode='.$product_item -> category_alias.'&Itemid=37');?>
								<figure class="product_image ">
									<?php echo set_image_webp($product_item->image,'resized',@$product_item-> name,'lazy',1,''); ?>
								</figure>
								
								<h2 class="name_compatable">
									<div class="check">
										<input type="checkbox" checked="checked" name='product_compatable[]' id="check_product_compatable_<?php echo $products_compatables[$types_compatable-> group_id][0] -> product_compatable_id; ?>" onclick="click_check_product_compatable(<?php echo $products_compatables[$types_compatable-> group_id][0] -> product_compatable_id; ?>)" value='<?php echo $products_compatables[$types_compatable-> group_id][0] -> product_compatable_id; ?>' class='check_product_compatable' rel1="<?php echo $product_item -> price?>" rel = "<?php echo $products_compatables[$types_compatable-> group_id][0] -> price; ?>" />
									</div><a target="_blank" href="<?php echo $link; ?>"  title="<?php echo htmlspecialchars ($product_item -> name); ?>"> <?php echo $product_item -> name; ?></a></h2>
									<div class='price_arae'>
										<span class='price_current'><?php echo format_money($products_compatables[$types_compatable-> group_id][0] -> price).''?></span>
										<?php if($products_compatables[$types_compatable-> group_id][0]-> price_old > $products_compatables[$types_compatable-> group_id][0]-> price) { ?>
											<span class='price_old'><?php echo format_money($products_compatables[$types_compatable-> group_id][0] -> price_old).''?></span>
										<?php }?>
									</div>
									<div class="clear"></div>
								</div>
								<div class="chose_other_compatables"><a href="javascript:void(0)" onclick="chose_other_compatables(<?php echo $types_compatable-> group_id; ?>)">Chọn <?php echo $products_compatables[$types_compatable-> group_id][0] -> group_name;  ?> khác</a></div>
							</div>
						<?php }?>
					<?php }?>
					<?php if($total_money_compatable){?>
						<div class='total_money_compatable' >
							<div class='label'>Tổng tiền: </div>
							<div class="total_money">
								<strong id="total_money_compatable"><?php echo format_money($total_money_compatable);?></strong><span class='total_money_compatable_old'><?php echo format_money($total_money_compatable_old);?></span>
							</div>
							<div class="count_total">

								<a href="javascript: buy_add_compatables(<?php echo $data-> id;?>)">
									<svg viewBox="0 -31 512.00026 512"><path d="m164.960938 300.003906h.023437c.019531 0 .039063-.003906.058594-.003906h271.957031c6.695312 0 12.582031-4.441406 14.421875-10.878906l60-210c1.292969-4.527344.386719-9.394532-2.445313-13.152344-2.835937-3.757812-7.269531-5.96875-11.976562-5.96875h-366.632812l-10.722657-48.253906c-1.527343-6.863282-7.613281-11.746094-14.644531-11.746094h-90c-8.285156 0-15 6.714844-15 15s6.714844 15 15 15h77.96875c1.898438 8.550781 51.3125 230.917969 54.15625 243.710938-15.941406 6.929687-27.125 22.824218-27.125 41.289062 0 24.8125 20.1875 45 45 45h272c8.285156 0 15-6.714844 15-15s-6.714844-15-15-15h-272c-8.269531 0-15-6.730469-15-15 0-8.257812 6.707031-14.976562 14.960938-14.996094zm312.152343-210.003906-51.429687 180h-248.652344l-40-180zm0 0"/><path d="m150 405c0 24.8125 20.1875 45 45 45s45-20.1875 45-45-20.1875-45-45-45-45 20.1875-45 45zm45-15c8.269531 0 15 6.730469 15 15s-6.730469 15-15 15-15-6.730469-15-15 6.730469-15 15-15zm0 0"/><path d="m362 405c0 24.8125 20.1875 45 45 45s45-20.1875 45-45-20.1875-45-45-45-45 20.1875-45 45zm45-15c8.269531 0 15 6.730469 15 15s-6.730469 15-15 15-15-6.730469-15-15 6.730469-15 15-15zm0 0"/></svg>
									<div class="title">Mua <?php echo (count($products_compatables) + 1); ?> sản phẩm</div>
									<div class="reduction">Tiết kiệm <?php echo format_money($total_money_compatable_old - $total_money_compatable); ?></div>
								</a>
							</div>
						</div>
					<?php }?>
				</div>
			</div>
			<div class="clear"></div>
		<?php }  else {?>
			<!-- Không có phụ kiện khuyến mãi nào đối với sản phẩm này -->
			<?php }?>