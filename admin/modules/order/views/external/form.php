<?php

$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 


global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png');
$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png'); 

$this -> dt_form_begin(1,4,$title.' '.FSText::_('Đơn hàng'));

if (!isset($_SESSION)) {
    session_start();
} 


$data_post = !empty($_SESSION['input_data'])?$_SESSION['input_data']:'';


// Tạo trang HTML và nhúng mã vạch vào
?>


<style type="text/css">
    /* CSS Styling */
    body {
    font-family: sans-serif; /* Sử dụng phông chữ không chân */
    }
    form {
    width: 1800px; /* Điều chỉnh độ rộng của form */
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
    
    
<form class="form-horizontal" role="form" action="#" name="adminForm">
     <label for="tennguoinhan">Số lượng sản phẩm :(vui lòng chọn số lượng sản phẩm trước khi nhập form. Mặc định là 1 sản phẩm)</label><br>
    <select id="mySelect">
        <?php 
            $number  = !empty($_GET['number'])?$_GET['number']:1;

            $currentPath = '/admin/order/external/add';

            for($k =1; $k<10; $k++){
        ?>
            <option value="<?= $currentPath ?>?number=<?= $k ?>" <?= $number==$k?'selected':''   ?>><?= $k ?></option>

        <?php
            }
        ?>
    </select>
    <div class="right">
        <label for="requester">Họ và tên người yêu cầu xuất:</label><br>
        <input type="text" id="requester" name="requester" value="<?= $data_post['requester']??'' ?>" required><br><br>
        <label for="storeName">Tên gian hàng:</label><br>
        <input type="text" id="storeName" name="storeName" value="<?= $data_post['storeName']??'' ?>" required><br><br>
        <label for="deliveryPerson">Tên NVC giao:</label><br>
        <input type="text" id="deliveryPerson" name="deliveryPerson" value="<?= $data_post['deliveryPerson']??'' ?>" required><br><br>
       
        <?php
       
            TemplateHelper::dt_edit_selectbox(FSText::_('Kho'),'warehouse_id',@$data -> warehouse_id,0,$warehouses,$field_value = 'id', $field_label='name',$size = 1,0,1);
            TemplateHelper::dt_edit_selectbox(FSText::_('Shop'),'shop_id',@$data -> shop_id,0,$shops,$field_value = 'id', $field_label='name',$size = 1,0,1);
             TemplateHelper::dt_edit_selectbox(FSText::_('Giờ'),'house_id',@$data -> house_id,0,$houses,$field_value = 'id', $field_label='name',$size = 1,0,1);

        ?>
       
        <!-- <label for="storeCode">Mã gian hàng:</label><br>
        <input type="text" id="storeCode" name="storeCode" value="<?= $data_post['storeCode']??'' ?>" required><br><br> -->
        <label for="customerPhone">Số điện thoại khách hàng:</label><br>
        <input type="text" id="customerPhone" name="customerPhone" value="<?= $data_post['customerPhone']??'' ?>" required><br><br>

        <label for="diachinhanhang">Địa chỉ nhận hàng:</label><br>
        <input type="text" id="diachinhanhang" name="diachinhanhang" value="<?= $data_post['diachinhanhang']??'' ?>" required><br><br>

         <label for="tennguoinhan">Tên người nhận hàng:</label><br>
        <input type="text" id="tennguoinhan" name="tennguoinhan" value="<?= $data_post['tennguoinhan']??'' ?>" required><br><br>
        <table>
            <tr>
                <th>TT</th>
                <th style="width: 267px;">Tên sản phẩm</th>
                <th>Mã đơn hàng</th>

                <th style="width: 10px;">Số lượng</th>
                <th style="width: 267px;">Sku phân loại hàng </th>
                <th>Phí vận chuyển</th>
                
                <th style="width:105px">Tổng số tiền người mua thanh toán</th>
                
                <th style="width:105px">Đơn giá</th>
                <th>Thành tiền</th>
                <th>Họ tên người thu tiền</th>
                <th>Ghi chú (Mã vận đơn)</th>
            </tr>

           
            <?php for($i =1; $i<=$number; $i++){ ?>
            <tr>
                <td><?= $i ?></td>
                <td><input type="text" id="productName<?= $i ?>"  name="productName<?= $i ?>" value="<?= $data_post["productName$i"]??'' ?>" required></td>
                <td><input type="text"  name="productCode<?= $i ?>" value="<?= $data_post["productCode$i"]??'' ?>" required></td>

                <td><input type="text"  name="soluong<?= $i ?>" value="<?= $data_post["soluong$i"]??'' ?>" required></td>
                <td><input type="text"  name="skuplhang<?= $i ?>" value="<?= $data_post["skuplhang$i"]??'' ?>" required></td>
                <td><input type="text"  name="phivanchuyen<?= $i ?>" value="<?= $data_post["phivanchuyen$i"]??'' ?>" required></td>
                <!-- <td><input type="text" id="phivanchuyennguoimuatra" name="phivanchuyennguoimuatra"></td> -->
                <td><input type="text"  name="tongsotiennguoimuathanhtoan<?= $i ?>" value="<?= $data_post["tongsotiennguoimuathanhtoan$i"]??'' ?>" required></td>
               
                <td><input type="text"  name="dongia<?= $i ?>" value="<?= $data_post["dongia$i"]??'' ?>" required></td>


                <td><input type="text"  name="thanhtien<?= $i ?>" value="<?= $data_post["thanhtien$i"]??'' ?>" required></td>
                <td><input type="text"  name="hotennguoithutien<?= $i ?>" value="<?= $data_post["hotennguoithutien$i"]??'' ?>" required></td>
                <td><input type="text"  name="ghichu<?= $i ?>" value="<?= $data_post["ghichu$i"]??'' ?>" required></td>

                
            </tr>

            <?php } ?>

            <input type="hidden" name="number" value="<?= $number ?>">
        </table>

        <!-- <button type="submit" onclick="submitbutton('save')">submit</button> -->
        <!-- <a class="toolbar" onclick="submitbutton('save')" href="#"><span title="Apply" style="background:url('https://dienmayai.com/admin/templates/default/images/toolbar/apply.png') no-repeat"></span>Apply</a> -->
        <br>
        
    </div>
    
</form>

<?php 

    $redis = new Redis();

    // Thiết lập kết nối
    $redis->connect('127.0.0.1', 6379);
?>

<script type="text/javascript">

    const selectElement = document.getElementById('mySelect');
    selectElement.addEventListener('change', function() {
        const selectedValue= this.value;

        const url = selectedValue;
        
        window.location.href = url;
       
    });

    let variable = {
        php: "code php",
        asp: "dot net",
        city: "New York"
    };

     $( function() {



    var availableTags =  variable;
    $( "#productName1" ).autocomplete({
          source: availableTags
        });
      } );


</script>

<?php $this -> dt_form_end(@$data,1,0); ?>

