<?php
// Tải file cấu hình và thiết lập biến $conn
require_once 'db_connect.php';

$fileSystemDir = "D:\\xampp\\htdocs\\cse485\\BTTH01\\Bai_1\\Images";

$webPath = "/cse485/BTTH01/Bai_1/Images";

if (!file_exists($fileSystemDir)) {
    mkdir($fileSystemDir, 0777, true);
}


// HÀM XỬ LÝ READ (Đọc dữ liệu từ CSDL)
// ============================
function loadFlowers($conn)
{
    $stmt = $conn->prepare("SELECT * FROM flowers ORDER BY id DESC");
    $stmt->execute();
    return $stmt->fetchAll();
}

$flowers = loadFlowers($conn);


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // CREATE (Thêm mới)
    if (isset($_POST['action']) && $_POST['action'] === 'create') {
        $name = trim($_POST['name']);
        $desc = trim($_POST['description']);

        // xử lý upload ảnh
        if (empty($_FILES['image']['name'])) {
            die("Lỗi: Vui lòng chọn ảnh.");
        }
        $imgName = time() . "_" . basename($_FILES['image']['name']);

        move_uploaded_file($_FILES['image']['tmp_name'], $fileSystemDir . "/" . $imgName);

        try {
            // Chèn dữ liệu vào CSDL
            $sql = "INSERT INTO flowers (name, description, image_path) VALUES (:name, :desc, :img)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'name' => $name,
                'desc' => $desc,
                'img' => $imgName
            ]);

            header("Location: index.php?admin=1");
            exit;

        } catch (PDOException $e) {
            die("Lỗi khi thêm mới: " . $e->getMessage());
        }
    }

    // DELETE (Xóa)
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $id = intval($_POST['id']);

        // 1. Tìm đường dẫn ảnh cũ để xóa file
        $stmt = $conn->prepare("SELECT image_path FROM flowers WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $flowerToDelete = $stmt->fetch();

        if ($flowerToDelete) {
            // SỬ DỤNG $fileSystemDir để xóa file
            $path = $fileSystemDir . "/" . $flowerToDelete['image_path'];
            if (file_exists($path)) {
                unlink($path);
            }

            // 2. Xóa record trong CSDL
            $sql = "DELETE FROM flowers WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute(['id' => $id]);
        }

        header("Location: index.php?admin=1");
        exit;
    }

    // UPDATE (Chỉnh sửa)
    if (isset($_POST['action']) && $_POST['action'] === 'update') {
        $id = intval($_POST['id']);
        $name = trim($_POST['name']);
        $desc = trim($_POST['description']);
        $imgName = null;
        $updateImage = false;

        // Xử lý ảnh mới (nếu có)
        if (!empty($_FILES['image']['name'])) {
            $updateImage = true;
            $imgName = time() . "_" . basename($_FILES['image']['name']);
            // SỬ DỤNG $fileSystemDir để lưu file
            move_uploaded_file($_FILES['image']['tmp_name'], $fileSystemDir . "/" . $imgName);

            // Lấy đường dẫn ảnh cũ để xóa
            $stmt = $conn->prepare("SELECT image_path FROM flowers WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $oldFlower = $stmt->fetch();

            if ($oldFlower) {
                // SỬ DỤNG $fileSystemDir để xóa file
                $oldPath = $fileSystemDir . "/" . $oldFlower['image_path'];
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
        }

        // Cập nhật CSDL
        if ($updateImage) {
            $sql = "UPDATE flowers SET name = :name, description = :desc, image_path = :img WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'name' => $name,
                'desc' => $desc,
                'img' => $imgName,
                'id' => $id
            ]);
        } else {
            $sql = "UPDATE flowers SET name = :name, description = :desc WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'name' => $name,
                'desc' => $desc,
                'id' => $id
            ]);
        }

        header("Location: index.php?admin=1");
        exit;
    }
}

// ============================
// KIỂM TRA CHẾ ĐỘ ADMIN
// ============================
$isAdmin = isset($_GET['admin']) && $_GET['admin'] == 1;

?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Bài 1: Hiển thị Ảnh từ CSDL (Nâng cấp)</title>

    <style>
        /* ... CSS giữ nguyên ... */
        body {
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            padding: 20px;
        }

        h1 {
            text-align: center;
            font-size: 32px;
            margin-bottom: 20px;
        }

        a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        .admin-container {
            width: 90%;
            max-width: 850px;
            margin: 0 auto;
        }

        .crud-form,
        .crud-table {
            background: #fff;
            padding: 20px;
            margin-top: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        }

        .crud-form input,
        .crud-form textarea,
        #editModal input,
        #editModal textarea {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
        }

        .btn {
            padding: 10px 16px;
            border-radius: 8px;
            margin-top: 12px;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background: #007bff;
            color: white;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table th {
            background: #eee;
            padding: 12px;
        }

        table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .img-thumb {
            width: 70px;
            border-radius: 6px;
        }

        .gallery {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-top: 35px;
        }

        .item {
            background: white;
            padding: 12px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .item img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 10px;
        }

        .item h3 {
            margin: 10px 0 5px;
        }

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 100;
        }

        .modal-content {
            background: white;
            margin: 10% auto;
            padding: 25px;
            border-radius: 12px;
            max-width: 500px;
        }
    </style>

</head>

<body>

    <h1>Bài 1 (Nâng cấp): Quản lý Hoa với CSDL MySQL</h1>
    <p style="text-align:center;">
        <a href="bai_1_index.php">Chế độ khách</a> |
        <a href="bai_1_index.php?admin=1">Chế độ quản trị (CRUD)</a>

    </p>

    <?php if (!$isAdmin): ?>

        <div class="gallery">
            <?php
            foreach ($flowers as $f):
                ?>
                <div class="item">
                    <img src="<?= $webPath . '/' . $f['image_path'] ?>">
                    <h3><?= htmlspecialchars($f['name']) ?></h3>
                    <p><?= htmlspecialchars($f['description']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>

    <?php else: ?>

        <div class="admin-container">

            <h2>Quản Trị Hình Ảnh – CRUD</h2>

            <div class="crud-form">
                <h3>Thêm Hình Ảnh</h3>
                <form method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="create">
                    <label>Tên hoa:</label>
                    <input type="text" name="name" required>
                    <label>Mô tả:</label>
                    <textarea name="description" required rows="3"></textarea>
                    <label>Ảnh:</label>
                    <input type="file" name="image" accept="image/*" required>
                    <button class="btn btn-primary" type="submit">Thêm mới</button>
                </form>
            </div>

            <div class="crud-table">
                <h3>Danh sách ảnh</h3>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Ảnh</th>
                        <th>Tên</th>
                        <th>Mô tả</th>
                        <th>Hành động</th>
                    </tr>

                    <?php foreach ($flowers as $f): ?>
                        <tr>
                            <td><?= $f['id'] ?></td>
                            <td><img class="img-thumb" src="<?= $webPath . '/' . $f['image_path'] ?>"></td>
                            <td><?= htmlspecialchars($f['name']) ?></td>
                            <td><?= htmlspecialchars($f['description']) ?></td>
                            <td>
                                <button class="btn btn-primary" onclick="openEditModal(
                                                <?= $f['id'] ?>, 
                                                '<?= htmlspecialchars($f['name']) ?>', 
                                                '<?= htmlspecialchars($f['description']) ?>',
                                                '<?= $webPath . '/' . $f['image_path'] ?>'
                                            )">
                                    Sửa
                                </button>
                                <form method="post" style="display:inline-block;" onsubmit="return confirm('Xóa ảnh này?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $f['id'] ?>">
                                    <button class="btn btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>

    <?php endif; ?>

    <div id="editModal" class="modal-overlay">
        <div class="modal-content">
            <h3>Chỉnh sửa thông tin hoa</h3>
            <form id="editForm" method="post" enctype="multipart/form-data">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" id="edit-id">
                <label>Tên hoa:</label>
                <input type="text" name="name" id="edit-name" required>
                <label>Mô tả:</label>
                <textarea name="description" id="edit-description" required rows="3"></textarea>
                <label>Ảnh hiện tại:</label>
                <p><img id="current-image" src="" style="width:100px; border-radius:8px;"></p>
                <label>Chọn ảnh mới (Bỏ qua nếu không thay đổi):</label>
                <input type="file" name="image" accept="image/*">
                <button class="btn btn-primary" type="submit">Lưu thay đổi</button>
                <button class="btn" type="button"
                    onclick="document.getElementById('editModal').style.display='none'">Hủy</button>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, name, description, imagePath) {
            // 1. Hiển thị Modal
            document.getElementById('editModal').style.display = 'block';

            // 2. Điền dữ liệu vào form
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-description').value = description;
            // imagePath hiện tại đã là đường dẫn Web (URL) chính xác
            document.getElementById('current-image').src = imagePath;
        }
    </script>

</body>

</html>