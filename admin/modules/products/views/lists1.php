<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bảng sản phẩm</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .table-container {
            max-height: 400px; /* Giới hạn chiều cao bảng */
            overflow-y: auto; /* Cho phép cuộn dọc */
            border: 1px solid #ddd;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            position: relative;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
            position: sticky;
            top: 0; /* Giữ tiêu đề ở trên cùng */
            z-index: 10;
        }
        img {
            max-width: 50px;
            height: auto;
        }
    </style>
</head>
<body>

    
<div class="filter_area">
    <div class="row">
        <input type="hidden" name="text_count" value="0">           
        <div class="fl-left pd-15"> 
            <input type="text" placeholder="Tìm kiếm" name="keysearch" id="search" value="" class="form-control fl-left">
            <span class="input-group-btn fl-left" style="margin-left: -2px;">
            <button onclick="this.form.submit();" class="btn btn-search btn-default" type="button">
            <i class="fa fa-search"></i>
            </button>
            </span>
        </div>
        <div class="fl-left">               <button class="btn btn-outline btn-primary" onclick="this.form.submit();">Tìm kiếm</button>             <button class="btn btn-outline btn-primary" onclick="document.getElementById('search').value='';                this.form.getElementById('filter_state').value='';this.form.submit();">Reset</button>           </div>
        <input type="hidden" name="filter_count" value="2">         
        <div class="fl-left pd-15">
            <select name="filter0" class="form-control " onchange="this.form.submit()">
                <option value="0"> -- Danh mục -- </option>
                <option value="1">Dự Án Hải Sản</option>
                <option value="2">Đồ chơi</option>
                <option value="3">Sản phẩm TLC</option>
                <option value="5">Đèn &amp; Trang trí</option>
                <option value="6">Các mã xả tồn sẽ dừng bán</option>
                <option value="7">Điện thoại &amp; Máy tính bảng</option>
                <option value="8">Bếp &amp; Phòng ăn</option>
                <option value="9">Bách hóa Online</option>
                <option value="10">Sức khỏe</option>
                <option value="11">Giường ngủ &amp; Nhà tắm</option>
                <option value="12">Âm thanh</option>
                <option value="13">Văn phòng phẩm và nghề thủ công</option>
                <option value="14">Thiết bị thông minh</option>
                <option value="15">Đồ gia dụng</option>
                <option value="16">Giày dép &amp; Quần áo nam</option>
                <option value="17">Ôtô, Xe máy &amp; Thiết bị định vị</option>
                <option value="18">Áo điều hòa- Dũng Hoan</option>
                <option value="19">Thể thao &amp; Hoạt động ngoài trời</option>
                <option value="20">Sách NTBook</option>
                <option value="21">Máy ảnh &amp;&nbsp;Máy bay camera</option>
                <option value="22">Trẻ sơ sinh &amp; Trẻ nhỏ</option>
                <option value="23">Dụng cụ sửa chữa nhà cửa</option>
                <option value="24">Túi xách và Vali túi du lịch</option>
                <option value="25">Đồng hồ, Mắt kính, Trang sức</option>
                <option value="26">Các mã dừng bán hẳn</option>
                <option value="27">Làm đẹp</option>
                <option value="28">Màn hình &amp; Máy in</option>
                <option value="29">Giày dép &amp; Quần áo nữ</option>
                <option value="30">Nội thất &amp; Sắp xếp</option>
                <option value="31">Máy vi tính &amp; Laptop</option>
                <option value="32">Chăm sóc nhà cửa</option>
                <option value="33">Chăm sóc thú cưng</option>
                <option value="34">Ngoài trời &amp; sân vườn</option>
                <option value="35">TV &amp; Video</option>
                <option value="36">Sản phẩm Seka</option>
                <option value="37">DAKYANG</option>
            </select>
        </div>
        <div class="fl-left pd-15">
            <select name="filter1" class="form-control " onchange="this.form.submit()">
                <option value="0"> -- Kho -- </option>
                <option value="1">Kho Hà Nội</option>
                <option value="2">Kho Hồ Chí Minh</option>
                <option value="3">Kho test</option>
                <option value="4">Kho hàng Cao Duy Hoan</option>
                <option value="5">Tầng 1</option>
                <option value="6">Kho Văn La</option>
                <option value="7">Kho Văn Phú</option>
            </select>
        </div>
    </div>
</div>
<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Ảnh</th>
                <th>Mã vạch</th>
                <th>Mã</th>
                <th>Tên</th>
                <th>Giá bán</th>
                <th>Giá bán đóng gói</th>
                <th>Giá bán thấp nhất</th>
                <th>Hàng chuyển kho</th>
                <th>Hàng đã xuất</th>
                <th>Tồn</th>
                <th>Tổng tồn</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><img src="product.jpg" alt="Ảnh SP"></td>
                <td>8934567890123</td>
                <td>SP001</td>
                <td>Sản phẩm A</td>
                <td>100,000₫</td>
                <td>95,000₫</td>
                <td>90,000₫</td>
                <td>50</td>
                <td>30</td>
                <td>200</td>
                <td>250</td>
            </tr>
            <tr>
                <td><img src="product2.jpg" alt="Ảnh SP"></td>
                <td>8934567890456</td>
                <td>SP002</td>
                <td>Sản phẩm B</td>
                <td>150,000₫</td>
                <td>140,000₫</td>
                <td>130,000₫</td>
                <td>30</td>
                <td>20</td>
                <td>150</td>
                <td>180</td>
            </tr>
            <tr>
                <td><img src="product3.jpg" alt="Ảnh SP"></td>
                <td>8934567890789</td>
                <td>SP003</td>
                <td>Sản phẩm C</td>
                <td>200,000₫</td>
                <td>190,000₫</td>
                <td>180,000₫</td>
                <td>40</td>
                <td>15</td>
                <td>120</td>
                <td>160</td>
            </tr>
            <tr>
                <td><img src="product3.jpg" alt="Ảnh SP"></td>
                <td>8934567890789</td>
                <td>SP003</td>
                <td>Sản phẩm C</td>
                <td>200,000₫</td>
                <td>190,000₫</td>
                <td>180,000₫</td>
                <td>40</td>
                <td>15</td>
                <td>120</td>
                <td>160</td>
            </tr>

             <tr>
                <td><img src="product3.jpg" alt="Ảnh SP"></td>
                <td>8934567890789</td>
                <td>SP003</td>
                <td>Sản phẩm C</td>
                <td>200,000₫</td>
                <td>190,000₫</td>
                <td>180,000₫</td>
                <td>40</td>
                <td>15</td>
                <td>120</td>
                <td>160</td>
            </tr>
            <tr>
                <td><img src="product3.jpg" alt="Ảnh SP"></td>
                <td>8934567890789</td>
                <td>SP003</td>
                <td>Sản phẩm C</td>
                <td>200,000₫</td>
                <td>190,000₫</td>
                <td>180,000₫</td>
                <td>40</td>
                <td>15</td>
                <td>120</td>
                <td>160</td>
            </tr>
             <tr>
                <td><img src="product3.jpg" alt="Ảnh SP"></td>
                <td>8934567890789</td>
                <td>SP003</td>
                <td>Sản phẩm C</td>
                <td>200,000₫</td>
                <td>190,000₫</td>
                <td>180,000₫</td>
                <td>40</td>
                <td>15</td>
                <td>120</td>
                <td>160</td>
            </tr>
            <tr>
                <td><img src="product3.jpg" alt="Ảnh SP"></td>
                <td>8934567890789</td>
                <td>SP003</td>
                <td>Sản phẩm C</td>
                <td>200,000₫</td>
                <td>190,000₫</td>
                <td>180,000₫</td>
                <td>40</td>
                <td>15</td>
                <td>120</td>
                <td>160</td>
            </tr>
             <tr>
                <td><img src="product3.jpg" alt="Ảnh SP"></td>
                <td>8934567890789</td>
                <td>SP003</td>
                <td>Sản phẩm C</td>
                <td>200,000₫</td>
                <td>190,000₫</td>
                <td>180,000₫</td>
                <td>40</td>
                <td>15</td>
                <td>120</td>
                <td>160</td>
            </tr>
            <tr>
                <td><img src="product3.jpg" alt="Ảnh SP"></td>
                <td>8934567890789</td>
                <td>SP003</td>
                <td>Sản phẩm C</td>
                <td>200,000₫</td>
                <td>190,000₫</td>
                <td>180,000₫</td>
                <td>40</td>
                <td>15</td>
                <td>120</td>
                <td>160</td>
            </tr>
             <tr>
                <td><img src="product3.jpg" alt="Ảnh SP"></td>
                <td>8934567890789</td>
                <td>SP003</td>
                <td>Sản phẩm C</td>
                <td>200,000₫</td>
                <td>190,000₫</td>
                <td>180,000₫</td>
                <td>40</td>
                <td>15</td>
                <td>120</td>
                <td>160</td>
            </tr>
            <tr>
                <td><img src="product3.jpg" alt="Ảnh SP"></td>
                <td>8934567890789</td>
                <td>SP003</td>
                <td>Sản phẩm C</td>
                <td>200,000₫</td>
                <td>190,000₫</td>
                <td>180,000₫</td>
                <td>40</td>
                <td>15</td>
                <td>120</td>
                <td>160</td>
            </tr>
             <tr>
                <td><img src="product3.jpg" alt="Ảnh SP"></td>
                <td>8934567890789</td>
                <td>SP003</td>
                <td>Sản phẩm C</td>
                <td>200,000₫</td>
                <td>190,000₫</td>
                <td>180,000₫</td>
                <td>40</td>
                <td>15</td>
                <td>120</td>
                <td>160</td>
            </tr>
            <tr>
                <td><img src="product3.jpg" alt="Ảnh SP"></td>
                <td>8934567890789</td>
                <td>SP003</td>
                <td>Sản phẩm C</td>
                <td>200,000₫</td>
                <td>190,000₫</td>
                <td>180,000₫</td>
                <td>40</td>
                <td>15</td>
                <td>120</td>
                <td>160</td>
            </tr>

            <!-- Thêm nhiều dòng hơn nếu cần -->
        </tbody>
    </table>
</div>

</body>
</html>