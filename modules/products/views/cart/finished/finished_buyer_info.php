<div class="products-cart-info">
	<h3 class="title"><?php echo FSText::_('Thông tin đặt hàng'); ?></h3>
	<div class='shopping_buyer_saller'>
		<table class="info-customer-gh" width="100%">
			<div class="form-item form-item-customer">
				<!-- <h4 class="title-steps">I.Thông tin khách hàng</h4> -->
				<div class="tabl-info-customer">
					<div class="customer-item cls">
						<div class='lable'><span><?php echo FSText::_('Họ tên:'); ?></span></div>
						<div class='value'><?php echo $order-> sender_name; ?></div>
						<div class="clear"></div>
					</div>
						<!-- <div class="customer-item">
							<div class='lable'><span>Gi&#7899;i t&#237;nh</span></div>
							<div class='value'><?php echo ($order->sender_sex == 'female')? "N&#7919;":"Nam"; ?></div>
							<div class="clear"></div>
						</div> -->
						<div class="customer-item cls">
							<div class='lable'><span><?php echo FSText::_('Địa chỉ:'); ?></span></div>
							<div class='value'><?php echo $order-> sender_address.', '. $order-> ward_name.', '.$order-> district_name.', '.$order-> city_name  ?></div>
							<div class="clear"></div>
						</div>
						<!-- <div class="customer-item cls">
							<div class='lable'><span><?php //echo FSText::_('Tỉnh/ Thành phố'); ?></span></div>
							<div class='value'><?php //echo @$order-> city_name; ?></div>
							<div class="clear"></div>
						</div> -->
						
						<div class="customer-item cls">
							<div class='lable'><span>Email</span></div>
							<div class='value'><?php echo $order-> sender_email; ?></div>
							<div class="clear"></div>
						</div>
						<div class="customer-item cls">
							<div class='lable'><span><?php echo FSText::_('Điện thoại:'); ?></span></div>
							<div class='value'><?php echo $order-> sender_telephone; ?></div>
							<div class="clear"></div>
						</div>

						<div class="customer-item cls">
							<div class='lable'><span><?php echo FSText::_('Ghi chú:'); ?></span></div>
							<div class='value'><?php echo @$order-> sender_comments; ?></div>
							<div class="clear"></div>
						</div>

						<div class="customer-item cls">
							<div class='lable'><span><?php echo FSText::_('Lưu ý:'); ?></span></div>
							<div class='value'>Nếu thông tin đơn hàng bị sai vui lòng liên hệ <?php echo $config['hotline'] ?> để được thay đổi.</div>
							<div class="clear"></div>
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="form-item form-item-pay">
					<h4 class="title-steps">II.Hình thức thanh toán</h4>
					<div class="item-pay">
						<?php $arr_payment = array(1=>'Trả bằng tiền mặt khi nhận hàng',2=>'Trả bằng thẻ ATM, Visa, Master khi nhận hàng',3=>'Thanh toán trực tuyến (ATM, Visa, Master)'); ?>
						<?php echo @$arr_payment[@$order -> payment_method]; ?>
					</div>
				</div>
				
				<div class="form-item form-item-order">
					<h4 class="title-steps">II.Hình thức nhận</h4>
					<div class="item-pay">
						<?php $arr_received = array(1=>'Tại nhà',2=>'Tại cửa hàng'); ?>
						<?php echo @$arr_received[@$order -> received_method]; ?>
					</div>
				</div>
			</table>
		</div>
		<div class="clear"></div>
	</div>