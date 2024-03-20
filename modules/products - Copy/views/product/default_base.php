		<?php if(!empty($product_memory)){?>
			<?php foreach ($product_memory as $item){
				$pr=$model->get_record_by_id($item->product_relate,'fs_products','category_alias,alias,category_id,id,name,price');
				if($data-> id == $pr->id) {
					$pb_name = $item-> name;
				}
			} ?>
		<?php }?>	
		<?php if(!empty($product_memory)){?>
			<label>Bạn đang xem phiên bản: <span><?php echo $pb_name; ?></span></label>
			<div class="boxmemory_relate cls <?php if(count($product_memory)>2) echo 'boxmemory_relate_slide'; ?>">						
				<?php $im=0; foreach ($product_memory as $item){
					$pr=$model->get_record_by_id($item->product_relate,'fs_products','category_alias,alias,category_id,id,name,price');
					if($data-> id == $pr->id) {
						$link_r = "javascript:void(0)";
					} else {
						$link_r = FSRoute::_('index.php?module=products&view=product&code='.$pr -> alias.'&ccode='.$pr->category_alias.'&id='.$pr->id.'&cid='.$pr->category_id.'&Itemid='.$Itemid);
					}
					?>
					<div class="boxmemory_relate_item relate_item-block <?php if($im > 1) echo 'hide'; ?>">
						<a href="<?php echo $link_r; ?>" title="<?php echo $pr->name; ?>" class= "<?php echo ($data-> id == $pr->id )?'active':'';?>">
							<span class="name"><?php echo $item -> name;?></span><br>
							<span><?php echo  format_money($pr -> price);?></span>
						</a>
					</div>
				<?php $im++; }	?>
			</div>
		<?php }?>
		<div class='product_base'>	
			<form action="#" name="buy_simple_form" method="post" >
				<?php if(!empty($prices_by_regions)){?>
					<div class="region_wp">		
						<?php $city_id_cookie = isset($_COOKIE['city_id'])?$_COOKIE['city_id']:0; ?>
						<div class="txt-region_wp">
							Mua hàng từ
						</div>
						<select  class="box_region" onchange="load_quick(this)" name="region_curent_id">
							<option value="0" data-price="0" data-type="region">-- Chọn khu vực --</option>
							<?php 	foreach ($prices_by_regions as $item){?>
								<option <?php echo $item->is_default == 1 ? 'selected' : '' ?> class="<?php echo $item->is_default == 1 ? 'trigger_is_default' : ''  ?>" value="<?php echo $item->id ?>"  data-price="<?php echo ($item -> price)?$item -> price:0;?>" data-type="region"><?php echo $item -> region_name;?></option>
							<?php }	?>
						</select>
					</div>
					<div class="clear"></div>
				<?php }?>

				<?php include 'default_prices.php';?>
				<?php //include 'default_member_level.php';?>


				<input type='hidden'  name="module" value="products"/>		    	
				<input type='hidden'  name="view" value="cart"/>
				<input type='hidden'  name="task" value="ajax_buy_product"/>
				<input type='hidden'  name="product_id" value="<?php echo $data -> id; ?>"/>
				<input type='hidden'  name="Itemid" value="10"/>
			</form>


			<!-- Kết thúc mua nhanh -->

			<div class="buy_fast_p">
				<div class="title_buy_fast_bold">Đặt hàng nhanh</div>
				<div class="title_buy_fast">Để lại số điện thoại, chúng tôi sẽ gọi lại ngay</div>
				<div class="clear"></div>
				<form action="" name="buy_fast_form" id="buy_fast_form" method="post" onsubmit="javascript: return submit_form_buy_fast();" >
					<div class="cls">
						<input type="tel" required value="" placeholder="Nhập số điện thoại tư vấn nhanh" id="telephone_buy_fast" name="telephone_buy_fast" class="keyword input-text" />
						<button type="submit" class="button-buy-fast button">Gửi</button>
					</div>
					<?php 
					$url = $_SERVER['REQUEST_URI'];
					$return = base64_encode($url);					
					?>
					<input type='hidden'  name="module" value="products"/>		    	
					<input type='hidden'  name="view" value="cart"/>
					<input type='hidden'  name="task" value="buy_fast_save"/>
					<input type='hidden'  name="id" value="<?php echo $data -> id; ?>"/>
					<input type='hidden'  name="Itemid" value="10"/>
					<input type="hidden" value="<?php echo $return; ?>" name="return"  />
				</form>
			</div>

			<!--	TAGS		-->

			<input type="hidden" name='record_alias' id='record_alias' value='<?php echo $data -> alias; ?>'>
			<input type="hidden" name='record_id' id='record_id' value='<?php echo $data -> id; ?>'>
			<input type="hidden" name='table_name'  id ='table_name' value='<?php echo str_replace('fs_products_','', $data -> tablename); ?>'>
		</div>

		<div class="hotline_detail_product"><?php echo $config['hotline_detail_product']; ?></div>

		<?php if($data-> gift_accessories){?>
			<div class="gift_summary">
				<div class="title_gift_full">
					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
						<g>
							<g>
								<path d="M478.609,99.726H441.34c4.916-7.78,8.16-16.513,9.085-25.749C453.38,44.46,437.835,18,411.37,6.269    c-24.326-10.783-51.663-6.375-71.348,11.479l-47.06,42.65c-9.165-10.024-22.34-16.324-36.962-16.324    c-14.648,0-27.844,6.32-37.011,16.375l-47.12-42.706C152.152-0.111,124.826-4.502,100.511,6.275    C74.053,18.007,58.505,44.476,61.469,73.992c0.927,9.229,4.169,17.958,9.084,25.734H33.391C14.949,99.726,0,114.676,0,133.117    v50.087c0,9.22,7.475,16.696,16.696,16.696h478.609c9.22,0,16.696-7.475,16.696-16.696v-50.087    C512,114.676,497.051,99.726,478.609,99.726z M205.913,94.161v5.565H127.37c-20.752,0-37.084-19.346-31.901-40.952    c2.283-9.515,9.151-17.626,18.034-21.732c12.198-5.638,25.71-3.828,35.955,5.445l56.469,51.182    C205.924,93.834,205.913,93.996,205.913,94.161z M417.294,69.544c-1.244,17.353-16.919,30.184-34.316,30.184h-76.891v-5.565    c0-0.197-0.012-0.392-0.014-0.589c12.792-11.596,40.543-36.748,55.594-50.391c8.554-7.753,20.523-11.372,31.587-8.072    C409.131,39.847,418.455,53.349,417.294,69.544z"></path>
							</g>
						</g>
						<g>
							<g>
								<path d="M33.391,233.291v244.87c0,18.442,14.949,33.391,33.391,33.391h155.826V233.291H33.391z"></path>
							</g>
						</g>
						<g>
							<g>
								<path d="M289.391,233.291v278.261h155.826c18.442,0,33.391-14.949,33.391-33.391v-244.87H289.391z"></path>
							</g>
						</g>
					</svg>
					Khuyến mại kèm theo
				</div>

				<div class="gift_full">
					<?php echo $data-> gift_accessories ?>
				</div>
			</div>

		<?php } ?>

		<?php // include "default_orders.php";?>

		<?php // include 'default_tags.php'; ?>

