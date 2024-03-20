<?php 
global $tmpl,$config;
$tmpl -> addTitle('Kết thúc đơn hàng');
$tmpl -> addStylesheet('finished','modules/products/assets/css');
$tmpl -> addScript('finished','modules/products/assets/js');
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
	$vnp_Amount = $inputData['vnp_Amount']; 
	$vnp_Amount = (int)$vnp_Amount / 100;
	try {
	    //Check Orderid    
	    //Kiểm tra checksum của dữ liệu
	    if ($secureHash == $vnp_SecureHash) {
	      

	       if (!empty($order)) {
	       		if($order->total_after_discount != null && $order->total_after_discount == $vnp_Amount ){
		           if ($order->code_vnpay != '00') {
		                if ($inputData['vnp_ResponseCode'] == '00') {
		                    $Status = 1;
		                    
		                    $row_vnpay['code_vnpay'] = '00';
		                    // $update_vnpay = $model->_update ($row_vnpay, 'fs_order' ,' id = '.$order -> id);
		                    // die;
		                } else {
		                    $Status = 2;
		                }        
		                $returnData['RspCode'] = '00';
		                $returnData['Message'] = 'Thanh toán thành công';
		                setcookie('cart', null, -1, '/');
		            } else {
		                $returnData['RspCode'] = '02';
		                $returnData['Message'] = 'Thanh toán thành công';
		                setcookie('cart', null, -1, '/');
		                 // $returnData['Message'] = 'Đơn hàng đã được xác nhận';
		            }
		        }else{
		        	$returnData['RspCode'] = '04';
                	$returnData['Message'] = 'Có lỗi. Số tiền không hợp lệ';
		        }
	        } else {
	            $returnData['RspCode'] = '01';
	            $returnData['Message'] = 'Có lỗi. Không tìm thấy đơn hàng';
	        }
	    } else {
	        $returnData['RspCode'] = '97';
	        $returnData['Message'] = 'Có lỗi. Chữ kí không hợ lệ';
	    }
	} catch (Exception $e) {
	    $returnData['RspCode'] = '99';
	    $returnData['Message'] = 'Có lỗi. Lỗi không rõ liên hệ với chúng tôi để biết thêm chi tiết';
	}
	//Trả lại VNPAY theo định dạng JSON
	// echo json_encode($returnData);
	// die;
}

?>
<div id="products-cart">
	<h1 class="page_title"><span><?php echo FSText::_('Chi tiết đơn hàng: DH') .str_pad($order -> id, 8 , "0", STR_PAD_LEFT); ?></span></h1>
	
	<?php include 'finished_items.php'; ?>
	<?php include 'finished_buyer_info.php'; ?>
		
	<div class="clear"></div>
	<?php if($order-> is_vnpay == 1){
		if($inputData['vnp_ResponseCode'] != '00'){
			$text_stt_vnpay = "Thanh toán không thành công";
		}else{
			$text_stt_vnpay = $returnData['Message'];
		}
		
	?>
		<div class="full-screen-block-popup-vnpay"></div>
		<div class="popup-status-vnpay">

			<div class="title"> <?php echo $text_stt_vnpay; ?> </div>
			<div class="item"><span>Mã đơn hàng: </span>DH<?php echo str_pad($order -> id, 8 , "0", STR_PAD_LEFT);?></div>
			<div class="item"><span>Thời gian: </span><?php echo date('d/m/Y H:i:s',strtotime($order -> created_time)); ?></div>
			<div class="item"><span>Số tiền: </span><?php echo format_money($order->total_after_discount); ?></div>
		</div>
	<?php } ?>
</div>

