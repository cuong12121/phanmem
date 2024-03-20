<?php 
global $tmpl;
$tmpl -> addTitle('Kết thúc đơn hàng');
$tmpl -> addStylesheet('cart','modules/products/assets/css');
$eid = FSInput::get('eid',0,'int');
$Itemid = FSInput::get('Itemid');


if($order -> is_vnpay == 1){
	require('libraries/vnpay_php/config.php');
	$inputData = array();
	$returnData = array();
	$row_vnpay = array();
	$data = $_REQUEST;
	foreach ($data as $key => $value) {
	    if (substr($key, 0, 4) == "vnp_") {
	        $inputData[$key] = $value;
	    }
	}

	$vnp_SecureHash = $inputData['vnp_SecureHash'];
	unset($inputData['vnp_SecureHashType']);
	unset($inputData['vnp_SecureHash']);
	ksort($inputData);
	$i = 0;
	$hashData = "";
	foreach ($inputData as $key => $value) {
	    if ($i == 1) {
	        $hashData = $hashData . '&' . $key . "=" . $value;
	    } else {
	        $hashData = $hashData . $key . "=" . $value;
	        $i = 1;
	    }
	}
	$vnpTranId = $inputData['vnp_TransactionNo']; //Mã giao dịch tại VNPAY
	$vnp_BankCode = $inputData['vnp_BankCode']; //Ngân hàng thanh toán
	//$secureHash = md5($vnp_HashSecret . $hashData);
	$secureHash = hash('sha256',$vnp_HashSecret . $hashData);
	$Status = 0;
	$orderId = $inputData['vnp_TxnRef'];

	try {
	    //Check Orderid    
	    //Kiểm tra checksum của dữ liệu
	    if ($secureHash == $vnp_SecureHash) {
	        //Lấy thông tin đơn hàng lưu trong Database và kiểm tra trạng thái của đơn hàng, mã đơn hàng là: $orderId            
	        //Việc kiểm tra trạng thái của đơn hàng giúp hệ thống không xử lý trùng lặp, xử lý nhiều lần một giao dịch
	        //Giả sử: $order = mysqli_fetch_assoc($result);   
	        $check_stt = array();
	        $check_stt["Status"] = 0;

	        if ($check_stt != NULL) {
	        	
	            if ($check_stt["Status"] == 0) {

	                if ($inputData['vnp_ResponseCode'] == '00') {
	                    $Status = 1;
	                    
	                    $row_vnpay['code_vnpay'] = '00';
	                    $update_vnpay = $model->_update ($row_vnpay, 'fs_order' ,' id = '.$order -> id);
	                    // die;
	                } else {
	                    $Status = 2;
	                }
	                // printr($order);
	                //Cài đặt Code cập nhật kết quả thanh toán, tình trạng đơn hàng vào DB
	                //
	                //
	                //
	                //Trả kết quả về cho VNPAY: Website TMĐT ghi nhận yêu cầu thành công                
	                $returnData['RspCode'] = '00';
	                $returnData['Message'] = 'Thành công';
	            } else {
	                $returnData['RspCode'] = '02';
	                $returnData['Message'] = 'Order already confirmed';
	            }
	        } else {
	            $returnData['RspCode'] = '01';
	            $returnData['Message'] = 'Order not found';
	        }
	    } else {
	        $returnData['RspCode'] = '97';
	        $returnData['Message'] = 'Chu ky khong hop le';
	    }
	} catch (Exception $e) {
	    $returnData['RspCode'] = '99';
	    $returnData['Message'] = 'Unknow error';
	}
	//Trả lại VNPAY theo định dạng JSON
	// echo json_encode($returnData);
	// die;
}

?>
<div id="products-cart">
		<h1 class="page_title"><span><?php echo FSText::_('Chi tiết đơn hàng'); ?></span></h1>
		
		<div class="tab-info-oder">
			<span><?php echo FSText::_('Mã đơn hàng'); ?> : </span>DH<?php echo str_pad($order -> id, 8 , "0", STR_PAD_LEFT);?>
		</div>

		<?php include 'finished_items.php'; ?>
		<?php include 'finished_buyer_info.php'; ?>
		
	<div class="clear"></div>
</div>

