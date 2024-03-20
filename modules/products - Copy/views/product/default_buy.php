	<?php 	global $config;?>
	<div class="frame_buy mt20">
		<a  id="buy-now"  href="#modal_buy_now" class="btn-buy btn btn-lg btn-primary mt10" data-toggle="modal">
			Đặt hàng ngay<br/>
			<span>(Tư vấn miễn phí, không mua không sao)</span>
		</a>
		<a  id="order"  href="javascript:void(0);"  onclick="javascript: buy_add(<?php echo $data ->id; ?>)" class="btn-buy btn btn-lg btn-primary mt10" data-toggle="modal">
			Thêm vào giỏ hàng<br/>
			<span>(Sản phẩm sẽ được thêm vào giỏ hàng của bạn)</span>
		</a>
		<a  id="buy-now"  href="javascript: instalment('<?php echo FSRoute::_('index.php?module=products&view=instalment'); ?>')" class="btn-buy btn btn-lg btn-primary mt10" data-toggle="modal">
			Trả góp<br/>
			<span>(Tính hàng trả góp)</span>
		</a>
	</div>
	
	<!-- Modal HTML -->
	<div id="modal_buy_now" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><span>Đặt hàng ngay - thông tin đặt hàng</span></h4>
				</div>
				<div class="modal-body">
					<form action="" name="eshopcart_info" method="post" id="eshopcart_info" >
						<div class="row">
							<div class=" col-modal-l col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<div class="media-box">
									<span class="media-img pull-left" >
										<img class="img-responsive " src="<?php echo URL_ROOT.str_replace('/original/','/resized/', $data -> image); ?>" alt="<?php echo $data->name;?>">
									</span>
									<div class="media-body">
										<h2><span><?php echo $data->name;?></span></h2>

										<?php if(count($price_by_memory)){?>
											<div class="select-box2 mt10">
												<select id='memory-modal' name="memory_modal"  onchange="load_quick(this.value,'memory')" >
													<option value="0" >Bộ nhớ sản phẩm</option>
													<?php 	foreach ($price_by_memory as $item){	?>
														<option value="<?php echo ($item->price)?$item->price:0; ?>_<?php echo $item->id ?>_<?php echo $item->memory_id ?>"><?php echo $item->memory_name?></option>
													<?php 	 }	?>
												</select>
											</div>		
										<?php }?>
										<?php if(count($price_by_usage_states)){?>
											<div class="select-box2 mt10">
												<select id='usage_states-modal' name="usage_states_modal"  onchange="load_quick(this.value,'usage_states')" >
													<option value="0" >Bộ nhớ sản phẩm</option>
													<?php 	foreach ($price_by_usage_states as $item){	?>
														<option value="<?php echo ($item->price)?$item->price:0; ?>_<?php echo $item->id ?>_<?php echo $item->usage_states_id ?>"><?php echo $item->usage_states_name?></option>
													<?php 	 }	?>
												</select>
											</div>		
										<?php }?>

										<?php if(count($price_by_color)){?>
											<div class="select-box2 mt10">
												<select  id="color-modal" name="color_modal" onchange="load_quick(this.value,'color')" >
													<option value="0">Chọn màu khác </option>
													<?php foreach ($price_by_color as $item){?>
														<option value="<?php echo ($item->price)?$item->price:0;?>_<?php echo $item->id ?>_<?php echo $item->color_id ?>"><?php echo $item->color_name;?></option>
													<?php }?>
												</select>
											</div>
										<?php }?>

										<?php if(count($price_by_extend_group)){
											foreach ($price_by_extend_group as $price_extend_group) { ?>
												<select  class="box_extend box_extend_<?php echo $price_extend_group-> group_extend_id ?>" id = "box_extend_<?php echo $price_extend_group-> group_extend_id ?>">
													<option value="0" data-price="0" data-type="extend_<?php echo $price_extend_group-> group_extend_id ?>"><?php echo $price_extend_group-> ground_extend_name?></option>
													<?php foreach ($price_by_extend[$price_extend_group -> group_extend_id]   as $item){?>
														<option value="<?php echo $item->id ?>" class= "price_extend_id_<?php echo $item->id  ?>" data-price="<?php echo ($item -> price)?$item -> price:0;?>" data-type="extend_<?php echo $price_extend_group-> group_extend_id ?>"><?php echo $item -> extend_name;?></option>
													<?php }	?>
												</select>
											<?php } }
											?>
										<!-- <div class="select-box2 mt10">
											<select name="region" id="region" >
												<option value="0">Chọn khu vực </option>
												<option value="sl_hn">Hà Nội</option>
										   		<option value="sl_hcm">Tp.Hồ Chí Minh</option>
										   		<option value="sl_dn">Đà Nẵng</option>
											</select>
										</div> -->
										<div class="select-box2 mt10">
											<?php $price_warranty = $config['price_warranty'];?>
											<select id="warranty-modal" name="warranty_modal"   onchange="load_quick(this.value,'warranty')">
												<option value="0_0" >Bảo hành mặc định</option>
												<?php if($price  < $price_warranty ){?>
													<option value="200000_3" >Bảo hành vàng</option>
												<?php }else{?>
													<option value="300000_3" >Bảo hành vàng</option>
												<?php }?>
											</select>
										</div>
										<div>
											<strong>Số lượng</strong>
											<input class="quantity_modal" type="text" name="quantity" value="1" id="quantity_modal">
										</div>
										<h3 class='price_modal'>
											<?php echo format_money($price,'đ'); ?>
										</h3>
									</div>
									<div class="clear"></div>
								</div>
								<div class="check-square mt10">Nhận giao hàng trong <strong>60 phút</strong> tại <strong>TP.Hà Nội</strong> <?php $data ->warranty  ?></div>
								<div class="check-square mt10">Giao hàng <strong>tận nơi</strong>, hài lòng thanh toán</div>
								<div class="check-square mt10">Bảo hành <strong><?php $data ->warranty  ?></strong></div>
								<div class="mt10">Mọi thắc mắc xin vui lòng liên hệ theo số máy <strong style="color: #E31010;"> <?php echo $config['hotline']?></strong> để biết thêm chi tiết.</div>
							</div>
							<div class=" col-modal-r col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<table width="100%" border="0" cellpadding="5">
									<tr>
										<td >
											<div class="body-td">
												<span> Họ và tên<font color="#FF0000"> (*)</font>: </span>
												<input type="text" name="sender_name" id="sender_name"  value="<?php echo $sender_name; ?>" class="input_text" />
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="body-td">
												<span>Điện thoại <font color="#FF0000"> (*)</font></span>
												<input type="text" name="sender_telephone" id="sender_telephone"  value="<?php echo $sender_telephone; ?>" class="input_text" />
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="body-td">
												<span>&#272;&#7883;a ch&#7881;<font color="#FF0000"> (*)</font>:</span>
												<input type="text" name="sender_address" id="sender_address"  value="<?php echo $sender_address; ?>" class="input_text" />
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="body-td">
												<span> Email<font color="#FF0000"> (*)</font>: </span>
												<input type="text" name="sender_email"  id="sender_email"  value="<?php echo $sender_email; ?>" class="input_text" />
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="body-td">
												<span>Thời gian nhận hàng  <font color="#FF0000"> (*)</font></span>
												<input type="text" name="received_time"  id="received_time"  value="" class="input_text"/>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<font color="#FF0000"> Lưu ý: (*) Thông tin bắt buộc phải điền</font>
										</td>
									</tr>
									<tr>
										<tr>
											<td>
												<a class="btn btn-default" href="javascript: void(0)" id='submitbt'>
													<span><?php echo FSText::_('Đặt hàng'); ?></span>
												</a>
												<a class="btn reset-default" href="javascript: void(0)" id='resetbt'>
													<span><?php echo FSText::_('Nhập lại'); ?></span>
												</a>
											</td>
										</tr>
									</table>
									<input type="hidden" name='id' value="<?php echo $data->id;?>" />
									<input type="hidden" name='price' value="<?php echo $price;?>" />
									<input type="hidden" name='price_old' value="<?php echo $data->price_old;?>" />
									<input type="hidden" name='module' value="products" />
									<input type="hidden" name='view' value="cart" />
									<input type="hidden" name='task' value="eshopcart2_save" id = 'task'/>
								</div>
							</div>
							
						</form>
					</div>
				</div>
			</div>
		</div> 