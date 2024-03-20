


<div class='product_base'>
	
	<h1 itemprop="name"><?php echo $data -> name; ?> </h1>

	<div class="status-rate cls">
		<?php include_once 'default_base_rated_fixed.php'; ?>
		<div class="status-product">
			<span class="icon_v1"></span>
			<span class="status_name"><?php echo @$style_status[$data-> status]->name; ?></span>
		</div>
	</div>
	<?php if($is_mobile && 1==2){ ?>	
	<div class='strengths_mobile'>
		<?php  
			echo $tmpl -> load_direct_blocks('strengths',array('style'=>'row_4','catid'=>'55'));
		?>
	</div>
	<?php } ?>

	<div class="clear"></div>

	<?php if($data->manufactory_name){ ?>
	<div class="manu_name_product">
		<span>Thương hiệu:</span> <?php echo $data->manufactory_name ?>
	</div>
	<?php } ?>
	<?php if(!empty($data->warranty)){?>
	<div class="manu_name_product">
		<span>Bảo hành:</span> <?php echo $data->warranty ?>
	</div>
	<?php } ?>
	<div class="clear"></div>



	<?php if( $data -> manufactory_name){ ?>
		<meta itemprop="brand" content="<?php echo $data -> manufactory_name; ?>">
	<?php }  else{?>
		<meta itemprop="brand" content="<?php echo $config['site_name']; ?>">
	<?php  } ?>


	
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

	

		<?php if(!empty($price_quantity) && 1==2) { ?>
			<div class="price_quantity">
				<div class="label"><strong>Mua nhiều giảm giá</strong></div>
				<div class="list">
					<?php foreach ($price_quantity as $price_quan) { ?>
						<div class="item cls">
							<div class="quan"><a href="javascript:void(0)" onclick="add_mutil_to_cart(<?php echo $data-> id;?>,<?php echo $price_quan-> quantity;  ?>)">Mua <?php echo $price_quan-> quantity;  ?></a></div>
							<div class="price_quan"><?php echo format_money($price_quan-> price); ?></div>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php } ?>


		

		<div class='detail_button product_detail_bt cls'>
			<?php if(1==2){ ?>
			<?php if(@$_COOKIE['user_id']) { ?>
				<div class="wishlist">
					<a href="javascript:void(0)" id="wishlist" onclick="update_wishlist(<?php echo $data-> id; ?>)" class="<?php if($wishlist) echo 'wishlist_active' ?>"><svg viewBox="0 -28 512.00002 512" ><path d="m471.382812 44.578125c-26.503906-28.746094-62.871093-44.578125-102.410156-44.578125-29.554687 0-56.621094 9.34375-80.449218 27.769531-12.023438 9.300781-22.917969 20.679688-32.523438 33.960938-9.601562-13.277344-20.5-24.660157-32.527344-33.960938-23.824218-18.425781-50.890625-27.769531-80.445312-27.769531-39.539063 0-75.910156 15.832031-102.414063 44.578125-26.1875 28.410156-40.613281 67.222656-40.613281 109.292969 0 43.300781 16.136719 82.9375 50.78125 124.742187 30.992188 37.394531 75.535156 75.355469 127.117188 119.3125 17.613281 15.011719 37.578124 32.027344 58.308593 50.152344 5.476563 4.796875 12.503907 7.4375 19.792969 7.4375 7.285156 0 14.316406-2.640625 19.785156-7.429687 20.730469-18.128907 40.707032-35.152344 58.328125-50.171876 51.574219-43.949218 96.117188-81.90625 127.109375-119.304687 34.644532-41.800781 50.777344-81.4375 50.777344-124.742187 0-42.066407-14.425781-80.878907-40.617188-109.289063zm0 0"/></svg></a>
					<input type="hidden" id="check_wishlist" value="<?php if($wishlist) echo '1'; else echo '0' ;?>">
				</div>
			<?php } ?>
			<?php } ?>

			<?php if(!empty($data-> summary)){ ?>
		<div class="gift_summary description">
			<?php echo $data-> summary ?>
		</div>
		<?php } ?>
			<div class="text">Số lượng:</div>
			<div class="numbers-row">
				<input name="buy_count" id="buy_count" value="1" type="text" placeholder="Số lượng">
				<span class="inc button" data="inc"><svg  width="10px" height="10px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" ><path fill="gray" d="M17.525 36.465l-7.071 7.07c-4.686 4.686-4.686 12.284 0 16.971L205.947 256 10.454 451.494c-4.686 4.686-4.686 12.284 0 16.971l7.071 7.07c4.686 4.686 12.284 4.686 16.97 0l211.051-211.05c4.686-4.686 4.686-12.284 0-16.971L34.495 36.465c-4.686-4.687-12.284-4.687-16.97 0z" class=""></path></svg></span>
				<span class="dec button" data="dec"><svg  width="10px" height="10px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" ><path fill="gray" d="M17.525 36.465l-7.071 7.07c-4.686 4.686-4.686 12.284 0 16.971L205.947 256 10.454 451.494c-4.686 4.686-4.686 12.284 0 16.971l7.071 7.07c4.686 4.686 12.284 4.686 16.97 0l211.051-211.05c4.686-4.686 4.686-12.284 0-16.971L34.495 36.465c-4.686-4.687-12.284-4.687-16.97 0z" class=""></path></svg></span>
			</div>
			<div class="clear"></div>
			
			<?php
			if(1==1 && !empty($sale)){?>
			<div class="wraper_sale">
				<div class="sale_day cls">
					<div class="sale_date">		
						
						<div class="cls buy_fast_body hide">
							<input type="text" value="" placeholder="" id="sale_date" name="sale_date" class="keyword input-text" />
							<button type="button" class="button-sale-date button" onclick="myCoppy()">Sao chép </button>
						</div>
						<?php 	
						global $insights;
						if (!$insights){ ?>
							<div class="title-share-fb cls">
								<div class="button-share"><?php include "share_facebook_coupon.php" ?></div>
							</div>
							<div class="clear"></div>
						<?php } ?>
						<?php 
						$url = $_SERVER['REQUEST_URI'];
						$return = base64_encode($url);	
						?>
						<?php 
						if($sale -> link_share ==""){
							$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";		
						}else{
							$actual_link = $sale->link_share;	
						}	
						?>
						<!-- <input type='hidden' name="link_share_fb_conf"  id="link_share_fb_conf" value="<?php //echo $config['link_share_facebook']?>"/> -->
						<input type='hidden' name="link_share_product" id="link_share_product" value="<?php echo $actual_link ?>"/>
						<input type='hidden'  name="id" value="<?php echo $data -> id; ?>"/>
						<input type="hidden" name="price_key_share" value="<?php echo $sale->money_dow; ?>">						
					</div>
				</div>
				<div class="clear"></div>
				<div class="text_aaa hide"><a href="javascript:void(0)" onclick="buy_add_product(<?php echo $data-> id; ?>)" class="text_cart" title="Thanh toán">Sử dụng mã này</a></div>
			</div>
			<?php } ?>
	
			
			<?php if($data-> status ==1){ ?>
				<div class="wrap-btm-buy cls">
					<button type="submit"class="btn-buy-222 fl" id="buy-now-222">
						<span>
							<?php echo FSText::_('Mua ngay'); ?>
						</span>
						
					</button>

					<?php if(1==2){ ?>
					<a href="javascript:void(0)" class="btn-tragop fr" data-toggle="modal">
						<span>Trả góp lãi xuất thấp</span>
						<p>(Tư vấn qua điện thoại)</p>
					</a>
					<?php } ?>

					<a  href="javascript:void(0)" onclick="add_to_cart(<?php echo $data-> id; ?>)" class="btn-dathang" data-toggle="modal">
						<font>Giao hàng hỏa tốc 2H</font>
					</a>
			
				</div>		
			<?php } ?>

			<div class="clear"></div>
		</div>
		<input type='hidden'  name="module" value="products"/>		    	
		<input type='hidden'  name="view" value="cart"/>
		<input type='hidden'  name="task" value="ajax_buy_product"/>
		<input type='hidden'  name="product_id" value="<?php echo $data -> id; ?>"/>
		<input type='hidden'  name="Itemid" value="10"/>
	</form>


	<!-- Kết thúc mua nhanh -->
	<?php if(1==2){ ?>
		<div class="buy_fast">
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
	<?php } ?>


		<!--	TAGS		-->

		<input type="hidden" name='record_alias' id='record_alias' value='<?php echo $data -> alias; ?>'>
		<input type="hidden" name='record_id' id='record_id' value='<?php echo $data -> id; ?>'>
		<input type="hidden" name='table_name'  id ='table_name' value='<?php echo str_replace('fs_products_','', $data -> tablename); ?>'>
	</div>



<?php 
	//include "default_orders.php";
?>

<?php //include 'default_tags.php'; ?>

