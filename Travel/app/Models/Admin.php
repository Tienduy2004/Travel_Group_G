<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    // Đảm bảo sử dụng bảng đúng
    protected $table = 'admins'; // Tên bảng của bạn

    // Các trường được phép gán đại trà
    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];

    // Các trường cần ẩn khi chuyển đổi thành mảng hoặc JSON
    protected $hidden = [
        'password', 'remember_token',
    ];

    // Các trường có kiểu dữ liệu ngày tháng nếu cần
    protected $dates = [
        'created_at', 'updated_at',
    ];
}
