<?php

// Kết nối MySQL
$servername = "localhost";
$username = "sql_dienmay_bak";  // Thay bằng username thực tế
$password = "bfsHT6wL4GBJnAYA";  // Thay bằng password thực tế
$dbname = "sql_dienmay_bak";  // Thay bằng tên database của bạn

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Câu lệnh SQL
$sql = "DELETE FROM fs_order_uploads_detail WHERE created_time <= '2024-08-30'";

// Thực thi truy vấn
if ($conn->query($sql) === TRUE) {
    echo "Xóa dữ liệu thành công!";
} else {
    echo "Lỗi: " . $conn->error;
}

// Đóng kết nối
$conn->close();
?>
