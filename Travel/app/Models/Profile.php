<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    use HasFactory;
    // Khai báo các trường có thể được gán hàng loạt
    protected $fillable = [
        'user_id',
        'avatar',
        'phone',
        'address',
        'birthdate',
        'gender',
        'bio',
        'cover_photo',
    ];

    // Thiết lập mối quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Phương thức tạo profile cho người dùng
    public static function createForUser($userId)
    {
        return self::create([
            'user_id' => $userId,
            'phone' => null,
            'address' => null,
            'date_of_birth' => null,
            'gender' => null,
            'avatar' => 'avatar.png',
            'bio' => null,
            'cover_photo' => null,
        ]);
    }

    // Phương thức lấy profile theo user_id cùng với thông tin name và email của user
    public static function getByUserId($userId)
    {
        return self::with(['user:id,name,email']) // Chỉ lấy id, name, email của user
            ->where('user_id', $userId)
            ->first();
    }
}
