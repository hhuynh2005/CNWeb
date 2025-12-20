<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IssueController;

// Đường dẫn hiển thị danh sách đồ án (trang chủ)

Route::get('/', [IssueController::class, 'index'])->name('issues.index');

// Đường dẫn để tạo mới một đồ án (hiển thị form thêm mới)
Route::get('/issue/create', [IssueController::class, 'create'])->name('issues.create');

// Đường dẫn để lưu dữ liệu đồ án mới (thực hiện thêm mới)
Route::post('/issue', [IssueController::class, 'store'])->name('issues.store');

// Đường dẫn để hiển thị chi tiết một đồ án cụ thể (tuỳ chọn)
Route::get('/issue/{id}', [IssueController::class, 'show'])->name('issues.show');

// Đường dẫn để chỉnh sửa thông tin đồ án (hiển thị form chỉnh sửa)
Route::get('/issue/{id}/edit', [IssueController::class, 'edit'])->name('issues.edit');

// Đường dẫn để cập nhật thông tin đồ án (thực hiện cập nhật)
Route::put('/issue/{id}', [IssueController::class, 'update'])->name('issues.update');

// Đường dẫn để xóa đồ án (thực hiện xóa sau khi có modal xác nhận)
Route::delete('/issue/{id}', [IssueController::class, 'destroy'])->name('issues.destroy');
