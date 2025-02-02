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

// Truy vấn danh sách ID cần xóa
$sql = "SELECT id FROM fs_order_uploads_page_pdf WHERE record_id  < '1472963'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = $row["id"];
        $deleteSQL = "DELETE FROM fs_order_uploads_page_pdf WHERE id = $id";

        if ($conn->query($deleteSQL) === TRUE) {
            echo "Đã xóa ID: $id \n";
        } else {
            echo "Lỗi khi xóa ID: $id - " . $conn->error . "<br>";
        }
    }
} 
else{
	echo "lỗi";
}

// Đóng kết nối
$conn->close();
?>


