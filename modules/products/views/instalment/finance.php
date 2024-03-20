
<div class="finance cls installment_type" id="finance_wrapper">
		<div class="type_head">
			<img id="product-icon" src="/modules/products/assets/images/hdsaison_logo.png"  alt="Trả góp">
						<div class="clearfix"></div>
						<br />
		</div>
		<div class="table_body_c">
			
			<div class="content1">
				<label class="mt20">Chọn số tiền trả góp</label>
				<div class=" select-box mt10">
					<select id="slpercent" onchange="CalculateInstallmentByMonth()" name="instalment_percent_before">
						<option value="20">Trả trước 20%</option>
						<option value="30" selected>Trả trước 30%</option>
						<option value="40">Trả trước 40%</option>
						<option value="50">Trả trước 50%</option>
						<option value="60">Trả trước 60%</option>
						<option value="70">Trả trước 70%</option>
					</select>
				</div>
				<div class="select-box">
					<select id="slmonth" onchange="CalculateInstallmentByMonth()" name="instalment_months">
						<option value="6">Thời gian vay 6 tháng</option>
						<option value="8">Thời gian vay 8 tháng</option>
						<option value="9" selected>Thời gian vay 9 tháng</option>
						<option value="10">Thời gian vay 10 tháng</option>
						<option value="12">Thời gian vay 12 tháng</option>
					</select>
				</div>	
			</div>

			<div class="table_result">
				<div id="result">
				</div>
				<div class="td-note">
						<span>Số tiền chênh lệch so với thực tế từ 10.000 - 100.000 đ/tháng,bạn vui lòng ghé cửa hàng để được tư vấn chính xác</span>
						</div>
				</div>

		</div>

		<div class="table_body_r">
			<?php include 'finance_right.php' ?>	

		</div>
 		<div class="btn_area">
          <button type="submit">Đặt mua trả góp</button>                    
        </div>
	
		

	
</div>