<div class="buyer_info">
	<div class="title-box-cart">Thông tin người mua hàng</div>
	<div class="mb-2"><b class="fs-16">Thông tin người mua</b> (<span class="red">*</span>) <i>Thông tin bắt buộc</i></div>
	<form action="#" name="eshopcart_info" method="post" id="eshopcart_info">
		<div class="shadow">
			<div class="sex">
				<label>
					<span class="radio">
						<input type="radio" value="Nam" name="sender_sex" checked="">
						<span class="icon"></span>
					</span> Nam
				</label>
				<label>
					<span class="radio">
						<input type="radio" name="sender_sex" value="Nữ">
						<span class="icon"></span>
					</span> Nữ
				</label>
			</div>

			<div class="box-input">
				<?php if(!empty($addess_books) AND isset($_COOKIE['user_id'])){ ?>
					<div id='addess_books'>
						
						<select name="addess_books" id="change_addess_books" >
							<option value="">Chọn sổ địa chỉ</option>
							<?php foreach ($addess_books as $addbook): ?>
								<option <?php echo $addbook->is_default == 1 ? 'selected' : '' ?> value="<?php echo $addbook->id ?>"><?php echo $addbook->full_name ?></option>
							<?php endforeach ?>
						</select>
					</div>
					<div class="clear"></div>
				<?php } ?>
				<input  placeholder="Họ tên (*)" type="text" name="sender_name" id="name_user" value="<?php echo !empty($data_user) ? $data_user->full_name : '' ?>" class="input_text input_text_50" size="30">
				<input placeholder="Điện thoại (*)" type="text" name="sender_telephone" id="telephone_user" value="<?php echo !empty($data_user) ? $data_user->telephone : '' ?>" class="input_text input_text_50" size="30">
				<input placeholder="Email" type="text" name="sender_email" id="sender_email" value="<?php echo !empty($data_user) ? $data_user->email : '' ?>" class="input_text" size="30">

<!-- 				<select name="city_id" id="city_id" class="input_text input_text_33">
					<option value="">Chọn Tỉnh Thành</option>
					<?php foreach ($cities as $city): ?>
						<?php if(!empty($data_user)){ ?>
							<option warehouse="<?php echo $city->warehouse_id ?>" latitude_warehouse="<?php echo $city->latitude_warehouse ?>" longitude_warehouse="<?php echo $city->longitude_warehouse ?>" latitude="<?php echo $city->latitude ?>" longitude="<?php echo $city->longitude ?>" <?php echo $city->id == $data_user-> city_id ? 'selected' : ''?> value="<?php echo $city->id ?>"><?php echo $city->name ?></option>
						<?php }else{ ?>
							<option warehouse="<?php echo $city->warehouse_id ?>" latitude_warehouse="<?php echo $city->latitude_warehouse ?>" longitude_warehouse="<?php echo $city->longitude_warehouse ?>" latitude="<?php echo $city->latitude ?>" longitude="<?php echo $city->longitude ?>" value="<?php echo $city->id ?>"><?php echo $city->name ?></option>
						<?php } ?>
					<?php endforeach ?>
				</select> -->

<!-- 				<select name="district_id" id="district_id" class="input_text input_text_33">
					<option value="">Chọn Quận huyện</option>
					<?php 
					if(!empty($district_user)){
						foreach ($district_user as $district_user_it){ 
					?>
						<option <?php echo $district_user_it->id == $data_user-> district_id ? 'selected' : ''?> value="<?php echo $district_user_it->id ?>"><?php echo $district_user_it->name ?></option>
					<?php 
						} 
					}
					?>
				</select> -->

<!-- 				<select name="ward_id" id="ward_id" class="input_text input_text_33">
					<option value="">Chọn Xã phường</option>
					<?php 
					if(!empty($ward_user)){
						foreach ($ward_user as $ward_user_it){ 
					?>
						<option class="<?php echo $ward_user_it->id == $data_user-> ward_id ? 'selected_ward_user' : ''?>" latitude="<?php echo $ward_user_it->latitude ?>" longitude="<?php echo $ward_user_it->longitude ?>" <?php echo $ward_user_it->id == $data_user-> ward_id ? 'selected' : ''?> value="<?php echo $ward_user_it->id ?>">
							<?php echo $ward_user_it->name ?>
						</option>
					
					<?php 
						} 
					}
					?>
				</select> -->

				
			
				<input placeholder="Địa chỉ ( Nhập số nhà, ngõ...)" type="text" name="sender_address" id="address_user" value="<?php echo !empty($data_user) ? $data_user->address : '' ?>" class="input_text" size="30">

				<?php if($ship_HL == 1){ ?>

				<input type="hidden" id="from_places" placeholder="Địa chỉ kho hàng" type="text" id="from_places" value="Khu Công nghiệp Phú Minh, Phường Cổ Nhuế 2, Quận Bắc Từ Liêm, TP. Hà Nội" class="input_text" size="30">
                <input id="origin" name="origin" type="hidden" value="Cổ Nhuế 2, Từ Liêm, Hà Nội, Việt Nam" />

				<!-- <input id="to_places" placeholder="Nhập và chọn vị trí Google Map gần địa chỉ đã chọn bên trên " type="text" value="<?php //echo isset($_SESSION['destination']) ? $_SESSION['destination'] : '' ?>" class="input_text" size="30"> -->
				<input name="sender_address_googlemap" id="destination" name="destination" type="hidden" value="<?php echo isset($_SESSION['destination']) ? $_SESSION['destination'] : '' ?>" />
				<div class="txt_to_places" id="result"></div>
				<input id="in_kilo" type="hidden" value="" />
				<input id="travel_mode" type="hidden" value="WALKING" />
				<!-- <button type="button" id="distance_form" width="50px" height="50px">Tính phí vận chuyển</button> -->
				<div class="clear"></div>
				<div id="map" style="height: 0px; width: 0%;" ></div>
				<?php } ?>


				<textarea placeholder="Ghi chú" name="sender_comments" id="sender_comments" class="input_text"></textarea>
			</div>
		</div>
		
		<div class="title-box-cart">Phương thức thanh toán</div>
		<div class="payment-type shadow">
			
			<div class="mb-2 mt-3"><b class="fs-16">Chọn phương thức thanh toán</b></div>
			<label class="container-rd <?php echo !isset($_SESSION['pay_method']) || isset($_SESSION['pay_method']) && $_SESSION['pay_method'] == 0 ? 'active' : '' ?>" id="method-cod" data-pay-method = "0">
				<span class="radio">
					<input onclick="pay_mothod(0)" type="radio" checked="checked" name="radio" value="0">
					<span class="icon"></span>
				</span> Thanh toán tiền mặt khi nhận hàng (COD)
			</label>

			<label class="container-rd <?php echo isset($_SESSION['pay_method']) && $_SESSION['pay_method'] == 2 ? 'active' : '' ?>" data-pay-method = "2">
				<span class="radio">
					<input onclick="pay_mothod(2)" type="radio" name="radio"  value="2">
					<span class="icon"></span>
				</span> Thanh toán qua số tài khoản ngân hàng <?php echo $config['free_ship_pay_online'] == 1 ? '(Miễn phí vận chuyển)' : '' ?>
			</label>

			<!-- danh sách STK ngân hàng -->
			<?php if(!empty($list_bankings)){ ?>
				<div class="list_bankings cls">
					<?php foreach ($list_bankings as $banking){ ?>
						<div class="item">
							<div class="name">Tên: <?php echo $banking->name ?> </div>
							<div class="branch">Chi nhánh: <?php echo $banking->branch ?></div>
							<div class="account">Số tài khoản: <?php echo $banking->account ?></div>
							<div class="account_name">Chủ tài khoản: <?php echo $banking->account_name ?></div>
						</div>
					<?php } ?>
				</div>
			<?php } ?>
			<!-- end danh sách STK ngân hàng -->

			<?php if(1==2){ ?>
			<input type="hidden" name="config_total_vnpay" id="config_total_vnpay" value="<?php echo $config['total_vnpay']; ?>">
			
			<?php 
				if(isset($total) && $total > $config['total_vnpay']){
					$class_vnpay = 'display-off';
				}else{
					$class_vnpay = '';
				}
			?>
			<label class="container-rd  <?php echo $class_vnpay ?> <?php echo isset($_SESSION['pay_method']) && $_SESSION['pay_method'] == 1 ? 'active' : '' ?>" id="ajax-method-vnpay" data-pay-method = "1">
				<span class="radio">
					<input onclick="pay_mothod(1)" type="radio" name="radio"  value="1">
					<span class="icon"></span>
				</span> Thanh toán bằng VNPAY (Giảm 50% phí vận chuyển)
			</label>
			<?php } ?>
			
			
		</div>

		<!-- end payment-type -->

		<?php if(1==2){ ?>
		<div id="tax-invoice">
			<label class="js-select-tax-invoice">
				<span class="checkbox"><input type="checkbox" id="invoice-ip" name="is_tax" value="1"><span class="icon"></span></span>
				Yêu cầu xuất hóa đơn GTGT cho đơn hàng này
			</label>

			<div id="tax-form" class="mt-2">
				<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tbody>
						<tr>
							<td width="120" align="left">Tên công ty*:</td>
							<td align="left">
								<input type="text" id="txtTaxName" class="input_text" name="tax_company">
							</td>
						</tr>
						<tr>
							<td width="120" align="left">Địa chỉ*:</td>
							<td align="left">
								<input type="text" id="txtTaxAddress" class="input_text" name="tax_address">
							</td>
						</tr>
						<tr>
							<td width="120" align="left">Email*:</td>
							<td align="left">
								<input type="text" id="txtTaxEmail" class="input_text" name="tax_email">
							</td>
						</tr>
						<tr>
							<td width="120" align="left">Mã số thuế*:</td>
							<td align="left">
								<input type="text" id="txtTaxCode" class="input_text" name="tax_code">
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<!-- end tax-form -->
		<?php } ?>

		<div class="all-button-cart cls">

			<a class="back-home" href="<?php echo URL_ROOT ?>">
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
				<g>
					<g>
						<path d="M492,236H68.442l70.164-69.824c7.829-7.792,7.859-20.455,0.067-28.284c-7.792-7.83-20.456-7.859-28.285-0.068    l-104.504,104c-0.007,0.006-0.012,0.013-0.018,0.019c-7.809,7.792-7.834,20.496-0.002,28.314c0.007,0.006,0.012,0.013,0.018,0.019    l104.504,104c7.828,7.79,20.492,7.763,28.285-0.068c7.792-7.829,7.762-20.492-0.067-28.284L68.442,276H492    c11.046,0,20-8.954,20-20C512,244.954,503.046,236,492,236z"/>
					</g>
				</g>
				</svg>
				<span><?php echo FSText::_('Quay lại mua thêm sản phẩm khác'); ?></span>	
			</a>
			<a class="button-submit" href="javascript:void(0);" onclick="javascript:submitForm();" title=""> <?php echo FSText::_('Thanh toán'); ?> </a>
		</div>

	
		<input type="hidden" name='module' value="products" />
		<input type="hidden" name='view' value="cart" />
		
		<!-- <input type="hidden" name="price_send" id="price_send" value=" '.$check_code-> money_dow.'"> -->
		<input type="hidden" name='price_send_h' id="price_send_h" value="0" />
		<input type="hidden" name='code_card_send_h' id="code_card_send_h" value="0" />
		<input type="hidden" name='type_down_h' id="type_down_h" value="0" />
		<input type="hidden" name='task' value="" id = 'task_buyer_form' />
		<input type="hidden" name='is_vnpay' value="<?php echo isset($_SESSION['pay_method']) ? $_SESSION['pay_method'] : 0 ?>" id = 'is_vnpay' />
		<input type="hidden" name='bank_code' value="0" id = 'bank_code_ip' />
		<input type="hidden" name='code_sale' value="" id="code-sale" />
		
	</form>
</div>





<script>
    

</script>

