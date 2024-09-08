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
    
    <form class="header__search" method="get" action="https://<?= DOMAIN ?>/admin/order/upload/view_order_by_date" style="display: flex; margin-bottom: 15px;">

       
        <label>từ</label>
        <input type="date" class="input-search ui-autocomplete-input"   name="date1" autocomplete="off" maxlength="100" required="" > 
         <label>đến</label>
        <input type="date" class="input-search ui-autocomplete-input"   name="date2" autocomplete="off" maxlength="100" required="" > 
       
        <button type="submit">Tìm kiếm </button> 
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

                
                $dem= $page>1?(intval($page)-1)*10:0;

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
                <td><?= date('d/m/Y', strtotime($value->date))  ?></td>
                <td><?= $value->time_id ?></td>
                <td><a href="<?= '/'.$value->file_pdf ?>" target="_blank"><?= basename($value->file_pdf) ?></a> </td>
                <td><a href="<?= '/'.$value->file_xlsx ?>" target="_blank"><?= basename($value->file_xlsx) ?></a> </td>
                <td></td>
                <td><?= date('d/m/Y,H:i:s', strtotime($value->created_time))   ?></td>
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
            <?php 
                if($page !=1):
            ?>
            <li class="page-item"><a class="page-link" href="?page=1">Về đầu</a></li>

            <?php
                endif;
            ?>

             
            <?php
            for($i=$page;$i<  intval($page)+3;$i++): ?>
            <li class="page-item"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
            <?php
            endfor;
            ?>
            <li>...</li>

            <?php
             if(empty($results->total)):
             ?>   

            <li class="page-item"><a class="page-link" href="?page=200">Trang cuối</a></li>
            <?php
            else:
            ?>    
            <li class="page-item"><a class="page-link" href="?page=<?= float(intval($results->total)/10) ?>">Trang <?=  float(intval($results->total)/10) ?></a></li>
         
        </ul>
    </nav>
</div>