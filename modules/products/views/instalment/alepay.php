
<div class="alepay cls installment_type" id="alepay_wrapper" style="display: none">	
	<div class="type_head">
		<img id="product-icon" src="/modules/products/assets/images/alego-logo.png"  alt="Trả góp">
		<div class="clearfix"></div>
		<br />
	</div>
	<div class="table_body_c">
		<div id="alert"></div>

		<?php include 'alepay_modal.php'; ?>		



		<div class="ale_content">
			<label class="mt20">Giá trị đơn hàng</label>
			<div class=" select-box mt10">
				<input type="text" name="ale_payment_total" id="ale_payment_total" class="text" value="<?php if(@$price_default) {echo format_money($price_default) ; 
							} else {echo format_money($price_by_region) ; }?>" readonly="readonly" /> 			
			</div>

		</div>
		<div class="ale_content">
			<label class="mt20">Số tiền trả trước</label>
			<div class=" select-box mt10">
				<input type="text" name="ale_payment_before" id="ale_payment_before" class="text" value="0" />			
			</div>			
		</div>
		<div class="ale_content">
			<label class="mt20">Số tiền trả góp</label>
			<div class=" select-box mt10">
				<input type="text" name="ale_payment_after" id="ale_payment_after" class="text" value="<?php if(@$price_default) {echo format_money($price_default) ; 
							} else {echo format_money($price_by_region) ; }?>" readonly="readonly" />			
			</div>			
		</div>
		<div class="ale_content">
			<label class="mt20">Ghi chú</label>
			<div class=" select-box mt10">

				<textarea name="ale_sender_comments" class="input_text" placeholder="Ghi chú"></textarea>
			</div>			
		</div>	
	</div>

	<div class="table_body_r">
		<?php include 'alepay_right.php' ?>	
	</div>
	<div class="btn_area">
		<button type="button" onclick="javascript: ale_payment()" >Thanh toán trả góp</button>


	</div>

</div>