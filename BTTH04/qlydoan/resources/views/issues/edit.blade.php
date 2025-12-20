<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cập nhật vấn đề</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-warning">
                <h3 class="mb-0">Cập nhật thông tin sự cố</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('issues.update', $issue->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="computer_id" class="form-label font-weight-bold">Tên máy tính</label> [cite: 4]
                        <select name="computer_id" class="form-select" required>
                            @foreach($computers as $computer)
                                <option value="{{ $computer->id }}" {{ $issue->computer_id == $computer->id ? 'selected' : '' }}>
                                    {{ $computer->computer_name }} - {{ $computer->model }} [cite: 4, 5]
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="reported_by" class="form-label">Người báo cáo</label> [cite: 11]
                        <input type="text" name="reported_by" class="form-control" value="{{ $issue->reported_by }}">
                        [cite: 11]
                    </div>
                    <div class="mb-3">
                        <label for="reported_date" class="form-label">Thời gian báo cáo</label> [cite: 12]
                        <input type="datetime-local" name="reported_date" class="form-control"
                            value="{{ date('Y-m-d\TH:i', strtotime($issue->reported_date)) }}" required> [cite: 12]
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="urgency" class="form-label">Mức độ sự cố</label> [cite: 14]
                            <select name="urgency" class="form-select" required>
                                <option value="Low" {{ $issue->urgency == 'Low' ? 'selected' : '' }}>Low</option> [cite:
                                14]
                                <option value="Medium" {{ $issue->urgency == 'Medium' ? 'selected' : '' }}>Medium</option>
                                [cite: 14]
                                <option value="High" {{ $issue->urgency == 'High' ? 'selected' : '' }}>High</option>
                                [cite: 14]
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Trạng thái</label> [cite: 15]
                            <select name="status" class="form-select" required>
                                <option value="Open" {{ $issue->status == 'Open' ? 'selected' : '' }}>Open</option> [cite:
                                15]
                                <option value="In Progress" {{ $issue->status == 'In Progress' ? 'selected' : '' }}>In
                                    Progress</option> [cite: 15]
                                <option value="Resolved" {{ $issue->status == 'Resolved' ? 'selected' : '' }}>Resolved
                                </option> [cite: 15]
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả chi tiết</label> [cite: 13]
                        <textarea name="description" class="form-control" rows="3"
                            required>{{ $issue->description }}</textarea> [cite: 13]
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('issues.index') }}" class="btn btn-secondary">Hủy</a>
                        <button type="submit" class="btn btn-warning">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>