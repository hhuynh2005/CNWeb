<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Issue;
use App\Models\Computer;
class IssueController extends Controller
{
    //
    public function index()
    {
        $issues = Issue::with('computer')->paginate(10);
        return view('issues.index', compact('issues'));
    }
    public function create()
    {
        $computers = Computer::all();
        return view('issues.create', compact('computers'));
    }

    // Lưu dữ liệu mới [cite: 23, 31]
    public function store(Request $request)
    {
        $request->validate([
            'computer_id' => 'required',
            'reported_by' => 'max:50',
            'reported_date' => 'required|date',
            'description' => 'required',
            'urgency' => 'required',
            'status' => 'required',
        ]);

        Issue::create($request->all());
        return redirect()->route('issues.index')->with('success', 'Vấn đề đã được thêm thành công!');
    }

    public function edit($id)
    {
        $issue = Issue::findOrFail($id); // 
        $computers = Computer::all(); // Lấy danh sách máy để chọn lại [cite: 10]
        return view('issues.edit', compact('issue', 'computers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'computer_id' => 'required', // [cite: 10]
            'urgency' => 'required', // [cite: 14]
            'status' => 'required', // [cite: 15]
        ]);

        $issue = Issue::findOrFail($id);
        $issue->update($request->all()); // 
        return redirect()->route('issues.index')->with('success', 'Cập nhật thành công!');
    }
    public function destroy($id)
    {
        $issue = Issue::findOrFail($id);
        $issue->delete(); // 
        return redirect()->route('issues.index')->with('success', 'Vấn đề đã được xóa!');
    }
}
