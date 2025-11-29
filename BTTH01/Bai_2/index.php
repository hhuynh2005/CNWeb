<?php
$file_path = 'D:\xampp\htdocs\cse485\BTTH01\Quiz.txt';


$lines = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);


$question_number = 1;
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Bài Thi Trắc Nghiệm - CSE485</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
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
            border-radius: 5px;
        }
    </style>
</head>

<body>

    <h1>Bài Thi Trắc Nghiệm</h1>
    <form action="process_quiz.php" method="POST">
        <?php
        for ($i = 0; $i < count($lines); $i += 6) {

            if ($i + 5 < count($lines)) {
                $question_text = $lines[$i];
                $option_A = $lines[$i + 1];
                $option_B = $lines[$i + 2];
                $option_C = $lines[$i + 3];
                $option_D = $lines[$i + 4];

                echo '<div class="question-block">';
                echo '<div class="question-title">Câu ' . $question_number . ': ' . htmlspecialchars($question_text) . '</div>';


                $options = [$option_A, $option_B, $option_C, $option_D];
                $option_letters = ['A', 'B', 'C', 'D'];

                foreach ($options as $key => $option_text) {
                    $letter = $option_letters[$key];
                    // Tên của radio button là 'q' + số thứ tự câu hỏi để nhóm các lựa chọn lại
                    echo '<div class="option">';
                    echo '<label>';
                    echo '<input type="radio" name="q' . $question_number . '" value="' . $letter . '">';
                    echo ' ' . htmlspecialchars(substr($option_text, 3));
                    echo '</label>';
                    echo '</div>';
                }

                echo '</div>';
                $question_number++;
            }
        }
        ?>
        <input type="submit" value="Hoàn thành bài thi">
    </form>

</body>

</html>