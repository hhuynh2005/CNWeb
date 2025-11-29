<?php
$file_path = 'D:\xampp\htdocs\cse485\BTTH01\65HTTT_Danh_sach_diem_danh.csv';

$csv_data = [];
$header = [];
$is_first_row = true;

if (!file_exists($file_path)) {
    die("Lỗi: Tệp CSV không tồn tại tại đường dẫn: " . htmlspecialchars($file_path));
}

// Mở tệp CSV để đọc
if (($handle = fopen($file_path, "r")) !== FALSE) {
    while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
        // Dòng đầu tiên là tiêu đề (header)
        if ($is_first_row) {
            $header = $row;
            $is_first_row = false;
        } else {
            // Các dòng còn lại là dữ liệu
            $csv_data[] = $row;
        }
    }
    fclose($handle);
} else {
    die("Lỗi: Không thể mở tệp CSV để đọc.");
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Hiển Thị Nội Dung Tệp CSV</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            color: #007bff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>

    <h1>📋 Dữ Liệu Tài Khoản Đọc Từ Tệp CSV</h1>
    <table>
        <thead>
            <tr>
                <?php foreach ($header as $col_name): ?>
                    <th><?php echo htmlspecialchars($col_name); ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($csv_data as $row): ?>
                <tr>
                    <?php foreach ($row as $cell): ?>
                        <td><?php echo htmlspecialchars($cell); ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>

</html>