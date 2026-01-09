<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Cập nhật Sản Phẩm</title>
    <style>
        body {
            padding: 40px;
            background-color: #f8f9fa;
            font-size: 1.1rem;
        }

        .form-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 3px solid #007bff;
            font-size: 2.2rem;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            font-size: 1.2rem;
            font-weight: 500;
            margin-bottom: 8px;
            display: block;
            color: #444;
        }

        .form-control {
            font-size: 1.1rem;
            padding: 12px 15px;
            height: auto;
            border: 2px solid #ddd;
            border-radius: 8px;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.3rem rgba(0, 123, 255, 0.25);
        }

        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .form-control.is-invalid:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.3rem rgba(220, 53, 69, 0.25);
        }

        .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 1rem;
            margin-top: 5px;
        }

        .btn-back {
            margin-right: 15px;
            padding: 12px 25px;
            font-size: 1.1rem;
        }

        .btn-container {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #eee;
        }

        .btn-primary {
            padding: 12px 30px;
            font-size: 1.1rem;
            font-weight: 500;
        }

        select.form-control {
            height: 52px;
        }

        .alert-danger {
            border-radius: 8px;
            font-size: 1.1rem;
            padding: 15px;
            margin-bottom: 25px;
        }

        .alert-danger ul {
            margin-bottom: 0;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h1>Cập nhật Sinh Viên</h1>

        <!-- Hiển thị lỗi validate tổng hợp -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Có lỗi xảy ra!</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('students.update', $student->id) }}" method="POST" novalidate>
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="full_name">Họ tên *</label>
                <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror"
                    value="{{ old('full_name', $student->full_name) }}" required>
                @error('full_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="student_id">Mã học sinh</label>
                <input type="text" name="student_id" class="form-control @error('student_id') is-invalid @enderror"
                    value="{{ old('student_id', $student->student_id) }}">
                @error('student_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" name="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email', $student->email) }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="school_id" class="form-label">Trường học</label>
                <select class="form-control @error('school_id') is-invalid @enderror" id="school_id" name="school_id">
                    <option value="">-- Chọn trường học --</option>
                    @foreach($school as $s)
                        <option value="{{ $s->id }}" {{ old('school_id', $student->id) == $s->id ? 'selected' : '' }}>
                            {{ $s->name }}
                        </option>
                    @endforeach
                </select>
                @error('school_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="btn-container">
                <a href="{{ route('students.index') }}" class="btn btn-secondary btn-back">
                    ← Quay lại danh sách
                </a>
                <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Tự động focus vào ô đầu tiên khi trang load
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelector('input[name="name"]').focus();

            // Xóa class is-invalid khi người dùng bắt đầu nhập
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('input', function () {
                    if (this.classList.contains('is-invalid')) {
                        this.classList.remove('is-invalid');
                    }
                });
            });
        });
    </script>
</body>

</html>