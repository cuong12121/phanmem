
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
            <th>Thành tiền</th>
        </tr>

        <?php 

        	if(!empty($info_data['data'])){
        		$dem =0;

        		foreach ($info_data['data'] as $key => $value) {
        			$dem++;


        			
        ?>

        <tr>
            <td><?= $dem ?></td>
            <td><?= $value->product_name  ?></td>
            <td><?= $value->shop_name  ?></td>
            <td><?= $value->shop_code  ?></td>
            <td><?= $value->count  ?></td>
            <td><?= $value->total_price  ?>đ</td>
        </tr>

        <?php 

        	}
        	}
        ?>
       
    </table>