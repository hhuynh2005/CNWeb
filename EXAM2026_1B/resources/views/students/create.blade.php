<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Thêm Học Sinh</title>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container-form {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .form-header {
            text-align: center;
            margin-bottom: 30px;
            color: #343a40;
            border-bottom: 2px solid #0d6efd;
            padding-bottom: 15px;
        }

        .form-label {
            font-weight: 500;
            color: #495057;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .form-control.is-invalid:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }

        .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 0.95rem;
            margin-top: 5px;
        }

        .btn-primary {
            padding: 10px 30px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .alert-danger {
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 25px;
        }

        .alert-danger ul {
            margin-bottom: 0;
        }

        .text-muted {
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <div class="container-form">
        <h1 class="form-header">Thêm Học Sinh Mới</h1>

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

        <!-- THÊM NOVALIDATE VÀO ĐÂY -->
        <form action="{{ route('students.store') }}" method="POST" novalidate>
            @csrf

            <div class="form-group">
                <label for="full_name" class="form-label">Họ và tên *</label>
                <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="full_name" name="full_name"
                    value="{{ old('full_name') }}" placeholder="Nhập họ tên học sinh">
                @error('full_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="student_id" class="form-label">Mã học sinh *</label>
                <input type="text" class="form-control @error('student_id') is-invalid @enderror" id="student_id" name="student_id"
                    value="{{ old('student_id') }}" placeholder="Nhập mã học sinh">
                @error('student_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

             <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                    value="{{ old('email') }}" placeholder="Nhập Email học sinh">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="phone" class="form-label">Số điện thoại</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone"
                    value="{{ old('phone') }}" placeholder="Nhập Phone học sinh">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
           

            <div class="form-group">
                <label for="school_id" class="form-label">Trường học</label>
                <select class="form-control @error('school_id') is-invalid @enderror" id="school_id" name="school_id">
                    <option value="">-- Chọn trường học --</option>
                    @foreach($schools as $s)
                        <option value="{{ $s->id }}" {{ old('school_id') == $s->id ? 'selected' : '' }}>
                            {{ $s->name }}
                        </option>
                    @endforeach
                </select>
                @error('school_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('students.index') }}" class="btn btn-secondary">
                    ← Quay lại danh sách
                </a>
                <button type="submit" class="btn btn-primary">Thêm học sinh</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // CHỈ CẦN PHẦN NÀY ĐỂ XÓA LỖI KHI NGƯỜI DÙNG NHẬP
        document.addEventListener('DOMContentLoaded', function () {
            // Tự động focus vào ô đầu tiên
            document.getElementById('full_name').focus();

            // Xóa class is-invalid khi người dùng bắt đầu nhập
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('input', function () {
                    if (this.classList.contains('is-invalid')) {
                        this.classList.remove('is-invalid');
                        const errorDiv = this.parentNode.querySelector('.invalid-feedback');
                        if (errorDiv) {
                            errorDiv.remove();
                        }
                    }
                });
            });
        });

        // KHÔNG CẦN validation client-side vì đã có Laravel validation
    </script>
</body>

</html>