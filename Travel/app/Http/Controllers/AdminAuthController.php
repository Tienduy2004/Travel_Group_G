<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
            // Hiển thị danh sách các admin
    public function index()
    {
        $admins = Admin::all();
        return view('admin.danhsach', compact('admins'));
    }

    // Hiển thị trang đăng nhập cho admin
    public function showLoginForm()
    {
        return view('admin.login');
    }

    // Đăng nhập cho admin
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Auth::guard('admin')->user();
            $request->session()->put('admin_name', $admin->name);

            return redirect()->route('admin.trangchu');
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ]);
    }

    // Hiển thị trang đăng ký cho admin
    public function showRegistrationForm()
    {
        return view('admin.register');
    }

    // Đăng ký admin mới
    public function register(Request $request)
    {
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

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.login')->with('success', 'Đăng ký thành công! Bạn có thể đăng nhập ngay.');
    }

    // Đăng xuất admin
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->forget('admin_name');

        return redirect('/admin/login');
    }

   
}
