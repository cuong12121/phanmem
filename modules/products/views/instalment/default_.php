<?php 
global $tmpl;
$tmpl -> addStylesheet("instalment","modules/products/assets/css");
$tmpl -> addStylesheet("jquery-ui","libraries/jquery/jquery.ui");
$tmpl -> addScript("jquery-ui","libraries/jquery/jquery.ui");
$tmpl -> addScript("instalment","modules/products/assets/js");
$id = FSInput::get('id');

?>
<div class="product_instalment">
	<table border="0" width="100%"  class="table-instalment-pack mt20" cellpadding="0">
		<thead>
			<tr> 
				<td colspan="2" align="center">
					<label id="mortgage">Không thế chấp tài khoản</label>
					<label id="prove">Không chứng minh toàn khoản</label>
					<label id="notarized">Không cần công chứng giấy tờ</label>
				</td>
			</tr>
		</thead>
		<tbody>
			<tr> 
				<td align="center" width="50%" valign="top">
					<div class="content">
						<label class="mt10">Sản phẩm trả góp</label>
						<div class="clearfix"></div>
						
						<div id="product-content">
							<img id="product-icon" src="<?php echo URL_ROOT.'images/tragop_sp.png'?>"  alt="">
						</div>
						<div class="clearfix"></div>
						<br/><br/>
						<input id="product_text"  placeholder="Nhập tên sản phẩm cần mua">
						<input type="hidden" id="product-id" value="<?php echo $id;?>">
						<input type="hidden" id="product-price" value="<?php echo $price;?>">
					</div>
				</td>
				<td align="center" width="50%" valign="top">
					<div class="content">
						<label class="mt20">Chọn số tiền trả góp</label>
						<div class=" select-box mt10">
							<select id="slpercent" onchange="CalculateInstallmentByMonth()" name="slpercent">
								<option value="20">Trả trước 20%</option>
								<option value="30" selected>Trả trước 30%</option>
								<option value="40">Trả trước 40%</option>
								<option value="50">Trả trước 50%</option>
								<option value="60">Trả trước 60%</option>
								<option value="70">Trả trước 70%</option>
							</select>
						</div>
						<div class="select-box">
							<select id="slmonth" onchange="CalculateInstallmentByMonth()" name="slmonth">
								<option value="6">Thời gian vay 6 tháng</option>
								<option value="8">Thời gian vay 8 tháng</option>
								<option value="9" selected>Thời gian vay 9 tháng</option>
								<option value="10">Thời gian vay 10 tháng</option>
								<option value="12">Thời gian vay 12 tháng</option>
							</select>
						</div>	
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center" id="result"></td>
			</tr>
		</tbody>
	</table>
	<table border="1" bordercolor="#ECEFF3" width="100%"  class="table-instalment-procedures mt20" cellpadding="4" cellspacing="10px">
		<thead >
			<tr bgcolor="#FAFAFA"> 
				<td colspan="2" align="center">
				<label>Thủ tục đăng ký hồ sơ</label>
				</td>
			</tr>
		</thead>
		<tbody>
			<tr> 
				<td align="left" width="30%">
					<div  class="content">
						<b>Mức giá tối thiểu sẽ hỗ trợ trả góp mua sản phẩm</b>
					</div>	
				</td>
				<td align="left">
					<div  class="content">
						Chỉ hỗ trợ trả góp những sản phẩm trên 3.000.000đ
					</div>	
				</td>
			</tr>
			<tr> 
				<td align="left">
					<div  class="content">
						<b>Độ tuổi</b>
					</div>	
				</td>
				<td align="left">
					<div  class="content">
						20 - 60
					</div>	
				</td>
			</tr>
			<tr> 
				<td align="left">
					<div  class="content">
						<b>Độ tuổi</b>
					</div>	
				</td>
				<td align="left">
					<div  class="content">
						CMND + Bằng lái (nếu số tiền vay &lt; 10 triệu)<br/>
						CMND + Hộ khẩu (nếu số tiền vay &gt; 10 triệu)
					</div>	
				</td>
			</tr>
			<tr> 
				<td align="left">
					<div  class="content">
						<b>Thời gian duyệt hồ sơ</b>
					</div>	
				</td>
				<td align="left">
					<div  class="content">
						15 - 30 phút
					</div>		
				</td>
			</tr>
			<tr> 
				<td align="left">
					<div  class="content">
						<b>Tỉ lệ duyệt hồ sơ thành công</b>
					</div>	
				</td>
				<td align="left">
					<div  class="content">
						80%
					</div>	
				</td>
			</tr>
			<tr> 
				<td align="left">
					<div  class="content">
						<b>Phương thức thanh toán </b>
					</div>	
				</td>
				<td align="left">
					<div  class="content">
						Miễn phí:<br />
						- Bưu điện<br />
						- Ngân hàng BIDV, Đông Á, Sacombank<br />
						Các ngân hàng khác: Có phí giao dịch ngân hàng<br />
						<b> Miễn phí 1 tháng cuối (không cần đóng cả vốn &amp; lãi)</b><br />
						Áp dụng cho thời gian góp 12 tháng<br />
					</div>	
				</td>
			</tr>
		</tbody>
	</table>
</div>
<input type='hidden' id='list_products' value='<?php echo json_encode($arr_products);?>'>