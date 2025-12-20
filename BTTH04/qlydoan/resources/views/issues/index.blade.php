<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Quản lý Phòng thực hành tin học</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            color: #566787;
            background: #f5f5f5;
            font-family: 'Varela Round', sans-serif;
            font-size: 13px;
        }

        .table-responsive {
            margin: 30px 0;
        }

        .table-wrapper {
            background: #fff;
            padding: 20px 25px;
            border-radius: 3px;
            min-width: 1000px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
        }

        .table-title {
            padding-bottom: 15px;
            background: #435d7d;
            color: #fff;
            padding: 16px 30px;
            margin: -20px -25px 10px;
            border-radius: 3px 3px 0 0;
        }

        .table-title h2 {
            margin: 5px 0 0;
            font-size: 24px;
        }

        table.table tr th,
        table.table tr td {
            border-color: #e9e9e9;
            padding: 12px 15px;
            vertical-align: middle;
        }

        .pagination {
            float: right;
            margin: 0 0 5px;
        }
    </style>
</head>

<body>
    <div class="container-xl">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2>Quản lý <b>Vấn đề Phòng máy</b></h2>
                        </div>
                        <div class="col-sm-6 text-end">
                            <a href="{{ route('issues.create') }}" class="btn btn-success">
                                <i class="material-icons align-middle">&#xE147;</i> <span>Thêm vấn đề mới</span>
                            </a>
                        </div>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Mã vấn đề</th>
                            <th>Tên máy tính</th>
                            <th>Tên phiên bản</th>
                            <th>Người báo cáo</th>
                            <th>Thời gian báo cáo</th>
                            <th>Mức độ</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($issues as $issue)
                            <tr>
                                <td>{{ $issue->id }}</td>
                                <td>{{ $issue->computer->computer_name }}</td>
                                <td>{{ $issue->computer->model }}</td>
                                <td>{{ $issue->reported_by }}</td>
                                <td>{{ \Carbon\Carbon::parse($issue->reported_date)->format('d/m/Y H:i') }}</td>
                                <td>
                                    <span
                                        class="badge {{ $issue->urgency == 'High' ? 'bg-danger' : ($issue->urgency == 'Medium' ? 'bg-warning' : 'bg-info') }}">
                                        {{ $issue->urgency }}
                                    </span>
                                </td>
                                <td>
                                    @if($issue->status == 'Open') <span class="text-primary">Mở</span>
                                    @elseif($issue->status == 'In Progress') <span class="text-warning">Đang xử lý</span>
                                    @else <span class="text-success">Đã giải quyết</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('issues.edit', $issue->id) }}" class="text-warning me-2">
                                        <i class="material-icons" title="Sửa">&#xE254;</i>
                                    </a>
                                    <button type="button" class="btn btn-link p-0 text-danger border-0"
                                        data-bs-toggle="modal" data-bs-target="#deleteModal{{ $issue->id }}">
                                        <i class="material-icons" title="Xóa">&#xE872;</i>
                                    </button>

                                    <div class="modal fade" id="deleteModal{{ $issue->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Xác nhận xóa</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Bạn có chắc chắn muốn xóa vấn đề báo cáo mã số
                                                    <strong>{{ $issue->id }}</strong> không?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Hủy</button>
                                                    <form action="{{ route('issues.destroy', $issue->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Xóa</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {{ $issues->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>