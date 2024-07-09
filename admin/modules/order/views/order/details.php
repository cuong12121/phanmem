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
        <input type="text" class="input-search ui-autocomplete-input" id="tags"  name="search" autocomplete="off" maxlength="100" required="" wfd-id="id0" autofocus > 
        
        <input type="hidden" name="active" value="1">    
        <button type="submit">Bắn đơn </button> 
    </form>
</div>
<?php
    $date = date('d-m-Y');

    global $db;

    

    $notification = !empty($_SESSION['notification'])?$_SESSION['notification']:'';

    if(!empty($notification)):
?>

<h3 style="color: red"><?= $notification ?> </h3>

<?php

    endif;

    unset($_SESSION['notification']);
?>
<h2>Danh sách đơn đã đóng mới nhất của  <?=  @$_SESSION ['ad_username'] ?></h2>

<table class="table-responsive">
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



        <?php 
            $now = date("d/m/Y");
            // echo "<pre>";
            //     var_dump($info_data);
            // echo "</pre>";
            // die;
        	if(!empty($info_data->data)){
        		$dem =0;

        		foreach ($info_data->data as $key => $value) {
        			$dem++;


        			
        ?>

        <tr>
            <td>
                <?= $dem ?>
                <div class="mobile">

                    <a href="https://dienmayai.com/admin/order/detail/search?search=<?= $value->id ?>&active=0" style="color: red">Hoàn đơn</a>
                </div>
                    
            </td>
            <td><?= $value->tracking_code  ?></td>
            <td><?= $value->product_name  ?></td>
            <td><?= $value->shop_name  ?></td>
            <td><?= $value->shop_code  ?></td>
            <td><?= $value->count  ?></td>
            <td><?= $value->record_id  ?></td>

            <?php 

                $sql = " SELECT username FROM  fs_users WHERE id = '$value->user_package_id'";
                $name = $db->getResult($query);
            ?>
            
            <td><?= $name ?></td>
            <td><?= date("d/m/Y", strtotime($value->date));  ?></td>

            <?php  
                $date_time_package = date("d/m/Y,H:i:s", strtotime($value->date_package)); 
                $date_package = date("d/m/Y", strtotime($value->date_package));

            ?>

            <td><?= $date_time_package  ?></td>
            
            <td><?=  number_format((float)$value->total_price, 0, ',', '.') ?>đ</td>
            <td class="return">
                <?php
                    if($now=== $date_package):
                ?>    
                <a href="https://dienmayai.com/admin/order/detail/search?search=<?= $value->id ?>&active=0">Hoàn đơn</a>

                <?php 
                   endif;
                ?>
            </td>
        </tr>

        <?php 

        	}
        	}
        ?>
       
    </table>

    <?php 
       
        $get_page =!empty($_GET['page'])?$_GET['page']:1
        
    ?>

    <nav aria-label="Page navigation example">
        <ul class="pagination">

            <?php 

                if($get_page !=1):
            ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?= intval($get_page)-1 ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            <?php
                endif;
            ?>

            <?php 
                for ($i = $get_page; $i < 3+intval($get_page); $i++) :
            ?>

            <li class="page-item"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
          

            <?php 
            endfor;    
            ?>


            <li class="page-item">
                <a class="page-link" href="?page=<?= intval($get_page)+3 ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>