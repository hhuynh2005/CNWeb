<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Thêm vấn đề mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Thêm mới báo cáo sự cố</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('issues.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="computer_id" class="form-label font-weight-bold">Tên máy tính</label> [cite: 4]
                        <select name="computer_id" class="form-select" required>
                            @foreach($computers as $computer)
                                <option value="{{ $computer->id }}">{{ $computer->computer_name }} - {{ $computer->model }}
                                </option> [cite: 4, 5]
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="reported_by" class="form-label">Người báo cáo sự cố</label> [cite: 11]
                        <input type="text" name="reported_by" class="form-control" placeholder="Tên người báo cáo">
                        [cite: 11]
                    </div>
                    <div class="mb-3">
                        <label for="reported_date" class="form-label">Thời gian báo cáo</label> [cite: 12]
                        <input type="datetime-local" name="reported_date" class="form-control" required> [cite: 12]
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="urgency" class="form-label">Mức độ sự cố</label> [cite: 14]
                            <select name="urgency" class="form-select" required>
                                <option value="Low">Low</option> [cite: 14]
                                <option value="Medium">Medium</option> [cite: 14]
                                <option value="High">High</option> [cite: 14]
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Trạng thái hiện tại</label> [cite: 15]
                            <select name="status" class="form-select" required>
                                <option value="Open">Open</option> [cite: 15]
                                <option value="In Progress">In Progress</option> [cite: 15]
                                <option value="Resolved">Resolved</option> [cite: 15]
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả chi tiết vấn đề</label> [cite: 13]
                        <textarea name="description" class="form-control" rows="3" required></textarea> [cite: 13]
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('issues.index') }}" class="btn btn-secondary">Quay lại</a>
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>