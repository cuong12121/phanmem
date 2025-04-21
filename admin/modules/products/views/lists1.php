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
            max-height: 700px; /* Giới hạn chiều cao bảng */
            overflow-y: auto; /* Cho phép cuộn dọc */
            border: 1px solid #ddd;
        }

        body #page-wrapper tr td{
            font-size: 15px;
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
            max-width: 100px;
            height: auto;
        }

        body #page-wrapper .btn-outline a{
            color: #fff;
        }

        .none{
            display: none;
        }
    </style>
</head>
<body>


<div class="form-search-pd">

    <div class="form_head">
        <div id="wrap-toolbar" class="wrap-toolbar">
            <div class="fl">
                <h1 class="page-header">Products</h1>
                <!--end: .page-header -->
                <!-- /.row -->    
            </div>
            <br>
            <?php 
                if(!empty($_GET['search'])){
            ?>
            <div>
                <h3>Bạn đang tìm kiếm với chuỗi : <?= $_GET['search'] ?></h3>
            </div>
            <?php 
                }
            ?>

            <div class="fr">

                <!-- <button onclick="showFormAdd()">test</button> -->
                <a class="toolbar"  href="/admin/index.php?module=products&view=products&task=export">
                    <span title="Xuất exel" style="background:url('https://dienmayai.com/admin/templates/default/images/toolbar/Excel-icon.png') no-repeat"></span>
                    Xuất exel
                </a>
                <a class="toolbar" onclick="javascript: submitbutton('print_barcode_open')" href="#">
                    <span title="In mã vạch" style="background:url('https://dienmayai.com/admin/templates/default/images/toolbar/print.png') no-repeat"></span>
                    In mã vạch
                </a>
                <a class="toolbar" href="/admin/product/add/1">
                    <span title="Thêm mới" style="background:url('https://dienmayai.com/admin/templates/default/images/toolbar/add.png') no-repeat"></span>
                    Thêm mới
                </a>


               <!--  <a class="toolbar" onclick="javascript: submitbutton('reset_amount_hold')" href="#">
                    <span title="Reset tạm giữ" style="background:url('https://dienmayai.com/admin/templates/default/images/toolbar/remove.png') no-repeat"></span>
                    Reset tạm giữ
                </a>
                <a class="toolbar" onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('Bạn phải chọn ít nhất một bản ghi');}else{ submitbutton('remove')} " href="#">
                    <span title="Xóa" style="background:url('https://dienmayai.com/admin/templates/default/images/toolbar/remove.png') no-repeat"></span>
                    Xóa
                </a>       -->
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
        <!--end: .wrap-toolbar-->
    </div>

    


    <form  action="/admin/product/search-fast/check" name="adminForm" method="get">    
        <div class="filter_area">
            <div class="row">

                <div class="fl-left pd-15"> 
                    <input type="text" placeholder="Tìm kiếm" name="search" id="search" value="<?= @$_GET['search'] ?>" class="form-control fl-left" >
                    <span class="input-group-btn fl-left" style="margin-left: -2px;">
                    <button type="submit" class="btn btn-search btn-default" type="button">
                    <i class="fa fa-search"></i>
                    </button>
                    </span>
                </div>
                <div class="fl-left">
                    <select name="filter1" class="form-control " >                 
                        <option value="0"> -- Kho -- </option>
                        <option value="1" <?=  !empty($_GET['filter1'])&&$_GET['filter1']==1?'selected':'' ?>>Kho Hà Nội</option>
                        <option value="2" <?=  !empty($_GET['filter1'])&&$_GET['filter1']==2?'selected':'' ?>>Kho Hồ Chí Minh</option>
                        <option value="3" <?=  !empty($_GET['filter1'])&&$_GET['filter1']==3?'selected':'' ?>>Kho test</option>
                        <option value="4" <?=  !empty($_GET['filter1'])&&$_GET['filter1']==4?'selected':'' ?>>Kho hàng Cao Duy Hoan</option>
                        <option value="5" <?=  !empty($_GET['filter1'])&&$_GET['filter1']==5?'selected':'' ?>>Tầng 1</option>
                        <option value="6" <?=  !empty($_GET['filter1'])&&$_GET['filter1']==6?'selected':'' ?>>Kho Văn La</option>
                        <option value="7" <?=  !empty($_GET['filter1'])&&$_GET['filter1']==7?'selected':'' ?>>Kho Văn Phú</option>                
                    </select>
                </div>
                <div class="fl-left">               
                    <button class="btn btn-outline btn-primary" type="submit">Tìm kiếm</button>             
                    <button class="btn btn-outline btn-primary"><a href="https://<?= DOMAIN  ?>/admin/product?get_template=1">Reset</a>  </button>           
                </div>
                 
                
            </div>
        </div>
    </form> 

</div>

<?php 
    $columns = [
        ['label' => 'Mã vạch', 'key' => 'id', 'table' => 'a'],
        ['label' => 'Mã', 'key' => 'code', 'table' => 'a'],
        ['label' => 'Tên', 'key' => 'name', 'table' => 'a'],
        ['label' => 'Giá bán', 'key' => 'sell', 'table' => 'a'],
        ['label' => 'Giá nhập', 'key' => 'import_price', 'table' => 'a'],
        ['label' => 'Giá bán đóng gói', 'key' => 'price_pack', 'table' => 'a'],
        ['label' => 'Giá bán thấp nhất', 'key' => 'price_min', 'table' => 'a'],
        ['label' => 'Hàng đã xuất', 'key' => 'exported', 'table' => 'a'],
        ['label' => 'Tồn', 'key' => 'amount', 'table' => 'b'],
        ['label' => 'Tổng tồn', 'key' => 'amount', 'table' => 'b'],
    ];

?>


<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Ảnh</th>
                <?php
                $currentUrl = $_SERVER['REQUEST_URI'];
                $currentUrl =str_replace('/admin/product', '', $currentUrl);
                echo $currentUrl;

                    foreach ($columns as $col) {
                        $label = $col['label'];
                        $key = $col['key'];
                        $table = $col['table'];

                        $ascHref = "?sort={$key}_asc&table={$table}";
                        $descHref = "?sort={$key}_desc&table={$table}";

                        $ascStyle = (strpos($currentUrl, $ascHref) !== false) ? 'style="color:red"' : '';
                        $descStyle = (strpos($currentUrl, $descHref) !== false) ? 'style="color:red"' : '';

                        echo "<th>
                                $label
                                <a href=\"$ascHref\" $ascStyle>▲</a>
                                <a href=\"$descHref\" $descStyle>▼</a>
                            </th>";
                    }
                ?>    
                <th>Sửa</th>
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
                <td>
                    <div class="wrap_list_pr"><a title="Sửa" href="/admin/product/edit/<?= $value->id ?>"><img border="0" alt="Sửa" src="/admin/templates/default/images/edit.png"></a></div>
                </td>
            </tr>
            
            <?php
                endforeach;
            ?>
            <!-- Thêm nhiều dòng hơn nếu cần -->
        </tbody>
    </table>

    
</div>


    
<?php
 $task = FSInput::get('task', 'display');
if($task ==='display'){ ?>

    <?php  
    $sort = $_GET['sort']??'' ?>;


<nav aria-label="Page navigation">
    <div style="text-align: center; font-weight: bold; margin-top: 30px;"><font>Tổng</font> : <span style="color:red">[8044]</span> </div>
    <ul class="pagination">
        <li><a class="title_pagination">Trang</a></li>
        <?php
            if($page>1){
        ?>
             <?php
            if(!empty($sort)){ ?>
            ?>
             <li><a title="Page 2" href="&page=<?= intval($page)-1 ?>"><?= intval($page)-1 ?></a></li>
            <?php }else{?>
            <li><a title="Page" href="/admin/product?page=<?= intval($page)-1 ?>"><?= intval($page)-1 ?></a></li>
            <?php } ?>
        <?php
            }
        ?>
        <li><a title="Page 2" href="/admin/product?page=<?= intval($page) ?>"><?= intval($page) ?></a></li>
        
        <?php
            if(!empty($sort)){ ?>
            ?>
             <li><a aria-label="Next" title="Last page" href="/&page=<?= intval($page)+1 ?>"><?= intval($page)+1 ?></a></li>
             
            <?php }else{?>
            <li><a title="Page" href="/admin/product?page=<?= intval($page)-1 ?>"><?= intval($page)-1 ?></a></li>
            <?php } ?>
       
    </ul>
</nav>

<?php

}
else{
    if(empty($_GET['search'])){

    
    ?>
<nav aria-label="Page navigation">
    <div style="text-align: center; font-weight: bold; margin-top: 30px;"><font>Tổng</font> : <span style="color:red">[8044]</span> </div>
    <ul class="pagination">
        <li><a class="title_pagination">Trang</a></li>
        <?php
            if($page>1){
        ?>
        <li><a title="Page 2" href="&page=<?= intval($page)-1 ?>"><?= intval($page)-1 ?></a></li>
        <?php
            }
        ?>
        <li><a title="Page 2" href="/admin/product/search-fast/check?search=&filter1=<?= $_GET['filter1'] ?>"><?= intval($page) ?></a></li>
        
    
        <li><a aria-label="Next" title="Last page" href="&page=<?= intval($page)+1 ?>"><?= intval($page)+1 ?></a></li>
    </ul>
</nav>

<?php 
    }
    else{
?>

<nav aria-label="Page navigation">
    <div style="text-align: center; font-weight: bold; margin-top: 30px;"><font>Tổng</font> : <span style="color:red">[8044]</span> </div>
    <ul class="pagination">
        <li><a class="title_pagination">Trang</a></li>
        <?php
            if($page>1){
        ?>
        <li><a title="Page 2" href="/admin/product/search-fast/check?search=<?= @$_GET['search'] ?>&filter1=<?= @$_GET['filter1'] ?>&page=<?= intval($page)-1 ?>"><?= intval($page)-1 ?></a></li>
        <?php
            }
        ?>
        <li><a title="Page 2" href="/admin/product/search-fast/check?search=<?= @$_GET['search'] ?>&filter1=<?= @$_GET['filter1'] ?>"><?= intval($page) ?></a></li>
        
    
        <li><a aria-label="Next" title="Last page" href="/admin/product/search-fast/check?search=<?= @$_GET['search'] ?>&filter1=<?= @$_GET['filter1'] ?>&page=<?= intval($page)+1 ?>"><?= intval($page)+1 ?></a></li>
    </ul>
</nav>

<?php
}}
?>

  <script type="text/javascript" src="/admin/templates/default/js/jquery-confirm.min.js"></script>
        <script type="text/javascript" src="/admin/templates/default/js/select2.min.js"></script>
        <script type="text/javascript" src="/admin/templates/default/js/helper.js?t=1743337733"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="/admin/templates/default/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="/admin/templates/default/bower_components/metisMenu/dist/metisMenu.min.js"></script>

        <!-- Morris Charts JavaScript -->
        <script src="/admin/templates/default/bower_components/raphael/raphael-min.js"></script>

        <!-- DataTables JavaScript -->
        <script src="/admin/templates/default/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
        <script src="/admin/templates/default/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
        <script src="/admin/templates/default/bower_components/datatables-responsive/js/dataTables.responsive.js"></script>
        <script>
            $(document).ready(function() {
                $('#dataTables-example1').DataTable({
                    responsive: true,
                    "language": {
                        "lengthMenu": "Hiển thị _MENU_ trên mỗi trang",
                        "zeroRecords": "Không tìm thấy gì - xin lỗi",
                        "info": "Đang ở trang _PAGE_ của _PAGES_",
                        "infoEmpty": "Không có dữ liệu có sẵn",
                        "infoFiltered": "(lọc từ tổng số hồ sơ _MAX_)",
                        "search": "Tìm kiếm nhanh:",
                        paginate: {
                            first:    '«',
                            previous: '‹',
                            next:     '›',
                            last:     '»'
                        },
                    },
                    select: {
                        style: 'multi'
                    },
                    "lengthMenu": [ 10 ,20, 30, 40 , 50],
                    "columnDefs": [
                    { "orderable": false, "targets": 1 }
                    ]
                });

            });
        </script>
        <!-- Custom Theme JavaScript -->
        <script src="https://dienmayai.com/admin/templates/default/dist/js/sb-admin-2.js"></script>
        <script src="https://dienmayai.com/admin/templates/default/dist/js/jquery.cookie.js"></script>
        <!-- Custom select chosen.jquery.js -->
        <script src="https://dienmayai.com/admin/templates/default/js/chosen.jquery.js" type="text/javascript"></script>
        <script type="text/javascript">
            var config = {
              '.chosen-select'           : {no_results_text: "Không tìm thấy "},
              '.chosen-select-deselect'  : {allow_single_deselect:true},
              '.chosen-select-no-single' : {disable_search_threshold:10},
              '.chosen-select-no-results': {no_results_text:"Không tìm thấy "},
              '.chosen-select-width'     : {width:"95%"}
          }
          for (var selector in config) {
              $(selector).chosen(config[selector]);
          }
        </script>


</body>
</html>