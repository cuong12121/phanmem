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