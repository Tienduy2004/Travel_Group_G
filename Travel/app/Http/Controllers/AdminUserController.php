<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    
    public function index()
    {
        if (!auth()->guard('admin')->check()) {        
            return redirect()->route('admin.login')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }  
        $admin = auth()->guard('admin')->user();
        if ($admin->role !== 'admin') {  
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }  
        $admins = Admin::paginate(10);
        return view('admin.users.index', compact('admins'));
    }

   
    public function editRole($id)
{
    // Kiểm tra quyền
    if (auth()->guard('admin')->user()->role !== 'admin') {
        abort(403, 'Bạn không có quyền truy cập trang này.');
    }

    // Không cho phép chỉnh sửa quyền của chính mình
    if (auth()->guard('admin')->user()->id == $id) {
        abort(403, 'Bạn không thể sửa quyền của chính mình.');
    }

    $admin = Admin::findOrFail($id); 

    return view('admin.users.edit', compact('admin'));
}

    
public function updateRole(Request $request, $id)
{
    // Kiểm tra quyền
    if (auth()->guard('admin')->user()->role !== 'admin') {
        abort(403, 'Bạn không có quyền truy cập trang này.');
    }

    // Không cho phép sửa quyền của chính mình
    if (auth()->guard('admin')->user()->id == $id) {
        abort(403, 'Bạn không thể sửa quyền của chính mình.');
    }

    $admin = Admin::findOrFail($id); 

    $request->validate([
        'role' => 'required|in:admin,customer', 
    ]);

    $admin->role = $request->input('role');
    $admin->save();

    return redirect()->route('admin.users.index')->with('success', 'Quyền của admin đã được cập nhật thành công.');
}

}
