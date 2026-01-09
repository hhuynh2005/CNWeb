<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\School;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    //
    public function index()
    {
        $students = Student::with('school')->paginate(5);
        return view('students.index', compact('students'));
    }

    /**
     * Hiển thị form tạo phòng mới
     */
    public function create()
    {
        $schools = School::all();
        return view('students.create', compact('schools'));
    }

    /**
     * Lưu phòng mới vào database
     */
    public function store(Request $request)
    {
        $request->validate([
            // // Tên sản phẩm: bắt buộc, là chuỗi
            'full_name' => 'required|string',

            // // Mô tả: không bắt buộc (nullable)
            'student_id' => 'required',

            // Giá: bắt buộc, là số, lớn hơn 0
            'email' => 'required|email',
            'phone' => 'required',
            // Cửa hàng: bắt buộc, phải tồn tại trong bảng stores
            'school_id' => 'required',

        ], [
            // Custom error messages (tiếng Việt)
            'full_name.required' => 'Vui lòng nhập tên học sinh',
            'full_name.string' => 'Tên học sinh phải là chuỗi ký tự',
            'student_id.string' => 'Vui lòng nhập học sinh',
            'school_id.required' => 'Vui lòng chọn học sinh',
            'school_id.exists' => 'Học sinh phải tồn tại không tồn tại',
            'email.required' => 'Vui lòng nhập Email',
            'email.email' => 'Nhập đúng định dạng email',

        ]);

        Student::create($request->all());

        return redirect()->route('students.index')
            ->with('success', 'Thêm học sinh thành công');
    }

    /**
     * Hiển thị thông tin chi tiết phòng
     */


    /**
     * Hiển thị form chỉnh sửa phòng
     */
    public function edit($id)
    {
        // lấy số ít tránh trùng
        $student = Student::findOrFail($id);
        $school = Student::all();
        return view('students.edit', compact('student', 'school'));
    }

    /**
     * Cập nhật thông tin phòng
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            // // Tên sản phẩm: bắt buộc, là chuỗi
            'full_name' => 'required|string',

            // // Mô tả: không bắt buộc (nullable)
            'student_id' => 'required',

            // Giá: bắt buộc, là số, lớn hơn 0
            'email' => 'required|email',
            // Cửa hàng: bắt buộc, phải tồn tại trong bảng stores
            'school_id' => 'required',

        ], [
            // Custom error messages (tiếng Việt)
            'full_name.required' => 'Vui lòng nhập tên học sinh',
            'full_name.string' => 'Tên học sinh phải là chuỗi ký tự',
            'student_id.string' => 'Vui lòng nhập học sinh',
            'school_id.required' => 'Vui lòng chọn học sinh',
            'school_id.exists' => 'Học sinh phải tồn tại không tồn tại',
            'email.required' => 'Vui lòng nhập Email',
            'email.email' => 'Nhập đúng định dạng email',

        ]);

        $student = Student::findOrFail($id);
        $student->update($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Xóa phòng
     */
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Xóa thành công học sinh');
    }
}
