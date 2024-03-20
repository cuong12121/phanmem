<?php

session_start();
require('config.php');
require('Lib/Alepay.php');

$alepay = new Alepay($config);
$data = array();
$action = @$_REQUEST['action'];

parse_str(file_get_contents('php://input'), $params); // Lấy thông tin dữ liệu bắn vào
//var_dump($params);



// Tính phí calculateFee
$data1['amount'] = intval(preg_replace('@\D+@', '', '12000000'));
$data1['bankCode'] = 'SACOMBANK';
$data1['paymentMethod'] = 'VISA';
$data1['currencyCode'] = 'VND';

$result = $alepay->calculateFee($data1); // Khởi tạo



$data['cancelUrl'] = URL_DEMO;
$data['amount'] = intval(preg_replace('@\D+@', '', '12000000'));
$data['orderCode'] = date('dmY') . '_' . uniqid();
$data['currency'] = 'VND';
$data['orderDescription'] = 'ádfasdf';
$data['totalItem'] = 1;
$data['checkoutType'] = 2; // Thanh toán trả góp
$data['buyerName'] = 'pham huy';
$data['buyerEmail'] = 'phamhuy@delectech.vn';
$data['buyerPhone'] = '0987654321';
$data['buyerAddress'] = 'H NOI';
$data['buyerCity'] = 'HA NOI';
$data['buyerCountry'] = "VN";
$data['paymentHours'] = 48; //48 tiếng :  Thời gian cho phép thanh toán (tính bằng giờ)

foreach ($data as $k => $v) {
    if (empty($v)) {
        $alepay->return_json("NOK", "Bắt buộc phải nhập/chọn tham số [ " . $k . " ]");
        die();
    }
}

// switch ($action) {
//     case 'sendOrderToAlepayInstallment':
        // $result = $alepay->sendOrderToAlepay($data); // Khởi tạo
    //     break;
    // default: $alepay->return_json("1000", "Không tồn tại hàm xử lý");
// }
if (isset($result) && !empty($result->checkoutUrl)) {
    $alepay->return_json('OK', 'Thành công', $result->checkoutUrl);
} else {
    $alepay->return_json($result->errorCode, $result->errorDescription);
}


// List Bank
 // $result = $alepay->getlistBank('12000000','VND'); // Khởi tạo
 // print_r($result );





