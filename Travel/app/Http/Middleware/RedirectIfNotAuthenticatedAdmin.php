<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotAuthenticatedAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Kiểm tra xem người dùng có phải admin và đã đăng nhập chưa
        if (!Auth::guard('admin')->check()) {
            // Nếu chưa đăng nhập, chuyển hướng đến trang /admin/login
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}
