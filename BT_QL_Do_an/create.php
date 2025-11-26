<?php
// Xử lý form khi submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $ten_de_tai = $_POST['ten_de_tai'];
    $ten_sinh_vien = $_POST['ten_sinh_vien'];
    $mssv = $_POST['mssv'];
    $giang_vien_hd = $_POST['giang_vien_hd'];
    $nam_hoc = $_POST['nam_hoc'];
    $trang_thai = $_POST['trang_thai'];

    // Đọc file data.php để lấy mảng hiện tại
    require 'data.php';

    // Tạo ID mới (tăng dần từ ID lớn nhất)
    $new_id = 1;
    if (!empty($do_an_list)) {
        $ids = array_column($do_an_list, 'id');
        $new_id = max($ids) + 1;
    }

    // Tạo bản ghi mới
    $new_do_an = [
        'id' => $new_id,
        'ten_de_tai' => $ten_de_tai,
        'ten_sinh_vien' => $ten_sinh_vien,
        'mssv' => $mssv,
        'giang_vien_hd' => $giang_vien_hd,
        'nam_hoc' => $nam_hoc,
        'trang_thai' => $trang_thai,
        'created_at' => date('Y-m-d H:i:s')
    ];

    // Thêm vào mảng
    $do_an_list[] = $new_do_an;

    // Cập nhật file data.php
    $data_content = "<?php\n\$do_an_list = " . var_export($do_an_list, true) . ";\n?>";
    file_put_contents('data.php', $data_content);

    // Chuyển hướng về trang chủ với thông báo thành công
    header('Location: index.php?success=created');
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm đồ án mới</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="navbar">
        <div>Quản lý Đồ án Tốt nghiệp</div>
        <div>
            <a href="index.php">Dashboard</a>
            <a href="create.php" class="btn btn-primary">+ Thêm đồ án</a>
        </div>
    </div>

    <div class="container">
        <h1>Thêm đồ án mới</h1>

        <form method="POST" action="create.php" class="form">
            <div class="form-group">
                <label for="ten_de_tai">Tên đề tài:</label>
                <input type="text" id="ten_de_tai" name="ten_de_tai" required>
            </div>

            <div class="form-group">
                <label for="ten_sinh_vien">Tên sinh viên:</label>
                <input type="text" id="ten_sinh_vien" name="ten_sinh_vien" required>
            </div>

            <div class="form-group">
                <label for="mssv">MSSV:</label>
                <input type="text" id="mssv" name="mssv" required>
            </div>

            <div class="form-group">
                <label for="giang_vien_hd">Giảng viên hướng dẫn:</label>
                <input type="text" id="giang_vien_hd" name="giang_vien_hd" required>
            </div>

            <div class="form-group">
                <label for="nam_hoc">Năm học:</label>
                <input type="text" id="nam_hoc" name="nam_hoc" value="2024-2025" required>
            </div>

            <div class="form-group">
                <label for="trang_thai">Trạng thái:</label>
                <select id="trang_thai" name="trang_thai" required>
                    <option value="Đang thực hiện">Đang thực hiện</option>
                    <option value="Hoàn thành">Hoàn thành</option>
                    <option value="Tạm dừng">Tạm dừng</option>
                    <option value="Chưa bắt đầu">Chưa bắt đầu</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Thêm đồ án</button>
                <a href="index.php" class="btn btn-secondary">Hủy</a>
            </div>
        </form>
    </div>
</body>

</html>