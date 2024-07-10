<?php

$username = "admin";
$password = "TTP_KAW2024";
$data = ["username"=>$username, "password"=>$password, "action"=>"login"]; //xem trong header phần form login header trong f12 để lấy đúng trường
// Thông tin đăng nhập


// URL đăng nhập và trang đích
$loginUrl = "https://".DOMAIN."/admin/login.php";
$targetUrl = "https://".DOMAIN."/admin/modules/jobs/job.php";
// $targetUrl = "https://dienmayai.com/admin/order/upload";

// Khởi tạo cURL session
$ch = curl_init($loginUrl);

// Thiết lập các tùy chọn cURL
curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt'); // Lưu cookie

// Thực hiện yêu cầu đăng nhập
$loginResponse = curl_exec($ch);    


// Kiểm tra đăng nhập thành công
if (curl_errno($ch)) {
    echo 'Lỗi đăng nhập: ' . curl_error($ch);
} else {
    // Thiết lập tùy chọn cho yêu cầu đến trang đích
    curl_setopt($ch, CURLOPT_URL, $targetUrl);
    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt'); // Gửi cookie đã lưu

    // Thực hiện yêu cầu đến trang đích
    $targetResponse = curl_exec($ch);

    // Xử lý kết quả trả về từ trang đích
    if (curl_errno($ch)) {
        echo 'Lỗi truy cập trang đích: ' . curl_error($ch);
    } else {
        var_dump($targetResponse); // Hoặc xử lý kết quả theo ý muốn
    }
   
}

// Đóng cURL session
curl_close($ch);