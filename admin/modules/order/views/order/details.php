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
</style>
<table>
        <tr>
            <th>STT</th>
            <th>Tên sản phẩm </th>
            <th>Tên shop</th>
            <th>Mã shop</th>
            <th>Số lượng</th>
            <th>Id đơn hàng</th>
            <th>Tracking code</th>
            <th>Thành tiền</th>
        </tr>



        <?php 
            echo "<pre>";
                var_dump($info_data);
            echo "</pre>";
            die;
        	if(!empty($info_data->data)){
        		$dem =0;

        		foreach ($info_data->data as $key => $value) {
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
            <td><?= $value->total_price  ?>đ</td>
        </tr>

        <?php 

        	}
        	}
        ?>
       
    </table>

    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>