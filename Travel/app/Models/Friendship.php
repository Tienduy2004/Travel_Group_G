<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    protected $fillable = ['user_id', 'friend_id', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function friend()
    // {
    //     return $this->belongsTo(User::class);
    // }

    public static function isSender($user_id)
    {
        // Kiểm tra xem id có phải là user_id hay không
        return self::where('user_id', $user_id)->exists();
    }

    public static function getFriendship($userId, $friendId)
    {
        return self::where(function ($query) use ($userId, $friendId) {
            $query->where(function ($subQuery) use ($userId, $friendId) {
                $subQuery->where('user_id', $userId)
                          ->where('friend_id', $friendId);
            })->orWhere(function ($subQuery) use ($userId, $friendId) {
                $subQuery->where('user_id', $friendId)
                          ->where('friend_id', $userId);
            });
        })->first(); // Lấy một kết quả đầu tiên
    }
}
