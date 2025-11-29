<?php

// ĐỊNH NGHĨA THÔNG SỐ KẾT NỐI (Sử dụng thông tin mặc định của XAMPP)
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'test');

try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";

    // Tạo đối tượng PDO
    $conn = new PDO($dsn, DB_USER, DB_PASS);

    // Thiết lập cấu hình kết nối
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Lỗi kết nối CSDL: " . $e->getMessage());
}
?>