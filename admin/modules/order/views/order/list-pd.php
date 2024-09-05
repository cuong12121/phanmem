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
   
    <h2>Danh sách đơn đã đóng mới nhất của  admin</h2>
    <table class="table-responsive">
        <tbody>
            <tr>
                <th>STT</th>
                <th>Tracking code</th>
                <th>Tên sản phẩm </th>
                <th>Tên shop</th>
                <th>Mã shop</th>
                <th>Số lượng</th>
                <th>Id đơn hàng</th>
                <th>Người đánh đơn</th>
                <th>Ngày đánh đơn</th>
                <th>Thời gian đóng đơn hàng</th>
                <th>Thành tiền</th>
                <th>Hoàn đơn</th>
            </tr>
            <tr>
                <td>
                    1                
                    <div class="mobile">
                        <a href="https://dienmayai.com/admin/order/detail/search?search=1470147&amp;active=0" style="color: red">Hoàn đơn</a>
                    </div>
                </td>
                <td>LMP0266043552VNA</td>
                <td>Keo và miếng vá bể bơi-không màu- không size</td>
                <td>KAW MAX - Lazada</td>
                <td>AMS</td>
                <td>1</td>
                <td>243549</td>
                <td>PHUONGDGMB</td>
                <td>28/08/2024</td>
                <td>28/08/2024,01:31:29</td>
                <td>5.211đ</td>
                <td class="return">
                </td>
            </tr>
            
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