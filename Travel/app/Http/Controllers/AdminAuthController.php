<?php

namespace App\Http\Controllers;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login'); // Tạo view cho trang đăng nhập
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::guard('admin')->attempt($credentials)) {
            // Lưu tên admin vào session
            $admin = Auth::guard('admin')->user();
            $request->session()->put('admin_name', $admin->name);
    
            // Redirect đến trang bạn muốn sau khi đăng nhập thành công
            return redirect()->route('admin.trangchu'); // Chuyển hướng đến trang dashboard
        }
    
        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ]);
    }
    

    
    public function showRegistrationForm()
    {
        return view('admin.register'); // Tạo view cho trang đăng ký
    }

    public function register(Request $request)
    {
        // Xác thực dữ liệu nhập vào
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.register')
                             ->withErrors($validator)
                             ->withInput();
        }

        // Tạo mới admin
        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Mã hóa mật khẩu
        ]);

        return redirect()->route('admin.login')->with('success', 'Đăng ký thành công! Bạn có thể đăng nhập ngay.');
    }
    public function logout(Request $request)
{
    Auth::guard('admin')->logout();
    
    // Xóa tên admin khỏi session
    $request->session()->forget('admin_name');

    return redirect('/admin/login');
}


}