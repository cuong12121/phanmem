<?php

session_start();
require('config.php');
require('Lib/Alepay.php');

$alepay = new Alepay($config);
$data = array();
$action = @$_REQUEST['action'];

parse_str(file_get_contents('php://input'), $params); // Lấy thông tin dữ liệu bắn vào
//var_dump($params);


$data['cancelUrl'] = URL_DEMO;
$data['amount'] = intval(preg_replace('@\D+@', '', $params['amount']));
$data['orderCode'] = date('dmY') . '_' . uniqid();
$data['currency'] = $params['currency'];
$data['orderDescription'] = $params['orderDescription'];
$data['totalItem'] = intval($params['totalItem']);
$data['checkoutType'] = 2; // Thanh toán trả góp
$data['buyerName'] = trim($params['buyerName']);
$data['buyerEmail'] = trim($params['buyerEmail']);
$data['buyerPhone'] = trim($params['phoneNumber']);
$data['buyerAddress'] = trim($params['buyerAddress']);
$data['buyerCity'] = trim($params['buyerCity']);
$data['buyerCountry'] = trim($params['buyerCountry']);
$data['paymentHours'] = 48; //48 tiếng :  Thời gian cho phép thanh toán (tính bằng giờ)

foreach ($data as $k => $v) {
    if (empty($v)) {
        $alepay->return_json("NOK", "Bắt buộc phải nhập/chọn tham số [ " . $k . " ]");
        die();
    }
}


switch ($action) {
    case 'sendOrderToAlepayInstallment':
        $result = $alepay->sendOrderToAlepay($data); // Khởi tạo
        break;
    default: $alepay->return_json("1000", "Không tồn tại hàm xử lý");
}
if (isset($result) && !empty($result->checkoutUrl)) {
    $alepay->return_json('OK', 'Thành công', $result->checkoutUrl);
} else {
    $alepay->return_json($result->errorCode, $result->errorDescription);
}

