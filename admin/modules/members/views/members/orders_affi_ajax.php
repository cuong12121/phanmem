		<?php 
	//	CONFIG	

		$fitler_config  = array();

		$list_config = array();
		$list_config[] = array('title'=>'Mã đơn hàng','field'=>'id','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=> 'view_code_order'));
		$list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
		$list_config[] = array('title'=>'Thành tiền','field'=>'total_after_discount','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=> 'view_total_after_discount'));
		$list_config[] = array('title'=>'Trạng thái','field'=>'status','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=> 'view_status'));
		$list_config[] = array('title'=>'Xem chi tiết','field'=>'id','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=> 'view_views'));
		$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');

		TemplateHelper::genarate_form_liting2($this, $this->module,$this -> view,$orders_affi,$fitler_config,$list_config,@$sort_field,@$sort_direct,@$pagination);

	 // print_r($orders);die;
		?>
		<?php if(!empty($orders_affi)) { ?>
			<?php if(!empty($price_affi)){ ?>
				<div class="total-price">
					<span>Đã thanh toán <span class="red"><?php echo format_money($price_affi-> value); ?></span> cho Affiliate!</span>
				</div>
				<div class="total-price total-price-affi">
					<span>Sửa:</span> <input type="number" min="0" value="<?php echo $price_affi-> value;  ?>" id="price_affi">đ
					<a href="javascript:void(0)" onclick="submit_price_affi()">
						Xác nhận lại
					</a>
				</div>
			<?php } else {?>
				<div class="total-price">
					<span>Chưa thanh toán cho Affiliate!</span>
				</div>
				<div class="total-price total-price-affi">
					<span>Thanh toán:</span> <input type="number" min="0" id="price_affi">đ
					<a href="javascript:void(0)" onclick="submit_price_affi()">
						Xác nhận
					</a>
				</div>
			<?php } ?>
		<?php } ?>

		<style>
		.total-price-affi span {
			display: inline-block;
		}
		.total-price-affi input {
			display: inline-block;
			width: 150px;
			padding-right: 0;
			margin-right: 5px;
		}
	</style>




