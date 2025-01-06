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

        body #page-wrapper .btn-outline a{
            color: #fff;
        }
    </style>
</head>
<body>

<form class="form-horizontal" action="https://dienmayai.com/admin/product" name="adminForm" method="get">    
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
            <div class="fl-left">               
                <button class="btn btn-outline btn-primary" type="submit">Tìm kiếm</button>             
                <button class="btn btn-outline btn-primary"><a href="https://dienmayai.com/admin/product?get_template=1">Reset</a>  </button>           
            </div>
             
            
        </div>
    </div>
</form>    
<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Ảnh</th>
                <th>Mã vạch</th>
                <th>Mã</th>
                <th>Tên</th>
                <th>Giá bán</th>
                <th>Giá nhập</th>
                <th>Giá bán đóng gói</th>
                <th>Giá bán thấp nhất</th>
                <!-- <th>Hàng chuyển kho</th> -->
                <th>Hàng đã xuất</th>
                <th>Tồn</th>
                <th>Tổng tồn</th>
            </tr>
        </thead>
        <tbody>
            <?php

                foreach($list as $value):
            ?>
            <tr>
                <td> <?php if(!empty($value->image)){ ?> <img src="/<?= $value->image  ?>" alt="Ảnh SP"> <?php } ?></td>
                <td><?= $value->id ?></td>
                <td><?= $value->code ?></td>
                <td><?= $value->name ?></td>
                <td><?= number_format((float)$value->price, 0, ',', '.')   ?></td>
                <td><?= number_format((float)$value->import_price, 0, ',', '.')   ?></td>
                <td><?= number_format((float)$value->price_pack, 0, ',', '.')   ?></td>
                <td><?= number_format((float)$value->price_min, 0, ',', '.')   ?></td>
                <td>0</td>
               
                <td><?= $value->amount ?></td>
                <td><?= $value->amount ?></td>
            </tr>
            
            <?php
                endforeach;
            ?>
            <!-- Thêm nhiều dòng hơn nếu cần -->
        </tbody>
    </table>

    
</div>

<nav aria-label="Page navigation">
    <div style="text-align: center; font-weight: bold; margin-top: 30px;"><font>Tổng</font> : <span style="color:red">[8044]</span> </div>
    <ul class="pagination">
        <li><a class="title_pagination">Trang</a></li>
        <?php
            if($page>1){
        ?>
        <li><a title="Page 2" href="https://dienmayai.com/admin/product?get_template=1&page=<?= intval($page)-1 ?>"><?= intval($page)-1 ?></a></li>
        <?php
            }
        ?>
        <li><a title="Page 2" href="https://dienmayai.com/admin/product?get_template=1&page=<?= intval($page) ?>"><?= intval($page) ?></a></li>
        
    
        <li><a aria-label="Next" title="Last page" href="https://dienmayai.com/admin/product?get_template=1&page=<?= intval($page)+1 ?>"><?= intval($page)+1 ?></a></li>
    </ul>
</nav>

</body>
</html>