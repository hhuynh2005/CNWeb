<?php

$host = 'localhost';
$dbname = 'test';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Lỗi kết nối CSDL: " . $e->getMessage());
}

// Khởi tạo biến
$action = $_REQUEST['action'] ?? 'display';
$message = '';
$error = false;

// Xử lý hiển thị form upload
if ($action === 'upload_form') {
    // Chỉ hiển thị form, không xử lý
}

// ===============================================
// CHẾ ĐỘ 1: XỬ LÝ UPLOAD FILE VÀ LOAD DATA (INSERT)
// ===============================================
if ($action === 'upload_process' && $_SERVER["REQUEST_METHOD"] === "POST") {

    // 1. XỬ LÝ FILE UPLOAD
    if (isset($_FILES['quizFile']) && $_FILES['quizFile']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/temp_uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = 'temp_quiz_' . time() . '.txt';
        $file_path_uploaded = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['quizFile']['tmp_name'], $file_path_uploaded)) {

            // 2. LOGIC LOAD DATA TỪ FILE VỪA UPLOAD
            $lines = file($file_path_uploaded, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $total_inserted = 0;

            $sql = "INSERT INTO quiz_questions (question_text, option_a, option_b, option_c, option_d, correct_answer) 
                     VALUES (:q_text, :opt_a, :opt_b, :opt_c, :opt_d, :c_answer)";
            $stmt = $conn->prepare($sql);

            $conn->exec("TRUNCATE TABLE quiz_questions");
            $message .= "Đã xóa dữ liệu cũ trong bảng quiz_questions.<br>";

            // LẶP VÀ CHÈN DỮ LIỆU
            for ($i = 0; $i < count($lines); $i += 6) {
                if ($i + 5 < count($lines)) {
                    $q_text = trim($lines[$i]);
                    $opt_a = trim(substr($lines[$i + 1], 3));
                    $opt_b = trim(substr($lines[$i + 2], 3));
                    $opt_c = trim(substr($lines[$i + 3], 3));
                    $opt_d = trim(substr($lines[$i + 4], 3));
                    $answer_line = trim($lines[$i + 5]);
                    $c_answer = trim(strtoupper(str_replace('ANSWER:', '', $answer_line)));

                    try {
                        $stmt->execute([
                            ':q_text' => $q_text,
                            ':opt_a' => $opt_a,
                            ':opt_b' => $opt_b,
                            ':opt_c' => $opt_c,
                            ':opt_d' => $opt_d,
                            ':c_answer' => $c_answer
                        ]);
                        $total_inserted++;
                    } catch (PDOException $e) {
                        $error = true;
                        $message .= "Lỗi chèn câu hỏi: " . $e->getMessage() . "<br>";
                    }
                }
            }

            // 3. HOÀN TẤT
            $message = $error ? $message : "✅ Hoàn tất tải dữ liệu! Đã chèn {$total_inserted} câu hỏi.";
            unlink($file_path_uploaded);

            header("Location: bai_2_index.php?load_success=" . ($error ? 'false' : 'true'));
            exit;

        } else {
            $message = "Lỗi: Không thể di chuyển tệp đã tải lên.";
            $error = true;
        }
    } else {
        $message = "Lỗi: Vui lòng chọn tệp Quiz.txt hợp lệ.";
        $error = true;
    }
}

// ===============================================
// CHẾ ĐỘ 2: DISPLAY (READ dữ liệu từ CSDL)
// ===============================================
$questions = [];
if ($action === 'display' || isset($_GET['load_success'])) {
    try {
        $stmt = $conn->prepare("SELECT * FROM quiz_questions ORDER BY id ASC");
        $stmt->execute();
        $questions = $stmt->fetchAll();
    } catch (PDOException $e) {
        die("Lỗi truy vấn CSDL: " . $e->getMessage());
    }
}

// Đóng kết nối
$conn = null;
$question_number = 1;
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Bài Thi Trắc Nghiệm</title>
    <style>
        /* Giữ nguyên style của bạn */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #f4f4f4;
        }

        .quiz-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
        }

        .question-block {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .question-title {
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .option label {
            display: block;
            margin: 5px 0;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        .answer-hint {
            color: green;
            font-size: 0.9em;
            margin-top: 5px;
            font-weight: bold;
        }

        .controls {
            margin-bottom: 20px;
        }

        .message-success {
            color: green;
            font-weight: bold;
        }

        .message-error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="quiz-container">
        <h1>Bài Thi Trắc Nghiệm (Đọc từ CSDL)</h1>

        <div class="controls">
            <a href="bai_2_index.php?action=upload_form" style="color: red;">[Chế độ Quản trị: Upload Quiz.txt mới]</a>
            <?php if ($action !== 'display'): ?>
                | <a href="bai_2_index.php?action=display" style="color: blue;">[Quay lại trang Bài Thi]</a>
            <?php endif; ?>
        </div>

        <?php if (isset($_GET['load_success'])): ?>
            <p class="<?= $_GET['load_success'] == 'true' ? 'message-success' : 'message-error' ?>">
                <?= $_GET['load_success'] == 'true' ? '✅ Tải dữ liệu thành công!' : '❌ Lỗi tải dữ liệu!' ?>
            </p>
        <?php endif; ?>

        <?php if ($action === 'upload_form'): ?>
            <h2>Upload Tệp Quiz.txt</h2>
            <?php if (!empty($message)): ?>
                <p class="<?= $error ? 'message-error' : 'message-success' ?>"><?= $message ?></p>
            <?php endif; ?>
            <form method="POST" enctype="multipart/form-data" action="bai_2_index.php?action=upload_process">
                <label for="quizFile">Chọn tệp Quiz.txt:</label>
                <input type="file" name="quizFile" id="quizFile" accept=".txt" required><br><br>
                <input type="submit" value="Tải lên và Chèn vào CSDL">
            </form>
        <?php else: ?>
            <?php if (empty($questions)): ?>
                <p>Không có câu hỏi nào trong CSDL. Vui lòng bấm vào liên kết Quản trị để tải dữ liệu.</p>
            <?php else: ?>
                <form action="process_quiz.php" method="POST">
                    <?php foreach ($questions as $q): ?>
                        <div class="question-block">
                            <div class="question-title">Câu <?= $question_number ?>: <?= htmlspecialchars($q['question_text']) ?>
                            </div>
                            <?php
                            $options = ['A' => $q['option_a'], 'B' => $q['option_b'], 'C' => $q['option_c'], 'D' => $q['option_d']];
                            foreach ($options as $letter => $option_text): ?>
                                <div class="option">
                                    <label>
                                        <input type="radio" name="q<?= $q['id'] ?>" value="<?= $letter ?>">
                                        <?= $letter ?>. <?= htmlspecialchars($option_text) ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                            <div class="answer-hint">Đáp án đúng: <?= htmlspecialchars($q['correct_answer']) ?></div>
                        </div>
                        <?php $question_number++; ?>
                    <?php endforeach; ?>
                    <input type="submit" value="Hoàn thành bài thi">
                </form>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>

</html>