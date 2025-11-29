<?php
$imagesDir = "Images";
$dataFile = __DIR__ . "/data/flowers.json";

// tạo folder nếu chưa có
if (!file_exists($imagesDir))
    mkdir($imagesDir, 0777, true);
if (!file_exists(dirname($dataFile)))
    mkdir(dirname($dataFile), 0777, true);

// nếu file JSON chưa có -> tạo
if (!file_exists($dataFile)) {
    file_put_contents($dataFile, json_encode([]));
}

// ============================
// HÀM XỬ LÝ JSON
// ============================
function loadFlowers($file)
{
    $json = file_get_contents($file);
    return json_decode($json, true) ?: [];
}

function saveFlowers($file, $data)
{
    file_put_contents($file, json_encode(array_values($data), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

$flowers = loadFlowers($dataFile);

// ============================
// XỬ LÝ FORM (POST REQUEST)
// ============================
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // CREATE
    if (isset($_POST['action']) && $_POST['action'] === 'create') {
        $name = trim($_POST['name']);
        $desc = trim($_POST['description']);

        // xử lý upload ảnh
        $imgName = time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imagesDir . "/" . $imgName);

        $flowers[] = [
            "id" => time(),
            "name" => $name,
            "description" => $desc,
            "image" => $imgName,
        ];

        saveFlowers($dataFile, $flowers);
        header("Location: index.php");
        exit;
    }

    // DELETE
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $id = intval($_POST['id']);

        foreach ($flowers as $k => $f) {
            if ($f['id'] == $id) {
                // xóa ảnh
                $path = $imagesDir . "/" . $f['image'];
                if (file_exists($path))
                    unlink($path);

                unset($flowers[$k]);
                break;
            }
        }

        saveFlowers($dataFile, $flowers);
        header("Location: index.php");
        exit;
    }

    // UPDATE
    if (isset($_POST['action']) && $_POST['action'] === 'update') {
        $id = intval($_POST['id']);
        $name = trim($_POST['name']);
        $desc = trim($_POST['description']);

        foreach ($flowers as &$f) {
            if ($f['id'] == $id) {
                $f['name'] = $name;
                $f['description'] = $desc;

                // nếu có upload ảnh mới
                if (!empty($_FILES['image']['name'])) {
                    $imgName = time() . "_" . basename($_FILES['image']['name']);
                    move_uploaded_file($_FILES['image']['tmp_name'], $imagesDir . "/" . $imgName);

                    // xóa ảnh cũ
                    $old = $imagesDir . "/" . $f['image'];
                    if (file_exists($old))
                        unlink($old);

                    $f['image'] = $imgName;
                }
                break;
            }
        }

        saveFlowers($dataFile, $flowers);
        header("Location: index.php");
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
    <title>Hiển thị ảnh từ thư mục</title>

    <style>
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

        /* ===== ADMIN STYLE ===== */
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
        .crud-form textarea {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 8px;
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

        /* GALLERY (khách) */
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
    </style>

</head>

<body>

    <h1>Học phần: Hiển thị ảnh từ thư mục</h1>
    <p style="text-align:center;">
        <a href="index.php">Chế độ khách</a> |
        <a href="index.php?admin=1">Chế độ quản trị (CRUD)</a>
    </p>

    <?php if (!$isAdmin): ?>

        <!-- ============================
     CHẾ ĐỘ KHÁCH: HIỂN THỊ GALLERY
============================ -->
        <div class="gallery">
            <?php foreach ($flowers as $f): ?>
                <div class="item">
                    <img src="<?= $imagesDir . '/' . $f['image'] ?>">
                    <h3><?= htmlspecialchars($f['name']) ?></h3>
                    <p><?= htmlspecialchars($f['description']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>

    <?php else: ?>

        <!-- ============================
     GIAO DIỆN QUẢN TRỊ CRUD
============================ -->
        <div class="admin-container">

            <h2>Quản Trị Hình Ảnh – CRUD</h2>

            <!-- FORM THÊM MỚI -->
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

            <!-- DANH SÁCH -->
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
                            <td><img class="img-thumb" src="<?= $imagesDir . '/' . $f['image'] ?>"></td>
                            <td><?= htmlspecialchars($f['name']) ?></td>
                            <td><?= htmlspecialchars($f['description']) ?></td>

                            <td>
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

</body>

</html>