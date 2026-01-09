<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Thêm Sản Phẩm</title>
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
        <h1 class="form-header">Thêm Sản Phẩm Mới</h1>
        
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
        <form action="{{ route('products.store') }}" method="POST" novalidate>
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">Tên sản phẩm *</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" 
                       value="{{ old('name') }}" 
                       placeholder="Nhập tên sản phẩm">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Mô tả</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" 
                          rows="4" placeholder="Nhập mô tả sản phẩm">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="price" class="form-label">Giá (VND) *</label>
                <input type="text" class="form-control @error('price') is-invalid @enderror" 
                       id="price" name="price" 
                       value="{{ old('price') }}" 
                       placeholder="Nhập giá sản phẩm (ví dụ: 100000.00)">
                <small class="text-muted">Ví dụ: 100000.00</small>
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="store_id" class="form-label">Cửa hàng *</label>
                <select class="form-control @error('store_id') is-invalid @enderror" 
                        id="store_id" name="store_id">
                    <option value="">-- Chọn cửa hàng --</option>
                    @foreach($stores as $store)
                        <option value="{{ $store->id }}" {{ old('store_id') == $store->id ? 'selected' : '' }}>
                            {{ $store->name }}
                        </option>
                    @endforeach
                </select>
                @error('store_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                    ← Quay lại danh sách
                </a>
                <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // CHỈ CẦN PHẦN NÀY ĐỂ XÓA LỖI KHI NGƯỜI DÙNG NHẬP
        document.addEventListener('DOMContentLoaded', function() {
            // Tự động focus vào ô đầu tiên
            document.getElementById('name').focus();
            
            // Xóa class is-invalid khi người dùng bắt đầu nhập
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('input', function() {
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