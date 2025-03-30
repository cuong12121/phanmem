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
<div class="form_head">
    <div id="wrap-toolbar" class="wrap-toolbar">
        <div class="fl">
            <h1 class="page-header">Products</h1>
            <!--end: .page-header -->
            <!-- /.row -->    
        </div>
        <div class="fr">
            <a class="toolbar" onclick="javascript: submitbutton('export')" href="#">
                <span title="Xuất exel" style="background:url('https://dienmayai.com/admin/templates/default/images/toolbar/Excel-icon.png') no-repeat"></span>
                Xuất exel
            </a>
            <a class="toolbar" onclick="javascript: submitbutton('print_barcode_open')" href="#">
                <span title="In mã vạch" style="background:url('https://dienmayai.com/admin/templates/default/images/toolbar/print.png') no-repeat"></span>
                In mã vạch
            </a>
            <a class="toolbar" onclick="javascript: submitbutton('add')" href="#">
                <span title="Thêm mới" style="background:url('https://dienmayai.com/admin/templates/default/images/toolbar/add.png') no-repeat"></span>
                Thêm mới
            </a>
            <a class="toolbar" onclick="javascript: submitbutton('reset_amount_hold')" href="#">
                <span title="Reset tạm giữ" style="background:url('https://dienmayai.com/admin/templates/default/images/toolbar/remove.png') no-repeat"></span>
                Reset tạm giữ
            </a>
            <a class="toolbar" onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('Bạn phải chọn ít nhất một bản ghi');}else{ submitbutton('remove')} " href="#">
                <span title="Xóa" style="background:url('https://dienmayai.com/admin/templates/default/images/toolbar/remove.png') no-repeat"></span>
                Xóa
            </a>      
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
    <!--end: .wrap-toolbar-->
</div>


<form  action="https://<?= DOMAIN  ?>/admin/product/search-fast/check" name="adminForm" method="get">    
    <div class="filter_area">
        <div class="row">

            <div class="fl-left pd-15"> 
                <input type="text" placeholder="Tìm kiếm" name="search" id="search" value="" class="form-control fl-left">
                <span class="input-group-btn fl-left" style="margin-left: -2px;">
                <button type="submit" class="btn btn-search btn-default" type="button">
                <i class="fa fa-search"></i>
                </button>
                </span>
            </div>
            <div class="fl-left">               
                <button class="btn btn-outline btn-primary" type="submit">Tìm kiếm</button>             
                <button class="btn btn-outline btn-primary"><a href="https://<?= DOMAIN  ?>/admin/product?get_template=1">Reset</a>  </button>           
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
                
                <th>Hàng đã xuất</th>
                <th>Tồn</th>
                <th>Tổng tồn (Tổng tồn = Tồn - Hàng đã xuất)</th>
            </tr>
        </thead>
        <tbody>
            <?php
                
                foreach($list as $value):

                    $id_pd = $value->id;

                    
                    // echo($id_pd);

                    $query  = "SELECT amount FROM fs_status_packed WHERE 1=1 AND product_id = $id_pd AND status<2";
                    $product_sale = $db->getTotal($query);                     
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

                
                <td><?= $product_sale ?></td>

                <td><?= $value->amount  ?></td>
                <td><?= (int)$value->amount - (int)$product_sale ?></td>
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
        <li><a title="Page 2" href="https://dienmayai.com/admin/product?page=<?= intval($page)-1 ?>"><?= intval($page)-1 ?></a></li>
        <?php
            }
        ?>
        <li><a title="Page 2" href="https://dienmayai.com/admin/product?page=<?= intval($page) ?>"><?= intval($page) ?></a></li>
        
    
        <li><a aria-label="Next" title="Last page" href="https://dienmayai.com/admin/product?page=<?= intval($page)+1 ?>"><?= intval($page)+1 ?></a></li>
    </ul>
</nav>
<script type="text/javascript" src="https://dienmayai.com/admin/templates/default/js/helper.js?t=1743337731"></script>

</body>
</html>