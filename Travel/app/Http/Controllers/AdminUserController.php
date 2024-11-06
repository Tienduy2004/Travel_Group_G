<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    // Phương thức hiển thị danh sách Admins
    public function index()
    {
        // Kiểm tra quyền truy cập
        if (auth()->guard('admin')->user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        $admins = Admin::paginate(10); // Lấy tất cả người dùng admin và phân trang

        return view('admin.users.index', compact('admins'));
    }

    // Phương thức hiển thị form để chỉnh sửa quyền của Admin
    public function editRole($id)
    {
        // Kiểm tra quyền truy cập
        if (auth()->guard('admin')->user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        $admin = Admin::findOrFail($id); // Tìm admin theo id

        return view('admin.users.edit', compact('admin'));
    }

    // Phương thức cập nhật quyền cho Admin
    public function updateRole(Request $request, $id)
    {
        // Kiểm tra quyền truy cập
        if (auth()->guard('admin')->user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        $admin = Admin::findOrFail($id); // Tìm admin theo id

        $request->validate([
            'role' => 'required|in:admin,customer', // Chỉ cho phép role là 'admin' hoặc 'customer'
        ]);

        $admin->role = $request->input('role');
        $admin->save();

        return redirect()->route('admin.users.index')->with('success', 'Quyền của admin đã được cập nhật thành công.');
    }
}
