<?php

$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 


global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png');
$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png'); 


// Tạo trang HTML và nhúng mã vạch vào
?>


<style type="text/css">
    /* CSS Styling */
    body {
    font-family: sans-serif; /* Sử dụng phông chữ không chân */
    }
    form {
    width: 1600px; /* Điều chỉnh độ rộng của form */
    margin: 0 auto; /* Căn giữa form */
    padding: 20px;
    border: 1px solid #ccc;
    height: 1000px;
    }
    label {
    display: block;
    margin-bottom: 5px;
    }
    input[type="text"] {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    }
    table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    }
    th, td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: left;
    }

   
    th {
    background-color: #f0f0f0;
    }
    input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    padding: 10px 15px;
    border: none;
    cursor: pointer;
    }
    input[type="submit"]:hover {
    background-color: #45a049;
    }

    


    .right{
        float: left;
        width: 100%;
    }
</style>
    
    
<form method="post" action="">
    
    <div class="right">
        <label for="requester">Họ và tên người yêu cầu xuất:</label><br>
        <input type="text" id="requester" name="requester" required><br><br>
        <label for="storeName">Tên gian hàng:</label><br>
        <input type="text" id="storeName" name="storeName" required><br><br>
        <label for="deliveryPerson">Tên NVC giao:</label><br>
        <input type="text" id="deliveryPerson" name="deliveryPerson" required><br><br>
        <label for="department">Bộ phận:</label><br>
        <input type="text" id="department" name="department" required><br><br>
        <label for="storeCode">Mã gian hàng:</label><br>
        <input type="text" id="storeCode" name="storeCode" required><br><br>
        <label for="customerPhone">Số điện thoại khách hàng:</label><br>
        <input type="text" id="customerPhone" name="customerPhone" required><br><br>

        <label for="diachinhanhang">Địa chỉ nhận hàng:</label><br>
        <input type="text" id="diachinhanhang" name="diachinhanhang" required><br><br>

         <label for="tennguoinhan">Tên người nhận hàng:</label><br>
        <input type="text" id="tennguoinhan" name="tennguoinhan" required><br><br>
        <table>
            <tr>
                <th>TT</th>
                <th style="width: 267px;">Tên sản phẩm</th>
                <th>Mã đơn hàng</th>

                <th style="width: 10px;">Số lượng</th>
                <th>Phí vận chuyển</th>
                
                <th style="width:105px">Tổng số tiền người mua thanh toán</th>
                
                <th style="width:105px">Đơn giá</th>
                <th>Thành tiền</th>
                <th>Họ tên người thu tiền</th>
                <th>Ghi chú (Mã vận đơn)</th>
            </tr>
            <tr>
                <td>1</td>
                <td><input type="text" id="productName1" name="productName1" required></td>
                <td><input type="text" id="productCode1" name="productCode1" required></td>

                <td><input type="text" id="soluong" name="soluong" required></td>
                <td><input type="text" id="phivanchuyen" name="phivanchuyen" required></td>
                <!-- <td><input type="text" id="phivanchuyennguoimuatra" name="phivanchuyennguoimuatra"></td> -->
                <td><input type="text" id="tongsotiennguoimuathanhtoan" name="tongsotiennguoimuathanhtoan" required></td>
               
                <td><input type="text" id="dongia" name="dongia" required></td>


                <td><input type="text" id="thanhtien" name="thanhtien" required></td>
                <td><input type="text" id="hotenguoithutien" name="hotenguoithutien" required></td>
                <td><input type="text" id="ghichu" name="ghichu" required></td>
                
            </tr>
            
        </table>
        <button type="submit">submit</button>
        <br>
        
    </div>


    
</form>

