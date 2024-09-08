<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>

<!-- Popper JS -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
 <style type="text/css">
    table, th, td{
        border:1px solid #868585;
    }
    table{
        border-collapse:collapse;
        width:100%;
    }
    th, td{
        text-align:left;
        padding:10px;
    }
    table tr:nth-child(odd){
        background-color:#eee;
    }
    table tr:nth-child(even){
        background-color:white;
    }
    table tr:nth-child(1){
        background-color:skyblue;
    }
    .form-search{
        display: flex;
    }
    #tags{
        margin-right: 15px;
        height: 30px;
        font-size: 20px;
    }
    .return a{
        color: red !important;
    }

    @media only screen and (min-width: 601px) {
        .mobile{
            display: none;
        }
    }        
    @media only screen and (max-width: 600px) {
        #tags {
            margin-right: 15px;
            height: 50px;
            font-size: 26px;
        }

    }
</style>

<div id="page-wrapper" class="page-wrapper-small" style="min-height: 110px;">
    <div class="form_head">
        <div id="wrap-toolbar" class="wrap-toolbar">
            <div class="fl">
                <h1 class="page-header">Hệ thống quản lý nội dung (CMS)</h1>
                <!--end: .page-header -->
                <!-- /.row -->    
            </div>
            <div class="clearfix"></div>
        </div>
        <!--end: .wrap-toolbar-->
    </div>
    <!--end: .form_head-->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <style type="text/css">
        table, th, td{
        border:1px solid #868585;
        }
        table{
        border-collapse:collapse;
        width:100%;
        }
        th, td{
        text-align:left;
        padding:10px;
        }
        table tr:nth-child(odd){
        background-color:#eee;
        }
        table tr:nth-child(even){
        background-color:white;
        }
        table tr:nth-child(1){
        background-color:skyblue;
        }
        .form-search{
        display: flex;
        }
        #tags{
        margin-right: 15px;
        height: 30px;
        font-size: 20px;
        }
        .return a{
        color: red !important;
        }
        body #page-wrapper a{
            color: orange;
        }
        @media only screen and (min-width: 601px) {
        .mobile{
        display: none;
        }
        }        
        @media only screen and (max-width: 600px) {
        #tags {
        margin-right: 15px;
        height: 50px;
        font-size: 26px;
        }
        }
    </style>
    <div class="form-search">
        <form class="header__search" method="get" action="https://dienmayai.com/admin/order/detail/search" style="display: flex; margin-bottom: 15px;">
            <input type="text" class="input-search ui-autocomplete-input" id="tags" name="search" autocomplete="off" maxlength="100" required="" wfd-id="id0" autofocus=""> 
            <input type="hidden" name="active" value="1">    
            <button type="submit">Bắn đơn </button> 
        </form>
    </div>
   
    <h2>Danh sách đơn hàng</h2>
    <table class="table-responsive">
        <tbody>
            <tr>
                <th>STT</th>
                <th>Kho</th>
                <th>Sàn </th>
                <th>Shop</th>
                <th>Tên file</th>
                <th>Ngày</th>
                <th>Giờ</th>
                <th>Hóa đơn PDF</th>
                <th>Đơn hàng excel</th>
                <th>Sửa</th>
                <th>Thời gian tạo</th>
                <th>Id</th>
            </tr>
            <?php
            if(!empty($result)){

                $dem=0;

                foreach ($result as $key => $value) {
                    $dem++;
              
            ?>    
            <tr>
                <td>
                    <?= $dem ?>                 
                </td>
                <td><?= $kho[$value->warehouse_id]  ?></td>
                <td><?= $san[$value->platform_id]   ?></td>
                <td><?= $value->shop_code ?></td>
                <td><?= $value->name ?></td>
                <td><?=  new DateTime($value->date)->format('d/m/Y')  ?></td>
                <td><?= $value->time_id ?></td>
                <td><a href="<?= '/'.$value->file_pdf ?>" target="_blank"><?= basename($value->file_pdf) ?></a> </td>
                <td><a href="<?= '/'.$value->file_xlsx ?>" target="_blank"><?= basename($value->file_xlsx) ?></a> </td>
                <td></td>
                <td><?= $value->created_time ?></td>
                <td class="return">
                    <?= $value->id ?>
                </td>
            </tr>
            <?php
                }}
            ?>
            
        </tbody>
    </table>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item"><a class="page-link" href="?page=1">1</a></li>
            <li class="page-item"><a class="page-link" href="?page=2">2</a></li>
            <li class="page-item"><a class="page-link" href="?page=3">3</a></li>
            <li class="page-item">
                <a class="page-link" href="?page=4" aria-label="Next">
                <span aria-hidden="true">»</span>
                </a>
            </li>
        </ul>
    </nav>
</div>