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
    
    <form class="header__search" method="get" action="https://<?= DOMAIN ?>/admin/order/detail/box/package" style="display: flex; margin-bottom: 15px;">
        <input type="text" class="input-search ui-autocomplete-input" id="tags"  name="search" autocomplete="off" maxlength="100" required="" wfd-id="id0" autofocus > 
        
        <input type="hidden" name="active" value="1">    
        <button type="submit">Bắn đơn </button> 
    </form>
</div>

<br>

<div class="form">
    <a href="/admin/index.php?module=order&view=order&task=view_pack">Nhập đơn bằng file excel</a>
</div>


<?php 
     global $db;
    $skip_user = [9,208,251,206];


    if(in_array($user_id, $skip_user)):
   
?>
<div class="form-search">
    
    <form class="header__search" method="get" action="https://<?= DOMAIN ?>/admin/order/detail/search/package" style="display: flex; margin-bottom: 15px;">

        <?php 
           

            $sqls = " SELECT username,id FROM  fs_users";

            $db->query ( $sqls );
            $names = $db->getObjectList ();


            $define_id = ['252'=>'PHUONGDGMB', '253'=>'LANDGMB', '254'=>'LOANDGMB','255'=>'CANHDGMB', '256'=>'TRANGDGMB', '9'=>'admin', '257'=>'HAIDGMB', '258'=>'ANHDGMN', '259'=>'THOADGMN', '260'=>'THUDGMN'];
              
        ?>

        <select name="name">

            <option value ="0">Tên người dùng</option>
            <?php
                foreach($define_id as $key=>$val){
            ?>
                <option value="<?= $key ?>"><?= $val ?></option>

            <?php
                }
            ?>
        </select>
        <label>từ</label>
        <input type="date" class="input-search ui-autocomplete-input"   name="date1" autocomplete="off" maxlength="100" required="" > 
         <label>đến</label>
        <input type="date" class="input-search ui-autocomplete-input"   name="date2" autocomplete="off" maxlength="100" required="" > 
        &nbsp;
        <select name="kho">                 
            <option value="0"> -- Kho -- </option>
            <option value="1" <?=  !empty($_GET['kho'])&&$_GET['kho']==1?'selected':'' ?>>Kho Hà Nội</option>
            <option value="2" <?=  !empty($_GET['kho'])&&$_GET['kho']==2?'selected':'' ?>>Kho Hồ Chí Minh</option>
            <option value="3" <?=  !empty($_GET['kho'])&&$_GET['kho']==3?'selected':'' ?>>Kho test</option>
            <option value="4" <?=  !empty($_GET['kho'])&&$_GET['kho']==4?'selected':'' ?>>Kho hàng Cao Duy Hoan</option>
            <option value="5" <?=  !empty($_GET['kho'])&&$_GET['kho']==5?'selected':'' ?>>Tầng 1</option>
            <option value="6" <?=  !empty($_GET['kho'])&&$_GET['kho']==6?'selected':'' ?>>Kho Văn La</option>
            <option value="7" <?=  !empty($_GET['kho'])&&$_GET['kho']==7?'selected':'' ?>>Kho Văn Phú</option>                
        </select>

        <input type="checkbox" name="options" value="1"> xuất file excel<br>
        
       
        <button type="submit">Tìm kiếm </button> 
    </form>
</div>
<?php
    endif;

?>

<?php

    $date = date('d-m-Y');

    $notification = !empty($_SESSION['notification'])?$_SESSION['notification']:'';

    if(!empty($notification)):
?>

<h3 style="color: red"><?= $notification ?> </h3>

<?php

    endif;

    unset($_SESSION['notification']);

    $redis = new Redis();

    // Thiết lập kết nối
    $redis->connect('127.0.0.1', 6379);

    $data_prepare =  json_decode($redis->get("data_box_order"));




?>
<?php
$dem=0;
if(!empty($data_prepare)):

  
?>    

<h3>Danh sách chờ update đơn bắn </h3>


<table class="table-responsive">
    <tr>
        <th>STT</th>
        <th>Tracking code</th>
        <th>ID người bắn đơn </th>
        <th>Giờ bắn đơn</th>
        <th>trạng thái</th>
        
    </tr>
    <?php
    foreach($data_prepare as $val):
        $dem++
    ?>

    <tr>
        <td><?= $dem ?></td>
        <td><?= $val->search ?></td>
        <td><?= $val->user_id ?></td>
        <td><?= $val->date_time ?></td>
        <td>đang chờ</td>
    </tr>
    <?php
        endforeach;
    ?>
</table>   

<br>
<?php

endif;
?>
 

<?php 

    if($user_id !='9'||$user_id !='251'):
   
?>
    <h2>Danh sách đơn đã đóng mới nhất của  <?=  @$_SESSION ['ad_username'] ?></h2>

<?php
    endif

?>


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
            <th>Đơn vị vận chuyển</th>
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

                    <a href="https://<?= DOMAIN ?>/admin/order/detail/search?search=<?= $value->id ?>&active=0" style="color: red">Hoàn đơn</a>
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
                $name = $db->getResult($sql);
            ?>
            
            <td><?= $name ?></td>
            <td><?= date("d/m/Y", strtotime($value->date));  ?></td>

            <?php  
                $date_time_package = date("d/m/Y,H:i:s", strtotime($value->date_package)); 
                $date_package = date("d/m/Y", strtotime($value->date_package));
                

            ?>

            <td><?= $date_time_package  ?></td>

            <td><?= $value->shipping_unit_name?$value->shipping_unit_name:''  ?></td>

            
            
            <td><?=  number_format((float)$value->total_price, 0, ',', '.') ?>đ</td>
            <td class="return">
                <?php
                    if($now=== $date_package):
                ?>    
                <a href="https://<?= DOMAIN ?>/admin/order/detail/search?search=<?= $value->id ?>&active=0">Hoàn đơn</a>

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