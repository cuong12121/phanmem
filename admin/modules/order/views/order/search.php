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
</style>
<div class="form-search">
    
    <form class="header__search" method="get" action="https://<?= DOMAIN ?>/admin/order/detail/search" style="display: flex; margin-bottom: 15px;">
        <input type="text" class="input-search ui-autocomplete-input" id="tags"  name="search" autocomplete="off" maxlength="100" required="" wfd-id="id0"> 
        
      
        <button type="submit"> tìm kiếm </button> 
    </form>
</div>

<table>
        <tr>
            <th>STT</th>
            <th>Tên sản phẩm </th>
            <th>Tên shop</th>
            <th>Mã shop</th>
            <th>Số lượng</th>
            <th>Id đơn hàng</th>
            <th>Tracking code</th>
            <th>Ngày đánh đơn</th>
            <th>Thành tiền</th>
        </tr>



        <?php 
            // echo "<pre>";
            //     var_dump($info_data);
            // echo "</pre>";
            // die;
        	if(!empty($info_data)){
        		$dem =0;

        		foreach ($info_data as $key => $value) {
        			$dem++;


        			
        ?>

        <tr>
            <td><?= $dem ?></td>
            <td><?= $value->product_name  ?></td>
            <td><?= $value->shop_name  ?></td>
            <td><?= $value->shop_code  ?></td>
            <td><?= $value->count  ?></td>
            <td><?= $value->record_id  ?></td>
            <td><?= $value->tracking_code  ?></td>
            <td><?= date("d/m/Y", strtotime($value->date));  ?></td>
            <td><?=  number_format((float)$value->total_price, 0, ',', '.') ?>đ</td>
        </tr>

        <?php 

        	}
        	}
        ?>
       
    </table>

    <?php 
       
        $get_page =!empty($_GET['page'])?$_GET['page']:1
        
    ?>

   